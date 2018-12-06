<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GetPicturesController extends Controller
{
    public function getDonationPicture() {

        $exists = Storage::disk('public')->exists('11.png');
        $contents = Storage::disk('public')->get('11.png');

        $path = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();

        $url_public = Storage::disk('public')->url('public_file.txt');
        $url_local = Storage::url('local_file.txt');

        $size_public = Storage::disk('public')->size('public_file.txt');
        $size_local= Storage::size('local_file.txt');

        //return response()->file($path . '11.png');

//        Storage::disk('public')->put('public_file.txt', 'Contents');
  //      Storage::disk('local')->put('public_file.txt', 'Contents');

        return [
            'url_public' => $url_public,
            'url_local' => $url_local,
            'size_public' => $size_public,
            'size_local' => $size_local,
        ];
    }
}
