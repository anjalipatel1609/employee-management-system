@include('header')

@if (Session::has('success'))
    <br><br>
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


<h1 class="mt-4">Services</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ url(route('services')) }}">Service</a></li>
    <li class="breadcrumb-item active">Service Name</li>
</ol>


@php
    $task_counter = 0;
@endphp


<form method="POST" action="{{ route('updateService', $service_to_show->id) }}" class="position-relative">
    @csrf
    <div class="mb-3">
        <label for="service_name" class="form-label">Service Name</label>
        <input type="text" class="form-control" id="service_name" name="service_name" required
               value="{{ $service_to_show->service_name }}">
    </div>
    <div id="sub_services_container" style="margin-left: 5%">
        <!-- Server data for sub-services and tasks -->
        @if(isset($service_to_show))
            @foreach($service_to_show->subServices as $subServiceIndex => $subService)
                <div class="mb-3 sub-service border border-secondary rounded p-3">
                    <input type="hidden" name="sub_services[{{ $subServiceIndex }}][id]" value="{{ $subService->id }}">

                    <label class="form-label">Sub-service Name</label>
                    @if($subServiceIndex > 0)
                    <!-- Delete button for subservice (except the first one) -->
                    <a onclick = "return confirm('Are you sure to delete this sub-service !')" href="{{ route('deleting_sub_service', $subService->id) }}" class="btn btn-sm btn-danger delete_btn">Delete Sub-service</a>
                    @endif
                    <div class="position-relative">
                        <input type="text" class="form-control" name="sub_services[{{ $subServiceIndex }}][sub_service_name]" required value="{{ $subService->sub_service_name }}">
                    </div>

                    <div class="mb-3 mt-3">
                        <label class="form-label">Frequency</label>
                        <select class="form-control" name="sub_services[{{ $subServiceIndex }}][frequency]">
                            <option value="monthly" {{ $subService->frequency == 'monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="bimonthly" {{ $subService->frequency == 'bimonthly' ? 'selected' : '' }}>Bimonthly</option>
                            <option value="quarterly" {{ $subService->frequency == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                            <option value="four-monthly" {{ $subService->frequency == 'four-monthly' ? 'selected' : '' }}>Every 4 months</option>
                            <option value="biannually" {{ $subService->frequency == 'biannually' ? 'selected' : '' }}>Biannually</option>
                            <option value="annually" {{ $subService->frequency == 'annually' ? 'selected' : '' }}>Annually</option>
                            <option value="once" {{ $subService->frequency == 'once' ? 'selected' : '' }}>Once</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tasks</label>
                        <div class="task_fields" id = "BPCCS_KSV">
                            @foreach($subService->subServiceTasks as $taskIndex => $task)

                                @php
                                    $task_counter++;
                                @endphp

                                <div class="mb-3 task only_existing_task" style="display: flex">
                                    
                                    <input type="hidden" name="sub_services[{{ $subServiceIndex }}][tasks][{{ $taskIndex }}][id]" value="{{ $task->id }}">

                                    <input type="text" class="form-control" name="sub_services[{{ $subServiceIndex }}][tasks][{{ $taskIndex }}][task]" required value="{{ $task->task }}">
                                    @if($taskIndex > 0)
                                    <!-- Delete button for task (except the first one) -->
                                    <a onclick = "return confirm('Are you sure to delete this task !')"  href="{{ route('deleting_task', $task->id) }}"  class="btn btn-sm btn-danger delete_btn">
                                        <i class="fas fa-trash-alt fa-lg"></i> <!-- Font Awesome trash icon with large size -->
                                    </a>
                                    
                                    @endif
                                </div>
                            @endforeach

                            <div class="task_fields" id="dynamicTaskContainer3_{{ $subServiceIndex }}"></div>

                            <!-- Add Task button -->

                            <button type="button" class="btn btn-sm btn-light mb-2" onclick="addTasksFields2({{ $subServiceIndex }})">Add Task</button>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

        <div id="dynamicServiceContainer"></div>

    </div>
    <!-- Add sub-service button -->
    <button type="button" class="btn btn-secondary mb-3"  onclick = "addSubServiceFields()">Add Sub-service</button>
    <!-- Submit button -->
    <button type="submit" class="btn btn-primary position-absolute bottom-0 end-0">Submit</button>
</form>


<!-- Sub-service template -->
<div id="sub_service_template" style="display: none;">
    <div class="mb-3 sub-service border border-secondary rounded p-3 position-relative">
        <label class="form-label">Sub-service Name</label>
        <button type="button" class="btn btn-sm btn-danger delete_btn delete_sub_service">Delete Sub-service</button>

        <div class="position-relative">
            <input type="text" class="form-control" name="sub_service_name[]" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tasks</label>
            <div class="task_fields">
                <div class="mb-3 task" style="display: flex">
                    <input type="text" class="form-control" name="task[]" required>
                </div>
                <!-- Add Task button -->
                <button type="button" class="btn btn-sm btn-light add_task mb-2">Add Task</button>
            </div>
        </div>
    </div>
</div>

<!-- Task template -->
<div id="task_template" style="display: none;">
    <div class="mb-3 task" style="display: flex">
        <input type="text" class="form-control" name="task[]" required>
        <button type="button" class="btn btn-sm btn-danger delete_btn delete_task">
            <i class="fas fa-trash-alt fa-lg"></i> <!-- Font Awesome trash icon with large size -->
        </button>
    </div>
</div>

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>

        var js_index = -1;
        var js_task_counter = -1;

        function addSubServiceFields() {
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
                            
                                <input type="text" class="form-control" name="new_sub_services[${js_index}][sub_service_name]" required>
                                <!-- Delete button for sub-service -->
                                <button type="button" class="btn btn-sm btn-danger delete_btn delete_sub_service" style="position: absolute; top: 5px; right: 5px;">Delete</button>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Frequency</label>
                                <select class="form-control" name="new_sub_services[${js_index}][frequency]">
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

                                        <input type="text" class="form-control" name="new_sub_services[${js_index}][new_tasks][${js_task_counter}][]" required>
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
                        <input type="text" class="form-control" name="new_sub_services[${js_index}][new_tasks][${js_task_counter}][]" required>
                        <!-- Delete button for task -->
                        <button type="button" class="btn btn-sm btn-danger delete_btn delete_task2" style="margin-left: 10px">Delete</button>
                    </div>
                </div>

            `;

            container2.appendChild(TaskFieldsDiv);
        }

        function addTasksFields2(subServiceIndexJS) {

            // console.log("hiiiii");

            var existingTaskCounterElement = document.getElementById("BPCCS_KSV");
            var only_existing_task = existingTaskCounterElement.getElementsByClassName("only_existing_task").length;

            var newTaskCounterElement = document.getElementById(`dynamicTaskContainer3_${subServiceIndexJS}`);
            var newly_added_task = newTaskCounterElement.getElementsByClassName("newly_added_task").length;

            var taskIndex = only_existing_task + newly_added_task;

            console.log(taskIndex);

            var container3 = document.getElementById(`dynamicTaskContainer3_${subServiceIndexJS}`);
            var TaskFieldsDiv2 = document.createElement("div");
            TaskFieldsDiv2.classList.add("row", "mb-3", "mt-3");

            TaskFieldsDiv2.innerHTML = `

                <div id="task_template3">

                    <div class="mb-3 task newly_added_task" style="display: flex">

                        <input type="text" class="form-control" name="sub_services[${subServiceIndexJS}][tasks][${taskIndex}][task]" required>
                        <!-- Delete button for task -->
                        <button type="button" class="btn btn-sm btn-danger delete_btn delete_task3" style="margin-left: 10px">Delete</button>
                    </div>
                </div>

            `;

            container3.appendChild(TaskFieldsDiv2);
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

        $(document).on('click', '.delete_task3', function () {
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

@include('footer')
