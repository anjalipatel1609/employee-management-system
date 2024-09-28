@include('header')
<h1 class="mt-4">Not Allocated Task</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ url(route('home')) }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Not allocated task</li>
</ol>

<div class="card mb-4">

                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Client ID</th>
                                            <th>Client Name</th>
                                            <th>Service</th>
                                            <th>Entry Date</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Client ID</th>
                                            <th>Client Name</th>
                                            <th>Service</th>
                                            <th>Entry Date</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>

                                        @if(count($allNotAllocatedTask) > 0)
                                            @foreach($allNotAllocatedTask as $eachallNotAllocatedTask)
                                                <tr>
                                                    <td>{{ $eachallNotAllocatedTask->client->id }}</td>
                                                    <td>{{ $eachallNotAllocatedTask->client->client_name }}</td>
                                                    <td>{{ $eachallNotAllocatedTask->client_Service_tasks->task }}</td>
                                                    <td>{{ $eachallNotAllocatedTask->client->date_time }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        
                                        </tbody>
                                </table>
</div>
@include('footer')
