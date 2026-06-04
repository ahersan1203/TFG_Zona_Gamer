<?php

namespace Database\Seeders;

use App\Models\Juego;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JuegoSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $juegos = [
            ['nombre' => 'Fortnite', 'desarrollador' => 'Epic Games', 'genero' => 'Battle Royale', 'Plataforma' => 'PC, PS, Xbox'],
            ['nombre' => 'League of Legends', 'desarrollador' => 'Riot Games', 'genero' => 'MOBA', 'Plataforma' => 'PC'],
        ];

        foreach ($juegos as $juego) {
            Juego::create($juego);
        }
    }
}
