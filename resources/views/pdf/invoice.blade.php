<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 20mm 15mm;
            line-height: 1.6;
        }
        .invoice {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            background-color: #f9f9f9;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
            background-color: #28559A;
        }
        .invoice-header h1 {
            margin: 0;
            color: white;
        }
        .invoice-details {
            margin-bottom: 30px;
            background-color: #fff;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            color: #353535;
        }
        .invoice-details p {
            margin: 5px 0;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        .invoice-table th, .invoice-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .invoice-table th {
            background-color: #f2f2f2;
        }
        .invoice-total {
            background-color: #28559A;
            width: 50%;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        .invoice-total p {
            margin: 5px 0;
        }
        .invoice {
            display: flex;
            flex-direction: column;
        }

        .invoice-total {
            align-self: flex-end;
            margin-top: auto; 
            background-color: #28559A;
            width: 50%;
            text-align: center;
            color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

@php
    $totalPrice = 0;
@endphp

    <div class="invoice">
        <div class="invoice-header">
            <h1>Invoice</h1>
        </div>
        <div class="invoice-details">
            <p><strong>Client ID:</strong> {{ $client->id }}</p>
            <p><strong>Client Name:</strong> {{ $client->client_name }}</p>
            <p><strong>Phone:</strong> {{ $client->phone }}</p>
            <p><strong>Email:</strong> {{ $client->email }}</p>
            <p><strong>Date:</strong> {{ $client->date_time }}</p>
        </div>
        <table class="invoice-table" style = "text-align : center;">
            <thead>
                <tr>
                    <th>Main Service</th>
                    <th>sub Service</th>
                    <th>Price</th>
                    <th>payment status</th>
                    <th>Bill number</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clientServices as $service)
                <tr>
                    <td>{{ $service->SubServiceTaken->mainService->service_name }}</td>
                    <td>{{ $service->SubServiceTaken->sub_service_name }}</td>
                    <td>{{ $service->payment_amount }} /-</td>
                    <td>{{ $service->payment_status }}</td>
                    <td>{{ $service->bill_number }}</td>

                    <?php $totalPrice += $service->payment_amount; ?>
                    
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="invoice-total">
            <p><strong>Total Amount:</strong> {{ $totalPrice }} /-</p>
        </div>
    </div>
</body>
</html>
