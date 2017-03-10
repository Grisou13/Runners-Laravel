<?php
/**
 * User: Eric.BOUSBAA
 */
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Helpers\Helper;
use Lib\Models\Group;
use Lib\Models\User;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get the groups name (Group A, Group B, Group AA, etc...)
        // can generate up to 702 different groups name
        $alphabet = Helper::mkrange("A", "ZZ");

        // Get all the groups that have at least one active user
        $groups = Group::with("users")->actifUser()->get();
//        $groups = Group::with("users")->get();
        $i = 0;
        foreach($groups as $g){
            // add the label (groups name)
            $g->label = $alphabet[$i];
            $i ++;
        }

        // get the users wihout groups. Theses users are in the "no group" container
        $usersWithoutGroup = User::whereNull("group_id")->get();

        return view('group.index', ["groups" => $groups, "no_group" => $usersWithoutGroup]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
