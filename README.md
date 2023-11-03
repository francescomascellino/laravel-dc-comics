<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# CRUD

## INDICE

- <a href="#creare-un-nuovo-progetto" target="_blank">CREARE UN NUOVO PROGETTO</a>
- <a href="#create-app-layouts" target="_blank">CREARE LAOUT DELL'APP</a>
- <a href="#creare-una-migration-e-un-seeder-per-popolare-il-data" target="_blank">CREARE UNA MIGRATION E UN SEEDER PER POPOLARE IL DATABASE</a>
- <a href="#eseguire-la-migrazione" target="_blank">ESEGUIRE MIGRATION E SEEDING</a>
- <a href="#creare-un-resource-controller" target="_blank">CREARE UN RESOURCE CONTROLLER</a>
- <a href="#restful-crud---index-leggere-i-details" target="_blank">CRUD - INDEX</a>
- <a href="#show-controller---leggere-unentita-nel-dettaglio" target="_blank">CRUD - SHOW</a>
- <a href="#restful-crud---create-creare-una-nuova-voce-nel-database" target="_blank">CRUD - CREATE</a>
- <a href="#file-storage---upload-an-image" target="_blank">CARICARE UN'IMMAGINE/SYSTEM STORAGE</a>
- <a href="#mass-assignmente" target="_blank">MASS ASSIGNMENT</a>
- <a href="#visualizzare-le-immagini-caricate" target="_blank">VISUALIZZARE LE IMMAGINI CARICATE</a>
- <a href="#crud---edit" target="_blank">CRUD - EDIT</a>
- <a href="#crud---destroy" target="_blank">CRUD - DESTROY</a>

- <a href="https://github.com/fabiopacifici/104_laravel_lightsabers/blob/444355619943da593f9d68027d232c7e70afb32e/README.md" target="_blank">Step by Step Guide by fabiopacifici</a>



## CREARE UN NUOVO PROGETTO: 
https://github.com/francescomascellino/laravel-primi-passi#readme

```bash
laravel new [FOLDER NAME] --git
```

INSTALLARE IL PRESET DI LARAVEL

```bash
composer require pacificdev/laravel_9_preset
```

```bash
php artisan preset:ui bootstrap
```

RIMUOVERE LA RIGA `type": "module` DAL FILE ***package.json*** OPPURE RINOMINARE IL FILE `vite.config.js` file IN `vite.config.cjs`

INSTALLARE I PACCHETTI:

```bash
npm i
```

AVVIARE I SERVER SU DUE TERMINALI DIVERSI

```bash
npm run dev
```

```bash
php artisan serve
```

## Create App Layouts

- add an app.blade.php layout file for guests
- add an admin.blade.php layout file for admin users

Copy the welcome.blade.php file and place inside a folder called /layouts

```text

/layouts
 - app.blade.php
 - admin.blade.php

```

Remember to user the blade `@yield('content')` directive to add the placeholders for your pages contents.
And add also a yield for the page title `@yield('page-title', 'can accept a default value')`.

## CREARE UNA MIGRATION E UN SEEDER PER POPOLARE IL DATABASE:
https://github.com/francescomascellino/laravel-migration-seeder#readme

EDITARE IL FLE .env

```php
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=[MAMP SQL PORT] <---
DB_DATABASE=[DATABASE NAME] <---
DB_USERNAME=root
DB_PASSWORD=[PASSWORD] <---
```

CREARE UN MODEL/MIGRATION/SEEDER CON UN UNICO COMANDO (ms = mIGRATIONsEEDER)

```bash
php artisan make:model Comic -ms
```

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
php artisan make:controller --resource Admin\ComicController
```

CHE CREERA' UN RESOURCE CONTROLLER CON I METODI CRUD INTEGRATI (MA MANCANTI DI LOGICA) IN App\Http\Controllers\Admin\ComicController

OPPURE PER CREARE UN RESOURCE CONTROLLER GIA' ASSOCIATO A UN MODELLO:

```bash
php artisan make:controller Admin/ComicsController --resource --model=Comic
```

## CONTROLLARE LA LISTA DELLE ROUTES

```bash
php artisan route:list
```
OTTIMIZZARE PER AGGIORNARE LE ROUTES IN CASO DI PROBLEMA:

```bash
php artisan optimize
```
O PULIRE LA CACHE DELLE ROUTES:

```bash
php artisan route:clear
```

AGGIUNGERE I RESOURCE CONTROLLERS NECESSARI A routes\web.php

```php
use App\Http\Controllers\Admin\ComicController; //RESOURCE CONTROLLER
use App\Http\Controllers\Guests\PageController; // CONTROLLER NORMALE
```

DA L'URi admin/comics ALLE ROUTES DEFINITE TRAMITE Admin\ComicController

```php
Route::resource('admin/comics', ComicController::class);
```

USIAMO LA URi admin/comics PERCHE' IN admin SICURAMENTE DOVREMO GESTIRE ALTRE VIEWS MENTRE IN admin/comics GESTIREMO IL DATABASE COMICS. ADMIN POTREBBE AVERE NUMEROSE VIEWS; COME AD ESEMPIO UNA IPOTETICA admin/users PER GESTIRE GLI UTENTI (CHE NECESSITERA' DI UN CONTROLLER DEDICATO)

QUESTO CI PERMETTE DI RIDIRIGERE I LINK ALLE VIEWS USANDO AD ESEMPIO:

```php
href="{{ route('comics.create') }}"  // URI http://[IP]:[PORTA]/admin/comics/create
```

DEFINITA IN App\Http\Controllers\Admin\ComicController COME:

```php
public function create()
{
    return view('admin.add'); // views/admin/add.blade.php
}
```

OPPURE:

```php
<a href="{{ route('comics.index') }}">Dashboard</a>
```

DEFINITA IN App\Http\Controllers\Admin\ComicController COME:

```php
public function index()
{
    $comics = Comic::all();
    return view('admin.index', compact('comics')); // views/admin/index.blade.php
}
```

OPPURE:

```php
<a href="{{ route('comics.show', $comic) }}">Details</a>
```

DEFINITA IN App\Http\Controllers\Admin\ComicController COME:

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

PER VISUALIZZARE DALL CONTROLLER PER I GUESTS I DETTAGLI DI UNA SINGOLA ENTITA':

DEFINIRE IL METODO IN IN App\Http\Controllers\Guests\PageController

```php
public function comic_details(Comic $comic)
{
    return view('comic_details', compact('comic'));
}
```
DEFINIAMO LA ROUTE IN web.php

```php
Route::get('comic_details/{comic}', [PageController::class, 'comic_details'])->name('details');
```

CICLIAMO L'ARRAY PER STAMPARE IN PAGINA GLI ELEMENTI DESIDERATI E LINKIAMO LA ROUTE

```php
@foreach ($comics as $comic)
<!-- CODICE -->
    <a href="{{ route('details', $comic) }}">
<!-- CODICE -->
@endforeach
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
    return view('admin.index', compact('comics'));
}
```

ORA E' POSSIBILE CICLARE $comics NELLA VISTA COLLEGATA ALLA ROUTE:

```php
@forelse ($comics as $comic)
    // CODICE
    <p>{{ $comic->title }}</p>
    // CODICE
@empty
    <h1>Database is empty</h1>
@endforelse
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

USARE UNA ROUTE PER COLLEGARE LA VISTA SHOW PASSANDO UN ARGOMENTO CHE CI SERVIRA' A VISUALIZZARE NEL DETTAGLIO L'ENTITA' DESIDERATA

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

NELLA VISTA 'comics.create' CREARE IL FORM USANDO COME METODO LA ROUTE .store() CHE AVRA' IL COMPITO DI GESTIRE I DATI DEL FORM.

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

    $newComic->title = $data['title'];

    // CODICE

    $newComic->save(); // SALVA IL NUOVO OGGETTO NEL DATABASE

    return to_route('admin.index'); // RIDIRIGE ALLA VISTA ORIGINALE (ALTRIMENTI SI RESTERA' FERMI SU UNA PAGINA VUOTA E AGGIORNANO VERRA' NUOVAMENTE INVIATOIL MODULO)
}
```

## FILE STORAGE - UPLOAD AN IMAGE

MODIFICARE ***config/filestystems.php*** IN DA local in public.

LA FUNZIONE env() VERIFICA SE NEL FILE .env E' PRESENTE UNA CHIAVE CON IL VALORE INDICATO NEL PRIMO PARAMETRO (FILESYSTEM_DISK). SE PRESENE UTILIZZA QUEL VALORE, ALTRIMENTI UTILIZZA IL VALORE PASSATO COME SECONDO PARAMETRO (public).

```php
'default' => env('FILESYSTEM_DISK', 'public'),
```

MODIFICARE LA STRINGA ***FILESYSTEM_DISK=*** DEL FILE ***.env*** in public IN QUESTO MODO LARRAVEL DIRIGERA' AUTOMATICAMENTE I NOSTRI FILE CARICATI NELLA CARTELLA ***storage/app/public***

```php
FILESYSTEM_DISK=public
```

COLLEGHIAMO LO STORAGE CHE COLLEGA ALLA CARTELLA storage/app/public DA TERMINALE

```bash
php artisan storage:link
```

CREIAMO IL FORM INDICANDO L'ATTRIBUTO ***enctype="multipart/form-data"*** IN MODO DA POTER INDICARE AL FORM LA PRESENZA DI FILES DI VARIO FORMATO

```php
<form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
```

NEL METODO store() DEL CONTROLLER INTERESSATO INVOCHIAMO IL METODO put() INDICANDO LA SOTTOCARTELLA DI DESTINAZIONE (comics_thumb IN QUESTO CASO) E IL VALORE DA SALVARE ($request->thumb IN QUESTO CASO)

```php
public function store(Request $request)
{
    $data = $request->all();

    $newComic = new Comic();

    $newComic->title = $data['title'];
    // CODICE...

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

### MASS ASSIGNMENT

E' POSSIBILE ASSEGNARE IN MASSA I DATI INSERITI NEL FORM SENZA DOVERLI PRENDERE SINGOLARMENTE DALLA Request.

MODIFICARE IL MODELLO IN App\Models (IN QUESTO CASO Comic.php)
```php
class Comic extends Model
{
    use HasFactory;

    // ASSEGNA LA TABELLA COMICS - UTILE SE CI SONO PROBLEMI DI ASSEGNAZIONE TRA LA TABELLA E LA DEPENDENCY INJECTION CAUSATI DAL NOME DEL MODELLO
    protected $table = "comics";

    // ASSEGNA I CAMPI MODIFICABILI IN MASSA (MASS ASSIGNEMENT. DEVE ESSERE USATA LA VARIABILE CODIFICATA $fillable)
    protected $fillable = ['title', 'price', 'series', 'thumb'];
}
```

SCRIVERE DIVERSAMENTE IL METODO store()

```php
public function store(Request $request)
{
    $data = $request->all();
    if ($request->has('thumb')) {
        $file_path = Storage::put('comics_thumbs', $request->thumb);
        $newComic->thumb = $file_path;
    }

    // MASS ASSIGNMENT
    $newComic = Comic::create($data);

    return to_route('admin.index');
}
```

### VISUALIZZARE LE IMMAGINI CARICATE

USIAMO LA FUNZIONE ASSET PER VISUALIZZARE IN UNA VIEW IL FILE CARICATO

```php
<img src="{{ asset('storage/' . $comic->thumb) }}">
```

SE IL DATABASE CONTIENE SIA FILES CARICATI CHE LINK E' NECESSARIO INSERIRE DELLE CONDIZIONI:

```php
@if (str_contains($comic->thumb, 'http'))

<img class=" img-fluid" src="{{ $comic->thumb }}" alt="{{ $comic->title }}">

@else

<img class=" img-fluid"src="{{ asset('storage/' . $comic->thumb) }}">

@endif
```

## CRUD - EDIT

COLLEGARE LA VISTA AL METODO EDIT INDICANDO L'ISTANZA DEL MODELLO CHE NECESSITA DI MODIFICHE:

```php
public function edit(Comic $comic)
{
    return view('admin.edit', compact('comic'));
}
```

CREARE IL COLLEGAMENTO ALLA VISTA CONTENENTE IL FORM

```php
<a href="{{ route('comics.edit', $comic) }}">Edit</a>
```

INSERIRE IL FORM IN PAGINA, AGGIUNGENDO IL TOKEN @method('PUT') PER MODIFICARE IL METODO DEL FORM IN MODO CHE USI IL CONTROLLER.

DARE COME ACTION IL METODO UPDATE DEL CONTROLLER (action="{{ route('comics.update', $comic) }}")

INSERIRE I VARI CAMPI DA MODIFICARE IN MASSA ASSEGNATI NEL MODELLO (VEDI SOPRA)

DARE AI VARI CAMPI L'ATTRIBUTO value ORIGINALE IN MODO DA AVERE SOTT'OCCHIO COSA STIAMO MODIFICANDO (ES: value="{{ $comic->title }}")

```php
<form action="{{ route('comics.update', $comic) }}" method="POST" enctype="multipart/form-data">

    @csrf
    
    @method('PUT') // EDITA IL METODO DEL FORM ASSEGNANDO IL METODO put() DEL CONTROLLER

    <div class="mb-3">

        <label for="title" class="form-label"><strong>Titolo</strong></label>

        <input type="text" class="form-control" name="title" id="title"  aria-describedby="helpTitle" value="{{ $comic->title }}">
    </div>

    // CODICE

    <button type="submit" class="btn btn-success my-3">SAVE</button>

</form>
```

DEFINIRE IL METODO UPDATE

```php
public function update(Request $request, Comic $comic)
{
    $data = $request->all();

    // SE SIA LA REQUEST CHE L'ENTITA' CHE STIAMO EDITANDO HANNO UN thumb (CHIAVE DELL'IMMAGINE)
    if ($request->has('thumb') && $comic->thumb) {

    // VUOL DIRE CHE NELLO STORAGE E' PRESENTE UN'IMMAGINE DA ELIMINARE
    Storage::delete($comic->thumb);

    // LA NUOVA IMMAGINE VIENE SALVATA E IL SUO PERCORSO ASSEGNATO A $data
    $newCover = $request->thumb;
    $path = Storage::put('comics_thumbs', $newCover);
    $data['thumb'] = $path;
    }

    // AGGIORNA L'ENTITA' CON I VALORI DI $data
    $comic->update($data);
    return to_route('comics.show', $comic); // RIDIRIGE ALLA VISTA DEL DETTAGLIO DELL'ELEMENTO APPENA MODIFICATO

    }
```

## CRUD - DESTROY

CREIAMO UN FORM CON METODO POST CHE INDIRIZZA ALLA ROTTA .destroy.

UTILIZZIAMO IL TOKEN `@method('DELETE')` PER SOVRASCRIVERE IL METODO DEL FORM

UTILIZZIAMO SEMPRE IL TOKEN `@csrf`

```php
<form action="{{route('comic.destroy', $comic)}}" method="POST">
    @csrf
    @method('DELETE')
    <button class="btn btn-danger m-2" type="submit">DELETE</button>
</form>
```

EDITIAMO IL METODO destroy NEL CONTROLLER:

```php
public function destroy(Comic $comic)
{
    // CONTROLLA SE L'ISTANZA HA UN FILE DI ANTEPRIMA. SE SI LO ELIMINA DAL filesystem
    if(!is_null($comic->thumb)) {
        Storage::delete($comic->thumb);
    }
    
    // ELIMINA IL RECORD DAL DATABASE
    $comic->delete();

    // RIDIRIGE AD UNA ROTTA DESIDERATA CON UN MESSAGGIO
    return to_route('comics.index')->with('message', 'Well Done, Element Deleted Succeffully');
}
```

SE LA NOSTRA FLASHED SESSION CONTIENE UN DATO CHIAMATO 'message' ALLORA MOSTRIAMOLO IN PAGINA.

IL MESSAGGIO POTREBBE ANCHE ESSERE MOSTRATO ANCHE PER L'AGGIUNTA DI NUOVI RECORD O PER LA LORO MODIFICA, BASTA AGGIUNGERE L'ECHO NELLA VISTA DESIDERATA.
https://laravel.com/docs/10.x/responses#redirecting-with-flashed-session-data

```php
@if (session('message'))

    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

        <strong>Holy guacamole!</strong> {{session('message')}}
    </div>

@endif
```