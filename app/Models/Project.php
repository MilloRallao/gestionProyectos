<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
    ];

    /**
     * Get the activities for the project.
     */
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * The users that belong to the project.
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->with('permissions');
    }
}
