<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\Career;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all careers to associate with rooms
        $careers = Career::all();

        // Sample room data grouped by career type
        $roomData = [
            'Computer Science' => [
                ['CS101', 'Introduction to Programming', 'Basic programming concepts using Python'],
                ['CS201', 'Data Structures', 'Fundamental data structures and algorithms'],
                ['CS301', 'Database Systems', 'Relational database design and SQL'],
                ['CS401', 'Artificial Intelligence', 'Introduction to AI and machine learning'],
            ],
            'Business Administration' => [
                ['BUS101', 'Principles of Management', 'Fundamentals of business management'],
                ['BUS201', 'Financial Accounting', 'Basic accounting principles'],
                ['BUS301', 'Marketing Principles', 'Introduction to marketing strategies'],
                ['BUS401', 'Business Ethics', 'Ethical decision making in business'],
            ],
            'Electrical Engineering' => [
                ['EE101', 'Circuit Analysis', 'Basic electrical circuit theory'],
                ['EE201', 'Digital Systems', 'Digital logic and computer systems'],
                ['EE301', 'Electromagnetics', 'Electromagnetic field theory'],
                ['EE401', 'Power Systems', 'Generation and distribution of electrical power'],
            ],
            'Medicine' => [
                ['MED101', 'Human Anatomy', 'Study of human body structure'],
                ['MED201', 'Biochemistry', 'Chemical processes in living organisms'],
                ['MED301', 'Pathology', 'Study of disease causes and effects'],
                ['MED401', 'Pharmacology', 'Study of drug action'],
            ],
        ];

        foreach ($roomData as $careerName => $rooms) {
            $career = $careers->firstWhere('name', $careerName);

            if ($career) {
                foreach ($rooms as $room) {
                    Room::create([
                        'career_id' => $career->id,
                        'code' => $room[0],
                        'name' => $room[1],
                        'desc' => $room[2],
                    ]);
                }
            }
        }

        // Additional random rooms for any remaining careers
        $faker = \Faker\Factory::create();
        $remainingCareers = $careers->whereNotIn('name', array_keys($roomData));

        foreach ($remainingCareers as $career) {
            for ($i = 0; $i < 4; $i++) {
                Room::create([
                    'career_id' => $career->id,
                    'code' => strtoupper(substr($career->name, 0, 2)) . $faker->numberBetween(100, 499),
                    'name' => $faker->catchPhrase . ' ' . $faker->randomElement(['I', 'II', 'III', 'Advanced']),
                    'desc' => $faker->sentence(10),
                ]);
            }
        }
    }
}
