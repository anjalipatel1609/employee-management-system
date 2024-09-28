@include('header')
<h1 class="mt-4">Client Report</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Client Report</li>
</ol>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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
    <table class="table table-hover table-bordered results" style = "text-align : center;" id="myTable">
        <thead>
        <tr>
            <th scope="col" index="0">
                Client ID <i class="fas fa-filter"></i>
                <div class="filter"></div>
            </th>
            <th scope="col" index="1">
                Client Name <i class="fas fa-filter"></i>
                <div class="filter"></div>
            </th>
            <th scope="col" index="2">
                Paid Amount <i class="fas fa-filter"></i>
                <div class="filter"></div>
            </th>
            <th scope="col" index="3">
                Unpaid Amount <i class="fas fa-filter"></i>
                <div class="filter"></div>
            </th>
            <th scope="col" index="4">
                Total Amount <i class="fas fa-filter"></i>
                <div class="filter"></div>
            </th>
        </tr>
        </thead>
        <tbody>

            @if(count($allClient) > 0)
                @foreach($allClient as $eachClient)
                    <tr>
                        <td>{{ $eachClient->id }}</td>
                        <td>{{ $eachClient->client_name }}</td>

                            @php
                                $clientAllSubServices = $eachClient->services;
                                $clientAllPaidSubServices = $eachClient->services->where('payment_status', "paid");
                                $clientAllUnPaidSubServices = $eachClient->services->where('payment_status', "unpaid");
                                $paid_price = 0;
                                $unpaid_price = 0;
                                $total_price = 0;
                            @endphp

                            @foreach($clientAllSubServices as $EachSubServices)
                                <?php $total_price += $EachSubServices->payment_amount; ?>
                            @endforeach

                            @foreach($clientAllPaidSubServices as $EachPaidSubServices)
                                <?php $paid_price += $EachPaidSubServices->payment_amount; ?>
                            @endforeach

                            @foreach($clientAllUnPaidSubServices as $EachUnpaidSubServices)
                                <?php $unpaid_price += $EachUnpaidSubServices->payment_amount; ?>
                            @endforeach

                        <td>
                            @if($paid_price == 0)
                                -------------
                            @else
                                &#8377; {{ $paid_price }} /-
                            @endif
                        </td>

                        <td>
                            @if($unpaid_price == 0)
                                -------------
                            @else
                                &#8377; {{ $unpaid_price }} /-
                            @endif
                        </td>

                        <td>
                            @if($total_price == 0)
                                -------------
                            @else
                                &#8377; {{ $total_price }} /-
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" style = "text-align: center;">No any record available yet !</td>
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

@include('footer')
