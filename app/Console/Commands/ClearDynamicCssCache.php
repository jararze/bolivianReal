<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearDynamicCssCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'css:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear dynamic CSS cache';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Cache::forget('theme_dynamic_css');
        $this->info('Dynamic CSS cache cleared successfully.');
    }
}
