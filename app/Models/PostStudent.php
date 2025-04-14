<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PostStudent extends Pivot
{
    protected $table = 'post_student';

    protected $casts = [
        'read_at' => 'datetime',
    ];

    /**
     * Mark the post as read for the student
     */
    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }

    /**
     * Check if the post is read by the student
     */
    public function isRead(): bool
    {
        return !is_null($this->read_at);
    }

    /**
     * Scope for read posts
     */
    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    /**
     * Scope for unread posts
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }
}