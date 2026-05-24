<?php

namespace Database\Seeders;

use App\Models\Publicacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PublicacionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $publicaciones = [
    [
        'usuario_id' => 2,
        'contenido' => 'Nuevo juego lanzado!',
        'imagen' => null,
        'fecha' => now(),
        'tipo' => 'noticia'
    ],
    [
        'usuario_id' => 1,
        'contenido' => 'Mi opinión sobre el torneo',
        'imagen' => null,
        'fecha' => now(),
        'tipo' => 'post'
    ]
    ];

    foreach ($publicaciones as $publicacion) {
        Publicacion::create($publicacion);
    }
    }
}

