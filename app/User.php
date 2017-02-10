<?php
/**
*User: Joel.DE-SOUSA
*/
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Helpers\Status;
use App\Concerns\StatusConcern;
use App\Contracts\StatusableContract;

class User extends Authenticatable implements StatusableContract
{
    use Notifiable, StatusConcern;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',"firstname","lastname","shortname","phone_number","sex","accesstoken","stat"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', "accesstoken"
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
    public static function getAccessTokenKey()
    {
      return "accesstoken";
    }
    public function images()
    {
      return $this->hasMany(Image::class);
    }
    public function profileImage()
    {
      return $this->images()->where("type","profile")->orderBy("created_at","desc")->first();
    }
    public function licenseImage()
    {
      return $this->images()->where("type","license")->orderBy("created_at","desc")->first();
    }
}
