@include('header')
<h1 class="mt-4">Employees</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Employees</li>
</ol>

@if (Session::has('success'))
    <div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
        @foreach ($errors->all() as $error)
            {{ $error }}<br>
        @endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (Session::has('update_success'))
    <div id="updateSuccessAlert" class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('update_success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Employee Form -->
<form method="POST" class="row g-3 mt-2" action="{{ route('Employee_C') }}">
    @csrf
    <div class="col-12 mb-3">
        <label for="employee_name" class="form-label">Employee Name</label>
        <input type="text" class="form-control" id="employee_name" name="employee_name" value="{{ old('employee_name') }}" placeholder="Employee Name" required>
    </div>
    <div class="col-6  mb-3">
        <label for="employee_phone" class="form-label">Employee Phone</label>
        <input type="text" class="form-control" id="employee_phone" name="employee_phone" value="{{ old('employee_phone') }}" maxlength="10" placeholder="Employee Phone" required>
    </div>
    <div class="col-6 mb-3">
        <label for="employee_email" class="form-label">Employee Email</label>
        <input type="email" class="form-control" id="employee_email" name="employee_email" value="{{ old('employee_email') }}" placeholder="Employee Email" required>
    </div>
    <div class="col-12 mb-3">
        <label for="employee_address" class="form-label">Employee Address</label>
        <textarea class="form-control" id="employee_address" name="employee_address" rows="3" placeholder="Employee Address" required>{{ old('employee_address') }}</textarea>
    </div>

    <div class="col-12">
        <label class="form-label" for="inputSt">Select user type</label>
        <select class="form-select border border-secondary" id="inputSt" name="user_type" required>
            <option value="" selected disabled style = "text-align : center;">Select User Type</option>
            <option value="Employee">Employee</option>
            <option value="HR">HR</option>
        </select>
    </div>

    <div class="col-12 mb-3">
        <label for="employee_password" class="form-label">Employee Password</label>
        <input type="password" class="form-control" id="employee_password" value="{{ old('employee_password') }}" name="employee_password" placeholder="Employee Password" required>
    </div>
    <div class="col-12 mb-3">
        <label for="employee_confirm_password" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="employee_confirm_password" value="{{ old('employee_confirm_password') }}" name="employee_confirm_password" placeholder="Confirm Password" required>
    </div>
    <div class="col-12">
        <button class="btn btn-primary" type="submit">Register Employee</button>
    </div></form>

<!-- Employee Table -->
<table class="table">
    <thead>
        <tr>
            <th>Employee ID</th>
            <th>Employee Name</th>
            <th>Employee Phone</th>
            <th>Employee Email</th>
            <th>Employee Address</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

        @if(count($allEmployees) > 0)
            @foreach($allEmployees as $eachEmployee)
                <tr>
                    <td>{{ $eachEmployee->id }}</td>
                    <td>{{ $eachEmployee->employee_name }}</td>
                    <td>{{ $eachEmployee->employee_phone }}</td>
                    <td>{{ $eachEmployee->employee_email }}</td>
                    <td>{{ $eachEmployee->employee_address }}</td>
                    <td>
                        <button class="btn btn-success edit-btn" type="button" data-bs-toggle="modal" data-bs-target="#editModal{{$eachEmployee->id}}"><i class="far fa-edit"></i></button>

                        <div class="modal fade" id="editModal{{$eachEmployee->id}}" tabindex="-1" aria-labelledby="editModalLabel{{$eachEmployee->id}}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel{{$eachEmployee->id}}">Edit Employee Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="editForm{{$eachEmployee->id}}"  method = "post" action = "{{ route('employee_U', $eachEmployee->id) }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="editEmployeeID{{$eachEmployee->id}}" class="form-label">Employee ID</label>
                                                <input type="text" class="form-control" id="editEmployeeID{{$eachEmployee->id}}" value = "{{$eachEmployee->id}}" readonly required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="editEmployeeName{{$eachEmployee->id}}" class="form-label">Employee Name</label>
                                                <input type="text" class="form-control" id="editEmployeeName{{$eachEmployee->id}}" name="employee_name" value = "{{$eachEmployee->employee_name}}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="editEmployeePhone{{$eachEmployee->id}}" class="form-label">Employee Phone</label>
                                                <input type="text" class="form-control" id="editEmployeePhone{{$eachEmployee->id}}" name="employee_phone" maxlength="10" value = "{{$eachEmployee->employee_phone}}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="editEmployeeEmail{{$eachEmployee->id}}" class="form-label">Employee Email</label>
                                                <input type="email" class="form-control" id="editEmployeeEmail{{$eachEmployee->id}}" name="employee_email" value = "{{$eachEmployee->employee_email}}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="editEmployeeAddress{{$eachEmployee->id}}" class="form-label">Employee Address</label>
                                                <input type="text" class="form-control" id="editEmployeeAddress{{$eachEmployee->id}}" name="employee_address" value = "{{$eachEmployee->employee_address}}" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="{{ url(route('employee_details', $eachEmployee->id)) }}"><button class="btn btn-success eye-btn" type="button"><i class="far fa-eye"></i></button></a>

                        @if($eachEmployee->is_active == "1")
                            <a class="btn btn-light" onclick="return confirm('Are you sure to deactivate this employee !')" href="{{ route('deactivating_employee', $eachEmployee->id) }}">
                                Deactivate
                            </a>
                        @endif

                        @if($eachEmployee->is_active == "0")
                            <a class="btn btn-light" onclick="return confirm('Are you sure to activate this employee !')" href="{{ route('activating_employee', $eachEmployee->id) }}">
                                Activate
                            </a>
                        @endif

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

<!-- HR Table -->
<table class="table">
    <thead>
        <tr>
            <th>HR ID</th>
            <th>HR Name</th>
            <th>HR Phone</th>
            <th>HR Email</th>
            <th>HR Address</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

        @if(count($allHRs) > 0)
            @foreach($allHRs as $eachHR)
                <tr>
                    <td>{{ $eachHR->id }}</td>
                    <td>{{ $eachHR->employee_name }}</td>
                    <td>{{ $eachHR->employee_phone }}</td>
                    <td>{{ $eachHR->employee_email }}</td>
                    <td>{{ $eachHR->employee_address }}</td>
                    <td>
                    <button class="btn btn-success edit-btn" type="button" data-bs-toggle="modal" data-bs-target="#editModal{{$eachHR->id}}"><i class="far fa-edit"></i></button>

                    <div class="modal fade" id="editModal{{$eachHR->id}}" tabindex="-1" aria-labelledby="editModalLabel{{$eachHR->id}}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel{{$eachHR->id}}">Edit HR Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editForm{{$eachHR->id}}"  method = "post" action = "{{ route('employee_U', $eachHR->id) }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="editEmployeeID{{$eachHR->id}}" class="form-label">HR ID</label>
                                            <input type="text" class="form-control" id="editEmployeeID{{$eachHR->id}}" value = "{{$eachHR->id}}" readonly required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="editEmployeeName{{$eachHR->id}}" class="form-label">HR Name</label>
                                            <input type="text" class="form-control" id="editEmployeeName{{$eachHR->id}}" name="employee_name" value = "{{$eachHR->employee_name}}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="editEmployeePhone{{$eachHR->id}}" class="form-label">HR Phone</label>
                                            <input type="text" class="form-control" id="editEmployeePhone{{$eachHR->id}}" maxlength="10" name="employee_phone" value = "{{$eachHR->employee_phone}}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="editEmployeeEmail{{$eachHR->id}}" class="form-label">HR Email</label>
                                            <input type="email" class="form-control" id="editEmployeeEmail{{$eachHR->id}}" name="employee_email" value = "{{$eachHR->employee_email}}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="editEmployeeAddress{{$eachHR->id}}" class="form-label">HR Address</label>
                                            <input type="text" class="form-control" id="editEmployeeAddress{{$eachHR->id}}" name="employee_address" value = "{{$eachHR->employee_address}}" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                        <a href="{{ url(route('employee_details', $eachHR->id)) }}"><button class="btn btn-success eye-btn" type="button"><i class="far fa-eye"></i></button></a>

                        @if($eachHR->is_active == "1")
                            <a class="btn btn-light" onclick="return confirm('Are you sure to deactivate this HR !')" href="{{ route('deactivating_employee', $eachHR->id) }}">
                                Deactivate
                            </a>
                        @endif

                        @if($eachHR->is_active == "0")
                            <a class="btn btn-light" onclick="return confirm('Are you sure to activate this HR !')" href="{{ route('activating_employee', $eachHR->id) }}">
                                Activate
                            </a>
                        @endif

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

<!-- jQuery CDN -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    const originalEmployeeData = {};

    // Function to handle edit button click for employees
    function editEmployee(button) {
        const row = button.closest('tr');
        const employeeId = row.cells[0].innerText;
        const employeeNameCell = row.cells[1];
        const employeePhoneCell = row.cells[2];
        const employeeEmailCell = row.cells[3];
        const employeeAddressCell = row.cells[4];

        // Store original data
        originalEmployeeData[row.rowIndex] = {
            employeeName: employeeNameCell.innerText,
            employeePhone: employeePhoneCell.innerText,
            employeeEmail: employeeEmailCell.innerText,
            employeeAddress: employeeAddressCell.innerText
        };

        // Replace cell contents with input fields
        employeeNameCell.innerHTML = `<input type="text" class="form-control" value="${originalEmployeeData[row.rowIndex].employeeName}">`;
        employeePhoneCell.innerHTML = `<input type="text" class="form-control" value="${originalEmployeeData[row.rowIndex].employeePhone}">`;
        employeeAddressCell.innerHTML = `<textarea class="form-control" rows="3">${originalEmployeeData[row.rowIndex].employeeAddress}</textarea>`;

        // Change buttons to Save and Cancel
        row.cells[5].innerHTML = `
            <button class="btn btn-primary save-btn" onclick="saveEmployee(this, ${employeeId})" type="button">
                <i class="far fa-save"></i> Save
            </button>
            <button class="btn btn-secondary cancel-btn" onclick="cancelEditEmployee(this)" type="button">
                <i class="fas fa-times"></i> Cancel
            </button>
        `;
    }

    // Function to handle saving edited employee details
    function saveEmployee(button, employeeId) {
        const row = button.closest('tr');
        const employeeNameInput = row.cells[1].querySelector('input');
        const employeePhoneInput = row.cells[2].querySelector('input');
        const employeeAddressInput = row.cells[4].querySelector('textarea');

        const updatedEmployeeName = employeeNameInput.value;
        const updatedEmployeePhone = employeePhoneInput.value;
        const updatedEmployeeAddress = employeeAddressInput.value;

        // AJAX request to send updated data
        $.ajax({
            url: '/your-specific-route',
            method: 'POST',
            data: {
                employee_id: employeeId,
                employee_name: updatedEmployeeName,
                employee_phone: updatedEmployeePhone,
                employee_address: updatedEmployeeAddress
            },
            success: function(response) {
                // Update the row with new values if request is successful
                row.cells[1].innerText = updatedEmployeeName;
                row.cells[2].innerText = updatedEmployeePhone;
                row.cells[4].innerText = updatedEmployeeAddress;

                // Change buttons back to Edit
                row.cells[5].innerHTML = `
                    <button class="btn btn-success edit-btn" type="button" onclick="editEmployee(this)">
                        <i class="far fa-edit"></i> Edit
                    </button>
                `;
            },
            error: function(xhr, status, error) {
                // Handle error if needed
                console.error('Error updating employee:', error);
            }
        });
    }

    // Function to handle cancel button click for employees
    function cancelEditEmployee(button) {
        const row = button.closest('tr');

        // Restore original data
        row.cells[1].innerText = originalEmployeeData[row.rowIndex].employeeName;
        row.cells[2].innerText = originalEmployeeData[row.rowIndex].employeePhone;
        row.cells[4].innerText = originalEmployeeData[row.rowIndex].employeeAddress;

        // Change buttons back to Edit
        row.cells[5].innerHTML = `
        <button class="btn btn-success edit-btn" type="button" onclick="editEmployee(this)">
                    <i class="far fa-edit"></i> Edit
                </button>
                <button class="btn btn-success eye-btn" type="button"><i class="far fa-eye"></i></button>
                
                @if(isset($eachEmployee))
                        @if($eachEmployee->is_active == "1")
                            <a class="btn btn-light" onclick="return confirm('Are you sure to deactivate this employee !')" href="{{ route('deactivating_employee', $eachEmployee->id) }}">
                                Deactivate
                            </a>
                        @endif

                        @if($eachEmployee->is_active == "0")
                            <a class="btn btn-light" onclick="return confirm('Are you sure to activate this employee !')" href="{{ route('activating_employee', $eachEmployee->id) }}">
                                Activate
                            </a>
                        @endif
                @endif
        `;
    }
</script>
@include('footer')
