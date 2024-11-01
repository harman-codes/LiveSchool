<?php

namespace Database\Seeders;

use App\Models\PerformanceIndicator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PerformanceIndicatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(empty(PerformanceIndicator::count())){
            PerformanceIndicator::insert([
                ['min' => 0, 'max' => 30, 'remarks' => 'Poor', 'color' => '#d40000'],
                ['min' => 31, 'max' => 50, 'remarks' => 'Below Average', 'color' => '#fad616'],
                ['min' => 51, 'max' => 60, 'remarks' => 'Average', 'color' => '#e06c00'],
                ['min' => 61, 'max' => 75, 'remarks' => 'Good', 'color' => '#0040ff'],
                ['min' => 76, 'max' => 90, 'remarks' => 'Very Good', 'color' => '#0dcf03'],
                ['min' => 91, 'max' => 100, 'remarks' => 'Excellent', 'color' => '#005709'],
            ]);
        }
    }
}
