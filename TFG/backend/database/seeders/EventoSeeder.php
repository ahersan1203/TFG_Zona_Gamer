<?php

namespace Database\Seeders;

use App\Models\Evento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventoSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $eventos = [
            [
                'nombre' => 'Torneo Fortnite',
                'descripcion' => 'Competencia internacional de Fortnite',
                'fecha_inicio' => '2026-03-10',
                'fecha_final' => '2026-03-12',
                'lugar' => 'Online',
            ],
            [
                'nombre' => 'Campeonato LoL',
                'descripcion' => 'Evento de League of Legends',
                'fecha_inicio' => '2026-04-05',
                'fecha_final' => '2026-04-07',
                'lugar' => 'Ciudad de México',
            ]
        ];

        foreach ($eventos as $evento) {
            Evento::create($evento);
        }
    }
}

