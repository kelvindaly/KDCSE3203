<?php

namespace App\Http\Controllers;

use App\Services\CostCalculationService;
use App\Models\PickupRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Zone;
use App\Models\PackagePriority;
use App\Models\PackageSize;
use App\Models\Package;
use App\Models\User;

class PickupRequestController extends Controller
{
    public function create()
    {
        $zones = Zone::all();
        $packagePriorities = PackagePriority::all();
        $packageSizes = PackageSize::all();

        return view('pickup_requests.create', compact('zones', 'packagePriorities', 'packageSizes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pickup_date' => 'required|date',
            'pickup_time' => 'required|date_format:H:i',
            'pickup_address' => 'required|string|max:255',
            'payment_preference' => 'required|string|max:50',
            'packages.*.zone_id' => 'required|exists:zones,id',
            'packages.*.priority_id' => 'required|exists:package_priorities,id',
            'packages.*.size_id' => 'required|exists:package_sizes,id',
            'packages.*.recipient_name' => 'required|string|max:255',
            'packages.*.recipient_address' => 'required|string|max:255',
            'packages.*.recipient_email' => 'required|email|max:255',
            'packages.*.recipient_phone' => 'required|string|max:20',
        ]);

        $user = Auth::user();
        $customerId = null;
        $driverId = null;

        if ($user->role === 'driver') {
            $driverId = $user->id;
            if ($request->has('customer_id')) {
                $customerId = $request->input('customer_id');
            } else {
                $customer = User::create([
                    'name' => $request->input('customer_name'),
                    'address' => $request->input('customer_address'),
                    'phone' => $request->input('customer_phone'),
                    'role' => 'customer',
                ]);
                $customerId = $customer->id;
            }
        } else {
            $customerId = $user->id;
        }

        $pickupRequest = PickupRequest::create([
            'user_id' => $customerId,
            'pickup_date' => $validated['pickup_date'],
            'pickup_time' => $validated['pickup_time'],
            'pickup_address' => $validated['pickup_address'],
            'payment_preference' => $validated['payment_preference'],
            'pickup_status' => 'Pending',
        ]);

        foreach ($validated['packages'] as $packageData) {
            $cost = CostCalculationService::calculate($packageData['zone_id'], $packageData['priority_id'], $packageData['size_id']);

            // Debug: Output driver information
            echo "Driver ID: " . $driverId . "<br>";

            $driver = User::where('id', $driverId)->where('role', 'driver')->first();
            if (!$driver) {
                $driverId = null;
                echo "Driver not valid or not found. Setting driverId to null.<br>";
            } else {
                echo "Driver found: " . $driver->name . " (ID: " . $driver->id . ")<br>";
            }

            Package::create([
                'pickup_request_id' => $pickupRequest->id,
                'zone_id' => $packageData['zone_id'],
                'priority_id' => $packageData['priority_id'],
                'size_id' => $packageData['size_id'],
                'recipient_name' => $packageData['recipient_name'],
                'recipient_address' => $packageData['recipient_address'],
                'recipient_email' => $packageData['recipient_email'],
                'recipient_phone' => $packageData['recipient_phone'],
                'cost' => $cost,
                'driver_id' => $driverId,
            ]);

            
        }

        if ($driverId) {
            $pickupRequest->pickup_status = "Will be picked up immediately by: " . $user->name;
        } else {
            $pickupRequest->pickup_status = "Will be picked up later today";
        }

        $pickupRequest->save();

        if ($user->role === 'driver') {
            return redirect()->route('driver.dashboard')->with('success', 'Pickup request created successfully.');
        } else {
            return redirect()->route('pickup-requests.schedule')->with('success', 'Pickup request created successfully.');
        }
    }

    public function schedule()
    {
        $pickupRequests = PickupRequest::where('user_id', Auth::id())->with('packages')->get();
        return view('pickup_requests.schedule', compact('pickupRequests'));
    }

    public function estimateCost(Request $request)
    {
        try {
            $cost = CostCalculationService::calculate($request->zone_id, $request->priority_id, $request->size_id);
            return response()->json(['estimated_cost' => $cost]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while calculating the estimate.'], 500);
        }
    }

    public function generateQuote($pickupRequestId, Request $request)
    {
        $pickupRequest = PickupRequest::where('id', $pickupRequestId)
            ->where('user_id', Auth::id())
            ->with('packages')
            ->firstOrFail();

        $totalCost = 0;
        $shippingLabels = [];

        foreach ($pickupRequest->packages as $package) {
            $totalCost += $package->cost;
            $shippingLabels[] = [
                'recipient_name' => $package->recipient_name,
                'recipient_address' => $package->recipient_address,
                'recipient_phone' => $package->recipient_phone,
            ];
        }

        if ($request->ajax()) {
            return response()->json([
                'totalCost' => $totalCost,
                'shippingLabels' => $shippingLabels,
            ]);
        }

        return view('pickup_requests.quote', compact('pickupRequest', 'totalCost', 'shippingLabels'));
    }

    public function calculateEstimate(Request $request)
    {
        try {
            $zoneId = $request->query('zone_id');
            $priorityId = $request->query('priority_id');
            $sizeId = $request->query('size_id');

            $cost = CostCalculationService::calculate($zoneId, $priorityId, $sizeId);

            return response()->json(['estimated_cost' => $cost]);

        } catch (\Exception $e) {
            \Log::error('Error calculating estimate: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while calculating the estimate.'], 500);
        }
    }
}
