@include('header')
<h1 class="mt-4">{{ $employeeToShow->employee_name }}</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ url(route('employee')) }}">Employee</a></li>
    <li class="breadcrumb-item active">{{ $employeeToShow->employee_name }}</li>
</ol>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<style>
    body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        table {
            margin: 0 auto;
            margin-top: 20px;
            width: 100%;
            position: relative;
            overflow: auto;
            overflow-y: overlay;
        }

        th,
        thead {
            position: sticky;
            top: 0;
            border: 1px solid #dddddd;
            background-color: #1f2d54;
            text-align: center;
            color: white;
            table-layout: fixed;
            word-break: break-word;
            height: 45px;
        }

        .filter {
            position: absolute;
            width: 20vw;
            height: 30vh;
            display: none;
            text-align: left;
            font-size: small;
            z-index: 9999;
            overflow: auto;
            background: #ffffff;
            color: #1f2d54;
            border: 1px solid #dddddd;
        }

        .filter input {
            margin: 5px !important;
            padding: 0 !important;
            width: 10%;
        }

        .filter div {
            padding: 5px;
        }

        .fa-filter {
            margin-left: 5px;
            font-size: 14px;
            color: white;
        }
</style>
    <div class="container col-12" id="content1" style="margin-top: 30px">
    <table class="table table-hover table-bordered results" id="myTable">
        <thead>
        <tr>
            <th scope="col" index="0">Client<i class="fas fa-filter"></i>
                <div class="filter"></div>
            </th>
            <th scope="col" index="1">Task<i class="fas fa-filter"></i>
                <div class="filter"></div>
            </th>
            <th scope="col" index="2">Allocate Date<i class="fas fa-filter"></i>
                <div class="filter"></div>
            </th>
            <th scope="col" index="3">Deadline<i class="fas fa-filter"></i>
                <div class="filter"></div>
            </th>
            <th scope="col" index="4">Status<i class="fas fa-filter"></i>
                <div class="filter"></div>
            </th>
        </tr>
        </thead>
        <tbody>

        @if(count($allTaskOfParticullarEmployee) > 0)
            @foreach($allTaskOfParticullarEmployee as $eachTask)
                <tr>
                    <td>{{ $eachTask->ClientsTasks->client->id }} &nbsp;&nbsp;|&nbsp;&nbsp; {{ $eachTask->ClientsTasks->client->client_name }}</td>
                    <td>{{ $eachTask->ClientsTasks->client_Service_tasks->task }}</td>
                    <td>{{ $eachTask->allocated_date }}</td>
                    <td>
                    {{ \Carbon\Carbon::parse($eachTask->deadLine)->format('d/m/y h:i:s A') }}
                    <td>{{ $eachTask->is_completed == 0 ? 'In progress' : 'Completed' }}</td>
                </tr>
            @endforeach

        @else
            <tr>
                <td colspan="5" style = "text-align: center;">No any task allocated yet !</td>
            </tr>
        @endif
        
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            $("table th").click(function() {
                showFilterOption(this);
            });
        });

        var arrayMap = {};

        function showFilterOption(tdObject) {
            var filterGrid = $(tdObject).find(".filter");

            if (filterGrid.is(":visible")) {
                filterGrid.hide();
                return;
            }

            $(".filter").hide();

            var index = 0;
            filterGrid.empty();
            var allSelected = true;
            filterGrid.append(
                '<div><input id="all" type="checkbox" style="width: 10% !important" checked>All</div>'
            );

            var $rows = $(tdObject).parents("table").find("tr");
            var values = [];

            $rows.each(function(ind, ele) {
                if (ind > 0) {
                    var currentTd = $(ele).children()[$(tdObject).attr("index")];
                    if (!values.includes(currentTd.innerHTML)) {
                        values.push(currentTd.innerHTML);
                        var div = document.createElement("div");
                        div.classList.add("grid-item");
                        var str = $(ele).is(":visible") ? "checked" : "";
                        if ($(ele).is(":hidden")) {
                            allSelected = false;
                        }
                        div.innerHTML =
                            '<br><input type="checkbox" ' + str + " >" + currentTd.innerHTML;
                        filterGrid.append(div);
                        arrayMap[index] = ele;
                        index++;
                    }
                }
            });

            if (!allSelected) {
                filterGrid.find("#all").removeAttr("checked");
            }

            filterGrid.append(
                '<div style="text-align: center"><input id="close" type="button" value="Close" style="width: 40%"/><input id="ok" type="button" value="Ok" style="width: 40%"/></div>'
            );
            filterGrid.show();

            var $closeBtn = filterGrid.find("#close");
            var $okBtn = filterGrid.find("#ok");
            var $checkElems = filterGrid.find("input[type='checkbox']");
            var $gridItems = filterGrid.find(".grid-item");
            var $all = filterGrid.find("#all");

            $closeBtn.click(function() {
                filterGrid.hide();
                return false;
            });

            $okBtn.click(function() {
                filterGrid.find(".grid-item").each(function(ind, ele) {
                    if ($(ele).find("input").is(":checked")) {
                        $(arrayMap[ind]).show();
                    } else {
                        $(arrayMap[ind]).hide();
                    }
                });
                filterGrid.hide();
                return false;
            });

            $checkElems.click(function(event) {
                event.stopPropagation();
            });

            $gridItems.click(function(event) {
                var chk = $(this).find("input[type='checkbox']");
                $(chk).prop("checked", !$(chk).is(":checked"));
            });

            $all.change(function() {
                var chked = $(this).is(":checked");
                filterGrid.find(".grid-item [type='checkbox']").prop("checked", chked);
            });

            filterGrid.click(function(event) {
                event.stopPropagation();
            });

            return filterGrid;
        }
    </script>
    </div>

@include('footer')
