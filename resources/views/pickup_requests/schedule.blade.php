@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pickup Request Schedule</h1>

    @if($pickupRequests->isEmpty())
        <p>You have no scheduled pickup requests.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Request ID</th> <!-- New column for Pickup Request ID -->
                        <th>Pickup Date</th>
                        <th>Pickup Time</th>
                        <th>Pickup Address</th>
                        <th>Status</th>
                        <th>Packages</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pickupRequests as $request)
                        <tr>
                            <td>{{ $request->id }}</td> <!-- Display Pickup Request ID -->
                            <td>{{ $request->pickup_date->format('Y-m-d') }}</td>
                            <td>{{ $request->pickup_time->format('H:i') }}</td>
                            <td>{{ $request->pickup_address }}</td>
                            <td>{{ $request->pickup_status }}</td>
                            <td>
                                <ul>
                                    @foreach($request->packages as $index => $package)
                                        <li>
                                            <strong>Package {{ $index + 1 }}</strong><br>
                                            Zone: {{ $package->zone->zone_name }}<br>
                                            Priority: {{ $package->priority->priority_name }}<br>
                                            Size: {{ $package->size->size_range }}<br>
                                            Recipient: {{ $package->recipient_name }}<br>
                                            Address: {{ $package->recipient_address }}<br>
                                            Email: {{ $package->recipient_email }}<br>
                                            Phone: {{ $package->recipient_phone }}<br>
                                            Cost: ${{ $package->cost }}<br>
                                            <button class="btn btn-link" onclick="showShippingLabel('{{ $package->recipient_name }}', '{{ $package->recipient_address }}')">Print Shipping Label</button>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <button class="btn btn-primary" onclick="showQuoteModal({{ $request->id }})">Print Quote</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<!-- Modal for Quote -->
<div class="modal fade" id="quoteModal" tabindex="-1" aria-labelledby="quoteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quoteModalLabel">Shipping Quote</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="quoteContent">
                <!-- Quote content will be injected here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="printQuote()">Print</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Shipping Label -->
<div class="modal fade" id="shippingLabelModal" tabindex="-1" aria-labelledby="shippingLabelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shippingLabelModalLabel">Shipping Label</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="shippingLabelContent">
                <!-- Content will be loaded dynamically -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="printShippingLabel()">Print</button>
            </div>
        </div>
    </div>
</div>

<script>
function showQuoteModal(requestId) {
    fetch(`/pickup-requests/${requestId}/quote`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(response => response.json())
        .then(data => {
            let content = `<h4>Total Estimated Cost: $${data.totalCost.toFixed(2)}</h4>`;
            data.shippingLabels.forEach((label, index) => {
                content += `
                    <h5>Package ${index + 1}</h5>
                    <p><strong>Recipient:</strong> ${label.recipient_name}</p>
                    <p><strong>Address:</strong> ${label.recipient_address}</p>
                    <p><strong>Phone:</strong> ${label.recipient_phone}</p>
                    ${index !== data.shippingLabels.length - 1 ? '<hr>' : ''}
                `;
            });
            document.getElementById('quoteContent').innerHTML = content;
            let quoteModal = new bootstrap.Modal(document.getElementById('quoteModal'));
            quoteModal.show();
        })
        .catch(error => {
            console.error('Error fetching quote:', error);
            alert('Failed to fetch quote. Please try again.');
        });
}

function printQuote() {
    let printContents = document.getElementById('quoteContent').innerHTML;
    let originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;

    window.location.reload();
}

function showShippingLabel(name, address) {
    let content = `
        <p><strong>Recipient Name:</strong> ${name}</p>
        <p><strong>Address:</strong> ${address}</p>
    `;
    document.getElementById('shippingLabelContent').innerHTML = content;

    let myModal = new bootstrap.Modal(document.getElementById('shippingLabelModal'));
    myModal.show();
}

function printShippingLabel() {
    let printContents = document.getElementById('shippingLabelContent').innerHTML;
    let originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;

    window.location.reload();
}
</script>
@endsection
