<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenresSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('genres')->insert([
            ['name' => 'Рок', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Поп', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Джаз', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Классика', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Электроника', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Хип-хоп', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Блюз', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Метал', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
