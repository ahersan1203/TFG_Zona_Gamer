<?php

namespace Database\Seeders;

use App\Models\Comentario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComentarioSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comentarios = [
            ['publicacion_id' => 1, 'usuario_id' => 1, 'contenido' => 'Excelente juego!', 'fecha' => now()],
            ['publicacion_id' => 2, 'usuario_id' => 2, 'contenido' => 'Me encanta el juego!', 'fecha' => now()],
        ];

        foreach ($comentarios as $comentario) {
            Comentario::create($comentario);
        }
    }
}

