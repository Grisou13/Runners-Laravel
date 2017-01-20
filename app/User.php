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
        'name', 'email', 'password',"first_name","last_name","shortname","phone","sex","stat","qr_code"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function role()
    {
        return $this->hasOne(Role::class);
    }
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function runs()
    {
        return $this->hasMany(Run::class);
    }
}
