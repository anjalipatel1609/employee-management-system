@include('header')
<h1 class="mt-4">Accepted Task</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ url(route('home')) }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Accepted Task</li>
</ol>

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
                                            <th>Completed Date</th>
                                            <th>HR Remark</th>
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
                                            <th>Completed Date</th>
                                            <th>HR Remark</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>

                                        @if(count($allCompletedTaskOfSpecificEmployee) > 0)
                                            @foreach($allCompletedTaskOfSpecificEmployee as $eachCompletedTaskOfSpecificEmployee)
                                                <tr>
                                                    <td>{{ $eachCompletedTaskOfSpecificEmployee->ClientsTasks->client->id }}</td>
                                                    <td>{{ $eachCompletedTaskOfSpecificEmployee->ClientsTasks->client_Service->SubServiceTaken->mainService->service_name }}</td>
                                                    <td>{{ $eachCompletedTaskOfSpecificEmployee->ClientsTasks->client_Service->SubServiceTaken->sub_service_name }}</td>
                                                    <td>{{ $eachCompletedTaskOfSpecificEmployee->ClientsTasks->client_Service_tasks->task }}</td>
                                                    <td>{{ $eachCompletedTaskOfSpecificEmployee->allocated_date }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($eachCompletedTaskOfSpecificEmployee->deadLine)->format('d/m/y h:i:s A') }}</td>
                                                    <td>{{ $eachCompletedTaskOfSpecificEmployee->completed_date }}</td>
                                                    <td>{{ $eachCompletedTaskOfSpecificEmployee->task_approved_remark }}</td>
                                                </tr>
                                            @endforeach
                                        @endif

                                        <!--  -->
                                        
                                        </tbody>
                                </table>
</div>

@include('footer')
