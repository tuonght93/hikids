<?php namespace App\Libraries;

use File, Image, Input;

class ImageLib {

  public static function upload_image($file, $dirictory, $fileName, $resizes = array(), $crop = 0, $type='.png') {
    if (is_dir($dirictory) != true){
      $permission = intval('0777', 8);
      File::makeDirectory($dirictory, $permission, true);
    }
    $dirictory = $dirictory.'/';
    //$file->move($dirictory, $fileName.$type);
    $imgsource = Image::make($file);
    $imgsource->save($dirictory.$fileName.$type);
    if (!empty($resizes)) {
      foreach ($resizes as $resize) {
        $size = explode("x",$resize);
        $width = $size[0];
        $height = $size[1];
        if ($crop == 0) {
          $img = Image::make($dirictory.$fileName.$type);
          $img->resize($width, $height, function ($constraint) { 
            $constraint->aspectRatio();
          });
          $img->save($dirictory.$fileName.'_'.$resize.$type);
        } else {
          $img = Image::make($dirictory.$fileName.$type);
          $img->fit($width, $height);
          $img->save($dirictory.$fileName.'_'.$resize.$type);
        }
      }
    }
  }

  public static function ajax_upload_image($file, $dirictory, $fileName) {
    if (is_dir($dirictory) != true){
      $permission = intval('0777', 8);
      File::makeDirectory($dirictory, $permission, true);
    }
    $dirictory = $dirictory.'/';
    //$file->move($dirictory, $fileName.$type);
    $imgsource = Image::make($file);
    $imgsource->save($dirictory.$fileName);    
  }

  public static function delete_image($dirictory, $fileName, $resizes = array(), $type='.png') {
    // echo 'a';
    //echo $dirictory.'/'.$fileName.$type;die;
    File::delete($dirictory.'/'.$fileName.$type);
    if (!empty($resizes)) {
      foreach ($resizes as $resize) {
        $size = explode("x",$resize);
        $width = $size[0];
        $height = $size[1];
        File::delete($dirictory.'/'.$fileName.'_'.$resize.$type);
      }
    }
  }

  public static function delete_folder($directory) {
    File::deleteDirectory($directory);
  }

}
