<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KielaController extends Controller
{
    public function index(){
        // we get all the "kiélas" in JS
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
