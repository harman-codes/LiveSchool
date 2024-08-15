<?php

namespace Database\Seeders;

use App\Models\Schoolclass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolclassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $insertArray = [];

        $classes = ['1st', '2nd', '3rd', '4th', '5th', '6th', '7th', '8th', '9th', '10th', '11th', '12th'];
        $sections = ['A', 'B', 'C', 'D'];

        foreach($classes as $class){
            foreach($sections as $section){
                $insertArray[] = ['name' => $class, 'section' => $section, 'classwithsection' => $class.' ('.$section.')'];
            }
        }

        if(empty(Schoolclass::count())){
            Schoolclass::insert($insertArray);
        }
    }
}
