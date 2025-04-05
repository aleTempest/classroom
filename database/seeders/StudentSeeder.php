<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();

        // Get all career IDs to assign randomly
        $careerIds = \App\Models\Career::pluck('id')->toArray();

        foreach (range(1, 100) as $index) {
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;

            $user = User::create([
                'name' => "$firstName $lastName",
                'role' => 'student',
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]);

            $enrollmentYear = $faker->numberBetween(2018, 2023);
            $enrollmentNumber = str_pad($index, 4, '0', STR_PAD_LEFT);

            Student::create([
                'user_id' => $user->id,
                'career_id' => $faker->randomElement($careerIds),
                'enrollment' => 'STU' . $enrollmentYear . $enrollmentNumber,
                'date_of_birth' => $faker->dateTimeBetween('-25 years', '-18 years')->format('Y-m-d'),
                'address' => $faker->address,
                'phone_number' => $faker->phoneNumber,
                'emergency_contact' => $faker->name . ' (' . $faker->randomElement(['Father', 'Mother', 'Guardian']) . ') ' . $faker->phoneNumber,
                'enrollment_date' => $faker->dateTimeBetween("$enrollmentYear-01-01", "$enrollmentYear-12-31")->format('Y-m-d'),
            ]);
        }
    }
}
