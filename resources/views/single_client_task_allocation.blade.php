@include('header')
<h1 class="mt-4">Allocate Task</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Allocate Task</li>
</ol>
<style>
    .list-group-horizontal-scroll {
        display: flex;
        flex-direction: row;
        overflow-x: auto;
        white-space: nowrap;
        padding-left: 0;
        margin-bottom: 0;
        list-style: none;
    }
    .list-group-item {
        margin-bottom: 10px;
    }
</style>

@if(Session::has('success'))
    <script>
        alert("{{ Session::get('success') }}");
    </script>
@endif
<div class="table-bordered mt-4 p-3">
    <h5 class="mb-3">Not Allocated Tasks for Clients</h5>
    <div class="row">
        <div class="col">
            <ul class="list-group list-group-horizontal-scroll">
                @if(count($clientsWithUnallocatedTasks) > 0)
                    @foreach($clientsWithUnallocatedTasks as $eachClient)
                        <li class="list-group-item d-flex justify-content-between align-items-center">{{ $eachClient->id }} &nbsp;&nbsp;|&nbsp;&nbsp; {{ $eachClient->client_name }}</li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>

</div>

<form action="" class="row g-3 mt-2" method="POST">
    <div class="col-12">
        <label class="form-label" for="clientSelect">Select client</label>
        <select class="form-select border border-secondary" id="clientSelect" name="client" onchange="getServices(this.value)">
            <option disabled selected style = "text-align : center;">{{ $client->id }} &nbsp;&nbsp;|&nbsp;&nbsp; {{ $client->client_name }}</option>
            @if(count($clientsWithIncompleteTasks) > 0)
                @foreach($clientsWithIncompleteTasks as $eachClient)
                <option value="{{ $eachClient->id }}">{{ $eachClient->id }} &nbsp;&nbsp;|&nbsp;&nbsp; {{ $eachClient->client_name }}</option>
                @endforeach
            @endif
        </select>
    </div>
</form>

<table class="table mt-5">
    <thead>
        <tr>
            <th>Task Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="servicesBody">

        @if(count($ClientsTasks) > 0)
            @foreach($ClientsTasks as $eachTask)
                <tr>
                    <td>
                        {{ $eachTask->client_Service->SubServiceTaken->mainService->service_name}} &nbsp;&nbsp; | &nbsp;&nbsp;
                        {{ $eachTask->client_Service->SubServiceTaken->sub_service_name}} &nbsp;&nbsp; | &nbsp;&nbsp;
                        {{ $eachTask->client_Service_tasks->task}}
                    </td>
                    <td>

                        @if($eachTask->is_allocated == "0")
                            <button class="btn btn-success edit-btn" type="button" data-toggle="modal" data-target="#allocateModal_{{ $eachTask->id }}">
                                <i class="fas fa-hand-point-right"></i> Allocate
                            </button>

                            <div class="modal fade" id="allocateModal_{{ $eachTask->id }}" tabindex="-1" role="dialog" aria-labelledby="allocateModalLabel_{{ $eachTask->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="allocateModalLabel">Allocate Task</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method = "POST" action = "{{ route('allocating_task') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="taskSelect">Employee:</label>
                                                    <select class="form-control" id="taskSelect" name = "employee_id" required>
                                                    <option value="" selected disabled style = "text-align : center;">Select Employee</option>

                                                        @if(count($allEmployee) > 0)
                                                            @foreach($allEmployee as $eachEmployee)
                                                                <option value="{{ $eachEmployee->id }}">{{ $eachEmployee->id }} &nbsp;&nbsp;|&nbsp;&nbsp; {{ $eachEmployee->employee_name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="datetimeSelect">Deadline:</label>
                                                    <input type="datetime-local" class="form-control" id="datetimeSelect" name = "deadLine" required>
                                                </div>
                                                <input type="hidden" name="task_id" value="{{ $eachTask->id }}">
                                                <button type="submit" class="btn btn-primary mt-2">Allocate Task</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($eachTask->is_allocated == "1")
                            <button class="btn btn-success edit-btn" type="button" data-toggle="modal" data-target="#reallocateModal_{{ $eachTask->id }}">
                            <i class="fas fa-hand-point-right"></i> Reallocate
                            </button>

                            <div class="modal fade" id="reallocateModal_{{ $eachTask->id }}" tabindex="-1" role="dialog" aria-labelledby="reallocateModalLabel_{{ $eachTask->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="reallocateModalLabel_">Reallocate Task</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method = "POST" action = "{{ route('reallocating_task') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="taskSelect">Employee:</label>

                                                    <select class="form-control" id="taskSelect" name="employee_id" required>
                                                        @foreach($allEmployee as $eachEmployee)
                                                            <option value="{{ $eachEmployee->id }}" @if($eachTask->employee_id == $eachEmployee->id) selected @endif>
                                                                {{ $eachEmployee->id }} &nbsp;&nbsp;|&nbsp;&nbsp; {{ $eachEmployee->employee_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                                <div class="form-group">
                                                    <label for="datetimeSelect">Deadline:</label>
                                                    <input type="datetime-local" class="form-control" id="datetimeSelect"  name = "deadLine" required>
                                                </div>
                                                <input type="hidden" name="task_id" value="{{ $eachTask->id }}">
                                                <button type="submit" class="btn btn-primary mt-2">Reallocate Task</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif


                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="2" style = "text-align: center;">No any service remained to allocate !</td>
            </tr>
        @endif
    </tbody>
</table>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Modal for Allocation -->


<script>
    function getServices(clientId) 
    {
        $id = clientId;
        window.location.href = '/single_client_task_allocation/' + clientId;
    }

</script>

@include('footer')
