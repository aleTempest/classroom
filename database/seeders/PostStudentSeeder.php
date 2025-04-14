<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Student;
use App\Models\PostStudent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PostStudentSeeder extends Seeder
{
    public function run()
    {
        $posts = Post::whereNotNull('published_at')->get();
        $students = Student::all();

        if ($posts->isEmpty() || $students->isEmpty()) {
            $this->command->error('No published posts or students found! Please seed those first.');
            return;
        }

        foreach ($posts as $post) {
            // Get random subset of students (30-70% of all students)
            $studentCount = rand(
                ceil($students->count() * 0.3),
                ceil($students->count() * 0.7)
            );
            
            $selectedStudents = $students->random($studentCount);
            
            foreach ($selectedStudents as $student) {
                $readAt = rand(0, 1) ? Carbon::now()->subDays(rand(0, 2)) : null;
                
                PostStudent::create([
                    'post_id' => $post->id,
                    'student_id' => $student->id,
                    'read_at' => $readAt,
                ]);
            }
        }
    }
}