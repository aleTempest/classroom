<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $table = 'careers';

    protected $fillable = [
        'name',
    ];

    public function student()
    {
        return $this->hasOne(Student::class);
    }
}
