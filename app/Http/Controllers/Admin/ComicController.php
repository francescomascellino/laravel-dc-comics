<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isNull;

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


        // VALIDATION

        $valData = $request->validate(
            [
                'title' => 'required|bail|min:3|max:100',
                'thumb' => 'nullable|image|max:150',
                'price' => 'required|min:3|max:7',
                'series' => 'nullable|min:3|max:100',
            ]
        );

        // NON USATO CON VALIDATION:
        // $data = $request->all();

        // SENZA MASS ASSIGNMENT
        /*      
        $newComic = new Comic();
        $newComic->title = $data['title'];
        $newComic->price = $data['price'];
        $newComic->series = $data['series']; 
        

        if ($request->has('thumb')) {
            $file_path = Storage::put('comics_thumbs', $request->thumb);
            $newComic->thumb = $file_path;
        }

        $newComic->save();
        */

        // CON MASS ASSIGNMENT

        // SENZA VALIDATION
        /* 
        if ($request->has('thumb')) {
            $file_path = Storage::put('comics_thumbs', $request->thumb);
            $data['thumb'] = $file_path;
        }

        
         */

        // CON VALIDATION
        if ($request->has('thumb')) {
            $file_path = Storage::put('comics_thumbs', $request->thumb);
            $valData['thumb'] = $file_path;
        }

        $newComic = Comic::create($valData);

        return to_route('comics.index')->with('message', 'Well Done, New Entry Added Succeffully');
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
        $valData = $request->validate(
            [
                'title' => 'required|bail|min:3|max:100',
                'thumb' => 'nullable|image|max:150',
                'price' => 'required|min:3|max:7',
                'series' => 'nullable|min:3|max:100',
            ]
        );

        // NON UTILIZZATO CON VALIDATION
        // $data = $request->all();

        /*
        // SE SIA LA REQUEST CHE L'ENTITA' CHE STIAMO EDITANDO HANNO UN thumb (CHIAVE DELL'IMMAGINE)
        if ($request->has('thumb') && $comic->thumb) {

            // VUOL DIRE CHE NELLO STORAGE E' PRESENTE UN'IMMAGINE DA ELIMINARE
            Storage::delete($comic->thumb);

            // LA NUOVA IMMAGINE VIENE SALVATA E IL SUO PERCORSO ASSEGNATO A $data
            $newCover = $request->thumb;
            $path = Storage::put('comics_thumbs', $newCover);
            $data['thumb'] = $path;
        } 
        */

        // SE LA REQUEST CONTIENE UN CAMPO IMMAGINE
        if ($request->has('thumb')) {

            // SALVA L'IMMAGINE NEL FILESYSTEM
            $newCover = $request->thumb;
            $path = Storage::put('comics_thumbs', $newCover);

            // SE IL FUMETTO HA GIA' UNA COVER NEL DB  NEL FILE SYSTEM, DEVE ESSERE ELIMINATA DATO CHE LA STIAMO SOSTITUENDO
            if (!isNull($comic->thumb) && Storage::fileExists($comic->thumb)) {
                // ELIMINA LA VECCHIA COVER
                Storage::delete($comic->thumb);
            }

            // ASSEGNA AL VALORE DI $valData IL PERCORSO DELL'IMMAGINE NELLO STORAGE
            $valData['thumb'] = $path;
        }

        // AGGIORNA L'ENTITA' CON I VALORI DI $data
        $comic->update($valData);
        return to_route('comics.show', $comic)->with('message', 'Well Done, Element Edited Succeffully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comic $comic)
    {
        // CONTROLLA SE L'ISTANZA HA UN FILE DI ANTEPRIMA. SE SI LO ELIMINA DAL filesystem
        if (!is_null($comic->thumb)) {
            Storage::delete($comic->thumb);
        }

        // ELIMINA IL RECORD DAL DATABASE
        $comic->delete();

        // RIDIRIGE AD UNA ROTTA DESIDERATA CON UN MESSAGGIO
        return to_route('comics.index')->with('message', 'Well Done, Element Deleted Succeffully');
    }
}
