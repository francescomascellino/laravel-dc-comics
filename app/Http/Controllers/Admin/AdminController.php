<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comics = Comic::all();
        return view('admin.index', compact('comics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();



        $newComic = new Comic();
        $newComic->title = $data['title'];
        $newComic->price = $data['price'];
        $newComic->series = $data['series'];

        if ($request->has('thumb')) {
            $file_path = Storage::put('comics_thumbs', $request->thumb);
            $newComic->thumb = $file_path;
        }

        $newComic->save();

        return view('admin.add');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comic $comic)
    {
        return view('comic_details', compact('comic'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
