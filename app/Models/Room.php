<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'career_id',
        'code',
        'name',
        'desc'
    ];

    /**
     * Get the career that this room belongs to.
     */
    public function career()
    {
        return $this->belongsTo(Career::class);
    }

    /**
     * Get the enrollments for this room.
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get the students enrolled in this room.
     */
    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'room_id', 'user_id')
                   ->withTimestamps();
    }

    /**
     * Scope a query to filter rooms by career.
     */
    public function scopeForCareer($query, $careerId)
    {
        return $query->where('career_id', $careerId);
    }

    /**
     * Scope a query to search rooms by name or code.
     */
    public function scopeSearch($query, $searchTerm)
    {
        return $query->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('code', 'like', "%{$searchTerm}%");
    }
}
