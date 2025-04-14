<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherRoom extends Model
{
    protected $table = 'teacher_room';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'teacher_id',
        'room_id',
    ];

    /**
     * Get the teacher associated with this relationship.
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get the room associated with this relationship.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
