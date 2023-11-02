<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComicController extends Controller
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

        return to_route('admin.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comic $comic)
    {
        return view('admin.show_details', compact('comic'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comic $comic)
    {
        return view('admin.edit', compact('comic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comic $comic)
    {
        $data = $request->all();

        // SE SIA LA REQUEST CHE L'ENTITA' CHE STIAMO EDITANDO HANNO UN thumb (CHIAVE DELL'IMMAGINE)
        if ($request->has('thumb') && $comic->thumb) {

            // VUOL DIRE CHE NELLO STORAGE E' PRESENTE UN'IMMAGINA DA ELIMINARE
            Storage::delete($comic->thumb);

            // LA NUOVA IMMAGINE VIENE SALVATA E IL SUO PERCORSO ASSEGNATO A $data
            $newCover = $request->thumb;
            $path = Storage::put('comics_thumbs', $newCover);
            $data['thumb'] = $path;
        }

        // AGGIORNA L'ENTITA' CON I VALORI DI $data
        $comic->update($data);
        return to_route('comics.show', $comic); // new function to_route() laravel 9

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comic $somic)
    {
        //
    }
}
