<?php
namespace Database\Seeders;

use App\Models\MethodPayments;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([UserSeeder::class]);
        $this->call([RoleSeeder::class]);
        $this->call([MethodPaymentsSeeder::class]);
    }
}
