<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
                ['title' => 'Легкий', 'created_at' => now(), 'updated_at' => now()],
                ['title' => 'Хрупкий', 'created_at' => now(), 'updated_at' => now()],
                ['title' => 'Тяжелый', 'created_at' => now(), 'updated_at' => now()],
            ]
        );
    }
}
