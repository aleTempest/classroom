<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostAttachment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostAttachmentSeeder extends Seeder
{
    private $sampleFiles = [
        'sample.pdf' => 'application/pdf',
        'sample.docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'sample.xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'sample.jpg' => 'image/jpeg',
    ];

    public function run()
    {
        $posts = Post::all();

        if ($posts->isEmpty()) {
            $this->command->error('No posts found! Please seed posts first.');
            return;
        }

        foreach ($posts as $post) {
            // Create 1-3 attachments per post
            $attachmentCount = rand(1, 3);
            
            for ($i = 0; $i < $attachmentCount; $i++) {
                $fileType = array_rand($this->sampleFiles);
                $mimeType = $this->sampleFiles[$fileType];
                $extension = pathinfo($fileType, PATHINFO_EXTENSION);
                
                // In a real seeder, you would copy actual files to storage
                // For demonstration, we'll just create database records
                $path = "posts/{$post->id}/" . Str::uuid() . '.' . $extension;
                
                PostAttachment::create([
                    'post_id' => $post->id,
                    'original_name' => $fileType,
                    'path' => $path,
                    'mime_type' => $mimeType,
                    'size' => rand(10000, 500000), // 10KB to 500KB
                    'extension' => $extension,
                ]);
            }
        }

        $this->command->info('Post attachments seeded successfully!');
    }
}