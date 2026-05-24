<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = [
            [
                'name' => 'Juan',
                'email' => 'juan@email.com',
                'password' => bcrypt('password123'),
                'rol_id' => 2
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@email.com',
                'password' => bcrypt('admin123'),
                'rol_id' => 1
            ]
        ];

        foreach ($usuarios as $usuario) {
            User::create($usuario);
        }
    }
}
