<?php

namespace Database\Seeders;

use App\Helpers\SessionYears;
use App\Models\CurrentSessionYear;
use App\Models\Driver;
use App\Models\Holiday;
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


        /*Set current session year*/
        if(empty(CurrentSessionYear::count())){
            CurrentSessionYear::insert([
                'sessionyear' => '2024-25'
            ]);
        }

        /*Add data*/
        $this->call([
            SectionSeeder::class,
            SchoolclassSeeder::class,
            SubjectSeeder::class,
            PerformanceIndicatorSeeder::class,
            HolidaySeeder::class,
        ]);

        /*Add users*/
        if(empty(User::count())){
            //Create Admin
            User::factory()->create([
                'name' => 'Admin User',
                'username' => 'admin',
                'password' => 1234,
                'email' => 'admin@test.com',
                'mobile' => 9988776655,
                'role' => 'management',
                'is_admin' => true,
                'address' => 'Admin address, ABC School, NY, USA',
                'selectedsessionyear' => SessionYears::currentSessionYear()
            ]);

            //create teachers
            User::factory(10)->create();
        }


        /*Add Students*/
        if(empty(Student::count())){
            Student::factory()->create([
                'name' => 'John Doe',
                'gender' => 'm',
                'dob' => fake()->date('d-m-Y'),
                'mobile' => 9999999999,
                'email' => 'parent@test.com',
                'fathername' => 'Mike Doe',
                'mothername' => 'Michael',
                'address' => '123, Test Street, NY, USA',
                'username' => 'parent@test.com',
                'password' => 1234,
                'selectedsessionyear' => SessionYears::currentSessionYear()
            ]);

            Student::factory(30)
//                ->has(Studentdetail::factory()->count(1), 'studentdetails')
                ->create();
        }

        /*Add Drivers*/
        if(empty(Driver::count())){
            Driver::factory(10)->create();
        }

    }
}
