<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KielaController extends Controller
{
    public function __construct(){
        $this->middleware("auth");
    }

    /**
     * Simply display the view
     * All the content and the logic is made in the JS
     * todo maybe sort the schedule with the backend for speed optimisations & error prevention
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        return view("kiela.index");
    }
    public function create(){

    }
    public function store(Request $request){

    }
    public function show($id){

    }
    public function edit($id){

    }
    public function update(Request $request, $id){

    }
    public function destroy($id){

    }
}
