<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "activity_id",
    ];

    /**
     * Get the activity that owns the incident.
     */
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    /**
     * The users that belong to the incident.
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->with('permissions');
    }
}
