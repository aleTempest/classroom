<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Teacher;
use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PostSeeder extends Seeder
{
    public function run()
    {
        $teachers = Teacher::all();
        $rooms = Room::all();

        if ($teachers->isEmpty() || $rooms->isEmpty()) {
            $this->command->error('No teachers or rooms found! Please seed those first.');
            return;
        }

        $posts = [
            [
                'title' => 'Mathematics Assignment',
                'content' => 'Complete exercises 1-10 on page 45 for next class.',
                'topic' => 'Algebra Basics',
                'published_at' => Carbon::now()->subDays(2),
            ],
            [
                'title' => 'Science Project Guidelines',
                'content' => 'The science project will focus on renewable energy sources. Groups of 3-4 students.',
                'topic' => 'Environmental Science',
                'published_at' => Carbon::now()->subDays(1),
            ],
            [
                'title' => 'Literature Reading List',
                'content' => 'Please read chapters 3-5 of "To Kill a Mockingbird" for our next discussion.',
                'topic' => 'American Literature',
                'published_at' => Carbon::now(),
            ],
            [
                'title' => 'History Research Paper',
                'content' => 'Choose a topic from World War II era and submit a 5-page research paper.',
                'topic' => '20th Century History',
                'published_at' => null, // Draft post
            ],
        ];

        foreach ($posts as $postData) {
            Post::create(array_merge($postData, [
                'teacher_id' => $teachers->random()->id,
                'room_id' => $rooms->random()->id,
            ]));
        }

        $this->command->info('Posts seeded successfully!');
    }
}