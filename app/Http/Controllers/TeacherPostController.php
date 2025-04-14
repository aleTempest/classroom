<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherPostController extends Controller
{
    public function index()
    {
        $teacher = auth()->user()->teacher;

        $posts = Post::with(['room', 'attachments', 'students'])
            ->where('teacher_id', $teacher->id)
            ->latest()
            ->paginate(15);
        $publishedCount = $teacher->publishedCount;
        $draftCount = $teacher->draftCount;
        return view('posts.teacher.index', compact(
            'teacher',
            'publishedCount',
            'draftCount',
            'posts'
        ));
    }
}
