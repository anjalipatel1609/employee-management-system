@include('header')
<h1 class="mt-4">{{$mainServiceName}}</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">{{$subServiceName}}</li>
</ol>

    <table class="table">
        <thead>
            <tr>
                <th>Client ID</th>
                <th>Client Name</th>
                @foreach($tasks as $task)
                    <th>{{ $task->task }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @if(count($clients) > 0)
                @foreach($clients as $client)
                    <tr>
                        <td>{{ $client->client->id }}</td>
                        <td>{{ $client->client->client_name }}</td>
                        @foreach($tasks as $task)
                            @php
                                $clientTask = $client->clientTasks->where('CS_task_id', $task->id)->first();
                            @endphp
                            <td>
                                @if($clientTask)
                                    @if($clientTask->is_completed)
                                        Completed
                                    @elseif($clientTask->is_allocated)
                                        In Progress
                                    @else
                                        Not Allocated
                                    @endif
                                @else
                                    Not Allocated
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="{{ count($tasks) + 2 }}" style = "text-align: center;">No any record available yet !</td>
                </tr>
            @endif
        </tbody>
    </table>

@include('footer')
