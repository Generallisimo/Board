<?php

namespace Database\Seeders;

use App\Models\MethodPayments;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MethodPaymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MethodPayments::factory()->create([
            'name_method'=>'Sberbank',
            'currency'=>'RUB' 
        ]);
        MethodPayments::factory()->create([
            'name_method'=>'Tinkoff',
            'currency'=>'RUB' 
        ]);
        MethodPayments::factory()->create([
            'name_method'=>'Raiffeisen',
            'currency'=>'RUB' 
        ]);
        MethodPayments::factory()->create([
            'name_method'=>'Alfa',
            'currency'=>'RUB' 
        ]);
        MethodPayments::factory()->create([
            'name_method'=>'Private24',
            'currency'=>'UAH' 
        ]);
        MethodPayments::factory()->create([
            'name_method'=>'Monobank',
            'currency'=>'UAH' 
        ]);
    }
}
