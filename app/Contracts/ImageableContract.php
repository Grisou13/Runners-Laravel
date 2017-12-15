<?php

namespace App\Contracts;
use Illuminate\Http\File;
use Lib\Models\Image;

interface ImageableContract{
  /**
   * Retrieves all images belonging to the user
   * @return mixed
   */
  public function images();
  
  /**
   * Adds an image with a type of "profile"
   * If move is specified, the file will be moved to getStoredPath($file)
   * @param File $file
   * @param bool $move
   * @return Image
   */
  public function addProfileImage(File $file, $move = false);
  
  /**
   * Adds an image with a type of "license"
   * If move is specified, the file will be moved to getStoredPath($file)
   * @param File $file
   * @param bool $move
   * @return Image
   */
  public function addLicenseImage(File $file, $move = false);
  
  /**
   * Removes the profile image
   * @return void
   */
  public function removeProfileImage();
  
  /**
   * Removes the license image
   * @return void
   */
  public function removeLicenseImage();
  
  /**
   * Defines the base url for an image to be uploaded
   * ex: images/profile
   * @param string $extra
   * @return string
   */
  public function getBasePathForUpload($extra);
  
  /**
   * Realpath to the file on hard disk.
   * @param $extra
   * @return mixed
   */
  public function getStoredPath($extra);
  
  /**
   * Returns a url to the resource path.
   * The url is generated from getBasePathForUpload()
   * @param $extra
   * @return mixed
   */
  public function getUrlPath($extra);

}
