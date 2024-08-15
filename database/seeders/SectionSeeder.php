<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(empty(Section::count())){
            Section::insert([
                ['name' => 'A'],
                ['name' => 'B'],
                ['name' => 'C'],
                ['name' => 'D'],
            ]);
        }
    }
}
