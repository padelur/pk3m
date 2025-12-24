@php
    $companyName = $settings->company_name ?? 'PT. Makmur Mandiri Medika';
    $companyAddress = $settings->address ?? 'Jl. Imam Bonjol, Kel. Dimparoh, Kota Pahlawan - Sumatera Barat (+62 812-6773-6674)'; // Default from image if not set
    $companyPhone = $settings->phone ?? '-';
    $companyEmail = $settings->email ?? '-';

    // Format nomor PO tampilan (XXX/PO-CONS/MM/YYY)
    $idPart = str_pad((string) $purchaseOrder->id, 3, '0', STR_PAD_LEFT);
    $monthPart = $purchaseOrder->order_date?->format('m') ?? now()->format('m');
    $yearPart = $purchaseOrder->order_date?->format('Y') ?? now()->format('Y');
    $formattedNumber = "{$idPart}/PO-CONS/{$monthPart}/{$yearPart}";
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Purchase Order - {{ $purchaseOrder->po_number }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: Arial, Helvetica, sans-serif; /* Adjusted font */
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
        .po-number {
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
            background-color: #f0f8ff; /* Light blue background as in image */
            padding: 10px;
            height: 100px; /* Fixed height for consistency */
        }

        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 10px;
        }
        table.items th {
            border: 2px solid #000; /* Thicker border for header */
            background-color: #fce4d6; /* Light orange background */
            padding: 5px;
            text-align: center;
            font-weight: bold;
        }
        table.items td {
            border: 1px solid #000;
            padding: 4px 5px;
        }
        table.items td.striped {
            background-color: #e6f3f7; /* Light blue stripe */
        }
        /* Alternating row colors handled in loop logic or CSS if simple */
        
        .footer-section {
            margin-top: 20px;
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
        
        .notes-list {
            font-size: 9px;
            margin-top: 20px;
            padding-left: 15px;
        }
        .notes-list li {
            margin-bottom: 2px;
        }
        .red-text {
            color: red;
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
                    <div class="doc-title">Purchasing Order</div>
                    <div class="po-number">No: {{ $formattedNumber }}</div>
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
            <!-- Left Side: Supplier Info -->
            <td width="55%" style="vertical-align: top; padding-right: 10px;">
                <div class="info-section">
                    <table style="width: 100%;">
                        <tr>
                            <td width="30%">Principle</td>
                            <td width="5%">:</td>
                            <td>{{ $purchaseOrder->supplier->name }}</td>
                        </tr>
                        <tr>
                            <td>PIC</td>
                            <td>:</td>
                            <td>-</td> <!-- Placeholder as per image structure -->
                        </tr>
                        <tr>
                            <td>Kontak</td>
                            <td>:</td>
                            <td>{{ $purchaseOrder->supplier->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td>{{ $purchaseOrder->supplier->address ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>No. SP/ Purchase ID</td>
                            <td>:</td>
                            <td>-</td>
                        </tr>
                    </table>
                </div>
            </td>
            
            <!-- Right Side: Shipping Info -->
            <td width="45%" style="vertical-align: top; padding-left: 10px;">
                <div class="info-section">
                    <table style="width: 100%;">
                        <tr>
                            <td width="35%">Ekspedisi</td>
                            <td width="5%">:</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>Alamat Ekspedisi</td>
                            <td>:</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td colspan="3">&nbsp;</td> <!-- Spacer -->
                        </tr>
                        <tr>
                            <td>PIC Gudang PT.3M</td>
                            <td>:</td>
                            <td>RIKI</td> <!-- Hardcoded based on image or could be dynamic -->
                        </tr>
                        <tr>
                            <td>Kontak</td>
                            <td>:</td>
                            <td>+62 812-8339-0015</td>
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
            <th width="5%">No.</th>
            <th width="10%">Kode</th>
            <th width="45%">Nama Barang</th>
            <th width="15%">Kemasan</th>
            <th width="10%">Qty</th>
        </tr>
        </thead>
        <tbody>
        @foreach($purchaseOrder->items as $index => $item)
            <tr class="{{ $index % 2 == 1 ? 'striped' : '' }}">
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td style="text-align: center;">-</td>
                <td>
                    {{ $item->product->name }}
                    @if($item->product->size)
                         - {{ $item->product->size }}
                    @endif
                </td>
                <td style="text-align: center;">{{ $item->packaging ?? $item->product->unit ?? 'Pcs' }}</td>
                <td style="text-align: center;">{{ $item->quantity }}</td>
            </tr>
        @endforeach
        
        <!-- Fill empty rows to look like the image if list is short -->
        @for($i = count($purchaseOrder->items); $i < 10; $i++)
             <tr class="{{ $i % 2 == 1 ? 'striped' : '' }}">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        @endfor
        </tbody>
        <tfoot style="border-top: 2px solid #000;">
            <tr><td colspan="5" style="border: none;"></td></tr>
        </tfoot>
    </table>

    <!-- Signatures -->
    <table class="signatures">
        <tr>
            <td width="33%">
                <div style="margin-bottom: 5px;">Mengetahui,</div>
            </td>
            <td width="33%">
                <div style="margin-bottom: 5px;">Menyetujui,</div>
            </td>
            <td width="34%" style="vertical-align: bottom;">
                <div style="text-align: right; margin-bottom: 5px; margin-right: 10px;">
                    Tgl : <span class="date-box" style="background-color: #e6f3f7; padding: 2px 10px;">{{ $purchaseOrder->order_date?->format('d/m/Y') ?? date('d/m/Y') }}</span>
                </div>
            </td>
        </tr>
        <tr>
            <td style="height: 60px;"></td>
            <td style="height: 60px;"></td>
            <td style="height: 60px;"></td>
        </tr>
        <tr>
            <td>
                <div class="sign-box">( Rahmatul Fajriah, ST )</div>
            </td>
            <td>
                <div class="sign-box">( Sri Afdila, A. Md., AK )</div>
            </td>
            <td>
                <div class="sign-box">( apt. Deftia Harvima, S.Farm )</div>
                <div style="font-size: 9px; margin-top: 2px;">005/SIPA-1/DPMPTSP&NAKER/IV/2025</div>
            </td>
        </tr>
    </table>

    <!-- Notes -->
    @if($purchaseOrder->notes)
        <div style="font-weight: bold; margin-top: 10px; font-size: 10px;">Note:</div>
        <div class="notes-list" style="white-space: pre-wrap;">{{ $purchaseOrder->notes }}</div>
    @endif
</div>
</body>
</html>


