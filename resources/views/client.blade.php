@include('header')
<h1 class="mt-4">Client</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Client</li>
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

@if (Session::has('update_success'))
    <div id="updateSuccessAlert" class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('update_success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ route('client_C') }}" class="row g-3 mt-2" method="POST">
    @csrf
    <div class="col-12">
        <label class="form-label" for="inputgp">Client Name</label>
        <input class="form-control border border-secondary" id="inputgp" name="client_name" placeholder="Client Name" required
               type="text">
    </div>
    <div class="col-md-6">
        <label class="form-label" for="inputmentor">Phone</label>
        <input class="form-control border border-secondary" maxlength="10" id="inputprj" name="phone" placeholder="Phone"
               required type="text">
    </div>
    <div class="col-md-6">
        <label class="form-label" for="inputprj">Email</label>
        <input class="form-control border border-secondary" id="inputprj" name="email" placeholder="Email"
               required type="email">
    </div>
    <div class="col-md-6">
        <label class="form-label" for="inputStAnjali">Services</label>
        <select class="form-select border border-secondary" id="inputStAnjali" name="sub_service_id[]" required>
            <option value = "" disabled selected style = "text-align : center;">Select Services</option>
            @if(count($allSubServicesWithMainService) > 0)
                @foreach($allSubServicesWithMainService as $eachService)
                    <option value="{{ $eachService->id }}">{{ $eachService->mainService->service_name }}  &nbsp;&nbsp;|&nbsp;&nbsp; {{ $eachService->sub_service_name }}</option>       
                @endforeach
            @endif
        </select>
    </div>
    <div class="col-md-6">
    <label class="form-label" for="inputprj">Time</label>
    <select class="form-select border border-secondary" id="frequencyDropdown" name="starting_period[]" required>
        <option value = "" disabled selected style = "text-align : center;">Please Select Any Services First</option>
    </select>
    </div>

    <div id="dynamicTextBoxContainer"></div>

    <button class="btn btn-primary col-2" onclick="addStudentFields()" style="margin-left:auto" type="button">
        Add Service
    </button>
    <div class="col-12">
        <button class="btn btn-primary" type="submit">Register Client</button>
    </div>
    
    <script>
        var totalPrice = 0;

        var count = 0;


        // JavaScript function to add student fields
        function addStudentFields() {
            var container = document.getElementById("dynamicTextBoxContainer");
            var studentFieldsDiv = document.createElement("div");
            studentFieldsDiv.classList.add("row", "mb-3");

            count++;

            studentFieldsDiv.innerHTML = `
                <div class="col-12" style="display:flex; ">

                    <select class="form-select border border-secondary" id="inputStNidhi_${count}" onchange = "getDataF(this.value)" name="sub_service_id[]" required>
                    <option value = "" disabled selected style = "text-align : center;">Select Services</option>
                        @if(count($allSubServicesWithMainService) > 0)
                            @foreach($allSubServicesWithMainService as $eachService)
                                <option value="{{ $eachService->id }}">{{ $eachService->mainService->service_name }}  &nbsp;&nbsp;|&nbsp;&nbsp; {{ $eachService->sub_service_name }}</option>       
                            @endforeach
                        @endif
                    </select>

                    <select class="form-select border border-secondary" style="margin-left:10px" id="freeDDlNidhi_${count}" name="starting_period[]" required>
                        <option disabled value = "" selected style = "text-align : center;">Please Select Any Services First</option>
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
        }
      


        // Object to store original data for each row
        const originalClientData = {};

        // Function to handle edit button click for client table
        function editClientRow(button) {
            const row = button.closest('tr');
            const clientId = row.cells[0].innerText;
            const clientName = row.cells[1].innerText;
            const phone = row.cells[2].innerText;
            const email = row.cells[3].innerText;

            // Store original data
            originalClientData[row.rowIndex] = {
                clientId: clientId,
                clientName: clientName,
                phone: phone,
                email: email
            };

            // Replace cell contents with input fields
            row.cells[1].innerHTML = `<input type="text" class="form-control" value="${clientName}">`;
            row.cells[2].innerHTML = `<input type="text" class="form-control" value="${phone}">`;
            row.cells[3].innerHTML = `<input type="text" class="form-control" value="${email}">`;

            // Change buttons to Save and Cancel
            row.cells[4].innerHTML = `
                <button class="btn btn-primary save-client-btn" onclick="saveClientRow(this)" type="button">
                    <i class="far fa-save"></i> Save
                </button>
                <button class="btn btn-secondary cancel-client-btn" onclick="cancelClientEdit(this)" type="button">
                    <i class="fas fa-times"></i> Cancel
                </button>
            `;
        }

        // Function to handle save button click for client table
        function saveClientRow(button) {
            const row = button.closest('tr');
            const clientNameInput = row.cells[1].querySelector('input');
            const phoneInput = row.cells[2].querySelector('input');
            const emailInput = row.cells[3].querySelector('input');

            const updatedClientName = clientNameInput.value;
            const updatedPhone = phoneInput.value;
            const updatedEmail = emailInput.value;

            // AJAX request to send updated data
            $.ajax({
                url: '/your-client-update-route', // Replace with your actual update route
                method: 'POST',
                data: {
                    client_name: updatedClientName,
                    phone: updatedPhone,
                    email: updatedEmail
                },
                success: function(response) {
                    // Update the row with new values if request is successful
                    row.cells[1].innerText = updatedClientName;
                    row.cells[2].innerText = updatedPhone;
                    row.cells[3].innerText = updatedEmail;

                    // Change buttons back to Edit and Activate
                    row.cells[4].innerHTML = `
                        <button class="btn btn-success edit-btn" type="button" onclick="editClientRow(this)">
                            <i class="far fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-success eye-btn" type="button"><i class="far fa-eye"></i></button>
                        
                        @if(isset($eachClient))
                            @if($eachClient->is_active == "1")
                                <button class="btn btn-light" type="button" onclick="activateRow(this)">
                                    Deactivate
                                </button>
                            @endif

                            @if($eachClient->is_active == "0")
                                <button class="btn btn-light" type="button" onclick="activateRow(this)">
                                    Activate
                                </button>
                            @endif
                        @endif
                    `;
                },
                error: function(xhr, status, error) {
                    // Handle error if needed
                    console.error('Error updating client:', error);
                }
            });
        }

        // Function to handle cancel button click for client table
        function cancelClientEdit(button) {
            const row = button.closest('tr');

            // Restore original data
            row.cells[1].innerText = originalClientData[row.rowIndex].clientName;
            row.cells[2].innerText = originalClientData[row.rowIndex].phone;
            row.cells[3].innerText = originalClientData[row.rowIndex].email;

            // Change buttons back to Edit and Activate
            row.cells[4].innerHTML = `
                <button class="btn btn-success edit-btn" type="button" onclick="editClientRow(this)">
                    <i class="far fa-edit"></i> Edit
                </button>
                <button class="btn btn-success eye-btn" type="button"><i class="far fa-eye"></i></button>
                <button class="btn btn-light" type="button" onclick="activateClientRow(this)">
                    Activate
                </button>
            `;
        }

        
    </script>
</form>

<script>
    document.getElementById('inputStAnjali').addEventListener('change', function() {
        var serviceId = this.value; 
        var timeDropdown = document.getElementById('frequencyDropdown');
        var frequencies = frequencyData[serviceId]; 
        var currentMonth = new Date().getMonth(); 
        var currentYear = new Date().getFullYear(); 
        var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        timeDropdown.innerHTML = '';

        var defaultOption = document.createElement('option');
        defaultOption.value = ''; 
        defaultOption.text = 'Select Frequency'; 
        defaultOption.selected = true;
        defaultOption.disabled = true;
        timeDropdown.appendChild(defaultOption);

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
                            timeDropdown.appendChild(option);
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
                            timeDropdown.appendChild(option);
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
                            timeDropdown.appendChild(option);
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
                            timeDropdown.appendChild(option);
                        }
                        break;
                    case 'biannually':
                        var selectedYear1 = currentYear;
                        var selectedYear2 = currentYear + 1;
                        option = document.createElement('option');
                        option.value = 'April ' + selectedYear1 + ' - September ' + selectedYear1;
                        option.text = 'April ' + selectedYear1 + ' - September ' + selectedYear1;
                        timeDropdown.appendChild(option);
                        option = document.createElement('option');
                        option.value = 'October ' + selectedYear1 + ' - March ' + selectedYear2;
                        option.text = 'October ' + selectedYear1 + ' - March ' + selectedYear2;
                        timeDropdown.appendChild(option);
                        break;
                    case 'annually':
                        for (var i = 0; i < 5; i++) {
                            var selectedYear = currentYear + i;
                            option = document.createElement('option');
                            option.value = 'April ' + selectedYear + ' - March ' + (selectedYear + 1);
                            option.text = 'April ' + selectedYear + ' - March ' + (selectedYear + 1);
                            timeDropdown.appendChild(option);
                        }
                        break;

                    case 'once':
                        var currentDate = new Date();
                        var selectedDate = currentDate.getDate();
                        var selectedMonth = months[currentDate.getMonth()];
                        var selectedYear = currentDate.getFullYear();
                        option.value = 'Once | ' + selectedDate + '-' + selectedMonth + '-' + selectedYear;
                        option.text = 'Once | ' + selectedDate + '-' + selectedMonth + '-' + selectedYear;
                        timeDropdown.appendChild(option);
                        break;
                }
            });
        }
    });
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

<div class="mt-5">
    <table class="table">
        <thead>
            <tr>
                <th>Client Id</th>
                <th>Client Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Action</th>
                <th>Invoice</th>
            </tr>
        </thead>
        <tbody>
            @if(count($allClient) > 0)
                @foreach($allClient as $eachClient)
                <tr>
                    <td>{{ $eachClient->id }}</td>
                    <td>{{ $eachClient->client_name }}</td>
                    <td>{{ $eachClient->phone }}</td>
                    <td>{{ $eachClient->email }}</td>
                    <td>
                        <button class="btn btn-success edit-btn" type="button" data-bs-toggle="modal" data-bs-target="#editModal{{$eachClient->id}}"><i class="far fa-edit"></i></button>

                        <div class="modal fade" id="editModal{{$eachClient->id}}" tabindex="-1" aria-labelledby="editModalLabel{{$eachClient->id}}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel{{$eachClient->id}}">Edit Client Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="editForm{{$eachClient->id}}" method = "post" action = "{{ route('client_U', $eachClient->id) }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="editClientID{{$eachClient->id}}" class="form-label">Client ID</label>
                                                <input type="text" class="form-control" id="editClientID{{$eachClient->id}}" value = "{{$eachClient->id}}" readonly required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="editClientName{{$eachClient->id}}" class="form-label">Client Name</label>
                                                <input type="text" class="form-control" id="editClientName{{$eachClient->id}}" value = "{{$eachClient->client_name}}" name="client_name" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="editPhone{{$eachClient->id}}" class="form-label">Phone</label>
                                                <input type="text" class="form-control" id="editPhone{{$eachClient->id}}" maxlength="10" value = "{{$eachClient->phone}}" name="phone" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="editEmail{{$eachClient->id}}" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="editEmail{{$eachClient->id}}" value = "{{$eachClient->email}}" name="email" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="{{ url(route('client_details', $eachClient->id)) }}"><button class="btn btn-info eye-btn" type="button"><i class="far fa-eye"></i></button></a>
                        
                        @if($eachClient->is_active == "1")
                            <a class="btn btn-light" onclick="return confirm('Are you sure to deactivate this client !')" href="{{ route('deactivating_client', $eachClient->id) }}">
                                Deactivate
                            </a>
                        @endif

                        @if($eachClient->is_active == "0")
                            <a class="btn btn-light" onclick="return confirm('Are you sure to activate this client !')" href="{{ route('activating_client', $eachClient->id) }}">
                                Activate
                            </a>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('generate_invoice', $eachClient->id) }}"><button class="btn btn-primary eye-btn" type="button">Generate Invoice</button></a>

                    </td>
                </tr>
                @endforeach

            @else
                <tr>
                    <td colspan="6" style = "text-align: center;">No any user added yet !</td>
                </tr>
            @endif

        </tbody>
    </table>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

@include('footer')
