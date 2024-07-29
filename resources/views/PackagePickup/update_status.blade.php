@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Update Package Status</h1>
    <form method="POST" action="{{ route('driver.package.update', $package->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select id="status" name="status" class="form-select" required>
                <option value="picked-up" {{ $package->status == 'picked-up' ? 'selected' : '' }}>Picked Up</option>
                <option value="delivered" {{ $package->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Status</button>
    </form>
</div>
@endsection
