<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Run extends Model
{
    use SoftDeletes;
    protected $fillable = [
        "start_at","end_at","geo_from","geo_to","note", "nb_passenger", "artist"
    ];
    protected $dates = [
        "created_at",
        "updated_at",
        "start_at",
        "end_at"
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function car()
    {
        return $this->belongsTo(Car::class);
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
