@include('header')
<h1 class="mt-4">Task Approval</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Task Approval</li>
</ol>

@if (Session::has('success'))
    <div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-12">
        <table class="table">
            <thead>
                <tr>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Task Name</th>
                    <th>Employee Remark</th>
                    <th>Action</th>
                    <th>Remark</th>
                    <th>Submission</th>
                </tr>
            </thead>
            <tbody>
                    @if (isset($completedTask))
                        @if (count($completedTask) > 0)
                            @foreach ($completedTask as $eachCompletedTask)
                            <tr>
                                <td>{{ $eachCompletedTask->employee_id }}</td>
                                <td>{{ $eachCompletedTask->employee->employee_name }}</td>
                                <td>{{ $eachCompletedTask->ClientsTasks->client_Service->SubServiceTaken->mainService->service_name }}
                                    &nbsp;&nbsp;|&nbsp;&nbsp; {{ $eachCompletedTask->ClientsTasks->client_Service->SubServiceTaken->sub_service_name }}
                                    &nbsp;&nbsp;|&nbsp;&nbsp; {{ $eachCompletedTask->ClientsTasks->client_Service_tasks->task }}
                                </td>
                                <td>
                                    <input type="text" value = "{{ $eachCompletedTask->task_completed_remark }}" class="form-control" readonly>
                                </td>

                                <form action="{{ route('update_task_approval', $eachCompletedTask->id) }}" method="POST">
                                    @csrf 
                                    <input type="hidden" name="_method" value="POST"> 
                                    <input type="hidden" name="approval_status" value=""> 
                                    <input type="hidden" name="remark" value=""> 

                                    <td>
                                        <select class="form-control" name="approval_status" required>
                                            <option value="" selected disabled>Status</option>
                                            <option value="approve">Approve</option>
                                            <option value="decline">Decline</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="remark" placeholder="Enter remark" required> 
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-primary">Submit</button> 
                                    </td>
                                </form>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" style = "text-align: center;">No any record available yet !</td>
                            </tr>
                        @endif
                    @endif
            </tbody>
        </table>
    </div>
</div>


@include('footer')
