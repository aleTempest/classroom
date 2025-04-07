<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Room;
use App\Models\Career;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::with('career')
            ->latest()
            ->paginate(10);

        return view('rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $careers = Career::all();
        return view('rooms.create', compact('careers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'career_id' => 'required|exists:careers,id',
            'code' => 'required|string|max:20|unique:rooms,code',
            'name' => 'required|string|max:100',
            'desc' => 'nullable|string|max:255',
        ]);

        Room::create($validated);

        return redirect()->route('rooms.index')
            ->with('success', 'Room created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        $room->load(['career', 'enrollments.user']);
        return view('rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     */

public function edit(Room $room)
{
    $careers = Career::all();
    $students = User::where('role', 'student')->get();
    $enrolledStudentIds = $room->enrollments->pluck('user_id')->toArray();

    return view('rooms.edit', compact('room', 'careers', 'students', 'enrolledStudentIds'));
}

public function update(Request $request, Room $room)
{
    // Validate room data
    $validated = $request->validate([
        'career_id' => 'required|exists:careers,id',
        'code' => [
            'required',
            'string',
            'max:20',
            Rule::unique('rooms')->ignore($room->id),
        ],
        'name' => 'required|string|max:100',
        'desc' => 'nullable|string|max:255',
        'students' => 'nullable|array',
        'students.*' => 'exists:users,id',
    ]);

    // Update room info
    $room->update($validated);

    // Sync enrollments
    if ($request->has('students')) {
        // Get current enrollments
        $currentEnrollments = $room->enrollments()->pluck('user_id')->toArray();

        // Students to add (new selections not in current enrollments)
        $studentsToAdd = array_diff($request->students, $currentEnrollments);

        // Students to remove (current enrollments not in new selections)
        $studentsToRemove = array_diff($currentEnrollments, $request->students);

        // Add new enrollments
        foreach ($studentsToAdd as $studentId) {
            Enrollment::create([
                'room_id' => $room->id,
                'user_id' => $studentId,
                'enrolled_at' => now(),
            ]);
        }

        // Remove unselected enrollments
        if (!empty($studentsToRemove)) {
            $room->enrollments()->whereIn('user_id', $studentsToRemove)->delete();
        }
    } else {
        // If no students selected, remove all enrollments
        $room->enrollments()->delete();
    }

    return redirect()->route('rooms.index')
        ->with('success', 'Room and enrollments updated successfully.');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('rooms.index')
            ->with('success', 'Room deleted successfully.');
    }

    /**
     * Search rooms by name or code
     */
    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        $rooms = Room::search($searchTerm)
            ->with('career')
            ->paginate(10);

        return view('rooms.index', compact('rooms'));
    }

    /**
     * Get rooms by career
     */
    public function byCareer(Career $career)
    {
        $rooms = Room::forCareer($career->id)
            ->with('career')
            ->paginate(10);

        return view('rooms.index', compact('rooms', 'career'));
    }
}
