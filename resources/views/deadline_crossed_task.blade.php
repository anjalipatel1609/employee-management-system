@include('header')
<h1 class="mt-4">Dead Line Crossed Task</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ url(route('home')) }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Dead Line Crossed Task</li>
</ol>

<div class="card mb-4">

                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Client</th>
                                            <th>Employee</th>
                                            <th>Task</th>
                                            <th>Allocate Date</th>
                                            <th>Deadline</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Client</th>
                                            <th>Employee</th>
                                            <th>Task</th>
                                            <th>Allocate Date</th>
                                            <th>Deadline</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>

                                        @if(count($all_deadline_crossed_task) > 0)
                                            @foreach($all_deadline_crossed_task as $each_deadline_crossed_task)
                                                <tr>

                                                    <td>{{ $each_deadline_crossed_task->ClientsTasks->client->id }} &nbsp;&nbsp; | &nbsp;&nbsp; {{ $each_deadline_crossed_task->ClientsTasks->client->client_name }}</td>
                                                    <td>{{ $each_deadline_crossed_task->employee->id }} &nbsp;&nbsp; | &nbsp;&nbsp; {{ $each_deadline_crossed_task->employee->employee_name }}</td>
                                                    <td>{{ $each_deadline_crossed_task->ClientsTasks->client_Service_tasks->task }}</td>
                                                    <td>{{ $each_deadline_crossed_task->allocated_date }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($each_deadline_crossed_task->deadLine)->format('d/m/y h:i:s A') }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        
                                        </tbody>
                                </table>
</div>
@include('footer')
