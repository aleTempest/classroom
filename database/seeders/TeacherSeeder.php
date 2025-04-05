<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\User;

class TeacherSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();

        foreach (range(1, 50) as $index) {
            $user = User::create([
                'name' => $faker->firstName . ' ' . $faker->lastName,
                'role' => 'teacher',
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('12345678'),
                'email_verified_at' => now(),
            ]);

            Teacher::create([
                'user_id' => $user->id,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $user->email,
                'phone_number' => $faker->phoneNumber,
                'salary' => $faker->numberBetween(30000, 90000),
                'date_of_birth' => $faker->dateTimeBetween('-60 years', '-22 years')->format('Y-m-d'),
                'gender' => $faker->randomElement(['male', 'female']),
            ]);
        }
    }
}
