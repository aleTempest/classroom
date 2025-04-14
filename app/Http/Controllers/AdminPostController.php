<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class AdminPostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['teacher', 'room', 'attachments', 'students'])
            ->latest()
            ->paginate(15);

        return view('posts.admin.index', compact('posts'));
    }
}