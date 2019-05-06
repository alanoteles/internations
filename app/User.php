<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'admin', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * Get the groups records associated with the user.
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }


    /**
     * Creates api_token
     */
    public function createToken(){

        $this->api_token = str_random(80);
        $this->save();

        return $this->api_token;
    }


}
