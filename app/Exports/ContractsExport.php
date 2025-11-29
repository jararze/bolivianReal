<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ContractsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $contracts;

    public function __construct($contracts)
    {
        $this->contracts = $contracts;
    }

    public function collection()
    {
        return $this->contracts;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Código Propiedad',
            'Propiedad',
            'Tipo de Propiedad',
            'Ciudad',
            'Tipo de Contrato',
            'Inquilino/Arrendatario',
            'CI/Documento',
            'Teléfono',
            'Email',
            'Fecha de Inicio',
            'Fecha de Finalización',
            'Duración (meses)',
            'Monto',
            'Moneda',
            'Estado',
            'Días Restantes',
            'Creado Por',
            'Fecha de Creación',
        ];
    }

    public function map($contract): array
    {
        $daysRemaining = $contract->getDaysRemaining();

        return [
            $contract->id,
            $contract->property->code ?? '-',
            $contract->property->name ?? '-',
            $contract->property->propertyType->type_name ?? '-',
            $contract->property->citys->name ?? '-',
            $contract->getContractTypeLabel(),
            $contract->tenant_name ?? '-',
            $contract->tenant_ci ?? '-',
            $contract->tenant_phone ?? '-',
            $contract->tenant_email ?? '-',
            $contract->start_date->format('d/m/Y'),
            $contract->end_date->format('d/m/Y'),
            $contract->duration_months,
            $contract->amount ? number_format($contract->amount, 2) : '-',
            $contract->currency,
            $contract->getStatusLabel(),
            $daysRemaining > 0 ? $daysRemaining : ($contract->isExpired() ? 'Vencido' : '-'),
            $contract->createdBy->name ?? '-',
            $contract->created_at->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4472C4']
                ],
                'font' => ['color' => ['rgb' => 'FFFFFF'], 'bold' => true],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,   // ID
            'B' => 15,  // Código
            'C' => 30,  // Propiedad
            'D' => 18,  // Tipo
            'E' => 15,  // Ciudad
            'F' => 15,  // Tipo Contrato
            'G' => 25,  // Inquilino
            'H' => 15,  // CI
            'I' => 15,  // Teléfono
            'J' => 25,  // Email
            'K' => 12,  // Inicio
            'L' => 12,  // Fin
            'M' => 10,  // Duración
            'N' => 12,  // Monto
            'O' => 8,   // Moneda
            'P' => 12,  // Estado
            'Q' => 12,  // Días
            'R' => 20,  // Creado por
            'S' => 18,  // Fecha creación
        ];
    }
}
