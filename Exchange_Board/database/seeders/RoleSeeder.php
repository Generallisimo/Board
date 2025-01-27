<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(
            ['name'=>'admin'],
        );
        Role::create(
            ['name'=>'market'],
        );
        Role::create(
            ['name'=>'client'],
        );
        Role::create(
            ['name'=>'agent'],
        );
        Role::create(
            ['name'=>'support'],
        );
        Role::create(
            ['name'=>'guest'],
        );
        Role::create(
            ['name'=>'client_uah'],
        );
        Role::create(
            ['name'=>'market_uah'],
        );
        Role::create(
            ['name'=>'agent_uah'],
        );

        $user = User::find(1);
        $user->assignRole('admin');
    }
}
