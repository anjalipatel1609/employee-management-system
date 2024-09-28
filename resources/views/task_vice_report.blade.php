@include('header')
<h1 class="mt-4">Task Vice Report</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Task Vice Report</li>
</ol>

@php
    $frequencyData = []; // Preload frequency data from PHP into JavaScript
    foreach($allMainServices as $eachService) {
        $frequencyData[$eachService->id] = explode(',', $eachService->frequency);
    }
@endphp

<script>
    var frequencyData = @json($frequencyData); 
</script>

<form action="{{ route('task_vice_specific_report') }}" class="row g-3 mt-2" method="POST" onsubmit="return validateForm()">
    @csrf
    <div class="col-5">
        <label class="form-label" for="inputStAnjali">Main Services</label>
        <select class="form-select border border-secondary" id="inputStAnjali" name="main_service_id" required>
            <option value = "" disabled selected style = "text-align : center;">Select Services</option>
            @if(count($allMainServices) > 0)
                @foreach($allMainServices as $eachService)
                    <option value="{{ $eachService->id }}">{{ $eachService->service_name }}</option>       
                @endforeach
            @endif
        </select>
    </div>
    <div class="col-6">
        <label class="form-label" for="inputprj">Sub Service</label>
        <select class="form-select border border-secondary" id="frequencyDropdown" name="sub_service_id" required>
            <option value = "" disabled selected style = "text-align : center;">Please Select Any Services First</option>
        </select>
    </div>

    <input class="btn btn-primary col-1" type="submit" value="Go">
</form>

@if(isset($subServiceName))
<h1 class="mt-4" style = "font-size : 24px;">{{$mainServiceName}}</h1>
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
@endif

<script>
    document.getElementById('inputStAnjali').addEventListener('change', function() {
        var serviceId = this.value;
        var timeDropdown = document.getElementById('frequencyDropdown');
        timeDropdown.innerHTML = ''; 
        
        var defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.text = 'Select Sub-service';
        defaultOption.selected = true;
        defaultOption.disabled = true;
        timeDropdown.appendChild(defaultOption);
        
        var service = @json($allMainServices->pluck('subServices', 'id')->toArray());
        if (serviceId && service[serviceId]) {
            service[serviceId].forEach(function(subService) {
                var option = document.createElement('option');
                option.value = subService.id;
                option.text = subService.sub_service_name;
                timeDropdown.appendChild(option);
            });
        }
    });
</script>
<script>
    function validateForm() {
        var mainService = document.getElementById("inputStAnjali");
        var subService = document.getElementById("frequencyDropdown");

        if (mainService.value == "" || subService.value == "") {
            alert("Please select both Main Service and Sub Service.");
            return false; 
        }

        return true;
    }
</script>


@include('footer')
