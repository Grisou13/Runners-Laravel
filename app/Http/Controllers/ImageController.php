<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use Validator;
use Redirect;
use Session;
use Illuminate\Http\Request;
use App\Image;

class ImageController extends Controller
{
    public function upload(Request $request){

      //$file = array('image' => $request->file('image'));


      $rules = array('image' => 'required');

      $validator = Validator::make($request->all(), $rules);

      if($validator->fails()){
        return redirect()->back()->withInput()->withErrors($validator);
      }else{
        if($request->file('image')->isValid()){
          $type = $request->input('type');
          $user_id = $request->input('id');
          $file = $request->file("image");
          $destinationPath = 'images'; // upload path
          $extension = $file->getClientOriginalExtension();
          $filename = str_random(8). '.' . $extension;


          $image = new Image;
          $image->fill(array('filename' => $filename, 'original' => $file->getClientOriginalName(), "type"=>$type,"user_id"=>$user_id));
          $image->save();

          $file->move($destinationPath, $filename);

          Session::flash('success', 'Chargement réussi');
          return redirect()->back();
        }else{
          Session::flash('error', 'Image non valide !');
          return redirect()->back();
        }
      }
    }
}
