@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Invoice for Package #{{ $package->id }}</h1>
    <p><strong>Recipient Name:</strong> {{ $package->recipient_name }}</p>
    <p><strong>Recipient Address:</strong> {{ $package->recipient_address }}</p>
    <p><strong>Cost:</strong> ${{ $package->cost }}</p>
    <!-- Add more invoice details as needed -->

    <button class="btn btn-info" onclick="window.print()">Print Invoice</button>
</div>
@endsection
