<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'salary',
        'gender',
        'email',
        'phone_number'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'salary' => 'decimal:2'
    ];

    public function getFullNameAttribute() : string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
