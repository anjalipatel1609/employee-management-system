@include('header')
<h1 class="mt-4">Deadline crossed Task</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ url(route('home')) }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Deadline crossed Task</li>
</ol>

@if (Session::has('marked'))
    <div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('marked') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card mb-4">

                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Client ID</th>
                                            <th>Main Service</th>
                                            <th>Sub Service</th>
                                            <th>Task</th>
                                            <th>Allocated Date</th>
                                            <th>Deadline</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Client ID</th>
                                            <th>Main Service</th>
                                            <th>Sub Service</th>
                                            <th>Task</th>
                                            <th>Allocated Date</th>
                                            <th>Deadline</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>

                                        @if(count($allAllocatedTaskOfSpecificEmployee) > 0)
                                            @foreach($allAllocatedTaskOfSpecificEmployee as $eachAllocatedTaskOfSpecificEmployee)
                                                <tr>
                                                    <td>{{ $eachAllocatedTaskOfSpecificEmployee->ClientsTasks->client->id }}</td>
                                                    <td>{{ $eachAllocatedTaskOfSpecificEmployee->ClientsTasks->client_Service->SubServiceTaken->mainService->service_name }}</td>
                                                    <td>{{ $eachAllocatedTaskOfSpecificEmployee->ClientsTasks->client_Service->SubServiceTaken->sub_service_name }}</td>
                                                    <td>{{ $eachAllocatedTaskOfSpecificEmployee->ClientsTasks->client_Service_tasks->task }}</td>
                                                    <td>{{ $eachAllocatedTaskOfSpecificEmployee->allocated_date }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($eachAllocatedTaskOfSpecificEmployee->deadLine)->format('d/m/y h:i:s A') }}</td>
                                                    <td >

                                                        <form action = "{{ route('mark_task_as_completed') }}" method = "POST" style = "text-align: center;">
                                                            @csrf
                                                            <input type="text" placeholder="Remark Text" class="form-control" name="task_completed_remark" required>
                                                            <input type="hidden" name="task_id" value="{{ $eachAllocatedTaskOfSpecificEmployee->id }}">
                                                            <input type="hidden" name="client_task_id" value="{{ $eachAllocatedTaskOfSpecificEmployee->ClientsTasks->id }}">
                                                            <button type="submit" class="btn btn-light mt-2">Completed</button>
                                                        </form>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        
                                        </tbody>
                                </table>
</div>

<script>
    function markAsComplete(TaskID, ClientServiceID)
    {
        if(confirm('Are you sure to mark this task as completed !'))
        {
            window.location.href = "/mark_task_as_completed/" + TaskID + "/" + ClientServiceID;
        }
    }
</script>
@include('footer')
