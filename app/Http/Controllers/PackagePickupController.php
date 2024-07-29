<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\User;
use App\Models\PickupRequest;
use App\Models\Zone;
use App\Models\PackagePriority;
use App\Models\PackageSize;
use Illuminate\Support\Facades\Auth;

class PackagePickupController extends Controller
{
    // Display the driver's dashboard with assigned and unassigned packages
    public function dashboard()
    {
        $driver = Auth::user();

        // Packages assigned to this driver
        $assignedPackages = Package::where('driver_id', $driver->id)->get();

        // Packages not assigned to any driver
        $unassignedPackages = Package::whereNull('driver_id')->get();

        return view('PackagePickup.dashboard', compact('assignedPackages', 'unassignedPackages'));
    }

    // Show form to create a pickup request
    public function createPickupRequest()
    {
        $user = Auth::user();

        // Fetching all zones, priorities, and sizes
        $zones = Zone::all();
        $packagePriorities = PackagePriority::all();
        $packageSizes = PackageSize::all();

        // Fetch all users with the role of 'customer'
        $customers = User::where('role', 'customer')->get();

        // Determine if the current user is a driver
        $isDriver = $user->role === 'driver';

        return view('pickup_requests.create', compact('zones', 'packagePriorities', 'packageSizes', 'customers', 'isDriver'));
    }

    // Store the pickup request details
    public function storePickupRequest(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:users,id',
            'customer_name' => 'required_without:customer_id|string|max:255',
            'customer_address' => 'required_without:customer_id|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'pickup_date' => 'required|date',
            'pickup_time' => 'required|date_format:H:i',
            'pickup_address' => 'required|string|max:255',
        ]);

        // Create a new customer if not existing
        $customer = $request->customer_id 
            ? User::find($request->customer_id)
            : User::create([
                'name' => $validated['customer_name'],
                'address' => $validated['customer_address'],
                'phone' => $validated['customer_phone'],
                'role' => 'customer',
            ]);

        PickupRequest::create([
            'user_id' => $customer->id,
            'pickup_date' => $validated['pickup_date'],
            'pickup_time' => $validated['pickup_time'],
            'pickup_address' => $validated['pickup_address'],
            'driver_id' => Auth::id(),
            'pickup_status' => 'Pending',
        ]);

        return redirect()->route('driver.dashboard')->with('success', 'Pickup request created successfully.');
    }

    public function updateStatus(Request $request, Package $package)
    {
        $request->validate([
            'status' => 'required|string|in:picked-up,delivered',
        ]);

        // Update the status of the package
        $package->update(['status' => $request->status]);

        return redirect()->route('driver.dashboard')->with('success', 'Package status updated successfully.');
    }

    // Show form to edit package details
    public function edit(Package $package)
    {
        return view('PackagePickup.edit', compact('package'));
    }

    // Update package details
    public function update(Request $request, Package $package)
    {
        // Validate the request data
        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_address' => 'required|string|max:255',
            'recipient_email' => 'required|email|max:255',
            'recipient_phone' => 'required|string|max:20',
        ]);

        // Update the package with the new details
        $package->update($request->all());

        // Check if all packages in the related pickup request are marked as "picked-up" or "delivered"
        $pickupRequest = $package->pickupRequest;
        if ($pickupRequest) {
            $allPickedOrDelivered = $pickupRequest->packages->every(function ($pkg) {
                return in_array($pkg->status, ['picked-up', 'delivered']);
            });

            // Update the pickup request status if all packages are picked-up or delivered
            if ($allPickedOrDelivered) {
                $pickupRequest->update(['pickup_status' => 'Pick-Up Request Complete']);
            }
        }

        // Redirect back to the driver's dashboard with a success message
        return redirect()->route('driver.dashboard')->with('success', 'Package details updated successfully.');
    }

    // Generate and display invoice for a package
    public function invoice(Package $package)
    {
        return view('PackagePickup.invoice', compact('package'));
    }


    public function assignToMe(Package $package)
{
    // Ensure the logged-in user is a driver
    if (Auth::user()->role !== 'driver') {
        return redirect()->route('driver.dashboard')->with('error', 'Unauthorized action.');
    }

    // Assign the package to the logged-in driver
    $package->driver_id = Auth::id();
    $package->save();

    return redirect()->route('driver.dashboard')->with('success', 'Package assigned to you successfully.');
}

}

