@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Driver Dashboard</h1>

    <div class="my-4">
        <h2>Assigned Packages</h2>
        @if($assignedPackages->isEmpty())
            <p>No assigned packages at the moment.</p>
        @else
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Package ID</th>
                            <th>Pickup Request ID</th>
                            <th>Recipient</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Details</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assignedPackages as $package)
                            <tr>
                                <td>{{ $package->id }}</td>
                                <td>{{ $package->pickup_request_id }}</td>
                                <td>{{ $package->recipient_name }}</td>
                                <td>{{ $package->recipient_address }}</td>
                                <td>{{ $package->status }}</td>
                                <td>
                                    <ul>
                                        <li>Zone: {{ $package->zone->zone_name }}</li>
                                        <li>Priority: {{ $package->priority->priority_name }}</li>
                                        <li>Size: {{ $package->size->size_range }}</li>
                                        <li>Cost: ${{ $package->cost }}</li>
                                    </ul>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-secondary" onclick="editDetails({{ $package->id }})">Edit Details</button>
                                        <button class="btn btn-info" onclick="printInvoice({{ $package->id }})">Print Invoice</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div class="my-4">
        <h2>Unassigned Packages</h2>
        @if($unassignedPackages->isEmpty())
            <p>No unassigned packages at the moment.</p>
        @else
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Package ID</th>
                            <th>Pickup Request ID</th>
                            <th>Recipient</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Details</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($unassignedPackages as $package)
                            <tr>
                                <td>{{ $package->id }}</td>
                                <td>{{ $package->pickup_request_id }}</td>
                                <td>{{ $package->recipient_name }}</td>
                                <td>{{ $package->recipient_address }}</td>
                                <td>{{ $package->status }}</td>
                                <td>
                                    <ul>
                                        <li>Zone: {{ $package->zone->zone_name }}</li>
                                        <li>Priority: {{ $package->priority->priority_name }}</li>
                                        <li>Size: {{ $package->size->size_range }}</li>
                                        <li>Cost: ${{ $package->cost }}</li>
                                    </ul>
                                </td>
                                <td>
                                    <a href="{{ route('packages.assign', $package->id) }}" class="btn btn-primary">Assign to Me</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<script>
function editDetails(packageId) {
    window.location.href = '/packages/' + packageId + '/edit';
}

function printInvoice(packageId) {
    window.location.href = '/packages/' + packageId + '/invoice';
}
</script>
@endsection
