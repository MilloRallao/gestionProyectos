<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "project_id",
    ];

    /**
     * Get the project that owns the activity.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the incidents for the activity.
     */
    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }

    /**
     * The users that belong to the activity.
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->with('permissions');
    }
}
