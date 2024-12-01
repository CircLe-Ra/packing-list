<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-top: 20px;
        }

        .header img {
            width: 40%;
            margin-bottom: 10px;
        }

        .content {
            margin: 20px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 12px;
            padding: 10px;
        }

        .footer p {
            margin: 0;
        }

        .footer .address {
            margin-top: 5px;
        }

        .table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .table, .table th, .table td {
            border: 1px solid #000;
        }

        .table th, .table td {
            padding: 10px;
            text-align: center;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .table td img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
<div class="header">
    <!-- Gambar Header -->
    <img src="{{ public_path('images/header_image_1.jpg') }}" alt="Header Image 1">
    <img src="{{ public_path('images/header_image_2.jpg') }}" alt="Header Image 2">
</div>

<div class="content">
    <h2>{{ __('Delivery Report') }}</h2>
    <p><strong>{{ __('Driver') }}:</strong> {{ $data->driver->name }}</p>
    <p><strong>{{ __('Vehicle Number') }}:</strong> {{ $data->driver->vehicle_number }}</p>

    <div class="table">
        <table>
            <tr>
                <th>{{ __('KM Image Start') }}</th>
                <th>{{ __('Vehicle Image Start') }}</th>
            </tr>
            <tr>
                <td><img src="{{ public_path('storage/' . $data->delivery_images->first()->km_image_start) }}" alt="Km Image Start"></td>
                <td><img src="{{ public_path('storage/' . $data->delivery_images->first()->vehicle_image_start) }}" alt="Vehicle Image Start"></td>
            </tr>
            <tr>
                <th>{{ __('KM Image End') }}</th>
                <th>{{ __('Vehicle Image End') }}</th>
            </tr>
            <tr>
                <td><img src="{{ public_path('storage/' . $data->delivery_images->first()->km_image_end) }}" alt="Km Image End"></td>
                <td><img src="{{ public_path('storage/' . $data->delivery_images->first()->vehicle_image_end) }}" alt="Vehicle Image End"></td>
            </tr>
        </table>
    </div>
</div>

<div class="footer">
    <p>Delivery Report</p>
    <p class="address">Your Company Name, Address, City, Country</p>
</div>
</body>
</html>
