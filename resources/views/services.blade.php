@include('header')



@php
    $index = 0;
    $task_counter = 0;
@endphp


<script>
    // Automatically hide alerts after 5 seconds
    setTimeout(function() {
        document.getElementById('errorAlert').style.display = 'none';
        document.getElementById('successAlert').style.display = 'none';
        document.getElementById('updateSuccessAlert').style.display = 'none';
    }, 20000);
</script>

<!-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
        </ul>
    </div>
@endif -->

<h1 class="mt-4">Services</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Services</li>
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

<form method="POST" action="{{ route('service_C') }}" class="position-relative">
    @csrf
    <div class="mb-3">
        <label for="service_name" class="form-label">Service Name</label>
        <input type="text" class="form-control" id="service_name" name="service_name" required
               value="{{ old('service_name') }}">
    </div>
    <div id="sub_services_container" style="margin-left: 5%">
        <!-- Default sub-service and task fields -->
        <div class="mb-3 sub-service border border-secondary rounded p-3">
            <label class="form-label">Sub-service Name</label>
            <div class="position-relative">
                <input type="text" class="form-control" name="sub_services[{{$index}}][sub_service_name]" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Frequency</label>
                <select class="form-control" name="sub_services[{{$index}}][frequency]">
                    <option value="monthly">Monthly</option>
                    <option value="bimonthly">Bimonthly</option>
                    <option value="quarterly">Quarterly</option>
                    <option value="four-monthly">Every 4 months</option>
                    <option value="biannually">Biannually</option>
                    <option value="annually">Annually</option>
                    <option value="once">Once</option>
                </select>
            </div>
            <div class="mb-3" style="margin-left: 5%">
                <label class="form-label">Tasks</label>
                <div class="task_fields">
                    <div class="mb-3 task" style="display: flex">
                        <input type="text" class="form-control" name="sub_services[{{$index}}][tasks][{{$task_counter}}][]" required>
                        <!-- Delete button -->
                        <button type="button" class="btn btn-sm btn-danger delete_btn delete_task" style="display: none;">Delete</button>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-light add_task">Add Task</button>
            </div>
        </div>
    </div>

    <div id="dynamicServiceContainer"></div>

    <button type="button" class="btn btn-secondary mb-3" onclick = "addStudentFields()">Add Sub-service</button>

    <!-- Submit button -->
    <button type="submit" class="btn btn-primary position-absolute bottom-0 end-0">Submit</button>
</form>

<!-- Template for task fields -->
<div id="task_template" style="display: none;">

    <div class="mb-3 task" style="display: flex">
        <input type="text" class="form-control" name="sub_services[{{$index}}][tasks][{{$task_counter}}][]" required>
        <!-- Delete button for task -->
        <button type="button" class="btn btn-sm btn-danger delete_btn delete_task" style="margin-left: 10px">Delete</button>
    </div>
</div>

<!-- Template for task fields -->

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>

        var js_index = 0;
        var js_task_counter = 0;

        function addStudentFields() {
            var container = document.getElementById("dynamicServiceContainer");
            var studentFieldsDiv = document.createElement("div");
            studentFieldsDiv.classList.add("row", "mb-3", "mt-3");

            js_index++;
            js_task_counter++;

            studentFieldsDiv.innerHTML = `

                <div id="sub_service_template">
                        <div class="mb-3 sub-service border border-secondary rounded p-3 position-relative">
                            <label class="form-label">Sub-service Name</label>
                            <div style="display: flex; align-items: center;">
                                <input type="text" class="form-control" name="sub_services[${js_index}][sub_service_name]" required>
                                <!-- Delete button for sub-service -->
                                <button type="button" class="btn btn-sm btn-danger delete_btn delete_sub_service" style="position: absolute; top: 5px; right: 5px;">Delete</button>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Frequency</label>
                                <select class="form-control" name="sub_services[${js_index}][frequency]">
                                    <option value="monthly">Monthly</option>
                                    <option value="bimonthly">Bimonthly</option>
                                    <option value="quarterly">Quarterly</option>
                                    <option value="four-monthly">Every 4 months</option>
                                    <option value="biannually">Biannually</option>
                                    <option value="annually">Annually</option>
                                    <option value="once">Once</option>
                                </select>
                            </div>
                            <div class="mb-3" style="margin-left: 5%">
                                <label class="form-label">Tasks</label>
                                <div class="task_fields">
                                    <div class="mb-3">
                                        <input type="text" class="form-control" name="sub_services[${js_index}][tasks][${js_task_counter}][]" required>
                                    </div>
                                </div>

                                <div class="task_fields" id="dynamicTaskContainer_${js_index}"></div>
                                <button type="button" class="btn btn-sm btn-light" onclick="addTasksFields(${js_index})">Add Task</button>

                            </div>
                        </div>
                </div>
            `;

            container.appendChild(studentFieldsDiv);
        }

        function addTasksFields(index) {
            var container2 = document.getElementById(`dynamicTaskContainer_${index}`);
            var TaskFieldsDiv = document.createElement("div");
            TaskFieldsDiv.classList.add("row", "mb-3", "mt-3");

            TaskFieldsDiv.innerHTML = `

                <div id="task_template2">

                    <div class="mb-3 task" style="display: flex">
                        <input type="text" class="form-control" name="sub_services[${index}][tasks][${js_task_counter}][]" required>
                        <!-- Delete button for task -->
                        <button type="button" class="btn btn-sm btn-danger delete_btn delete_task2" style="margin-left: 10px">Delete</button>
                    </div>
                </div>

            `;

            container2.appendChild(TaskFieldsDiv);
        }

    $(document).ready(function () {
        const addSubServiceBtn = $('#add_sub_service');
        const subServicesContainer = $('#sub_services_container');
        const subServiceTemplate = $('#sub_service_template').html();
        const taskTemplate = $('#task_template').html();
        const taskTemplate2 = $('#task_template2').html();

        // Function to add a new sub-service
        function addSubService() {
            const newSubService = $(subServiceTemplate);
            subServicesContainer.append(newSubService);
            newSubService.find('.delete_btn').show();
        }

        // Function to add a new task field
        function addTask(btn) {
            const taskContainer = btn.closest('.mb-3').find('.task_fields');
            const newTask = $(taskTemplate);
            taskContainer.append(newTask);
            newTask.find('.delete_btn').show();
        }

        function addTask2(btn) {
            const taskContainer = btn.closest('.mb-3').find('.task_fields');
            const newTask = $(taskTemplate2);
            taskContainer.append(newTask);
            newTask.find('.delete_btn').show();
        }

        // Function to delete sub-service
        function deleteSubService(btn) {
            btn.closest('.sub-service').remove();
        }

        // Add event listeners
        addSubServiceBtn.on('click', addSubService);
        $(document).on('click', '.add_task', function () {
            addTask($(this));
        });
        $(document).on('click', '.add_task2', function () {
            addTask2($(this));
        });
        $(document).on('click', '.delete_sub_service', function () {
            deleteSubService($(this));
        });
        // Delete task
        $(document).on('click', '.delete_task', function () {
            $(this).closest('.task').remove();
        });

        $(document).on('click', '.delete_task2', function () {
            $(this).closest('.task').remove();
        });

        // Show delete button for user-added sub-services and tasks
        $(document).on('focus', '.sub-service input', function () {
            $(this).siblings('.delete_sub_service').show();
        });
        $(document).on('focus', '.task input', function () {
            $(this).siblings('.delete_task').show();
        });

        // Hide delete button for default sub-service and tasks
        $('.sub-service input').first().on('focus', function () {
            $(this).siblings('.delete_sub_service').hide();
        });
        $('.task input').first().on('focus', function () {
            $(this).siblings('.delete_task').hide();
        });
    });
</script>


<table class="table">
    <thead>
        <tr>
            <th>Service Name</th>
            <th>Action</th>
        </tr>
    </thead>


    <tbody>

        @if (count($allServices) > 0)
            @foreach ($allServices as $eachService)
                <tr>
                    <td>{{ $eachService->service_name }}</td>
                    <td>
                        <button class="btn btn-success edit-btn" type="button" onclick = "changePage({{ $eachService->id }})"><i class="far fa-edit"></i></button>

                        @if ($eachService->is_active == '1')
                            <a class="btn btn-light"
                                onclick="return confirm('Are you sure to deactivate this service !')"
                                href="{{ route('deactivating_service', $eachService->id) }}">
                                Deactivate
                            </a>
                        @endif

                        @if ($eachService->is_active == '0')
                            <a class="btn btn-light" onclick="return confirm('Are you sure to activate this service !')"
                                href="{{ route('activating_service', $eachService->id) }}">
                                Activate
                            </a>
                        @endif

                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="2" style = "text-align: center;">No any service added yet !</td>
            </tr>
        @endif

    </tbody>
</table>

<script>
    function changePage(mainServiceID) {
        window.location.href = "/service_details/" + mainServiceID;
    }
</script>
@include('footer')
