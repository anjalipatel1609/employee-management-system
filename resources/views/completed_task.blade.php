@include('header')
<h1 class="mt-4">Completed & Approved Task</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ url(route('home')) }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Completed & Approved Task</li>
</ol>

<div class="card mb-4">

                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Client ID</th>
                                            <th>Client Name</th>
                                            <th>Task</th>
                                            <th>Employee</th>
                                            <th>Completed Date</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Client ID</th>
                                            <th>Client Name</th>
                                            <th>Task</th>
                                            <th>Employee</th>
                                            <th>Completed Date</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>

                                        @if(count($allcompleted_task) > 0)
                                            @foreach($allcompleted_task as $eachallcompleted_task)
                                                <tr>
                                                    <td>{{ $eachallcompleted_task->ClientsTasks->client->id }}</td>
                                                    <td>{{ $eachallcompleted_task->ClientsTasks->client->client_name }}</td>
                                                    <td>{{ $eachallcompleted_task->ClientsTasks->client_Service_tasks->task }}</td>
                                                    <td>{{ $eachallcompleted_task->employee->id }} &nbsp;&nbsp; | &nbsp;&nbsp; {{ $eachallcompleted_task->employee->employee_name }}</td>
                                                    <td>{{ $eachallcompleted_task->completed_date }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        
                                        </tbody>
                                </table>
</div>
@include('footer')
