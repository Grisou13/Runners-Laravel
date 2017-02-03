<?php
/**
 * User: Eric.BOUSBAA
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        "active",
        "name"
    ];
    protected $casts = [
        "active"=>"boolean"
    ];
    public function users()
    {
        return $this->hasOne(User::class);
    }
}
