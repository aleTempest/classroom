<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'phone_number',
        'user_id'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'salary' => 'decimal:2'
    ];

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rooms(): BelongsToMany
    {
        return $this->belongsToMany(Room::class, 'teacher_room')
                    ->withTimestamps();
    }

    /**
     * Get all posts created by this teacher
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get posts with optional filters
     *
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPosts(array $filters = []): \Illuminate\Database\Eloquent\Collection
    {
        $query = $this->posts()->with(['room', 'attachments', 'students']);

        // Apply filters if provided
        if (!empty($filters)) {
            if (isset($filters['published'])) {
                $query->when($filters['published'] === 'true', function($q) {
                    $q->published();
                }, function($q) {
                    $q->whereNull('published_at');
                });
            }

            if (isset($filters['room_id'])) {
                $query->where('room_id', $filters['room_id']);
            }

            if (isset($filters['search'])) {
                $query->where(function($q) use ($filters) {
                    $q->where('title', 'like', '%'.$filters['search'].'%')
                      ->orWhere('content', 'like', '%'.$filters['search'].'%')
                      ->orWhere('topic', 'like', '%'.$filters['search'].'%');
                });
            }
        }

        return $query->latest()->get();
    }

    /**
     * Get published posts count
     */
    public function getPublishedPostsCount(): int
    {
        return $this->posts()->published()->count();
    }

    /**
     * Get draft posts count
     */
    public function getDraftPostsCount(): int
    {
        return $this->posts()->whereNull('published_at')->count();
    }
}
