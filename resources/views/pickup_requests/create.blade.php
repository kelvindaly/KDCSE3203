@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Pickup Request</h1>

    <form method="POST" action="{{ route('pickup-requests.store') }}">
    @csrf
    @method('PUT')

    @if(Auth::user()->role === 'driver')
    <h4>Customer Detials</h4>
    <div class="mb-4">
        <label for="customer_option" class="form-label">Customer Requesting Package-Pickup</label>
        <select class="form-control" id="customer_option" name="customer_option" onchange="toggleCustomerFields()">
            <option value="select" selected>Existing Customer</option>
            <option value="new">New Customer</option>
        </select>
    </div>

    <div id="existing_customer_section" class="mb-4">
        <div class="form-group">
            <label for="customer_id" class="form-label">Customer Name</label>
            <select class="form-control" id="customer_id" name="customer_id">
                <option value="" selected disabled>Select a Customer</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div id="new_customer_section" class="mb-4" style="display: none;">
        <h4>Create New Customer</h4>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="customer_name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Customer Name">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="customer_phone" class="form-label">Phone</label>
                    <input type="tel" class="form-control" id="customer_phone" name="customer_phone" placeholder="Customer Phone">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="customer_address" class="form-label">Address</label>
            <input type="text" class="form-control" id="customer_address" name="customer_address" placeholder="Customer Address">
        </div>
    </div>

    <script>
        function toggleCustomerFields() {
            var customerOption = document.getElementById('customer_option').value;
            var existingCustomerSection = document.getElementById('existing_customer_section');
            var newCustomerSection = document.getElementById('new_customer_section');

            if (customerOption === 'select') {
                existingCustomerSection.style.display = 'block';
                newCustomerSection.style.display = 'none';
            } else if (customerOption === 'new') {
                existingCustomerSection.style.display = 'none';
                newCustomerSection.style.display = 'block';
            }
        }
    </script>
@endif


<h4>Pickup Detials</h4>
        <div class="mb-3">
            <label for="pickup_date" class="form-label">Pickup Date</label>
            <input type="date" class="form-control" id="pickup_date" name="pickup_date" required>
        </div>

        <div class="mb-3">
            <label for="pickup_time" class="form-label">Pickup Time</label>
            <input type="time" class="form-control" id="pickup_time" name="pickup_time" required>
        </div>

        <div class="mb-3">
            <label for="pickup_address" class="form-label">Pickup Address</label>
            <input type="text" class="form-control" id="pickup_address" name="pickup_address" required>
        </div>

        <div class="mb-3">
            <label for="payment_preference" class="form-label">Payment Preference</label>
            <input type="text" class="form-control" id="payment_preference" name="payment_preference" required>
        </div>

        <h4>Packages</h4>
        <ul class="nav nav-tabs" id="packageTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="package-tab-0" data-bs-toggle="tab" data-bs-target="#package-0" type="button" role="tab" aria-controls="package-0" aria-selected="true">Package 1</button>
            </li>
        </ul>
        <div class="tab-content" id="packageTabsContent">
            <div class="tab-pane fade show active" id="package-0" role="tabpanel" aria-labelledby="package-tab-0">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="zone_id_0" class="form-label">Zone</label>
                            <select class="form-control" id="zone_id_0" name="packages[0][zone_id]" required>
                                <option value="" selected disabled>Select Zone</option>
                                @foreach($zones as $zone)
                                    <option value="{{ $zone->id }}">{{ $zone->zone_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="priority_id_0" class="form-label">Package Priority</label>
                            <select class="form-control" id="priority_id_0" name="packages[0][priority_id]" required>
                                <option value="" selected disabled>Select Priority</option>
                                @foreach($packagePriorities as $priority)
                                    <option value="{{ $priority->id }}">{{ $priority->priority_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="size_id_0" class="form-label">Package Size</label>
                            <select class="form-control" id="size_id_0" name="packages[0][size_id]" required>
                                <option value="" selected disabled>Select Size</option>
                                @foreach($packageSizes as $size)
                                    <option value="{{ $size->id }}">{{ $size->size_range }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="recipient_name_0" class="form-label">Recipient Name</label>
                            <input type="text" class="form-control" id="recipient_name_0" name="packages[0][recipient_name]" required>
                        </div>

                        <div class="mb-3">
                            <label for="recipient_address_0" class="form-label">Recipient Address</label>
                            <input type="text" class="form-control" id="recipient_address_0" name="packages[0][recipient_address]" required>
                        </div>

                        <div class="mb-3">
                            <label for="recipient_email_0" class="form-label">Recipient Email</label>
                            <input type="email" class="form-control" id="recipient_email_0" name="packages[0][recipient_email]" required>
                        </div>

                        <div class="mb-3">
                            <label for="recipient_phone_0" class="form-label">Recipient Phone</label>
                            <input type="tel" class="form-control" id="recipient_phone_0" name="packages[0][recipient_phone]" required>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <button type="button" class="btn btn-secondary me-2" onclick="addPackage()">Add Another Package</button>
                            <button type="button" class="btn btn-info" onclick="estimateCost(0)">Estimate Cost</button>
                        </div>
                        <div id="estimated-cost-0" class="mt-2 alert alert-info" style="display:none;">Estimate Cost Package 1: $0</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <div id="total-estimated-cost" class="alert alert-info" style="display:none;">Total Estimated Cost: $0</div>
            <button type="submit" class="btn btn-primary">Submit Pickup Request</button>
        </div>
    </form>
</div>

<script>
let totalEstimatedCost = 0;
let packageCosts = []; // To store costs for each package

function addPackage() {
    var container = document.getElementById('packageTabsContent');
    var packageCount = container.getElementsByClassName('tab-pane').length;

    var tabTemplate = `
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="package-tab-${packageCount}" data-bs-toggle="tab" data-bs-target="#package-${packageCount}" type="button" role="tab" aria-controls="package-${packageCount}" aria-selected="false">Package ${packageCount + 1}</button>
        </li>
    `;
    document.getElementById('packageTabs').insertAdjacentHTML('beforeend', tabTemplate);

    var packageTemplate = `
        <div class="tab-pane fade" id="package-${packageCount}" role="tabpanel" aria-labelledby="package-tab-${packageCount}">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="zone_id_${packageCount}" class="form-label">Zone</label>
                        <select class="form-control" id="zone_id_${packageCount}" name="packages[${packageCount}][zone_id]" required>
                            <option value="" selected disabled>Select Zone</option>
                            @foreach($zones as $zone)
                                <option value="{{ $zone->id }}">{{ $zone->zone_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="priority_id_${packageCount}" class="form-label">Package Priority</label>
                        <select class="form-control" id="priority_id_${packageCount}" name="packages[${packageCount}][priority_id]" required>
                            <option value="" selected disabled>Select Priority</option>
                            @foreach($packagePriorities as $priority)
                                <option value="{{ $priority->id }}">{{ $priority->priority_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="size_id_${packageCount}" class="form-label">Package Size</label>
                        <select class="form-control" id="size_id_${packageCount}" name="packages[${packageCount}][size_id]" required>
                            <option value="" selected disabled>Select Size</option>
                            @foreach($packageSizes as $size)
                                <option value="{{ $size->id }}">{{ $size->size_range }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="recipient_name_${packageCount}" class="form-label">Recipient Name</label>
                        <input type="text" class="form-control" id="recipient_name_${packageCount}" name="packages[${packageCount}][recipient_name]" required>
                    </div>

                    <div class="mb-3">
                        <label for="recipient_address_${packageCount}" class="form-label">Recipient Address</label>
                        <input type="text" class="form-control" id="recipient_address_${packageCount}" name="packages[${packageCount}][recipient_address]" required>
                    </div>

                    <div class="mb-3">
                        <label for="recipient_email_${packageCount}" class="form-label">Recipient Email</label>
                        <input type="email" class="form-control" id="recipient_email_${packageCount}" name="packages[${packageCount}][recipient_email]" required>
                    </div>

                    <div class="mb-3">
                        <label for="recipient_phone_${packageCount}" class="form-label">Recipient Phone</label>
                        <input type="tel" class="form-control" id="recipient_phone_${packageCount}" name="packages[${packageCount}][recipient_phone]" required>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <button type="button" class="btn btn-secondary me-2" onclick="addPackage()">Add Another Package</button>
                        <button type="button" class="btn btn-info" onclick="estimateCost(${packageCount})">Estimate Cost</button>
                    </div>
                    <div id="estimated-cost-${packageCount}" class="mt-2 alert alert-info" style="display:none;">Estimate Cost Package ${packageCount + 1}: $0</div>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', packageTemplate);

    packageCosts.push(0); // Initialize the cost for the new package
}

function estimateCost(packageIndex) {
    var zoneId = document.getElementById(`zone_id_${packageIndex}`).value;
    var priorityId = document.getElementById(`priority_id_${packageIndex}`).value;
    var sizeId = document.getElementById(`size_id_${packageIndex}`).value;

    if (zoneId && priorityId && sizeId) {
        fetch(`/estimate-cost?zone_id=${zoneId}&priority_id=${priorityId}&size_id=${sizeId}`)
            .then(response => response.json())
            .then(data => {
                if (data.estimated_cost !== undefined && !isNaN(data.estimated_cost)) {
                    var cost = parseFloat(data.estimated_cost);
                    var costDiv = document.getElementById(`estimated-cost-${packageIndex}`);
                    costDiv.style.display = 'block';
                    costDiv.innerText = `Estimate Cost Package ${packageIndex + 1}: $${cost.toFixed(2)}`;

                    // Update total cost
                    totalEstimatedCost = totalEstimatedCost - (packageCosts[packageIndex] || 0) + cost;
                    packageCosts[packageIndex] = cost; // Store the new cost
                    document.getElementById('total-estimated-cost').style.display = 'block';
                    document.getElementById('total-estimated-cost').innerText = `Total Estimated Cost: $${totalEstimatedCost.toFixed(2)}`;
                } else if (data.error) {
                    alert('Error: ' + data.error);
                } else {
                    alert('Unexpected response format.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again later.');
            });
    } else {
        alert('Please select all options to estimate the cost.');
    }
}
</script>
@endsection
