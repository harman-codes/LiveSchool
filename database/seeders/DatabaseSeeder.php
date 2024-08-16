<?php

namespace Database\Seeders;

use App\Models\CurrentSessionYear;
use App\Models\Schoolclass;
use App\Models\Student;
use App\Models\Studentdetail;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);



        /*Add users*/
        if(empty(User::count())){
            //Create Admin
            User::factory()->create([
                'name' => 'Admin',
                'username' => 'admin',
                'password' => 1234,
                'email' => 'admin@test.com',
                'mobile' => 9988776655,
                'role' => 'admin',
                'address' => 'Admin address, ABC School, NY, USA',
            ]);

            //create teachers
            User::factory(50)->create();
        }


        /*Add Students*/
        if(empty(Student::count())){
            Student::factory(100)
//                ->has(Studentdetail::factory()->count(1), 'studentdetails')
                ->create();
        }

        if(empty(CurrentSessionYear::count())){
            CurrentSessionYear::insert([
                'sessionyear' => '2024-25'
            ]);
        }


        $this->call([
            SectionSeeder::class,
            SchoolclassSeeder::class,
            SubjectSeeder::class
        ]);

    }
}
