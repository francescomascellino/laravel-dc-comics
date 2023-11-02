<?php

namespace App\Http\Controllers\Guests;

use App\Models\Comic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{

    public function welcome()
    {
        $comics = Comic::all();
        // dd($comics);
        // RETURNS THE VIEW 'welcome' (welcome.blade.php)
        return view('welcome', compact('comics'));
    }


    public function comic_details(Comic $comic)
    {
        // dd($comic);
        return view('comic_details', compact('comic'));
    }

    public function characters()
    {
        return view('characters');
    }
}
