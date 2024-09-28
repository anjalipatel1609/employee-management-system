@include('header')

@if (Session::has('success'))
    <br><br>
    <div id="successAlert" style = "text-align : center;" class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<h1 class="mt-4">{{ $client->client_name }}</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ url(route('client')) }}">Client</a></li>
    <li class="breadcrumb-item active">Generate Invoice</li>
</ol>

@php
    $total_price = 0;
    $paid_price = 0;
    $unpaid_price = 0;
@endphp

@if(isset($clientAllSubServices))
    @if(count($clientAllSubServices) > 0)
        @foreach($clientAllSubServices as $clientEachSubServicesZ)
            <?php $total_price += $clientEachSubServicesZ->payment_amount; ?>
        @endforeach
    @endif
@endif

@if(isset($Paid_services))
    @if(count($Paid_services) > 0)
        @foreach($Paid_services as $Paid_service)
            <?php $paid_price += $Paid_service->payment_amount; ?>
        @endforeach
    @endif
@endif

@if(isset($Unpaid_services))
    @if(count($Unpaid_services) > 0)
        @foreach($Unpaid_services as $Unpaid_service)
            <?php $unpaid_price += $Unpaid_service->payment_amount; ?>
        @endforeach
    @endif
@endif

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5 class="card-title">{{ $client->client_name }}</h5>
                <p class="card-text">Email : {{ $client->email }}</p>
                <p class="card-text">Phone : {{ $client->phone }}</p>
            </div>
            <div class="col-md-6">
                <p class="card-text">Joined : {{ $client->date_time }}</p>
                <p class="card-text">Status : 
                    @if($client->is_active == '1')
                        Active
                    @else
                        Inactive
                    @endif
                </p>
                <p class="card-text">Total Purchases: &#8377;{{ $total_price }} /-</p>
                <p class="card-text">Paid Amount : <span class="text-success"> &#8377;{{ $paid_price }} /-</span></p>
                <p class="card-text">Unpaid Amount : <span class="text-danger"> &#8377;{{ $unpaid_price }} /-</span></p>
            </div>
        </div>
    </div>
</div>

<div class="d-flex flex-row-reverse mt-5">
    <button id="generateInvoiceBtn" class="btn btn-primary" data-toggle="modal" data-target="#invoiceModal" style="margin-left: 10px">Generate
        Invoice</button>
    <button class="btn btn-secondary" data-toggle="modal" data-target="#printInvoiceModal">Print Invoice</button>
</div>

<div class="modal fade" id="printInvoiceModal" tabindex="-1" role="dialog" aria-labelledby="printInvoiceModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="printInvoiceModalLabel">Print Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Modal body content with tabs -->
                
                <div class="tab-content" id="printInvoiceTabContent">
                    <!-- Tab panes with content -->
                    <div class="tab-pane fade show active" id="selectService" role="tabpanel"
                        aria-labelledby="selectServiceTab">
                        <!-- Select service form presented as a table -->
                        <form id="serviceForm" action = "{{ route('printing_generated_invoice') }}" method = "post">
                            @csrf

                                    @if(isset($clientAllSubServices_InvoiceGenerated))
                                        @if(count($clientAllSubServices_InvoiceGenerated) > 0)
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Select</th>
                                                        <th>Service Name</th>
                                                        <th>Amount</th>
                                                        <th>Bill Number</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Example data -->

                                                    @if(isset($clientAllSubServices_InvoiceGenerated))
                                                        @if(count($clientAllSubServices_InvoiceGenerated) > 0)
                                                            @foreach($clientAllSubServices_InvoiceGenerated as $clientEachSubServicesW)
                                                                <tr>
                                                                    <td><input type="checkbox" name="selected_services[]" value="{{ $clientEachSubServicesW->id }}"></td>
                                                                    <td>{{ $clientEachSubServicesW->SubServiceTaken->sub_service_name }}</td>
                                                                    <td>&#8377; {{ $clientEachSubServicesW->payment_amount }} /-</td>
                                                                    <td>{{ $clientEachSubServicesW->bill_number }}</td>
                                                                </tr>
                                                            @endforeach

                                                        @else
                                                            <tr>
                                                                <span style = "text-align : center; color : #343434;"><b><i>There is no invoce data of any client service, [Generate First] !</i></b></span>
                                                            </tr>
                                                        @endif
                                                    @endif

                                                    <!-- Add more rows as needed -->
                                                </tbody>
                                            </table>

                                            <input type="hidden" name="client_id" value="{{ $client->id }}">
                                            <button type="submit" class="btn btn-primary mt-4">Print Invoice</button>
                                        @else
                                            <br><div style = "text-align : center; color : #343434;"><b><i>There is no invoce data of any client service, [Generate First] !</i></b></div><br>
                                        @endif
                                    @endif
                            

                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Invoice Modal -->
<div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="invoiceModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoiceModalLabel">Generate Invoice</h5>

                <button type="button" class="btn-close" aria-label="Close" data-dismiss="modal"></button>

            </div>
            
            <!-- Page 1: Services List -->
            <div class="modal-body" id="page1">
                <h5 class="modal-title mb-4" id="invoiceModalLabel">Select Services</h5>
                <div class="row" id="servicesList">
                    @if(isset($clientAllSubServices_ForGeneratingInvoice))
                        @if(count($clientAllSubServices_ForGeneratingInvoice) > 0)
                            @foreach($clientAllSubServices_ForGeneratingInvoice as $clientEachSubServices)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="service{{ $clientEachSubServices->id }}" value="{{ $clientEachSubServices->SubServiceTaken->sub_service_name }}">
                                    <label class="form-check-label" for="service{{ $clientEachSubServices->id }}">{{ $clientEachSubServices->SubServiceTaken->sub_service_name }}</label>
                                </div>
                            @endforeach

                        @else
                            <span style = "text-align : center; color : #343434;"><b><i>There is no any sub-services to show !</i></b></span>
                        @endif
                    @endif
                </div>

                <br>
                <h5 class="modal-title mb-4" id="invoiceModalLabel">Invoice Generated services</h5> 

                <div class="row" id="servicesList">
                    @if(isset($InvoiceGeneratedServices))
                        @if(count($InvoiceGeneratedServices) > 0)
                            @foreach($InvoiceGeneratedServices as $clientEachSub)
                                <form onsubmit = "return confirm('Are you sure to update the payment data of this service !')" action="{{ route('marking_client_service_payment_status_as_paid', $clientEachSub->id) }}" method = "post">
                                    @csrf
                                    <div class="form-check">
                                        <label class="form-check-label" style = "font-size : 18px;"> &nbsp;&nbsp;{{ $clientEachSub->SubServiceTaken->sub_service_name }}</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="text" name="payment_amount" placeholder = "Enter price" value = "{{ $clientEachSub->payment_amount }}" required>&nbsp;&nbsp;
                                        <select name="payment_status" required>
                                            <option value="" selected disabled>Select Payment status</option>
                                            <option value="paid">Paid</option>
                                            <option value="unpaid">Unpaid</option>
                                        </select>&nbsp;&nbsp;
                                        <button type = "submit" class="btn btn-primary">Update</button>
                                    </div>
                                    <br>
                                </form>
                            @endforeach

                        @else
                            <span style = "text-align : center; color : #343434;"><b><i>There is no any unpaid sub-services to show !</i></b></span>
                        @endif
                    @endif
                </div>

                <button id="nextPageBtn" class="btn btn-primary mt-4">Next</button>
            </div>


            <!-- Page 2: Selected Services and Price -->
            <div class="modal-body" id="page2" style="display: none;">
                <h5 class="modal-title mb-4">Enter Prices, and select payment status</h5>
                <form id="priceForm" action = "{{ route('generating_invoice') }}" method = "post">
                    @csrf
                    <div id="selectedServices">
                        <!-- Selected services will be displayed here -->
                    </div>
                    <div class="form-group mt-3">
                        <label for="totalPrice">Total Price:</label>
                        <input type="number" class="form-control" id="totalPrice" readonly>
                    </div>

                    <input type="hidden" name="service_ids[]" value="">
                    <input type="hidden" name="payment_status[]" value="">

                    <button type="button" id="prevPageBtn" class="btn btn-secondary mt-4 mr-2">Previous</button>
                    <button type="submit" id="" class="btn btn-primary mt-4">Submit</button>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {


        // Next button click handler
        $('#nextPageBtn').click(function() {
            // Check if at least one service is selected
            if ($('input[type="checkbox"]:checked').length === 0) {
                alert('Please select at least one service.');
                return;
            }
            // Hide Page 1, show Page 2
            $('#page1').hide();
            $('#page2').show();
            updateSelectedServices();
        });

        // Previous button click handler
        $('#prevPageBtn').click(function() {
            // Hide Page 2, show Page 1
            $('#page2').hide();
            $('#page1').show();
        });

        function updateSelectedServices() {
            var selectedServices = $('#selectedServices');
            var serviceIds = [];
            var paymentStatus = []; // Create an array to store payment status
            selectedServices.empty();
            $('input[type="checkbox"]:checked').each(function() {
                var serviceId = $(this).attr('id').replace('service', '');
                serviceIds.push(serviceId);
                var selectedPaymentStatus = $(this).parent().find('select[name="payment_status[]"]').val();
                if (selectedPaymentStatus !== null && selectedPaymentStatus !== "") {
                    paymentStatus.push(selectedPaymentStatus); // Only push if payment status is selected and not empty
                }
                selectedServices.append('<div>' + $(this).val() +
                    ': <input type="number" name="sub_service_price[]" class="priceInput" required>' +
                    '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
                    '<select name="payment_status[]" required>' +
                    '<option value="" selected disabled>Payment Status</option>' +
                    '<option value="paid">Paid</option>' +
                    '<option value="unpaid">Unpaid</option>' +
                    '</select><br><br></div>');
            });
            // Set the selected service IDs and payment status in the hidden input fields
            $('input[name="service_ids[]"]').val(serviceIds.join(','));
            $('input[name="payment_status[]"]').val(paymentStatus.join(',')); // Set payment status
            // Calculate total price
            calculateTotalPrice();
        }


        // Calculate total price
        function calculateTotalPrice() {
            var totalPrice = 0;
            $('.priceInput').each(function() {
                totalPrice += parseInt($(this).val()) || 0;
            });
            $('#totalPrice').val(totalPrice);
        }

        // Handle price input change
        $('#selectedServices').on('input', '.priceInput', function() {
            calculateTotalPrice();
        });

        // Submit button click handler (you can replace it with your actual submit action)
        $('#submitBtn').click(function() {
            var formData = {};
            $('.priceInput').each(function() {
                formData[$(this).parent().text().trim()] = $(this).val();
            });
            alert('Form data: ' + JSON.stringify(formData));
        });
    });
</script>


<div class="container mt-5">
    <h2>Client Service Details</h2>
    <div style="max-height: 400px; overflow-y: auto;">
        <table class="table" style="width: 100%; table-layout: fixed;">
            <thead>
                <tr>
                    <th>Service</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Payment Status</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>

                    @if(isset($clientAllSubServices))
                        @if(count($clientAllSubServices) > 0)
                            @foreach($clientAllSubServices as $clientEachSubServices)
                                <tr>
                                    <td>{{ $clientEachSubServices->SubServiceTaken->sub_service_name }}</td>

                                    <td>  
                                        @if($clientEachSubServices->is_allocated == '0')
                                            Not Allocated
                                        @elseif($clientEachSubServices->is_allocated == '1' && $clientEachSubServices->is_completed == '0')
                                            In Progress
                                        @elseif($clientEachSubServices->is_completed == '1')
                                            Completed
                                        @endif
                                    </td>

                                    <td>{{ $clientEachSubServices->entry_date}}</td>

                                    <td>
                                        @if($clientEachSubServices->payment_status == null)
                                            <span style = "font-size: 14px; color : #343434;"><b><i>Bill not generated</i></b></span>
                                        @else
                                            {{$clientEachSubServices->payment_status}}
                                        @endif
                                    </td>
                                    <td>
                                        @if($clientEachSubServices->payment_amount == null)
                                            <span style = "font-size: 14px; color : #343434;"><b><i>-------------</i></b></span>
                                        @else
                                            &#8377; {{$clientEachSubServices->payment_amount}} /-
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @endif
            </tbody>
        </table>
    </div>
</div>
@include('footer')
