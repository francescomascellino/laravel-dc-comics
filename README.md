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

```
php artisan migrate
```

## ESEGUIRE IL SEEDING

```
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

```
php artisan migrate:fresh --seed
```

## CREARE UN RESOURCE CONTROLLER

```
php artisan make:controller --resource User\PageController
```

## CONTROLLARE LA LISTA DELLE ROUTES

```
php artisan route:list
```
OTTIMIZZARE PER AGGIORNARE LE ROUTES IN CASO DI PROBLEMA:

```
php artisan optimize
```
AGGIUNGERE I RESOURCE CONTROLLERS NECESSARI A routes\web.php

```php
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\User\PageController;
```

DA IL NOME 'comics' ALLE ROUTES DEFINITE TRAMITE User\PageController

```php
Route::resource('comics', PageController::class);
```

DA IL NOME 'admin' ALLE ROUTES DEFINITE TRAMITE User\AdminController

```php
Route::resource('admin', AdminController::class);
```

QUESTO CI PERMETTE DI RIDIRIGERE I LINK ALLE VIEWS USANDO AD ESEMPIO:

```php
href="{{ route('admin.create') }}" 
```

DEFINITA IN App\Http\Controllers\Admin\AdminController COME:
```php
public function create()
{
    return view('admin.add'); // views/admin/add.blade.php
}
```

OPPURE:

```php
href="{{ route('admin.index') }}" 
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
    return view('comic_details', compact('comic')); // views/comic_details.blade.php
}
```

INDICA CHE LA ROUTE '/' CORRISPONDE AL METODO 'index' DI User\PageController
(SE PageController FOSSE SOSTITUITO CON AdminController LA PAGINA INIZIALE SAREBBE LA DASHBOARD DELL'ADMIN CON LA TABELLA)

```php
Route::get('/', [PageController::class, 'index'])->name('comics');
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
    return view('comic_details', compact('comic')); // views/comic_details.blade.php
}
```

USARE UNA ROUTE PER COLLEGARE LA VISTA SHOW PASSANDO UN ARGOMENTO CHE CI SERVIRA' A VISUALIZZARE NEL DETTAGLIO L'ENTITA' DESIDERATA (L'id)

```php
href="{{ route('comics.show', $comic->id) }}"
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
<a class="btn btn-primary" href="{{ route('admin.create') }}">ADD ENTRY</a>
```

NELLA VISTA 'admin.create' CREARE IL FORM USANDO COME METODO LA ROUTE .store() CHE AVRA' IL COMPITO DI GESTIRE I DATI DEL FORM.

IL METODO DEVE ESSERE 'POST'.

GLI ATTRIBUTI 'name' DEVONO COMBACIARE CON I NOMI DELLE COLONNE DEL DATABASE.

@csrf E' UN TOKEN CHE GENERA LARAVEL PER ASSICURARSI CHE LA CHIAMATA POST AVVENDA TRAMITE UN FORM DEL SITO PER EVITARE INTRUSIONI DA PARTE DI TERZI


```php
<form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">

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

    return view('admin.add'); // RIDIRIGE ALLA VISTA ORIGINALE (ALTRIMENTI SI RESTERA' FERMI SU UNA PAGINA VUOTA E AGGIORNANO VERRA' NUOVAMENTE INVIATOIL MODULO)
}
```