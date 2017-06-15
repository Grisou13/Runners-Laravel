<?php

namespace App\Contracts;
use Illuminate\Http\File;

interface ImageableContract{
  public function images();
  public function addProfileImage(File $file, $move = false);
  public function addLicenseImage(File $file, $move = false);
  public function removeProfileImage();
  public function removeLicenseImage();
  public function getBasePathForUpload($extra);
  public function getStoredPath($extra);
  public function getUrlPath($extra);

}
