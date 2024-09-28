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
            <option disabled selected style = "text-align : center;">Select client to allocte task</option>
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

        <tr>
            <td colspan="2" style = "text-align: center;">No any client selected yet !</td>
        </tr>

    </tbody>
</table>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function getServices(clientId) 
    {
        $id = clientId;
        window.location.href = '/single_client_task_allocation/' + clientId;
    }

</script>

@include('footer')
