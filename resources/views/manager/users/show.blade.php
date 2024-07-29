@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">{{ $user->name }}</div>

                <div class="card-body">
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Telephone:</strong> {{ $user->telephone }}</p>
                    <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
