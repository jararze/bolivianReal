<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Configuration;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Configuration::setConfig('main_data', [
            'name' => 'Your Company Name',
            'phone' => '+123 456 7890',
            'direction' => '123 Main Street, City, Country',
            'email' => 'contact@yourcompany.com',
            'attentionHour' => '9:00 AM - 6:00 PM',
        ], 'general');
    }
}
