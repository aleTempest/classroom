<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Career;
use Faker\Factory as Faker;

class CareerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $careerNames = [
            'Software Engineer',
            'Data Scientist',
            'Web Developer',
            'Network Administrator',
            'Database Administrator',
            'Systems Analyst',
            'UX/UI Designer',
            'DevOps Engineer',
            'Cybersecurity Specialist',
            'Cloud Architect'
        ];

        foreach ($careerNames as $name) {
            Career::create([
                'name' => $name,
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}
