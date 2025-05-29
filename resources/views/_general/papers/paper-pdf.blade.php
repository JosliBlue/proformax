<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ now()->format('d/m/Y') }} - {{ $paper->customer->getFullNameAttribute() }} - Proforma
        {{ $paper->id }} - {{ $company->company_name }}</title>
    <style>
        :root {
            --primary-color: {{ $company->company_primary_color }};
            --primary-text-color: {{ $company->company_primary_text_color }};
        }

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
            padding: 40px 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        .document-header {
            padding: 20px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 8px;
            margin-bottom: 40px;
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
            color: var(--primary-text-color);
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
            padding: 20px;
            margin-bottom: 30px;
        }

        .info-group h3 {
            color: var(--primary-color);
            font-size: 1.2rem;
            margin-bottom: 15px;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 5px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
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
            margin-top: 30px;
        }

        .products-section h3 {
            color: var(--primary-color);
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
            padding: 12px 15px;
            font-size: 0.9rem;
        }

        .products-table th {
            background-color: var(--primary-color);
            color: var(--primary-text-color);
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
    </style>
</head>

<body>
    <div class="container">
        <div class="document-header">
            <table class="header-table">
                <tr>
                    <td class="company-info">
                        <div class="company-name">{{ $company->company_name }}</div>
                        <!-- Puedes agregar más info aquí -->
                    </td>
                    <td class="company-logo-container">
                        <img src="{{ $company->getLogoUrlAttribute() }}" alt="Logo" class="company-logo">
                    </td>
                </tr>
            </table>
        </div>

        <div class="document-details">
            <div class="info-group">
                <h3>Detalles del documento</h3>
                {{--
                <div class="info-row">
                    <span class="label">Proforma:</span>
                    <span class="value">{{ $paper->id }}</span>
                </div>
                --}}

                <div class="info-row">
                    <span class="label">Cliente:</span>
                    <span class="value">{{ $paper->customer->getFullNameAttribute() }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Fecha de creación:</span>
                    <span class="value">{{ $paper->created_at->format('d/m/Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Fecha de emisión:</span>
                    <span class="value">{{ now()->format('d/m/Y') }}</span>
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
    </div>
</body>

</html>
