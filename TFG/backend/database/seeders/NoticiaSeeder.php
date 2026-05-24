<?php

namespace Database\Seeders;

use App\Models\Noticia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NoticiaSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $noticias = [
            ['usuario_id' => 2, 'titulo'=> 'Nuevo juego lanzado!','contenido' => 'Nuevo juego lanzado!', 'imagen' => null, 'categoria_id' => 1],
            ['usuario_id' => 1, 'titulo'=> 'Mi opinión sobre el torneo','contenido' => 'Mi opinión sobre el torneo', 'imagen' => null, 'categoria_id' => 2]
        ];

        foreach ($noticias as $noticia) {
            Noticia::create($noticia);
        }
    }
}

