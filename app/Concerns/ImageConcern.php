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
  public function getBasePathForUpload($path = null){
    $p = 'images/profile';
    $p.=starts_with($path,"/") ? $path : (DIRECTORY_SEPARATOR . $path);
    return $p;
  }
  public function getStoredPath($path = null){
    return public_path($this->getBasePathForUpload($path) );
  }
  public function getUrlPath($path = null){
    return $this->getBasePathForUpload($path);

  }
  /**
   * Creates a new profile image for the user
   * @param File $file
   * @return bool
   * @internal param $filename
   */
  public function addProfileImage(File $file, $move = false)
  {
    $image = $this->addImage($file, $move);
    $image->type="profile";
    return $image->save();
  }
  protected function addImage(File $file, $move = false)
  {
    if($move) {
      $filename = $file->hashName();
      $file->move($this->getStoredPath(), $filename);
      $filepath = $this->getUrlPath($filename);

    }
    elseif(!str_contains($file->path(), $this->getBasePathForUpload())){
        $filepath = $this->getUrlPath($file->getFilename());
    }
    else{
      
      $filepath = $this->getUrlPath($file->getFilename());
    }
    $image = new Image;
    $image->fill(array('filename' => $filepath));
    $image->user()->associate($this->id);
    return $image;
  }

  /**
   * Creates a new profile image for the user
   * @param File $file
   * @return bool
   * @internal param $filename
   */
  public function addLicenseImage(File $file, $move = false)
  {
    $image = $this->addImage($file, $move);
    $image->type="license";
    return $image->save();
  }
}
