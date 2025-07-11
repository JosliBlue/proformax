<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $paper->paper_date ? \Carbon\Carbon::parse($paper->paper_date)->format('d/m/Y') : '' }} -
        {{ $paper->customer->getFullName() }} - Proforma {{ $paper->id }} - {{ $company->company_name }}
    </title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: white;
        }

        .container {
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        .document-header {
            padding: 15px 20px;
            background-color: {{ $company->company_primary_color }};
            color: white;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .header-table {
            width: 100%;
        }

        .company-info {
            text-align: left;
            vertical-align: middle;
            width: 70%;
        }

        .company-name {
            font-size: 1.5rem;
            font-weight: bold;
            color: {{ $company->company_primary_text_color }};
        }

        .company-logo-container {
            text-align: right;
            width: 30%;
            vertical-align: middle;
        }

        .company-logo {
            width: 100px;
            height: 100px;
            object-fit: contain;
        }

        .document-details {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 10px 20px;
            margin: 20px 0;
        }

        .info-group h3 {
            color: {{ $company->company_primary_color }};
            font-size: 1.2rem;
            margin-bottom: 15px;
            border-bottom: 2px solid {{ $company->company_primary_color }};
            padding-bottom: 5px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 4px 0;
            border-bottom: 1px solid #eee;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .label {
            font-weight: bold;
            color: #666;
        }

        .value {
            color: #333;
        }

        .products-section {
            margin-top: 10px;
        }

        .products-section h3 {
            color: {{ $company->company_primary_color }};
            margin-bottom: 15px;
            font-size: 1.2rem;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .products-table th,
        .products-table td {
            padding: 10px 15px;
            font-size: 0.9rem;
        }

        .products-table th {
            background-color: {{ $company->company_primary_color }};
            color: {{ $company->company_primary_text_color }};
            text-align: left;
        }

        .products-table td {
            border-bottom: 1px solid #eee;
        }

        .products-table tr:last-child td {
            border-bottom: none;
        }

        .total-row {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .signature-section {
            margin-top: 100px;
            padding: 20px 0;
        }

        .signature-line {
            border-top: 1px solid #333;
            width: 300px;
            margin: 0 auto;
            padding-top: 5px;
            text-align: center;
            font-size: 0.9rem;
        }

        .footer {
            margin-top: 30px;
            width: 100%;
            border-collapse: collapse;
            font-size: 0.8rem;
            color: #666;
        }

        .footer td {
            border: none;
            padding: 0;
            vertical-align: baseline;
        }

        .footer-left {
            text-align: left;
            width: 50%;
        }

        .footer-right {
            text-align: right;
            width: 50%;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="document-header">
            <table class="header-table">
                <tr>
                    <td class="company-info">
                        <div class="company-name">{{ $company->company_name }}</div>
                    </td>
                    <td class="company-logo-container">
                        <img src="{{ $company->getLogoUrlAttribute() }}" alt="Logo" class="company-logo">
                    </td>
                </tr>
            </table>
        </div>

        <div class="document-details">
            <div class="info-group">
                <h3>Detalles</h3>
                <div class="info-row">
                    <span class="label">Cliente:</span>
                    <span class="value">{{ $paper->customer->getFullName() }}</span>
                </div>
                @if ($paper->customer->customer_cedula)
                    <div class="info-row">
                        <span class="label">Cédula:</span>
                        <span class="value">{{ $paper->customer->customer_cedula }}</span>
                    </div>
                @endif
                @if ($paper->customer->customer_email)
                    <div class="info-row">
                        <span class="label">Correo:</span>
                        <span class="value">{{ $paper->customer->customer_email }}</span>
                    </div>
                @endif
                <div class="info-row">
                    <span class="label">Fecha:</span>
                    <span
                        class="value">{{ $paper->paper_date ? \Carbon\Carbon::parse($paper->paper_date)->format('d/m/Y') : '' }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Días de vigencia:</span>
                    <span class="value">{{ $paper->paper_days }} días</span>
                </div>
            </div>
        </div>

        <div class="products-section">
            <table class="products-table">
                <thead>
                    <tr>
                        <th>PRODUCTO</th>
                        <th>CANTIDAD</th>
                        <th>PRECIO UNITARIO</th>
                        <th>SUBTOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paper->products as $product)
                        <tr>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->pivot->quantity }}</td>
                            <td>${{ number_format($product->pivot->unit_price, 2) }}</td>
                            <td>${{ number_format($product->pivot->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="3" class="text-right">TOTAL:</td>
                        <td>${{ number_format($paper->paper_total_price, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="signature-section">
            <div class="signature-line">
                @php
                    $gerente = $company->getGerente();
                @endphp
                @if ($gerente)
                    {{ $gerente->user_name }} @if ($gerente->user_cedula)
                        - {{ $gerente->user_cedula }}
                    @endif
                    <br>
                    <strong>Gerente</strong>
                @else
                    <strong>Firma del Gerente</strong>
                @endif
            </div>
        </div>

        <table class="footer">
            <tr>
                <td class="footer-left">
                    *Los precios no incluyen IVA
                </td>
                <td class="footer-right">
                    Generado por: {{ auth()->user()->user_name }}
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
