<?php
$bulanIndo = [
    'January' => 'Januari',
    'February' => 'Februari',
    'March' => 'Maret',
    'April' => 'April',
    'May' => 'Mei',
    'June' => 'Juni',
    'July' => 'Juli',
    'August' => 'Agustus',
    'September' => 'September',
    'October' => 'Oktober',
    'November' => 'November',
    'December' => 'Desember',
];

function terbilang($tahun)
{
    $angka = [
        0 => 'Nol',
        1 => 'Satu',
        2 => 'Dua',
        3 => 'Tiga',
        4 => 'Empat',
        5 => 'Lima',
        6 => 'Enam',
        7 => 'Tujuh',
        8 => 'Delapan',
        9 => 'Sembilan',
    ];

    // Pisahkan tahun ke dalam array per digit
    $tahun = str_split($tahun);
    $ejaan = '';

    // Cek bagian ribuannya
    if ($tahun[0] == '2') {
        $ejaan .= 'Dua Ribu ';
    }

    // Cek bagian puluhannya
    if ($tahun[1] != '0') {
        $ejaan .= $angka[$tahun[1]] . ' Puluh ';
    }

    // Cek bagian satuannya
    $ejaan .= $angka[$tahun[2]] . ' ' . $angka[$tahun[3]];

    return $ejaan;
}

function angkaTerbilang($angka)
{
    // Daftar angka dan satuan
    $angkaArray = [
        0 => 'Nol',
        1 => 'Satu',
        2 => 'Dua',
        3 => 'Tiga',
        4 => 'Empat',
        5 => 'Lima',
        6 => 'Enam',
        7 => 'Tujuh',
        8 => 'Delapan',
        9 => 'Sembilan',
        10 => 'Sepuluh',
        11 => 'Sebelas',
        12 => 'Dua Belas',
        13 => 'Tiga Belas',
        14 => 'Empat Belas',
        15 => 'Lima Belas',
        16 => 'Enam Belas',
        17 => 'Tujuh Belas',
        18 => 'Delapan Belas',
        19 => 'Sembilan Belas',
        20 => 'Dua Puluh',
        30 => 'Tiga Puluh',
        40 => 'Empat Puluh',
        50 => 'Lima Puluh',
        60 => 'Enam Puluh',
        70 => 'Tujuh Puluh',
        80 => 'Delapan Puluh',
        90 => 'Sembilan Puluh',
        100 => 'Seratus',
        1000 => 'Seribu',
        1000000 => 'Satu Juta',
        1000000000 => 'Satu Miliar',
    ];

    // Cek jika angka sudah ada dalam array
    if (isset($angkaArray[$angka])) {
        return $angkaArray[$angka];
    }

    // Jika angka lebih besar dari 20 dan lebih kecil dari 100
    if ($angka < 100) {
        $puluhan = floor($angka / 10) * 10;
        $satuan = $angka % 10;

        if ($satuan == 0) {
            return $angkaArray[$puluhan];
        }

        return $angkaArray[$puluhan] . ' ' . $angkaArray[$satuan];
    }

    // Jika angka lebih besar dari 100 dan lebih kecil dari 1000
    if ($angka < 1000) {
        $ratusan = floor($angka / 100);
        $sisa = $angka % 100;

        if ($sisa == 0) {
            return $angkaArray[$ratusan] . ' Ratus';
        }

        return $angkaArray[$ratusan] . ' Ratus ' . angkaTerbilang($sisa);
    }

    // Jika angka lebih besar dari 1000 dan lebih kecil dari 1 juta
    if ($angka < 1000000) {
        $ribuan = floor($angka / 1000);
        $sisa = $angka % 1000;

        if ($sisa == 0) {
            return angkaTerbilang($ribuan) . ' Ribu';
        }

        return angkaTerbilang($ribuan) . ' Ribu ' . angkaTerbilang($sisa);
    }

    // Jika angka lebih besar dari 1 juta
    if ($angka < 1000000000) {
        $jutaan = floor($angka / 1000000);
        $sisa = $angka % 1000000;

        if ($sisa == 0) {
            return angkaTerbilang($jutaan) . ' Juta';
        }

        return angkaTerbilang($jutaan) . ' Juta ' . angkaTerbilang($sisa);
    }

    // Jika angka lebih besar dari 1 miliar
    if ($angka >= 1000000000) {
        $miliar = floor($angka / 1000000000);
        $sisa = $angka % 1000000000;

        if ($sisa == 0) {
            return angkaTerbilang($miliar) . ' Miliar';
        }

        return angkaTerbilang($miliar) . ' Miliar ' . angkaTerbilang($sisa);
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Acara</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header styles */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header img {
            max-width: 100px;
            height: auto;
        }

        .title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        /* Remove bullet points from ul/li */
        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        li {
            margin-bottom: 5px;
        }

        /* Signature styles */
        .signature-table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }

        .signature-table td {
            text-align: center;
            padding: 20px;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 12px;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header with images -->
        <table class="header-table" style="width: 100%; border: none;margin-left: -30px; margin-top: -50px;">
            <tr>
                <td style="text-align: left; width: 50%; padding: 10px;border: none;margin-left: -20px; ">
                    <img src="data:image/jpeg;base64,{{ $akhlakImage }}" alt="Logo Kiri"
                        style="max-width: 200px; height: auto;" />
                </td>
                <td style="text-align: right; width: 50%; padding: 10px;border: none;">
                    <img src="data:image/png;base64,{{ $pelniImage }}" alt="Logo Kanan"
                        style="max-width: 150px; height: auto;" />
                </td>
            </tr>
        </table>

        <!-- Title -->
        <div class="title" style="margin-top: -40px;">
            BERITA ACARA PENERIMAAN BARANG
        </div>
        <!-- Content -->
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;border:none;">
            <tr>
                <td style="width: 30%; font-weight: bold;border:none;font-size: 12px">Nomor BAPB</td>
                <td style="border:none;font-size: 12px">: {{ $data->bapb_number }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;border:none;font-size: 12px">Penerima</td>
                <td style="border:none;font-size: 12px">: {{ $data->consumer->name }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;border:none;font-size: 12px">Alamat</td>
                <td style="border:none;font-size: 12px">: {{ $data->consumer->address }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;border:none;font-size: 12px">Kapal Pemuat</td>
                <td style="border:none;font-size: 12px">: {{ $data->shipment->loader_ship }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;border:none;font-size: 12px">TA - TD Kapal</td>
                <td style="border:none;font-size: 12px">: {{ $data->shipment->ta_shipment }} -
                    {{ $data->shipment->td_shipment }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;border:none;font-size: 12px">Tanggal Berangkat</td>
                <td style="border:none;font-size: 12px">: {{ $data->departure_date }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;border:none;font-size: 12px">Tanggal Penyerahan</td>
                <td style="border:none;font-size: 12px">: {{ $data->arrival_date }}</td>
            </tr>
        </table>
        <p style="font-size: 12px">Jenis - Jenis Barang Yang Diserahkan :</p>
        <!-- Table -->
        <table style="width: 95%; border-collapse: collapse; margin-bottom: 20px;border:none;">
            <thead>
                <tr>
                    <th style="font-size: 12px">No</th>
                    <th style="font-size: 12px">{{ __('Party') }}</th>
                    <th style="font-size: 12px">{{ __('Item Name') }}</th>
                    <th style="font-size: 12px">{{ __('No. Cont/Seal') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quantities as $distribution)
                    <tr>
                        <td style="font-size: 12px">{{ $loop->iteration }}</td>
                        <td style="font-size: 12px">{{ $distribution->quantity }} {{ __('Cardboard') }}</td>
                        <td style="font-size: 12px">{{ $distribution->shipment_item->item_name }}</td>
                        <td style="font-size: 12px">
                            {{ $distribution->shipment_item->shipment_detail->container->number_container }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Signature using Table -->
        <table class="signature-table" style="border: none; width: 100%; border-collapse: collapse;margin-left: -30px;">
            <tr>
                <td style="width: 25%; text-align: center; border: none; vertical-align: middle; padding: 20px;">
                    <p style="font-size: 12px; margin: 5px 0;">&nbsp;</p>
                    <p style="font-size: 12px; margin: 0;">Penerima ditujukan</p>
                    <p style="font-size: 12px; margin: 5px 0;">&nbsp;</p>
                    <p style="font-size: 12px; margin: 5px 0;">&nbsp;</p>
                    <div style="height: 60px;">
                        <img width="140" src="{{ $data->signature_consumer }}" />
                    </div>
                    <p style="font-size: 12px; margin-top: 10px;">{{ $data->consumer->name }}</p>
                </td>
                <td style="width: 25%; text-align: center; border: none; vertical-align: middle; padding: 5px;">
                    <p style="font-size: 12px; margin: 5px 0;">&nbsp;</p>
                    <p style="font-size: 12px; margin: 0;">Disaksikan :</p>
                    <p style="font-size: 12px; margin: 5px 0;">Balai Pengelola Transport Darat</p>
                    <p style="font-size: 12px; margin: 5px 0;">Kelas II Papua</p>
                    <div style="height: 60px;"></div>
                    <p style="font-size: 12px; margin-top: 10px;">ARISCA AULIA, A.Md</p>
                </td>
                <td style="width: 25%; text-align: center; border: none; vertical-align: middle; padding: 5px;">
                    <p style="font-size: 12px; margin: 5px 0;">&nbsp;</p>
                    <p style="font-size: 12px; margin: 0;">Disaksikan :</p>
                    <p style="font-size: 12px; margin: 5px 0;">Perum Damri Cabang Merauke</p>
                    <p style="font-size: 12px; margin: 5px 0;">&nbsp;</p>
                    <div style="height: 60px;"></div>
                    <p style="font-size: 12px; margin-top: 10px;">ARIEF HERMANTO, SE.,MM</p>
                </td>
                <td style="width: 25%; text-align: center; border: none; vertical-align: middle; padding: 5px;">
                    <p style="font-size: 12px; margin: 4.5px;">Merauke, {{ $data->departure_date }}</p>
                    <p style="font-size: 12px; margin: 5px 0;">Pengirim</p>
                    <p style="font-size: 12px; margin: 5px 0;">PT. Sarana Bandar Logistik</p>
                    <p style="font-size: 12px; margin: 5px 0;">&nbsp;</p>
                    <div style="height: 60px;"></div>
                    <p style="font-size: 12px; margin-top: 10px;">ENDAH WAHYUNINGSIH</p>
                </td>
            </tr>
        </table>

        <!-- Footer -->
    </div>

</body>

</html>

