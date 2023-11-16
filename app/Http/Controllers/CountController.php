<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;

class CountController extends Controller
{
    public function countPlatform(){
        $facebook = Bookmark::where('platform', 'facebook')->count();
        $instagram = Bookmark::where('platform', 'instagram')->count();
        $twitter = Bookmark::where('platform', 'twitter')->count();
        $youtube = Bookmark::where('platform', 'youtube')->count();
        $tiktok = Bookmark::where('platform', 'tiktok')->count();
        $telegram = Bookmark::where('platform', 'Telegram')->count();
        $discord = Bookmark::where('platform', 'Discord')->count();
        $lainnya = Bookmark::where('platform', 'Lainnya')->count();

        return response()->json([
            'facebook' => $facebook,
            'instagram' => $instagram,
            'twitter' => $twitter,
            'youtube' => $youtube,
            'tiktok' => $tiktok,
            'telegram' => $telegram,
            'discord' => $discord,
            'lainnya' => $lainnya
        ]);
    }
}
