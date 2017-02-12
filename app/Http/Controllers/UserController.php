<?php
/**
* User: Joel.DE-SOUSA
*/
namespace App\Http\Controllers;

use App\Helpers\Status;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Session;
use App\User;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',["only"=>["destroy","update","create"]]);
    }
    public function create(){
      return view("user.create")->with("user",new User);
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
      return view("user.show",compact("user"));
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
    $input = $request->all();
    $user->update($input);
    return redirect('user');
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
    $user->delete();
    return redirect('user');
  }
  public function store(CreateUserRequest $request)
  {
      $user = new User;
      $user->fill($request->except("_token"));
      $user->save();
      return redirect()->route("users.show",$user);
  }

}
