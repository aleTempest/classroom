<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Room;
use App\Models\User;
use App\Models\Enrollment;

class RoomStudentEnrollment extends Component
{
    public Room $room;
    public $search = '';
    public $selectedStudents = [];
    public $enrolledStudents = [];
    public $searchResults = [];

    protected $listeners = ['refreshEnrollments' => 'loadEnrolledStudents'];

    public function mount(Room $room)
    {
        $this->room = $room;
        $this->loadEnrolledStudents();
    }

    public function loadEnrolledStudents()
    {
        $this->enrolledStudents = $this->room->enrollments()
            ->with('user')
            ->get()
            ->map(function ($enrollment) {
                return $enrollment->user;
            })
            ->toArray();

        $this->selectedStudents = collect($this->enrolledStudents)
            ->pluck('id')
            ->toArray();
    }

    public function updatedSearch($value)
    {
        $this->searchStudents();
    }

    public function searchStudents()
    {
        if (strlen($this->search) >= 2) {
            $this->searchResults = User::where('role', 'student')
                ->where(function($query) {
                    $query->where('name', 'like', '%'.$this->search.'%')
                          ->orWhere('email', 'like', '%'.$this->search.'%');
                })
                ->whereNotIn('id', $this->selectedStudents)
                ->take(5)
                ->get();
        } else {
            $this->searchResults = [];
        }
    }

    public function toggleStudent($studentId)
    {
        if (($key = array_search($studentId, $this->selectedStudents)) !== false) {
            unset($this->selectedStudents[$key]);
        } else {
            $this->selectedStudents[] = $studentId;

            if (!collect($this->enrolledStudents)->pluck('id')->contains($studentId)) {
                $user = User::find($studentId);
                if ($user) {
                    $this->enrolledStudents[] = $user->toArray();
                }
            }
        }

        $this->searchStudents();
    }

    public function saveEnrollments()
    {
        dd('saving');
        // Get current enrollments
        $currentEnrollments = $this->room->enrollments()->pluck('user_id')->toArray();

        // Students to add
        $studentsToAdd = array_diff($this->selectedStudents, $currentEnrollments);

        // Students to remove
        $studentsToRemove = array_diff($currentEnrollments, $this->selectedStudents);

        // Add new enrollments
        foreach ($studentsToAdd as $studentId) {
            Enrollment::create([
                'room_id' => $this->room->id,
                'user_id' => $studentId,
                'enrolled_at' => now(),
            ]);
        }

        // Remove unselected enrollments
        if (!empty($studentsToRemove)) {
            $this->room->enrollments()->whereIn('user_id', $studentsToRemove)->delete();
        }

        $this->loadEnrolledStudents();
        $this->search = '';
        $this->searchResults = [];
        $this->emit('enrollmentsUpdated');

        session()->flash('message', 'Enrollments updated successfully');
    }

    public function removeStudent($studentId)
    {
        if (($key = array_search($studentId, $this->selectedStudents)) !== false) {
            unset($this->selectedStudents[$key]);
        }
        $this->saveEnrollments();
    }

    public function render()
    {
        return view('livewire.room-student-enrollment');
    }
}
