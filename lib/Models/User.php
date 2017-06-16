<?php
/**
*User: Joel.DE-SOUSA
*/
namespace Lib\Models;
use App\Events\UserCreatedEvent;
use App\Events\UserCreatingEvent;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Concerns\StatusConcern;
use App\Contracts\StatusableContract;
use App\Contracts\ImageableContract;
use App\Contracts\ApiAuthenticableContract;

use App\Concerns\ImageConcern as HasImages;
use App\Concerns\ApiAuthenticableConcern as HasApiToken;
use Spatie\Permission\Traits\HasRoles;
use Watson\Validating\ValidatingTrait;

class User extends Authenticatable implements StatusableContract, ImageableContract, ApiAuthenticableContract
{

    use Notifiable,ValidatingTrait, StatusConcern, HasRoles, HasImages,HasApiToken;
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
        'name', 'email', 'password',"firstname","lastname","phone_number","sex","accesstoken","status", "role_id"
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
      "creating"=>UserCreatingEvent::class,
      "created"=>UserCreatedEvent::class
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
        $id = $this->id;
        return Run::whereHas("runners",function($query) use ($id){
          return $query->where("user_id",$id);
        })->get();
    }



    public function setNameAttribute($value)
    {
        $this->attributes["name"] = $value ? $value : $this->attributes["firstname"]. " " .$this->attributes["lastname"];
    }

}
