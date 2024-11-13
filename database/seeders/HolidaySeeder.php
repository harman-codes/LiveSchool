<?php

namespace Database\Seeders;

use App\Helpers\DT;
use App\Helpers\SessionYears;
use App\Models\Holiday;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentYear = DT::currentYear();
        $currentSessionYear = SessionYears::currentSessionYear();
        if(empty(Holiday::count())){
            Holiday::insert([
                ['sessionyear' => $currentSessionYear, 'is_singleday' => 1, 'date' => $currentYear.'-01-01', 'from' => null, 'to' => null, 'name' => 'New Year'],
                ['sessionyear' => $currentSessionYear, 'is_singleday' => 0, 'date' => null, 'from' => $currentYear.'-06-01', 'to' => $currentYear.'-07-15', 'name' => 'Summer Vacations'],
                ['sessionyear' => $currentSessionYear, 'is_singleday' => 1, 'date' => $currentYear.'-08-15', 'from' => null, 'to' => null, 'name' => 'Independence Day'],
                ['sessionyear' => $currentSessionYear, 'is_singleday' => 1, 'date' => $currentYear.'-12-25', 'from' => null, 'to' => null, 'name' => 'Christmas'],
                ['sessionyear' => $currentSessionYear, 'is_singleday' => 0, 'date' => null, 'from' => $currentYear.'-12-26', 'to' => $currentYear.'-12-31', 'name' => 'Winter Vacations'],
            ]);
        }
    }
}
