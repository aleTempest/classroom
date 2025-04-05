<?php

namespace App\Livewire;

use Livewire\Component;

class TeacherPasswordToggle extends Component
{
    public $teacher;
    public $showPassword = false;
    public $maskedPassword = '••••••••';

    public function mount($teacher)
    {
        $this->teacher = $teacher;
    }

    public function togglePassword()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function render()
    {
        return view('livewire.teacher-password-toggle');
    }
}
