<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Schedule::command('contracts:check-expiring')
    ->dailyAt('08:00')
    ->emailOutputOnFailure(config('mail.admin_email'));


// ========================================
// PROGRAMACIÓN DE TAREAS (Task Scheduling)
// ========================================

// Verificar contratos por vencer - Ejecutar diariamente a las 8:00 AM
Schedule::command('contracts:check-expiring')
    ->dailyAt('08:00')
    ->name('check-expiring-contracts')
    ->withoutOverlapping() // Evitar que se ejecute si aún está corriendo
    ->onSuccess(function () {
        // Opcional: ejecutar algo cuando tenga éxito
    })
    ->onFailure(function () {
        // Opcional: ejecutar algo cuando falle
    });

// EJEMPLOS de otras frecuencias que puedes usar:

// Cada 5 minutos
// Schedule::command('contracts:check-expiring')->everyFiveMinutes();

// Cada hora
// Schedule::command('contracts:check-expiring')->hourly();

// Cada día a medianoche
// Schedule::command('contracts:check-expiring')->daily();

// Cada día a una hora específica
// Schedule::command('contracts:check-expiring')->dailyAt('13:00');

// Dos veces al día
// Schedule::command('contracts:check-expiring')->twiceDaily(8, 20);

// Cada semana los lunes a las 8:00
// Schedule::command('contracts:check-expiring')->weekly()->mondays()->at('08:00');

// Cada mes el primer día
// Schedule::command('contracts:check-expiring')->monthly();

// Solo en días laborables
// Schedule::command('contracts:check-expiring')->weekdays()->at('08:00');

// Solo fines de semana
// Schedule::command('contracts:check-expiring')->weekends()->at('10:00');

// OPCIONES ÚTILES:

// Ejecutar solo en producción
// Schedule::command('contracts:check-expiring')
//     ->dailyAt('08:00')
//     ->when(fn () => app()->environment('production'));

// Ejecutar en background (no bloquear)
// Schedule::command('contracts:check-expiring')
//     ->dailyAt('08:00')
//     ->runInBackground();

// Enviar email cuando falle
// Schedule::command('contracts:check-expiring')
//     ->dailyAt('08:00')
//     ->emailOutputOnFailure(config('mail.admin_email'));

// Guardar output en archivo
// Schedule::command('contracts:check-expiring')
//     ->dailyAt('08:00')
//     ->appendOutputTo(storage_path('logs/contracts-check.log'));
