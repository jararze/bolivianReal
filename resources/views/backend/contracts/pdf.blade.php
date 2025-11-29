<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Contratos</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            color: #333;
            line-height: 1.4;
        }

        .header {
            background-color: #0DBAE8;
            color: white;
            padding: 20px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 12px;
            opacity: 0.9;
        }

        .info-box {
            background-color: #f8f9fa;
            padding: 10px;
            margin-bottom: 15px;
            border-left: 3px solid #0DBAE8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        thead {
            background-color: #0DBAE8;
            color: white;
        }

        th {
            padding: 10px 5px;
            text-align: left;
            font-size: 9px;
            font-weight: bold;
        }

        td {
            padding: 8px 5px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 9px;
        }

        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .badge {
            display: inline-block;
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }

        .badge-success {
            background-color: #28a745;
            color: white;
        }

        .badge-danger {
            background-color: #dc3545;
            color: white;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #333;
        }

        .badge-info {
            background-color: #17a2b8;
            color: white;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #f8f9fa;
            padding: 10px 20px;
            text-align: center;
            font-size: 8px;
            color: #666;
            border-top: 1px solid #ddd;
        }

        .page-break {
            page-break-after: always;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
<!-- Header -->
<div class="header">
    <h1>Reporte de Contratos</h1>
    <p>Generado el {{ now()->format('d/m/Y H:i') }}</p>
</div>

<!-- Resumen -->
<div class="info-box">
    <p><strong>Total de Contratos:</strong> {{ $contracts->count() }}</p>
    <p><strong>Activos:</strong> {{ $contracts->where('status', 'active')->count() }}</p>
    <p><strong>Vencidos:</strong> {{ $contracts->where('status', 'expired')->count() }}</p>
</div>

<!-- Tabla de Contratos -->
<table>
    <thead>
    <tr>
        <th style="width: 8%;">ID</th>
        <th style="width: 20%;">Propiedad</th>
        <th style="width: 12%;">Tipo</th>
        <th style="width: 18%;">Inquilino</th>
        <th style="width: 10%;">Inicio</th>
        <th style="width: 10%;">Vencimiento</th>
        <th style="width: 12%;">Monto</th>
        <th style="width: 10%;">Estado</th>
    </tr>
    </thead>
    <tbody>
    @foreach($contracts as $contract)
        <tr>
            <td class="text-center">{{ $contract->id }}</td>
            <td>
                <strong>{{ $contract->property->name }}</strong><br>
                <span style="font-size: 8px; color: #666;">{{ $contract->property->code }}</span>
            </td>
            <td>
                        <span class="badge {{ $contract->contract_type === 'rent' ? 'badge-info' : 'badge-success' }}">
                            {{ $contract->getContractTypeLabel() }}
                        </span>
            </td>
            <td>{{ $contract->tenant_name ?? '-' }}</td>
            <td>{{ $contract->start_date->format('d/m/Y') }}</td>
            <td>
                {{ $contract->end_date->format('d/m/Y') }}
                @if($contract->isExpiringInMonths(1) && $contract->status === 'active')
                    <br><span class="badge badge-warning">{{ $contract->getDaysRemaining() }}d</span>
                @endif
            </td>
            <td class="text-right font-bold">{{ $contract->getFormattedAmount() }}</td>
            <td>
                        <span class="badge
                            @if($contract->status === 'active') badge-success
                            @elseif($contract->status === 'expired') badge-danger
                            @else badge-warning
                            @endif
                        ">
                            {{ $contract->getStatusLabel() }}
                        </span>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<!-- Footer -->
<div class="footer">
    <p>{{ config('app.name') }} - Reporte de Contratos</p>
    <p>Página <span class="page-number"></span></p>
</div>

<script type="text/php">
    if (isset($pdf)) {
        $text = "Página {PAGE_NUM} de {PAGE_COUNT}";
        $size = 8;
        $font = $fontMetrics->getFont("DejaVu Sans");
        $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
        $x = ($pdf->get_width() - $width) / 2;
        $y = $pdf->get_height() - 35;
        $pdf->page_text($x, $y, $text, $font, $size);
    }
</script>
</body>
</html>
