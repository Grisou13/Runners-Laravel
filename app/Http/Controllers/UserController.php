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
use Illuminate\Http\File;


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
    return redirect()->route("users.index")->with("message","Utilisateur mis à jour");
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
    return redirect()->route("users.index")->with("message","Utilisateur supprimé!");
  }
  public function resetPassword(ResetPasswordRequest $request, User $user){
    $res = Password::sendResetLink(['email' => $user->email]);
    $user->generatetoken();//regenerate api token
    return redirect()->back()->with("message","Un email a été envoyé à {$user->email}, pour remplacer son mot de passe");
  }
  public function store(CreateUserRequest $request)
  {
      $user = new User;
      $user->fill($request->except("_token"));
      if(!$request->has("password"))
        $user->password = str_random(52); // maybe the user is a driver (no password inserted)
      $user->save();
      return redirect()->route("users.show",$user)->with("message","Utilisateur crée !");
  }

  public function storeLicenseImage(Request $request, User $user)
  {
    $file = $request->file("image");
    $currentUser = $request->user();
    if($currentUser->id !== $user->id && !$currentUser->hasPermissionTo("edit all profile images")){
      return abort(401, "You cannot edit another's users profile image without being them");//
    }
    if($user->licenseImage() != null)
      $user->removeLicenseImage();

    //notify the user that we need to move the file
    $user->addLicenseImage(new File($file),true);
    Session::flash('success', 'Chargement réussi');
    return redirect()->back();
  }
  public function storeProfileImage(Request $request, User $user)
  {
      $file = $request->file("image");
      $currentUser = $request->user();
      if($currentUser->id !== $user->id && !$currentUser->hasPermissionTo("edit all profile images")){
        return abort(401, "You cannot edit another's users profile image without being them");//
      }
      if($user->profileImage() != null)
        $user->removeProfileImage();

      //notify the user that we need to move the file
      $user->addProfileImage(new File($file),true);
      Session::flash('success', 'Chargement réussi');
      return redirect()->back();
  }

}
