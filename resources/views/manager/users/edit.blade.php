@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit User') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('users.update', $user->id) }}">
                    @csrf
                    @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="telephone" class="form-label">{{ __('Telephone') }}</label>
                            <input id="telephone" type="text" class="form-control" name="telephone" value="{{ old('telephone', $user->telephone) }}">
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">{{ __('Role') }}</label>
                            <select id="role" class="form-select" name="role" required onchange="toggleZoneSelection()">
                                <option value="manager" {{ $user->role == 'manager' ? 'selected' : '' }}>Manager</option>
                                <option value="warehouse_staff" {{ $user->role == 'warehouse_staff' ? 'selected' : '' }}>Warehouse Staff</option>
                                <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>Customer</option>
                                <option value="driver" {{ $user->role == 'driver' ? 'selected' : '' }}>Driver</option>
                            </select>
                        </div>

                        <div class="mb-3" id="zoneSelection" style="display: none;">
                            <label for="zone" class="form-label">{{ __('Zone') }}</label>
                            <select id="zone" class="form-select" name="zone_id">
                                @foreach($zones as $zone)
                                    <option value="{{ $zone->id }}" {{ $user->zone_id == $zone->id ? 'selected' : '' }}>
                                        {{ $zone->zone_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control" name="password">
                            <small class="form-text text-muted">Leave blank if you do not want to change the password.</small>
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                        </div>

                        <div class="mb-0">
                            <button type="submit" class="btn btn-primary">{{ __('Update User') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleZoneSelection() {
    const role = document.getElementById('role').value;
    const zoneSelection = document.getElementById('zoneSelection');

    if (role === 'driver') {
        zoneSelection.style.display = 'block';
    } else {
        zoneSelection.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    toggleZoneSelection();
    document.getElementById('role').addEventListener('change', toggleZoneSelection);
});
</script>
@endsection
