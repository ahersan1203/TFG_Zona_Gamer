<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = ['Acción', 'Aventura', 'Multijugador', 'Competitivo', 'Cooperativo', 'Indie', 'RPG', 'Simulación', 'Deportes', 'Estrategia'];
        foreach ($categorias as $categoria) {
            Categoria::create(['nombre' => $categoria, 'descripcion' => 'Descripción de la categoría ' . $categoria]);
        }
    }
}

