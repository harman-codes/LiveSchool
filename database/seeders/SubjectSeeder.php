<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(empty(Subject::count())){
            Subject::insert([
                ['name' => 'science'],
                ['name' => 'mathematics'],
                ['name' => 'english'],
                ['name' => 'social studies'],
                ['name' => 'hindi'],
                ['name' => 'punjabi'],
                ['name' => 'history'],
                ['name' => 'geography'],
                ['name' => 'civics'],
                ['name' => 'chemistry'],
                ['name' => 'physics'],
                ['name' => 'biology'],
                ['name' => 'economics'],
                ['name' => 'commerce'],
                ['name' => 'business studies'],
                ['name' => 'accounts'],
            ]);
        }
    }
}
