<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with(['user', 'career'])
            ->orderBy('enrollment_date', 'desc')
            ->paginate(10);

        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $careers = Career::all();
        return view('students.create', compact('careers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'career_id' => ['required', 'exists:careers,id'],
            'enrollment' => ['required', 'string', 'max:50', 'unique:students'],
            'date_of_birth' => ['required', 'date'],
            'address' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:20'],
            'emergency_contact' => ['required', 'string', 'max:255'],
            'enrollment_date' => ['required', 'date'],
        ]);

        // Create user first
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student',
        ]);

        // Create student record
        $student = Student::create([
            'user_id' => $user->id,
            'career_id' => $request->career_id,
            'enrollment' => $request->enrollment,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'emergency_contact' => $request->emergency_contact,
            'enrollment_date' => $request->enrollment_date,
        ]);

        return redirect()->route('students.show', $student)
            ->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {

        $student->load(['user', 'career']);
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {

        $careers = Career::all();
        return view('students.edit', compact('student', 'careers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$student->user_id],
            'career_id' => ['required', 'exists:careers,id'],
            'enrollment' => ['required', 'string', 'max:50', 'unique:students,enrollment,'.$student->id],
            'date_of_birth' => ['required', 'date'],
            'address' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:20'],
            'emergency_contact' => ['required', 'string', 'max:255'],
            'enrollment_date' => ['required', 'date'],
        ]);

        // Update user
        $student->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update student
        $student->update([
            'career_id' => $request->career_id,
            'enrollment' => $request->enrollment,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'emergency_contact' => $request->emergency_contact,
            'enrollment_date' => $request->enrollment_date,
        ]);

        return redirect()->route('students.show', $student)
            ->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {

        // This will also delete the associated user due to onDelete('cascade')
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }
}
