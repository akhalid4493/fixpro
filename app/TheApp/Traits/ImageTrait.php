<?php

namespace App\TheApp\Traits;

use Image;
use File;

trait ImageTrait
{

    static public function base64($imgUrl,$folder,$oldPath=null,$highet=null,$width=null)
    {

        $folder = self::createFolder('uploads/'.$folder);

        $path   = $imgUrl;
        $type   = '.jpg';
        $imgname = md5(rand() * time()) . '.' . $type;

        // Get new name of image Url & Path of folder to save in it
        $fname = $folder.'/'.$imgname;
        $img = Image::make($path);

        // Resize image 
        if ($highet && $width != null)
            $img->resize($highet,$width);

        // End of this proccess
        $img->save($fname);

        // Remove the old path in update method
        if ($path != null){
            if(file_exists($path))
                unlink($path);
        }

        
        return $fname;
    }

    
    static public function uploadImage($imgUrl,$folder,$oldPath=null,$highet=null,$width=null)
    {
        $path = self::createFolder('uploads/'.$folder);
        $fname = md5(rand() * time()) . '.' . $imgUrl->getClientOriginalExtension();

        $newPath = $path.'/'.$fname;

        $img = Image::make($imgUrl->getRealPath());

        // Resize image 
        if ($highet && $width != null)
            $img->resize($highet,$width);

        // End of this proccess
        $img->save($newPath);

        if(File::exists($oldPath))
            self::deleteImagePath($oldPath);

        return $newPath;
    }

    static public function mulitUploads($imgUrl , $highet=null , $width=null, $counter=null)
    {
        $file  = $imgUrl;
        $fname = 'uploads/'. md5(rand() * time()) .'.' . $file->getClientOriginalExtension();
        $img = Image::make($file->getRealPath());
        
        // Resize image 
        if ($highet && $width != null)
            $img->resize($highet,$width);

        // End of this proccess
        $img->save($fname);

        return $fname;
    }

    static public function createFolder($path)
    {
        if(File::exists($path)) {
            return $path;
        }else{
            $create = public_path().'/'.$path;
            File::makeDirectory($create, $mode = 0777, true, true);
            return $path;
        }
    }
    
    static public function copyImage($oldPath,$newPath,$imgName)
    {
        $old = 'uploads/'.$oldPath;
        $path = self::createFolder('uploads/'.$newPath);
        $new = $path.'/'.$imgName;

        $move = File::copy($old , $new);

        if ($move) {
            return $new;
        }
    }

    static public function deleteImagePath($path)
    {
        if(file_exists($path))
            unlink($path);
    }

    static public function deleteDirectory($path)
    {
        if(file_exists($path))
            File::deleteDirectory(public_path($path));
    }

    static public function uploadMob($imgUrl,$ext=null,$highet=null,$width=null,$path=null)
    {

        $path   = $imgUrl;
        $type   = $ext;

        // Get new name of image Url & Path of folder to save in it
        $fname = 'uploads/'. md5(rand() * time()) . $type;
        $img = Image::make($path);

        // Resize image 
        if ($highet && $width != null)
            $img->resize($highet,$width);

        // End of this proccess
        $img->save($fname);

        // Remove the old path in update method
        if ($path != null){
            if(file_exists($path))
                unlink($path);
        }

        
        return $fname;
    }
    
    static public function uploadApiFile($file)
    {
        $file_name = substr(md5(time()), 0, 15);

        if (is_string($file)) {
            $extension = "jpg";
            $fileName = $file_name . "." . $extension;
            $binary = base64_decode($file);
            header('Content-Type: bitmap; charset=utf-8');
            $file = fopen('uploads/'. $fileName, 'wb');
            fwrite($file, $binary);
            fclose($file);
        }

        return $fileName;
    }

}