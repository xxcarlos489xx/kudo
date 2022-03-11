<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Gumlet\ImageResize;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function processBase64One($source, $path, $name = 'image',$width = 0, $height = 0)
    {
        if($source !== null) {
            $data_pieces = explode(",", $source);
            $encoded_image = $data_pieces[1];
            $decoded_image = base64_decode($encoded_image);
            $file = strtoupper(md5($name)).'_'.time();
            file_put_contents($path.$file."_original.png", $decoded_image);
            if ($width > 0 && $height > 0) {
                $image = new ImageResize($path.$file."_original.png");
                $image->resize($width,$height);
                $image->save($path.$file."_resize.png");
                unlink($path.$file."_original.png");
            }
            return $file;
        }
        return null;
    }
}
