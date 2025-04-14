<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\Room;
use App\Models\TeacherRoom;

class TeacherRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing relationships
        TeacherRoom::truncate();

        $teachers = Teacher::all();
        $rooms = Room::all();

        if ($teachers->isEmpty() || $rooms->isEmpty()) {
            $this->command->info('No teachers or rooms found. Skipping seeding.');
            return;
        }

        // Assign exactly one random teacher to each room
        foreach ($rooms as $room) {
            $teacher = $teachers->random(); // Random teacher for each room
            
            TeacherRoom::create([
                'teacher_id' => $teacher->id,
                'room_id' => $room->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info("Assigned 1 teacher per room ({$rooms->count()} assignments)");
        $this->command->info("Teachers may have multiple rooms, but no room has multiple teachers");
    }
}