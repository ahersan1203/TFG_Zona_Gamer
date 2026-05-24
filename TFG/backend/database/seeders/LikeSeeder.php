<?php

namespace Database\Seeders;

use App\Models\Like;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LikeSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $likes = [
            ['usuario_id' => 1, 'publicacion_id' => 1, 'fecha' => now()],
            ['usuario_id' => 2, 'publicacion_id' => 2, 'fecha' => now()],
        ];

        foreach ($likes as $like) {
            Like::create($like);
        }
    }
}

