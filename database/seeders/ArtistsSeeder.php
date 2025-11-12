<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArtistsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('artists')->insert([
            ['name' => 'The Beatles', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Queen', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mozart', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Daft Punk', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ария', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Michael Jackson', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Led Zeppelin', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Nirvana', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
