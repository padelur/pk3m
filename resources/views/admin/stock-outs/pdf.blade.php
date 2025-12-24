@php
    $total = 0;
    $companyName = $settings->company_name ?? 'PT. Makmur Mandiri Medika';
    $companyAddress = $settings->address ?? 'Jl. Imam Bonjol, Kel. Dimparoh, Kota Pahlawan - Sumatera Barat (+62 812-6773-6674)';
    $companyPhone = $settings->phone ?? '-';
    $companyEmail = $settings->email ?? '-';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Faktur Penjualan - {{ $stockOut->invoice_number }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
        }
        .wrapper {
            padding: 20px 25px;
        }
        .header-box {
            border: 2px solid #000;
            padding: 5px;
            margin-bottom: 20px;
        }
        .header-content {
            text-align: center;
        }
        .company-name {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .doc-title {
            font-size: 14px;
            font-weight: bold;
            margin: 2px 0;
        }
        .invoice-number {
            font-size: 12px;
            font-weight: bold;
        }
        .company-address {
            font-size: 9px;
            margin-top: 2px;
        }
        
        .info-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            margin-bottom: 5px;
        }
        .info-table td {
            vertical-align: top;
            padding: 1px;
        }
        .info-section {
            background-color: #f0f8ff;
            padding: 10px;
            height: 100px;
        }

        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 10px;
        }
        table.items th {
            border: 2px solid #000;
            background-color: #fce4d6;
            padding: 5px;
            text-align: center;
            font-weight: bold;
        }
        table.items td {
            border: 1px solid #000;
            padding: 4px 5px;
        }
        table.items td.striped {
            background-color: #e6f3f7;
        }
        table.items td.num { text-align: center; }
        table.items td.qty, table.items td.price, table.items td.total { text-align: right; }
        
        .totals-row td {
            font-weight: bold;
            background-color: #fce4d6;
        }

        .signatures {
            width: 100%;
            margin-top: 5px;
        }
        .signatures td {
            text-align: center;
            vertical-align: top;
        }
        .sign-box {
            margin-top: 50px;
            font-weight: bold;
        }
        
        .date-right {
            text-align: right;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .date-box {
            display: inline-block;
            border-bottom: 1px solid #000;
            min-width: 100px;
            text-align: center;
        }
        .note {
            font-size: 10px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <!-- Header -->
    <div class="header-box">
        <table width="100%">
            <tr>
                <td width="20%" style="vertical-align: middle; text-align: left;">
                    <img src="{{ public_path('images/logo.png') }}" style="width: 80px; height: auto;">
                </td>
                <td width="60%" style="vertical-align: middle; text-align: center;">
                    <div class="company-name">{{ $companyName }}</div>
                    <div class="doc-title">Faktur Penjualan</div>
                    <div class="invoice-number">No: {{ $stockOut->invoice_number }}</div>
                    <div class="company-address">{{ $companyAddress }}</div>
                </td>
                <td width="20%" style="vertical-align: middle; text-align: right;">
                    <!-- Spacer for centering -->
                </td>
            </tr>
        </table>
    </div>

    <!-- Info Sections -->
    <table class="info-table" style="width: 100%; margin-bottom: 15px;">
        <tr>
            <!-- Left Side: Customer Info -->
            <td width="55%" style="vertical-align: top; padding-right: 10px;">
                <div class="info-section">
                    <table style="width: 100%;">
                        <tr>
                            <td width="30%">Kepada Yth</td>
                            <td width="5%">:</td>
                            <td>{{ $stockOut->customer_name }}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td>-</td> <!-- Add customer address if available in DB -->
                        </tr>
                        <tr>
                            <td>Kontak</td>
                            <td>:</td>
                            <td>-</td>
                        </tr>
                    </table>
                </div>
            </td>
            
            <!-- Right Side: Invoice Info -->
            <td width="45%" style="vertical-align: top; padding-left: 10px;">
                <div class="info-section">
                    <table style="width: 100%;">
                        <tr>
                            <td width="35%">Tanggal</td>
                            <td width="5%">:</td>
                            <td>{{ $stockOut->request_date?->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td>Dibuat Oleh</td>
                            <td>:</td>
                            <td>{{ $stockOut->creator->name ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    <!-- Items Table -->
    <table class="items">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="40%">Nama Barang</th>
                <th width="10%">Qty</th>
                <th width="20%">Harga</th>
                <th width="25%">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stockOut->items as $index => $item)
                @php
                    $lineTotal = ($item->price ?? 0) * $item->quantity;
                    $total += $lineTotal;
                @endphp
                <tr class="{{ $index % 2 == 1 ? 'striped' : '' }}">
                    <td class="num">{{ $index + 1 }}</td>
                    <td>
                        {{ $item->product->name }}
                        @if($item->product->size)
                            - {{ $item->product->size }}
                        @endif
                    </td>
                    <td class="qty">{{ $item->quantity }}</td>
                    <td class="price">Rp {{ number_format($item->price ?? 0, 0, ',', '.') }}</td>
                    <td class="total">Rp {{ number_format($lineTotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            
            <!-- Fill empty rows -->
            @for($i = count($stockOut->items); $i < 8; $i++)
                 <tr class="{{ $i % 2 == 1 ? 'striped' : '' }}">
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            @endfor
        </tbody>
        <tfoot>
            <tr class="totals-row">
                <td colspan="4" style="text-align: right; border: 1px solid #000;">Total</td>
                <td class="total" style="border: 1px solid #000;">Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <!-- Date -->
    <div class="date-right" style="margin-top: 20px;">
        Tgl : <span class="date-box">{{ $stockOut->request_date?->format('d/m/Y') ?? date('d/m/Y') }}</span>
    </div>

    <!-- Signatures -->
    <table class="signatures">
        <tr>
            <td width="50%">Diserahkan oleh,</td>
            <td width="50%">Diterima oleh,</td>
        </tr>
        <tr>
            <td style="height: 60px;"></td>
            <td style="height: 60px;"></td>
        </tr>
        <tr>
            <td>
                <div class="sign-box">( {{ $stockOut->creator->name ?? '..................' }} )</div>
            </td>
            <td>
                <div class="sign-box">( ...................................... )</div>
            </td>
        </tr>
    </table>

    @if($stockOut->notes)
        <div class="note">
            <strong>Catatan:</strong><br>
            {!! nl2br(e($stockOut->notes)) !!}
        </div>
    @endif
</div>
</body>
</html>


