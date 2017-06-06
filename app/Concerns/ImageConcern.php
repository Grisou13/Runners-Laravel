<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 01.06.2017
 * Time: 21:19
 */

namespace App\Concerns;


use Illuminate\Http\File;
use Lib\Models\Image;

trait ImageConcern
{

  public function images()
  {
    return $this->hasMany(Image::class);
  }
  /**
   * @return Image
   */
  public function profileImage()
  {
    return ($this->images()->where("type","profile")->orderBy("created_at","desc")->first());
  }
  /**
   * @return Image
   */
  public function licenseImage()
  {
    return $this->images()->where("type","license")->orderBy("created_at","desc")->first();
  }

  /**
   * @return bool
   */
  public function removeProfileImage(){
    return $this->profileImage()->delete();
  }
  /**
   * @return bool
   */
  public function removeLicenseImage(){
    return $this->licenseImage()->delete();
  }
  
  /**
   * Creates a new profile image for the user
   * @param File $file
   * @return bool
   * @internal param $filename
   */
  public function addProfileImage(File $file, $move = false)
  {
    $destinationPath = 'images/profile'; // upload path
    
    if($move) {
      $filepath = $file->hashName($destinationPath);
      $file->move(public_path($destinationPath), $filepath);
    }
    else{
      $filepath = $destinationPath . DIRECTORY_SEPARATOR . $file->getFilename();
    }
    $image = new Image;
    $image->fill(array('filename' => $filepath));
    $image->type = "profile";
    $image->user()->associate($this->id);
    return $image->save();
  }
  
  /**
   * Creates a new profile image for the user
   * @param File $file
   * @return bool
   * @internal param $filename
   */
  public function addLicenseImage(File $file, $move = false)
  {
    $destinationPath = 'images/profile'; // upload path
    if($move) {
      $filepath = $file->hashName($destinationPath);
      $file->move(public_path($destinationPath), $filepath);
    }
    else{
      $filepath = $destinationPath . DIRECTORY_SEPARATOR . $file->getFilename();
    }
    
    $image = new Image;
    $image->fill(array('filename' => $filepath));
    $image->type = "license";
    $image->user()->associate($this->id);
    return $image->save();
  }
}