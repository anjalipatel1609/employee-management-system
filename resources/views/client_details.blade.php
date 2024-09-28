@include('header')
<h1 class="mt-4">{{ $clientToShow->client_name }}</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ url(route('client')) }}">Client</a></li>
    <li class="breadcrumb-item active">{{ $clientToShow->client_name }}</li>
</ol>

@php
    $frequencyData = []; // Preload frequency data from PHP into JavaScript
    foreach($allSubServicesWithMainService as $eachService) {
        $frequencyData[$eachService->id] = explode(',', $eachService->frequency);
    }
@endphp

<script>
    var frequencyData = @json($frequencyData); 
</script>

@if ($errors->any())
    <div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
        @foreach ($errors->all() as $error)
            {{ $error }}<br>
        @endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (Session::has('success'))
    <div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('updating_client_service_details', $clientToShow->id) }}" class="row g-3 mt-2" method="POST">
    @csrf
    @foreach($Clients_service as $index => $eachClients_service)
        <input type="hidden" name="client_service_ID[]" value = "{{ $eachClients_service->id }}">

        <div class="col-md-6">
            <label class="form-label" for="DefaultDDL{{ $index }}">Services</label>
            <select class="form-select border border-secondary" id="DefaultDDL{{ $index }}" name="sub_service_id[]">
                <option value="{{ $eachClients_service->id }}">{{ $eachClients_service->SubServiceTaken->mainService->service_name }} 
                    &nbsp;&nbsp;|&nbsp;&nbsp;
                    {{ $eachClients_service->SubServiceTaken->sub_service_name }}</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="frequencyDropdown{{ $index }}">Time</label>
            <select class="form-select border border-secondary" id="frequencyDropdown{{ $index }}" name="starting_period[]">
                <option value="{{ $eachClients_service->starting_period }}">{{ $eachClients_service->starting_period }}</option>
            </select>
        </div>
    @endforeach

    <div id="dynamicTextBoxContainer"></div>
    <button class="btn btn-primary col-2" onclick="addStudentFields()" style="margin-left:auto" type="button">
        Add Service
    </button>
    <div class="col-12">
        <button class="btn btn-primary" type="submit">Save</button>
    </div>
</form>
<script>
        var totalPrice = 0;
        var count = 0;

        function addStudentFields() {
            var container = document.getElementById("dynamicTextBoxContainer");
            var studentFieldsDiv = document.createElement("div");
            studentFieldsDiv.classList.add("row", "mb-3");

            count++;

            studentFieldsDiv.innerHTML = `
            
                <div class="col-12" style="display:flex; ">

                    <select class="form-select border border-secondary" id="inputStNidhi_${count}" onchange = "getDataF(this.value)" name="sub_service_id_new[]" required>
                    <option disabled selected style = "text-align : center;">Select Services</option>
                        @if(count($allSubServicesWithMainService) > 0)
                            @foreach($allSubServicesWithMainService as $eachService)
                                <option value="{{ $eachService->id }}">{{ $eachService->mainService->service_name }}  &nbsp;&nbsp;|&nbsp;&nbsp; {{ $eachService->sub_service_name }}</option>       
                            @endforeach
                        @endif
                    </select>

                    <select class="form-select border border-secondary" style="margin-left:10px" id="freeDDlNidhi_${count}" name="starting_period_new[]" required>
                        <option disabled selected style = "text-align : center;">Please Select Any Services First</option>
                    </select>
                  
                    <button class="btn btn-danger" type="button" onclick="removeStudentFields(this)" style="margin-left:10px;"><i class="far fa-trash-alt"></i></button>
                </div>
            `;

            container.appendChild(studentFieldsDiv);
        }

        // JavaScript function to remove student fields
        function removeStudentFields(deleteButton) {
            var container = document.getElementById("dynamicTextBoxContainer");
            var fieldDiv = deleteButton.parentNode.parentNode; // Get the parent row div
            container.removeChild(fieldDiv);
            updateTotal();

        }
       // Function to update the total price
    function updateTotal() {
        var total = 0;
        var priceInputs = document.getElementsByName("service_price[]");
        priceInputs.forEach(function(input) {
            if (!isNaN(input.value) && input.value.trim() !== '') {
                total += parseFloat(input.value);
            }
        });

        // Update total price on the page
        totalPrice = total;
        document.getElementById("totalAmount").value = totalPrice;
    }
</script>

<script>

    function getDataF(serviceId) {
        var serviceId = serviceId; 
        var count = document.getElementById("dynamicTextBoxContainer").childElementCount;
        var timeDropdown2 = document.getElementById(`freeDDlNidhi_${count}`);
        var frequencies = frequencyData[serviceId]; 

        var currentMonth = new Date().getMonth(); 
        var currentYear = new Date().getFullYear(); 
        var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        timeDropdown2.innerHTML = '';

        var defaultOption = document.createElement('option');
        defaultOption.value = ''; 
        defaultOption.text = 'Select Frequency'; 
        defaultOption.selected = true;
        defaultOption.disabled = true;
        timeDropdown2.appendChild(defaultOption);

        if (frequencies) {
            frequencies.forEach(function(frequency) {
                var option = document.createElement('option');
                option.value = frequency;

                switch (frequency) {
                    case 'monthly':
                        for (var i = currentMonth; i < currentMonth + 12; i++) {
                            var monthIndex = i % 12; 
                            var selectedMonth = months[monthIndex];
                            var selectedYear = currentYear;
                            option = document.createElement('option');
                            option.value = selectedMonth + ' ' + selectedYear; 
                            option.text = selectedMonth + ' ' + selectedYear;
                            timeDropdown2.appendChild(option);
                        }
                        break;
                    case 'bimonthly':
                        for (var i = currentMonth + 1; i < currentMonth + 12; i += 2) {
                            var monthIndex = i % 12; 
                            var selectedMonth1 = months[monthIndex];
                            var selectedYear1 = currentYear;
                            var selectedMonth2 = months[(monthIndex + 1) % 12];
                            var selectedYear2 = currentYear;
                            if (monthIndex === 11) {
                                selectedYear2 = currentYear + 1;
                            }
                            option = document.createElement('option');
                            option.value = selectedMonth1 + ' ' + selectedYear1 + ' - ' + selectedMonth2 + ' ' + selectedYear2;
                            option.text = selectedMonth1 + ' ' + selectedYear1 + ' - ' + selectedMonth2 + ' ' + selectedYear2;
                            timeDropdown2.appendChild(option);
                        }
                        break;
                    case 'quarterly':
                        for (var i = currentMonth + 2; i < currentMonth + 12; i += 3) {
                            var monthIndex1 = i % 12; 
                            var selectedMonth1 = months[monthIndex1];
                            var selectedYear1 = currentYear;
                            var monthIndex2 = (i + 1) % 12; 
                            var selectedMonth2 = months[monthIndex2];
                            var selectedYear2 = currentYear;
                            var monthIndex3 = (i + 2) % 12; 
                            var selectedMonth3 = months[monthIndex3];
                            var selectedYear3 = currentYear;
                            if (monthIndex3 === 0) {
                                selectedYear3 = currentYear + 1;
                            }
                            option = document.createElement('option');
                            option.value = selectedMonth1 + ' ' + selectedYear1 + ' - ' + selectedMonth3 + ' ' + selectedYear3;
                            option.text = selectedMonth1 + ' ' + selectedYear1 + ' - ' + selectedMonth3 + ' ' + selectedYear3;
                            timeDropdown2.appendChild(option);
                        }
                        break;
                    case 'four-monthly':
                        for (var i = currentMonth + 3; i < currentMonth + 12; i += 4) {
                            var monthIndex1 = i % 12; 
                            var selectedMonth1 = months[monthIndex1];
                            var selectedYear1 = currentYear;
                            var monthIndex2 = (i + 1) % 12; 
                            var selectedMonth2 = months[monthIndex2];
                            var selectedYear2 = currentYear;
                            var monthIndex3 = (i + 2) % 12; 
                            var selectedMonth3 = months[monthIndex3];
                            var selectedYear3 = currentYear;
                            var monthIndex4 = (i + 3) % 12; 
                            var selectedMonth4 = months[monthIndex4];
                            var selectedYear4 = currentYear;
                            if (monthIndex4 === 0) {
                                selectedYear4 = currentYear + 1;
                            }
                            option = document.createElement('option');
                            option.value = selectedMonth1 + ' ' + selectedYear1 + ' - ' + selectedMonth4 + ' ' + selectedYear4;
                            option.text = selectedMonth1 + ' ' + selectedYear1 + ' - ' + selectedMonth4 + ' ' + selectedYear4;
                            timeDropdown2.appendChild(option);
                        }
                        break;
                    case 'biannually':
                        var selectedYear1 = currentYear;
                        var selectedYear2 = currentYear + 1;
                        option = document.createElement('option');
                        option.value = 'April ' + selectedYear1 + ' - September ' + selectedYear1;
                        option.text = 'April ' + selectedYear1 + ' - September ' + selectedYear1;
                        timeDropdown2.appendChild(option);
                        option = document.createElement('option');
                        option.value = 'October ' + selectedYear1 + ' - March ' + selectedYear2;
                        option.text = 'October ' + selectedYear1 + ' - March ' + selectedYear2;
                        timeDropdown2.appendChild(option);
                        break;
                    case 'annually':
                        for (var i = 0; i < 5; i++) {
                            var selectedYear = currentYear + i;
                            option = document.createElement('option');
                            option.value = 'April ' + selectedYear + ' - March ' + (selectedYear + 1);
                            option.text = 'April ' + selectedYear + ' - March ' + (selectedYear + 1);
                            timeDropdown2.appendChild(option);
                        }
                        break;

                    case 'once':
                        var currentDate = new Date();
                        var selectedDate = currentDate.getDate();
                        var selectedMonth = months[currentDate.getMonth()];
                        var selectedYear = currentDate.getFullYear();
                        option.value = 'Once | ' + selectedDate + '-' + selectedMonth + '-' + selectedYear;
                        option.text = 'Once | ' + selectedDate + '-' + selectedMonth + '-' + selectedYear;
                        timeDropdown2.appendChild(option);
                        break;

                }
            });
        }
    }
</script>
@include('footer')
