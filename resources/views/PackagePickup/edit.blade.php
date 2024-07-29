@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Package</h1>
    <form method="POST" action="{{ route('packages.update', $package->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="recipient_name" class="form-label">Recipient Name</label>
            <input type="text" class="form-control" id="recipient_name" name="recipient_name" value="{{ $package->recipient_name }}" required>
        </div>

        <div class="mb-3">
            <label for="recipient_address" class="form-label">Recipient Address</label>
            <input type="text" class="form-control" id="recipient_address" name="recipient_address" value="{{ $package->recipient_address }}" required>
        </div>

        <div class="mb-3">
            <label for="recipient_email" class="form-label">Recipient Email</label>
            <input type="email" class="form-control" id="recipient_email" name="recipient_email" value="{{ $package->recipient_email }}" required>
        </div>

        <div class="mb-3">
            <label for="recipient_phone" class="form-label">Recipient Phone</label>
            <input type="tel" class="form-control" id="recipient_phone" name="recipient_phone" value="{{ $package->recipient_phone }}" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select id="status" name="status" class="form-select" required>
                <option value="" disabled {{ is_null($package->status) ? 'selected' : '' }}>Select a Status</option>
                <option value="picked-up" {{ $package->status == 'picked-up' ? 'selected' : '' }}>Picked Up</option>
                <option value="delivered" {{ $package->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="delivered" {{ $package->status == 'pending' ? 'selected' : '' }}>Pending</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Package</button>
    </form>
</div>
@endsection


