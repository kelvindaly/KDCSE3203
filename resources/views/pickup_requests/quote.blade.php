@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Quote for Pickup Request #{{ $pickupRequest->id }}</h1>

    <div class="mb-4">
        <h2>Total Estimated Cost: ${{ number_format($totalCost, 2) }}</h2>
    </div>

    <div class="card">
        <div class="card-header">Shipping Labels</div>
        <div class="card-body">
            @foreach($shippingLabels as $index => $label)
                <h5>Package {{ $index + 1 }}</h5>
                <p><strong>Recipient:</strong> {{ $label['recipient_name'] }}</p>
                <p><strong>Address:</strong> {{ $label['recipient_address'] }}</p>
                <p><strong>Phone:</strong> {{ $label['recipient_phone'] }}</p>
                @if(!$loop->last)
                    <hr>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection
