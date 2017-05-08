<?php

namespace Lib\Models;
use Illuminate\Database\Eloquent\Model;

abstract class Status extends Model
{
    public $timestamps = false;
    public $fillable = ["value","key","weight"];
    protected $type = "";
    public function getTypeAttribute()
    {
        return $this->type;
    }
}

class CarStatus extends Status
{
    protected $type = "Car";
}
class UserStatus extends Status
{
    protected $type = "User";
}
class RunStatus extends Status
{
    protected $type = "Run";
}
class RunSubscriptionStatus extends Status
{
    protected $type = "RunSubscription";
}