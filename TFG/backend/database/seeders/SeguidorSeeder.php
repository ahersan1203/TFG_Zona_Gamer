<?php

namespace Database\Seeders;

use App\Models\Seguidor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeguidorSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seguidores = [
            [
                'usuario_id' => 2,
                'usuario_seguido_id' => 1,
                'estado' => 'aceptado'
            ],
            [
                'usuario_id' => 1,
                'usuario_seguido_id' => 2,
                'estado' => 'aceptado'
            ],
        ];

        foreach ($seguidores as $seguidor) {
            Seguidor::create($seguidor);
        }
    }
}
