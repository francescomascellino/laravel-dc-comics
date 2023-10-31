<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# CRUD

CREARE UN RESOURCE CONTROLLER

```
php artisan make:controller --resource User\PageController
```

CONTROLLARE LA LISTA DELLE ROUTES

```
php artisan route:list
```
OTTIMIZZARE PER AGGIORNARE LE ROUTES IN CASO DI PROBLEMA:

```
php artisan optimize
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
SE PageController FOSSE SOSTITUITO CON AdminController LA PAGINA INIZIALE SAREBBE LA DASHBOARD DELL'ADMIN CON LA TABELLA

```php
Route::get('/', [PageController::class, 'index'])->name('comics');
```
