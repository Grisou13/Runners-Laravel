<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        "active"
    ];
    protected $casts = [
        "active"=>"boolean"
    ];
    public function users()
    {
        return $this->hasOne(User::class);
    }
}
