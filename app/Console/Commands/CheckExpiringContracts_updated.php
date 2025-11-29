<?php

namespace App\Console\Commands;

use App\Models\PropertyContract;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckExpiringContracts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contracts:check-expiring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar contratos que vencen pronto y enviar alertas (3 meses, 1 mes, 1 semana)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Verificando contratos por vencer...');

        $alertCounts = [
            '3_months' => 0,
            '1_month' => 0,
            '1_week' => 0,
        ];

        // ========== ALERTAS DE 3 MESES ==========
        $this->info("\n📅 Verificando contratos que vencen en 3 meses...");
        $contracts3Months = PropertyContract::active()
            ->whereRaw('alert_3months_sent = 0')
            ->get()
            ->filter(function ($contract) {
                return $contract->needsThreeMonthAlert();
            });

        foreach ($contracts3Months as $contract) {
            try {
                $this->processAlert($contract, '3 meses', function ($contract) {
                    $contract->markThreeMonthAlertSent();
                });
                $alertCounts['3_months']++;
            } catch (\Exception $e) {
                $this->error("✗ Error en contrato #{$contract->id}: {$e->getMessage()}");
            }
        }

        // ========== ALERTAS DE 1 MES ==========
        $this->info("\n📅 Verificando contratos que vencen en 1 mes...");
        $contracts1Month = PropertyContract::active()
            ->whereRaw('alert_1month_sent = 0')
            ->get()
            ->filter(function ($contract) {
                return $contract->needsOneMonthAlert();
            });

        foreach ($contracts1Month as $contract) {
            try {
                $this->processAlert($contract, '1 mes', function ($contract) {
                    $contract->markOneMonthAlertSent();
                });
                $alertCounts['1_month']++;
            } catch (\Exception $e) {
                $this->error("✗ Error en contrato #{$contract->id}: {$e->getMessage()}");
            }
        }

        // ========== ALERTAS DE 1 SEMANA ==========
        $this->info("\n📅 Verificando contratos que vencen en 1 semana...");
        $contracts1Week = PropertyContract::active()
            ->whereRaw('alert_1week_sent = 0')
            ->get()
            ->filter(function ($contract) {
                return $contract->needsOneWeekAlert();
            });

        foreach ($contracts1Week as $contract) {
            try {
                $this->processAlert($contract, '1 semana', function ($contract) {
                    $contract->markOneWeekAlertSent();
                });
                $alertCounts['1_week']++;
            } catch (\Exception $e) {
                $this->error("✗ Error en contrato #{$contract->id}: {$e->getMessage()}");
            }
        }

        // ========== MARCAR CONTRATOS EXPIRADOS ==========
        $this->info("\n⏰ Actualizando contratos expirados...");
        $expiredCount = PropertyContract::expired()
            ->where('status', 'active')
            ->update(['status' => 'expired']);

        if ($expiredCount > 0) {
            $this->info("✓ {$expiredCount} contrato(s) marcado(s) como expirado(s)");
        }

        // ========== RESUMEN ==========
        $this->info("\n" . str_repeat('=', 50));
        $this->info('📊 RESUMEN DE ALERTAS ENVIADAS');
        $this->info(str_repeat('=', 50));
        $this->table(
            ['Tipo de Alerta', 'Cantidad'],
            [
                ['3 meses antes', $alertCounts['3_months']],
                ['1 mes antes', $alertCounts['1_month']],
                ['1 semana antes', $alertCounts['1_week']],
                ['Contratos expirados', $expiredCount],
            ]
        );

        $totalAlerts = array_sum($alertCounts);
        if ($totalAlerts === 0 && $expiredCount === 0) {
            $this->info("\n✓ No hay contratos que requieran atención.");
        } else {
            $this->info("\n✓ Proceso completado exitosamente.");
        }

        return Command::SUCCESS;
    }

    /**
     * Procesar una alerta individual
     */
    private function processAlert(PropertyContract $contract, string $period, callable $markSentCallback): void
    {
        $property = $contract->property;
        $daysRemaining = $contract->getDaysRemaining();

        $this->line(sprintf(
            "  → Propiedad: %s | Contrato #%d | Vence en %d días",
            $property->name,
            $contract->id,
            $daysRemaining
        ));

        // Aquí puedes agregar el envío de email
        // Ejemplo:
        // Mail::to(config('mail.admin_email'))->send(
        //     new ContractExpiringMail($contract, $period)
        // );

        // También puedes enviar notificación al inquilino si tiene email
        // if ($contract->tenant_email) {
        //     Mail::to($contract->tenant_email)->send(
        //         new TenantContractExpiringMail($contract, $period)
        //     );
        // }

        // Marcar como enviada
        $markSentCallback($contract);

        Log::info("Alerta de vencimiento enviada ({$period})", [
            'contract_id' => $contract->id,
            'property_id' => $property->id,
            'property_name' => $property->name,
            'days_remaining' => $daysRemaining,
            'end_date' => $contract->end_date->format('Y-m-d'),
            'tenant' => $contract->tenant_name,
            'period' => $period,
        ]);

        $this->info("  ✓ Alerta enviada");
    }
}
