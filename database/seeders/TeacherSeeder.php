<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Teacher;

class TeacherSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();

        foreach (range(1,50) as $index) {
            Teacher::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'phone_number' => $faker->phoneNumber,
                'salary' => $faker->numberBetween(30000, 90000),
                'date_of_birth' => $faker->dateTimeBetween('-60 years', '-22 years')->format('Y-m-d'),
                'gender' => $faker->randomElement(['male', 'female']),
            ]);
        }
    }
}

