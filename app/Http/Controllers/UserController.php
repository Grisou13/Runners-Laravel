<?php
/**
* User: Joel.DE-SOUSA
*/
namespace App\Http\Controllers;

use App\Helpers\Status;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\UploadedFile;
use Route;
use Session;
use Lib\Models\User;
use Lib\Models\Image;
use Lib\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Auth;
use Password;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',["only"=>["destroy","update","create","storeLicenseImage","storeProfileImage"]]);
    }
    public function create(){
      return view("user.create")->with("user",new User);
    }
    public function redirectToUser()
    {
      return redirect()->route("users.show",["user"=>auth()->user()]);
    }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\View\View
   */
  public function index(Request $request)
  {
    if($request->has("status"))
      $users = User::ofStatus($request->get("status"))->get();
    else
      $users = User::all();
    // load the view and pass the user list
    //
//    $status = \DB::table('users')->distinct('stat')->select('stat')->get()->map(function ($stat) {
//      return $stat->stat;
//    });
    //dd($users);
    return view('user.index')->with('users', $users)->with("status",Status::getUserStatus()); //TODO: récuprer tout les statut depuis la table user
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show(User $user)
  {
      return view("user.edit",compact("user"));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit(User $user)
  {
    return view("user.edit")->with('user', $user);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(UpdateUserRequest $request, User $user)
  {
    /*//TODO : Validation
    $this->validate($request, [
      'license_plates'   => 'required',
      'brand'            => 'required',
      'model'            => 'required'
    ]);*/
    $input = $request->except(["_token"]);
    $user->update($input);
    return redirect()->route("users.index");
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy(User $user)
  {
    // delete
    try{
      $user->delete();
    }catch(\Exception $e){
      return redirect()->back()->with("error_message","L'utilisateur n'as pas pu être supprimé. Est-ce qu'il serait dans des runs?");
    }
    return redirect()->route("users.index");
  }
  public function resetPassword(ResetPasswordRequest $request, User $user){
    $res = Password::sendResetLink(['email' => $user->email]);
    return redirect()->back()->with("message","Un email a été envoyé à {$user->email}, pour remplacer son mot de passe");
  }
  public function store(CreateUserRequest $request)
  {
      $user = new User;
      $user->fill($request->except("_token"));
      if(!$request->has("password"))
        $user->password = str_random(52);
      //$user->role()->associate(Role::where("role","runner")->first());
      $user->save();
      return redirect()->route("users.show",$user);
  }

  public function storeLicenseImage(Request $request)
  {
    $file = $request->file("image");
    $user = $request->user();
    //notify the method that we need to move the file
    $user->addLicenseImage($file,true);

    Session::flash('success', 'Chargement réussi');
    return redirect()->back();
  }
  public function storeProfileImage(Request $request)
  {
      $file = $request->file("image");
      $user = $request->user();
      if($user->profileImage() != null)
        $user->removeProfileImage();
      //notify the method that we need to move the file
      $user->addProfileImage($file,true);

      Session::flash('success', 'Chargement réussi');
      return redirect()->back();
  }

}
