<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\Room;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $topTeachers = Teacher::withCount(['posts' => function($query) {
                $query->whereNotNull('published_at')
                      ->where('published_at', '<=', now());
            }])
                ->orderByDesc('posts_count')
                ->take(5)
                ->get();

            return view('admin-dashboard', [
                'careersCount' => Career::count(),
                'teachersCount' => Teacher::count(),
                'roomsCount' => Room::count(),
                'topTeachers' => $topTeachers
            ]);
        }

        if ($user->hasRole('teacher')) {
            $teacher = Teacher::with(['posts' => function($query) {
                $query->with(['room', 'attachments', 'students'])
                      ->latest();
            }])->findOrFail($user->teacher->id);

            $publishedCount = $teacher->getPublishedPostsCount();
            $draftCount = $teacher->getDraftPostsCount();

            $posts = $teacher->posts()
                             ->with(['room', 'attachments', 'students'])
                             ->latest()
                             ->paginate(10);

            return view('posts.teacher.index', compact(
                'teacher',
                'publishedCount',
                'draftCount',
                'posts'
            ));
        }

        return view('dashboard');
    }
}
