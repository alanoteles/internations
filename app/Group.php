<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name'
    ];


    /**
     * Get the users records associated with the group.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
