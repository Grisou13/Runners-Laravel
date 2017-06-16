<?php
/**
*User: Joel.DE-SOUSA
*/
namespace App\Http\Controllers\Auth;

use Lib\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:255|unique:users',

            'password' => 'required|min:6|confirmed'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        dump($data);
        return User::create([
            'firstname' => array_key_exists("firstname",$data) ?$data['firstname'] : null,
            'lastname'  => array_key_exists("lastname",$data) ?$data['lastname'] : null,
            'name'  => array_key_exists("name",$data) ? $data['name'] : null,
            'email'      => $data['email'],
            'phone_number'      => "",
            'sex'        => array_key_exists("sex",$data) ?$data["sex"] :true,
            'accesstoken'    => "",
            'password' => bcrypt($data['password'])
        ]);
    }
}
