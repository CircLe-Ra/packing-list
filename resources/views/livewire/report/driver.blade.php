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
<table class="header-table" style="width: 100%; border: none;margin-left: -30px; margin-top: -50px;">
    <tr>
        <td style="text-align: left; width: 50%; padding: 10px;border: none;margin-left: -20px; ">
            <img src="data:image/jpeg;base64,{{ $akhlakImage }}" alt="Logo Kiri" style="max-width: 200px; height: auto;" />
        </td>
        <td style="text-align: right; width: 50%; padding: 10px;border: none;">
            <img src="data:image/png;base64,{{ $pelniImage }}" alt="Logo Kanan" style="max-width: 150px; height: auto;" />
        </td>
    </tr>
</table>

<div class="content">
    <h2 style="font-size: 20px;margin-top: -50px;text-align: center">{{ __('Delivery Report') }}</h2>
    <p style="font-size: 14px"><strong>{{ __('Driver') }}:</strong> {{ $data->driver->name }}</p>
    <p style="font-size: 14px;margin-top: -10px"><strong>{{ __('Vehicle Number') }}:</strong> {{ $data->driver->vehicle_number }}</p>

    <div class="table">
        <table>
            <tr>
                <th style="font-size: 14px">{{ __('KM Image Start') }}</th>
                <th style="font-size: 14px">{{ __('Vehicle Image Start') }}</th>
            </tr>
            <tr>
                <td><img style="width: 50%" src="{{ public_path('storage/' . $data->delivery_images->first()->km_image_start) }}" alt="Km Image Start"></td>
                <td><img style="width: 50%" src="{{ public_path('storage/' . $data->delivery_images->first()->vehicle_image_start) }}" alt="Vehicle Image Start"></td>
            </tr>
            <tr>
                <th style="font-size: 14px">{{ __('KM Image End') }}</th>
                <th style="font-size: 14px">{{ __('Vehicle Image End') }}</th>
            </tr>
            <tr>
                <td><img style="width: 50%" src="{{ public_path('storage/' . $data->delivery_images->first()->km_image_end) }}" alt="Km Image End"></td>
                <td><img style="width: 50%" src="{{ public_path('storage/' . $data->delivery_images->first()->vehicle_image_end) }}" alt="Vehicle Image End"></td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
