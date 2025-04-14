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
            return view('admin-dashboard', [
                'careersCount' => Career::count(),
                'teachersCount' => Teacher::count(),
                'roomsCount' => Room::count(),
            ]);

        }

        if ($user->hasRole('teacher')) {
            return view('dashboard');
        }

        return view('dashboard');
    }
}
