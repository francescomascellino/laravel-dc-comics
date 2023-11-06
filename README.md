<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# CRUD

## INDICE

- <a href="#creare-un-nuovo-progetto" target="_blank">CREARE UN NUOVO PROGETTO</a>
- <a href="#create-app-layouts" target="_blank">CREARE LAOUT DELL'APP</a>
- <a href="#creare-una-migration-e-un-seeder-per-popolare-il-database" target="_blank">CREARE UNA MIGRATION E UN SEEDER PER POPOLARE IL DATABASE</a>
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
- <a href="#validation" target="_blank">VALIDATION DEI FORM</a>
- <a href="#validation---gestione-degli-errori" target="_blank">VALIDATION - GESTIONE DEGLI ERRORI</a>
- <a href="#form-requests---classi-contenenti-le-regole-di-validazione" target="_blank">FORM REQUESTS - CLASSI CONTENENTI LE REGOLE DI VALIDAZIONE</a>
- <a href="#soft-delete" target="_blank">SOFT DELETE</a>


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
php artisan db:seed --class=ComicTableSeeder
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

## VALIDATION

LA VALIDAZIONE CONSENTE DI EFFETTUARE DELLE VALIDAZIONI LATO FRONT IN MODO DA NON INVIARE QUERY ERRATE ED EVENTUALMENTE DANNOSE AL DATABASE.

ELENCO DELLE REGOLE DI VALIDAZIONE: https://laravel.com/docs/10.x/validation#available-validation-rules

AD ESEMPIO PER VALIDARE UN METODO ***store***:

```php
/**
 * Store a new blog post.
 */
public function store(Request $request)
{
    $validated = $request->validate(
        [
            // nome campo form (uguale al nome della colonna) => regole
            'title' => 'required|bail|min:3|max:100',
            'thumb' => 'nullable|image|max:150',
            'price' => 'required|min:3|max:7',
            'series' => 'nullable|min:3|max:100', 
        
        ]
    );
 

    $newComic = Comic::create($validated); // MASS ASSIGNMENT
 
    return to_route('comics.index')->with('message', 'Well Done, New Entry Added Succeffully');
}
```

### VALIDATION - GESTIONE DEGLI ERRORI

GLI ERRORI VENGONO CONSERVATI NEGLI ERRORI NELLA VARIABILE  GLOBALE $errors E POSSONO ESSERE STAMPATI IN PAGINA

```php
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
```
LA DIRETTIVA BLADE ***@error*** CI PERMETTE DI CONTROLLARE SE PER UN DETERMINATO ATTRIBUTO ESISTE UN ERRORE ED EVENTUALMENTE EFFETTUARNE UN ***echo*** IN PAGINA

```php 
<div class="mb-3">

    <label for="title" class="form-label"><strong>Titolo</strong></label>

        <input type="text" class="form-control" 
        name="title" 
        id="title" 
        aria-describedby="helpTitle" 
        placeholder="Inserisci il titolo del prodotto"  
        value="{{ old('title') }}">

        @error('title')
            <div class="text-danger">{{ $message }}</div>
        @enderror

</div>
```

PER RECUPERARE IL VECCHIO VALORE DI UNA PRCEDENTE REQUEST, E' POSSIBILE INVOCARE IL METODO ***old()***. IL METODO RECUPERERA' IL PRECEDENTE VALORE DALLA SESSIONE.

```php
$title = $request->old('title');
```

Laravel also provides a global old helper. If you are displaying old input within a Blade template, it is more convenient to use the old helper to repopulate the form. If no old input exists for the given field, null will be returned:

LARAVEL HA ANCHE UN HELPER GLOBALE ***old()*** CHE CI PERMETTE DI RIPOPOLARE IL FORM. SE NON VI SONO VECCHI VALORI PER UN DETERMINATO CAMPO VERRA' RESTITUITO ***null***.

```php
<input type="text" name="title" value="{{ old('title') }}">
```

E' QUINDI POSSIBILE PASSARE UN VALORE DI DEFAULT SE NON ESISTE UN ERRORE SUL CAMPO CONTROLLATO, AD ESEMPIO SE STIAMO MODIFICANDO UN ELEMENTO ESISTENTE ANZICHE' CREARNE UNO NUOVO:

```php
<input type="text" name="title" value="{{ old('title, $comic->title') }}">
```

SE NON FUZIONA:

```php
<input type="text" name="title" value="{{ old('title') ? old('title') : $comic->title}}">
```

MESSAGGI DI ERRORE PERSONALIZZATI

PER PERSONALIZZARE I FILE DI LINGUAGGIO DI LARAVEL E' NECCASSIO EFFETTUARE LO SCAFFOLD DELLA CARTELLA `lang`

```bash
php artisan lang:publish
```

QUESTO CREERA' LA CARTELLA ***lang***. AL SUO INTERNO TROVEREMO LA CARTELLA ***eng*** E IL FILE ***validation.php*** CHE CONTIENE I MESSAGGI DELLE REGOLE DI VALIDAZIONE.

ALLA FINE DELL'ARRAY TROVEREMO LA CHIAVE ***'custom'*** CHE CI PERMETTE L'INSERIMENTO DI VALORI PERSONALIZZATI:

```php
    'custom' => [

        // NESSAGGI PERSONALIZZATI PER OGNI REGOLA DEI VARI ATTRIBUTI
        'title' => [
            'required' => 'Il campo :attribute è obbligatorio!',

            'min' => [
                'string' => 'Il campo :attribute deve contenere almeno :min caratteri.',
            ],

            'max' => [
                'string' => 'Il campo :attribute non deve contenere più di :max caratteri.',
            ],
        ],

    // NOMI PERSONALIZZATI PER OGNI ATTRIBUTO DA USA COME PLACEHOLDER
    'attributes' => [
        'title' => 'Titolo',
        'thumb' => 'Copertina',
        'price' => 'Prezzo',
        'series' => 'Serie',
    ],
```

## FORM REQUESTS - CLASSI CONTENENTI LE REGOLE DI VALIDAZIONE

E' POSSIBILE CREARE DELLE CLASSI CONTENENTI LE REGOLE DI VALIDAZIONE IN MODO DI NON DOVERLE INSERIRE ALL'INTERNO DEI CONTROLLER
https://laravel.com/docs/10.x/validation#creating-form-requests

```bash
php artisan make:request Store[NOME]Request (PER LE STORE QUESTS)
```
OPPURE PER LE UPDATE REQUEST

```bash
php artisan make:request Update[NOME]Request
```
QUINDI PER QUESTO ESERCIZIO VERRANNO USATI I COMANDI ARTISAN:

```bash
php artisan make:request StoreComicRequest
php artisan make:request UpdateComicRequest
```

NEL FILE DELLA REQUEST DENTRO LA CARTELLA ***Http/Requests*** SETTARE SU `true` L'AUTORIZZAZIONE NEL METODO ***uthorize()***
```php
/**
 * Determine if the user is authorized to make this request.
 */
public function authorize(): bool
    {
        return true;
    }
```

INSERIRE LE REGOLE NEL METODO ***rules()***

```php
/**
 * Get the validation rules that apply to the request.
 *
 * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
 */
public function rules(): array
{
    // VALIDATION RULES
    return [
        'title' => 'required|bail|min:3|max:100',
        'thumb' => 'nullable|image|max:150',
        'price' => 'required|min:3|max:7',
        'series' => 'nullable|min:3|max:100',
    ];
}
```

AGGIUNGERE L'***@use*** DELLE REQUEST NEL CONTROLLER

```php
use App\Http\Requests\StoreComicRequest;
use App\Http\Requests\UpdateComicRequest;
```

MODIFICARE I METODI

```php
// USA REQUEST StoreComicRequest CLASS ANZICHE' Request NEL METODO STORE
public function store(StoreComicRequest $request)
{

    // ASSEGNA ALLA VARIABILE I VALORI GIA' VALIDATI DALLA CLASSE StoreComicRequest
    $validated = $request->validated();

    // SALVA I DATI IN UNA NUOVA ISTANZA DEL MODELLO Comic
    $newComic = Comic::create($validated);
 
    return to_route('comics.index')->with('message', 'Well Done, New Entry Added Succeffully');
}
```

```php
    public function update(UpdateComicRequest $request, Comic $comic)
    {

        // ASSEGNA ALLA VARIABILE I VALORI GIA' VALIDATI DALLA CLASSE UpdateComicRequest
        $validated = $request->validated();

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

            // ASSEGNA AL VALORE DI $validated IL PERCORSO DELL'IMMAGINE NELLO STORAGE
            $validated['thumb'] = $path;
        }

        // AGGIORNA L'ENTITA' CON I VALORI DI $validated
        $comic->update($validated);
        return to_route('comics.show', $comic)->with('message', 'Well Done, Element Edited Succeffully');
    }
```

## SOFT DELETE

OLTRE A POTER ELIMINARE DEFINITIVAMENTE UN RECORD DAL NOSTRO DATABASE E' POSSIBILE ABILITARE IL "SOFT DELETE". QUANDO UN MODELLO E' SOFT DELETED NON E' EFFETTIVAMENTE RIMOSSO IN MANIERA PERMANENTE, MA GLI VIENE ASSEGNATO UN NUOVO ATTRIBUTO ***deleted_at*** CHE INDICA DATA E ORA DI QUANDO L'ELEMENTO E' STATO ELIMINATO.
I RECORD SOFT DELETED NON COMPAIONO QUANDO VENGONO CICLATI A MENO CHE NON SIAMO NOI A RICHIEDERLO SPECIFICAMENTE QUANDO CREIAMO LA QUERY.
https://laravel.com/docs/10.x/eloquent#soft-deleting

PER UTILIZZARE IL SOFT DELETE DOBBIAMO AGGIUNGERE IL TRATTO ELOQUENT ***Illuminate\Database\Eloquent\SoftDeletes*** AL MODELLO INTERESSATO.

(App/Models/Comic.php)

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // SOFT DELETE

class Comic extends Model
{
    use HasFactory;

    use SoftDeletes; // SOFT DELETE

    // ASSEGNA LA TABELLA COMICS
    protected $table = "comics";

    // ASSEGNA I CAMPI MODIFICABILI IN MASSA (MASS ASSIGNEMENT)
    protected $fillable = ['title', 'price', 'series', 'thumb'];
}
```

SE ABBIAMO GIA' EFFETTUATO LA MIGRATION DOBBIAMO AGGIORNARE IL DATABASE INSERENDO LA NUOVA COLONNA CREANDO UNA MIGRATION DI UPDATE. QUESTO CI PERMETTERA' DI AGGUNGERE IL CAMPO DESIDERATO
https://github.com/francescomascellino/laravel-migration-seeder#if-it-is-needed-to-update-the-table

```bash
php artisan make:migration update_comics_table --table=comics
```

AGGIUNGIAMO NEI METODI ***up()*** E ***down()*** DELLA MIGRATION APPENA CREATA LE ISTRUZIONI PER AGGIUNGERE (***up()***) IL SoftDeletes E PER EFFETTUARE IL ROLLBACK (***down()***)

```php
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('comics', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comics', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
```

ESEGUIAMO LA MIGRAZIONE PER RENDERE EFFETTIVE LE MODIFICHE

```bash
php artisan migrate
```

ADESSO IL DATABASE HA LA COLONNA deleted_at E IN CASO DI ELIMINAZIONE DI UN RECORD, QUESTO VERRA' SEMPLICEMENTE NASCOSTO.

PER VISUALIZZARE ANCHE GLI ELEMENTI CANCELLATI BISOGNA INVOCARE SUL MODELLO IL METODO withTrashed() QUANDO CREIAMO LA QUERY

AD ESEMPIO IL NOSTRO METODO index() IN ComicController DOVREBBE DIVENTARE:

```php
public function index()
{
    $comics = Comic::withTrashed()->get();
    return view('admin.index', compact('comics'));
}
```

IL METODO onlyTrashed() INVECE DA COME OUTPUT SOLTANDO GLI ELEMENTI SOFT DELETED

```php
$comics = Comic::onlyTrashed()->get();
```

```php
public function index()
    {
        $comics = Comic::all();
        $trashed_comics = Comic::onlyTrashed()->get();
        return view('admin.index', compact('comics', 'trashed_comics'));
    }
```

IN ***index.blade.php*** POSSIAMO USARE IL METODO ***trashed()*** PER CONTROLLARE SE IL RECORD E' SOFT DELETED ED EVENTUALMENTE SEGNALARLO COME TALE O ANCHE STAMPARLO IN UNA TABELLA DIFFERENTE

```php
<tbody>

    @forelse ($comics as $comic)

        <tr class="">
            <td class="align-middle" scope="row">{{ $comic->id }}

                @if ($comic->trashed())
                    <p class="text-danger"><strong>This record has been deleted on {{ $comic->deleted_at }}</strong></p>
                @endif

            </td>
        </tr>  

    @empty
        <h1>Database is empty</h1>
    @endforelse

</tbody>
```

PER RIMUOVERE IL SOFT DELETE DA UN RECORD E' NECESSARIO USARE IL METODO ***restore()*** 

```php
$comic->restore();
```

PER ELIMINARE DEFINITIVAMENTE UN RECORD INVECE UTILIZZARE ***forceDelete()***

```php
$comic->forceDelete();
```