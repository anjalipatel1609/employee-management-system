@include('header')
<h1 class="mt-4">Activity Log</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Activity Log</li>
</ol>

                        <div class="card mb-4">
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Client ID</th>
                                            <th>Client Name</th>
                                            <th>Main Service</th>
                                            <th>Sub Service</th>
                                            <th>Status</th>
                                            <th>Entry Date</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Client ID</th>
                                            <th>Client Name</th>
                                            <th>Main Service</th>
                                            <th>Sub Service</th>
                                            <th>Status</th>
                                            <th>Entry Date</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>

                                    @if(count($AllClients_service) > 0)
                                        @foreach($AllClients_service as $eachClients_service)
                                            <tr>
                                                <td>{{ $eachClients_service->client->id }}</td>
                                                <td>{{ $eachClients_service->client->client_name }}</td>
                                                <td>{{ $eachClients_service->SubServiceTaken->mainService->service_name }}</td>
                                                <td>{{ $eachClients_service->SubServiceTaken->sub_service_name }}</td>
                                                <td>
                                                
                                                @if($eachClients_service->is_completed)
                                                    Completed
                                                @elseif($eachClients_service->is_allocated)
                                                    In Progress
                                                @else
                                                    Not Allocated
                                                @endif

                                                <td>{{ $eachClients_service->client->date_time }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                        </tbody>
                                </table>
</div>
@include('footer')
