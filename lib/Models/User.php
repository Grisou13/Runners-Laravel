<?php
/**
*User: Joel.DE-SOUSA
*/
namespace Lib\Models;
use App\Events\UserCreatingEvent;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Helpers\Status;
use App\Concerns\StatusConcern;
use App\Contracts\StatusableContract;

use Watson\Validating\ValidatingTrait;

class User extends Authenticatable implements StatusableContract
{

    use Notifiable,ValidatingTrait, StatusConcern;
    protected $rules = [
        'email'   => 'required|unique:users,email',
        'name'    => 'required|min:1',
        "password"=> "required|min:6",
        "firstname"=>"sometimes|min:1",
        "lastname"=>"sometimes|min:1",
        "shortname"=>"sometimes|min:1",
        "sex"=>"sometimes",
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',"firstname","lastname","phone_number","sex","accesstoken","status"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', "accesstoken"
    ];


    protected $events = [
      "creating"=>UserCreatingEvent::class
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    public function runs()
    {
        return $this->hasManyThrough(Run::class,RunDriver::class);
    }
    public static function getAccessTokenKey()
    {
      return "accesstoken";
    }
    public function getAccessToken()
    {
      return $this->attributes[$this->getAccessTokenKey()];
    }
    public function setAccesstokenAttribute($value)
    {
        $this->attributes[$this->getAccessTokenKey()]= $value ? $value : $this->generateToken();
    }
    public function generateToken()
    {
        return bcrypt(Carbon::now()->toDateString() . $this->email . $this->name);
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
    public function setNameAttribute($value)
    {
        $this->attributes["name"] = $value ? $value : $this->attributes["firstname"]. " " .$this->attributes["lastname"];
    }
}
