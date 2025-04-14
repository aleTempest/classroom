<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Room;
use App\Models\Enrollment;
use Carbon\Carbon;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing enrollments
        Enrollment::truncate();

        // Get all students (users with student role)
        $students = User::where('role', 'student')->get();
        
        // Get all available rooms
        $rooms = Room::all();

        // Ensure we have students and rooms to work with
        if ($students->isEmpty() || $rooms->isEmpty()) {
            $this->command->info('No students or rooms found. Skipping enrollments seeding.');
            return;
        }

        // Create enrollments
        foreach ($rooms as $room) {
            // Random number of students to enroll in this room (between 5 and 20)
            $studentCount = rand(5, min(20, $students->count()));
            
            // Get random students
            $randomStudents = $students->random($studentCount);
            
            foreach ($randomStudents as $student) {
                // Random enrollment date within the past year
                $enrolledAt = Carbon::now()->subDays(rand(0, 365))->subHours(rand(0, 24));
                
                Enrollment::create([
                    'room_id' => $room->id,
                    'user_id' => $student->id,
                    'enrolled_at' => $enrolledAt,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info('Enrollments seeded successfully!');
    }
}