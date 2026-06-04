<?php

namespace Database\Seeders;

use App\Models\Seguidor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeguidorSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $juan = User::where('email', 'juan@email.com')->first();
        $admin = User::where('email', 'admin@email.com')->first();

        if (!$juan || !$admin) return;

        Seguidor::firstOrCreate(
            ['usuario_id' => $juan->id, 'usuario_seguido_id' => $admin->id],
            ['estado' => 'aceptado']
        );

        Seguidor::firstOrCreate(
            ['usuario_id' => $admin->id, 'usuario_seguido_id' => $juan->id],
            ['estado' => 'aceptado']
        );
    }
}