<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# CRUD

## CREARE UN NUOVO PROGETTO: 
https://github.com/francescomascellino/laravel-primi-passi#readme

## CREARE UNA MIGRATION E UN SEEDER PER POPOLARE IL DATABASE:
https://github.com/francescomascellino/laravel-migration-seeder#readme

MIGRATION: 

```php
public function up(): void
{
    Schema::create('comics', function (Blueprint $table) {
    $table->id();

    $table->string('title');
    $table->longText('description')->nullable();
        $table->longText('thumb')->nullable();
        $table->tinyText('price');
        $table->string('series')->nullable();
        $table->date('sale_date')->nullable();
        $table->string('type')->nullable();
        $table->text('artists')->nullable();
        $table->text('writers')->nullable();

        $table->timestamps();
    });
}
```

ComicTableSeeder:

```php
namespace Database\Seeders;

use App\Models\Comic; // AGGIUNGERE MODEL
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comics = [ASSOCIATIVE OBJECTS ARRAY];

        foreach ($comics as $comic) {
            $NewComic = new Comic();
            $NewComic->title = $comic['title'];
            $NewComic->description = $comic['description'];
            $NewComic->thumb = $comic['thumb'];
            $NewComic->price = $comic['price'];
            $NewComic->series = $comic['series'];
            $NewComic->sale_date = $comic['sale_date'];
            $NewComic->type = $comic['type'];
            $NewComic->artists = implode(', ', $comic['artists']);
            $NewComic->writers = implode(', ', $comic['writers']);

            //SAVE THE DATA
            $NewComic->save();
        }

    }
}
```

## ESEGUIRE LA MIGRAZIONE

```bash
php artisan migrate
```

## ESEGUIRE IL SEEDING

```bash
php artisan db:seed --class=ComicTableSeder
```
OPPURE PER DROPPARE E RIPOPOLARE IL DATABASE ALLO STESSO MOMENTO:

AGGIUNGERE IN seeders/DatabaseSeeder run METHOD:

```php
public function run(): void
{
    $this->call([
        ComicsTableSeeder::class,
    ]);
    // \App\Models\User::factory(10)->create();

    // \App\Models\User::factory()->create([
    //   
    //     'email' => 'test@example.com',
    // ]);
}
```

ESEGUIRE:

```bash
php artisan migrate:fresh --seed
```

## CREARE UN RESOURCE CONTROLLER

```bash
php artisan make:controller --resource User\PageController
```

## CONTROLLARE LA LISTA DELLE ROUTES

```bash
php artisan route:list
```
OTTIMIZZARE PER AGGIORNARE LE ROUTES IN CASO DI PROBLEMA:

```bash
php artisan optimize
```
AGGIUNGERE I RESOURCE CONTROLLERS NECESSARI A routes\web.php

```php
use App\Http\Controllers\Admin\ComicController;
use App\Http\Controllers\Guests\PageController;
```

DA L'URi admin/comics ALLE ROUTES DEFINITE TRAMITE Admin\ComicController

```php
Route::resource('admin/comics', ComicController::class);
```

QUESTO CI PERMETTE DI RIDIRIGERE I LINK ALLE VIEWS USANDO AD ESEMPIO:

```php
href="{{ route('comics.create') }}" 
```

DEFINITA IN App\Http\Controllers\Admin\AdminController COME:
```php
public function create()
{
    return view('comics.add'); // views/admin/add.blade.php
}
```

OPPURE:

```php
href="{{ route('comics.index') }}" 
```

DEFINITA IN App\Http\Controllers\Admin\AdminController COME:
```php
public function index()
{
    $comics = Comic::all();
    return view('admin.index', compact('comics')); // views/admin/index.blade.php
}
```

OPPURE:

```php
href="{{ route('comics.show', $comic->id) }}"
```

DEFINITA IN App\Http\Controllers\User\PageController COME:

```php
public function show(Comic $comic)
{
    return view('admin.show_details', compact('comic')); // views/admin/admin.show_details.blade.php
}
```

INDICA CHE LA ROUTE '/' CORRISPONDE AL METODO 'welcome' DI Guests\PageController

```php
Route::get('/', [PageController::class, 'welcome'])->name('comics');
```

## RESTFUL CRUD - INDEX. LEGGERE I details

AGGIUNGERE IL MODEL NEL CONTROLLER INTERESSATO

```php
use App\Models\Comic;
```

DEFINIRE NEL CONTROLLER INTERESSATO IL METODO index():

```php
public function index()
{
    $comics = Comic::all();
    return view('welcome', compact('comics')); // welcome.blade.php
}
```

ORA E' POSSIBILE CICLARE $comics NELLA VISTA COLLEGATA ALLA ROUTE:

```php
@foreach ($comics as $id => $comic)
//CODICE
@endforeach
```

## SHOW CONTROLLER - LEGGERE UN'ENTITA' NEL DETTAGLIO

DEFINIRE NEL CONTROLLER INTERESSATO IL METODO show():

```php
// $comic E' UNA ISTANZA DEL MODELLO Comic
public function show(Comic $comic)
{
    return view('admin.show_details', compact('comic')); // views/admin/admin.show_details.blade.php
}
```

USARE UNA ROUTE PER COLLEGARE LA VISTA SHOW PASSANDO UN ARGOMENTO CHE CI SERVIRA' A VISUALIZZARE NEL DETTAGLIO L'ENTITA' DESIDERATA (L'id)

```php
href="{{ route('comics.show', $comic) }}"
```

VISUALIZZARE NELLA PAGINA DELLA VISTA COLLEGATA ALLA ROUTE I DETTAGLI DESIDERATI:

```php
<div>
    <img src="{{ $comic->thumb }}" alt="{{ $comic->title }}">
</div>
```

## RESTful CRUD - CREATE, CREARE UNA NUOVA VOCE NEL DATABASE

COLLEGARE LA VISTA AL METODO CREATE:

```php
public function create()
{
    return view('admin.add'); // admin/add.blade.php
}
```

RICHIAMARE LA VISTA CONTENENTE IL FORM:

```php
<a class="btn btn-primary" href="{{ route('comics.create') }}">ADD ENTRY</a>
```

NELLA VISTA 'admin.create' CREARE IL FORM USANDO COME METODO LA ROUTE .store() CHE AVRA' IL COMPITO DI GESTIRE I DATI DEL FORM.

IL METODO DEVE ESSERE 'POST'.

GLI ATTRIBUTI 'name' DEVONO COMBACIARE CON I NOMI DELLE COLONNE DEL DATABASE.

@csrf E' UN TOKEN CHE GENERA LARAVEL PER ASSICURARSI CHE LA CHIAMATA POST AVVENDA TRAMITE UN FORM DEL SITO PER EVITARE INTRUSIONI DA PARTE DI TERZI


```php
<form action="{{ route('comics.store') }}" method="POST" enctype="multipart/form-data">

@csrf // IMPORTANTE

    <div class="mb-3">

        <label for="title" class="form-label"><strong>Titolo</strong></label>

        <input type="text" class="form-control" name="title" id="title" aria-describedby="helpTitle" placeholder="Inserisci il titolo del prodotto">
    </div>

    <button type="submit" class="btn btn-success my-3">SAVE</button>

</form>
```

IMPOSTARE IL METODO store() NEL CONTROLLER PER GESTIRE I DATI INVIATI AL SUBMIT

```php
public function store(Request $request)
    {
    $data = $request->all();

    $newComic = new Comic();

    $newComic->save(); // SALVA IL NUOVO OGGETTO NEL DATABASE

    return to_route('admin.index'); // RIDIRIGE ALLA VISTA ORIGINALE (ALTRIMENTI SI RESTERA' FERMI SU UNA PAGINA VUOTA E AGGIORNANO VERRA' NUOVAMENTE INVIATOIL MODULO)
}
```

## FILE STORAGE - UPLOAD AN IMAGE

MODIFICARE config/filestystems.php IN DA local in public.

LA FUNZIONE env() VERIFICA SE NEL FILE .env E' PRESENTE UNA CHIAVE CON IL VALORE INDICATO NEL PRIMO PARAMETRO (FILESYSTEM_DISK). SE PRESENE UTILIZZA QUEL VALORE, ALTRIMENTI UTILIZZA IL VALORE PASSATO COME SECONDO PARAMETRO (public).

```php
'default' => env('FILESYSTEM_DISK', 'public'),
```

MODIFICARE LA STRINGA FILESYSTEM_DISK= DEL FILE .ev in public IN QUESTO MODO LARRAVEL DIRIGERA' AUTOMATICAMENTE I NOSTRI FILE CARICATI NELLA CARTELLA storage/app/public

```php
FILESYSTEM_DISK=public
```
COLLEGHIAMO LO STORAGE CHE COLLEGA ALLA CARTELLA storage/app/public DA TERMINALE

```bash
php artisan storage:link
```

CREIAMO IL FORM INDICANDO L'ATTRIBUTO enctype="multipart/form-data" IN MODO DA POTER INDICARE AL FORM LA PRESENZA DI FILES DI VCARIO FORMATO

```php
<form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
```

NEL METODO store() DEL CONTROLLER INTERESSATO INVOCHIAMO IL METODO put() INDICANDO LA SOTTOCARTELLA DI DESTINAZIONE (comics_thumb IN QUESTO CASO) E ILç VALORE DA SALVARE ($request->thumb IN QUESTO CASO)

```php
public function store(Request $request)
{
    $data = $request->all();

    $newComic = new Comic();

    // CODICE

    // SE $request HA UNA CHIAVE 'thumb', ALLORA:
    if ($request->has('thumb')) {
        // SALVA IL FILE NELLA CARTELLA storage/app/public/comics_thumbs
        $file_path = Storage::put('comics_thumbs', $request->thumb);

        // ASSEGNA IL FILE APPENA SALVATO AL VALORE DELLA CHIAVE thumb DEL NUOVO OGGETTO CHE STIAMO CREANDO
        $newComic->thumb = $file_path;
    }

    $newComic->save(); // SALVA LA NUOVA ISTANZA NEL DATABASE

    return to_route('admin.index'); // REINDERIZZA A UNA VIEW DESIDERATA
    }
```

USIAMO LA FUNZIONE ASSET PER VISUALIZZARE IN UNA VIEW IL FILE CARICATO

```php
<img src="{{ asset('storage/' . $comic->thumb) }}">
```

SE IL DATABASE CONTIENE SIA FILES CARICATI CHE LINK E' NECESSARIO INSERIRE DELLE CONDIZIONI:

```php
@if (str_contains($comic->thumb, 'http'))

    <td><img class=" img-fluid" style="height: 100px" src="{{ $comic->thumb }}" alt="{{ $comic->title }}"></td>

@else

    <td><img class=" img-fluid" style="height: 100px" src="{{ asset('storage/' . $comic->thumb) }}"></td>

@endif
```