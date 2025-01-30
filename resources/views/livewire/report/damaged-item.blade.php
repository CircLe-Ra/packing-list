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
            font-family: "Times New Roman", Times, sans-serif;
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
            BERITA ACARA
        </div>
        <!-- Content -->
        <p style="text-align: justify; font-size: 12px;width: 95%;">Pada hari ini Senin Tanggal {{ date('d') }}
            bulan {{ $bulanIndo[date('F')] }} Tahun {{ terbilang(date('Y')) }} ({{ date('d/m/Y') }}) telah dibongkar
            {{ $totalContainer }} ({{ angkaTerbilang($totalContainer) }}) cont berupa barang logistik. Terdapat beberapa
            barang yang rusak berikut data barang:</p>

        <!-- Table -->
        <table class="content-table" style="width: 95%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="font-size: 12px">No</th>
                    <th style="font-size: 12px">{{ __('Number Container') }}</th>
                    <th style="font-size: 12px">{{ __('Item Name') }}</th>
                    <th style="font-size: 12px">{{ __('Quantity') }}</th>
                    <th style="font-size: 12px">{{ __('Information') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $item)
                    <tr>
                        <td style="font-size: 12px">{{ $loop->iteration }}</td>
                        <td style="font-size: 12px">{{ $item->container->number_container }}</td>
                        <td style="font-size: 12px">
                            <ul>
                                @foreach ($item->shipment_items as $item_detail)
                                    @if ($item_detail->item_damaged != 0)
                                        <li>
                                            {{ $item_detail->item_name }}
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </td>
                        <td style="font-size: 12px">
                            <div class="flex-container">
                                <div class="ul-container">
                                    <ul>
                                        @php
                                            $total = 0;
                                        @endphp
                                        @foreach ($item->shipment_items as $item_detail)
                                            @php
                                                $total = $item_detail->item_damaged + $total;
                                            @endphp
                                            @if ($item_detail->item_damaged != 0)
                                                <li>
                                                    {{ $item_detail->item_damaged }} {{ __('Cardboard') }}
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </td>
                        <td style="font-size: 12px">{{ __('Damaged Items') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Total -->
        <p style="font-size: 12px;"><strong>TOTAL: {{ $total }} {{ __('Cardboard') }}</strong> </p>

        <!-- Paragraph 2 -->
        <p style="font-size: 12px;width: 95%;">Demikian Berita Acara ini kami buat agar dapat diketahui bersama. Atas
            perhatian dan kerjasamanya kami ucapkan terima kasih.</p>

        <table class="signature-table" style="border: none; width: 100%; border-collapse: collapse;margin-left: -30px;">
            <tr>
                <td style="width: 33.33%; text-align: center; border: none; vertical-align: middle; padding: 5px;">
                    <p style="font-size: 12px; margin: 0;">Tally Man</p>
                    <div style="height: 60px;"></div>
                    <p style="font-size: 12px; margin-top: 10px;">{{ auth()->user()->name }}</p>
                </td>
                <td style="width: 33.33%; text-align: center; border: none; vertical-align: middle; padding: 5px;">
                    <p style="font-size: 12px; margin: 0;">Mengetahui</p>
                    <div style="height: 60px;"></div>
                    <p style="font-size: 12px; margin-top: 10px;">GUSRIANTO</p>
                </td>
                <td style="width: 33.33%; text-align: center; border: none; vertical-align: middle; padding: 5px;">
                    <p style="font-size: 12px; margin: 0;">Bag. Operasional</p>
                    <div style="height: 60px;"></div>
                    <p style="font-size: 12px; margin-top: 10px;">MELKI</p>
                </td>
            </tr>
        </table>

        <table class="signature-table" style="border: none; width: 100%; border-collapse: collapse;margin-left: -30px;">
            <tr>
                <td style="width: 100%; text-align: center; border: none; vertical-align: middle; padding: 5px;">
                    <p style="font-size: 12px; margin: 5px 0;">Mengetahui,</p>
                    <p style="font-size: 12px; margin: 5px 0;">Kepala Cabang</p>
                    <div style="height: 60px;"></div>
                    <p style="font-size: 12px; margin-top: 10px;">ENDAH WAHYUNINGSIH</p>
                </td>
            </tr>
        </table>

        <!-- Footer -->
    </div>

    @if (!empty($itemDamageImages))
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                @foreach ($itemDamageImages as $index => $base64Image)
                    @if ($index % 2 == 0 && $index != 0)
            </tr>
            <tr> <!-- Mulai baris baru setiap dua gambar -->
    @endif
    <td style="width: 50%; text-align: center; padding: 10px;">
        <img src="data:image/jpeg;base64,{{ $base64Image }}" alt="Item Damage Image"
            style="width: 40%; height: auto; margin-top: 20px;" />
    </td>
    @endforeach
    </tr>
    </table>
    @endif

</body>

</html>

