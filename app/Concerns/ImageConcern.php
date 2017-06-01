<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 01.06.2017
 * Time: 21:19
 */

namespace App\Concerns;


use Lib\Models\Image;

trait ImageConcern
{
  /**
   * @return Image
   */
  public function profileImage()
  {
    return $this->images()->ofType("profile");
  }
  /**
   * @return Image
   */
  public function licenseImage()
  {
    return $this->images()->ofType("license");
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
   * @param $filename
   */
  public function addProfileImage($filename)
  {
    $image = new Image;
    $image->fill(array('filename' => $filename));
    $image->save();
    $image->type = "profile";
    $image->user()->associate(auth()->id());
    $image->save();
  }
  /**
   * Creates a new profile image for the user
   * @param $filename
   */
  public function addLicenseImage($filename)
  {
    $image = new Image;
    $image->fill(array('filename' => $filename));
    $image->save();
    $image->type = "license";
    $image->user()->associate(auth()->id());
    $image->save();
  }
}