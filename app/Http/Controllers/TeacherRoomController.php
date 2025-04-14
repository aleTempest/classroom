<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;

class TeacherRoomController extends Controller
{
    public function index()
    {
        // Get the authenticated user's teacher record
        $teacher = Teacher::where('user_id', Auth::id())->first();
        
        if (!$teacher) {
            abort(403, 'You are not registered as a teacher');
        }

        // Get all rooms assigned to this teacher with related data
        $rooms = $teacher->rooms()
                    ->with(['career', 'enrollments.user'])
                    ->orderBy('name')
                    ->get();

        return view('teacher_room.index', [
            'teacher' => $teacher,
            'rooms' => $rooms
        ]);
    }
}