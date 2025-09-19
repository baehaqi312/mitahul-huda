<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSedeeer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Luthfi Baehaqi',
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'password' => bcrypt('12345678'),
        ]);
    }
}
