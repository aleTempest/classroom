<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherPostController extends Controller
{
    public function index()
    {
        $teacherId = Auth::id(); // Assuming teachers are authenticated users
        
        $posts = Post::with(['room', 'attachments', 'students'])
            ->where('teacher_id', $teacherId)
            ->latest()
            ->paginate(15);

        return view('posts.teacher.index', compact('posts'));
    }
}