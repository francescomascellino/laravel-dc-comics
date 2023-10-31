<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel Comics - {{Str::ucfirst(Route::currentRouteName())}}</title>

    {{-- FONT AWESOME --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles -->
    @vite('resources/js/app.js')

</head>

<body>

    <header>

        <div class="container-fluid dc-additional-sites">

            <div class="row justify-content-center">
                <div class="col-8  d-flex justify-content-end align-items-center py-1 ">
                    <span class="px-5">DC POWER&trade;VISA&reg;</span>
                    <span>ADDITIONAL DC SITES <i class="fa-solid fa-caret-down"></i></span>
                </div>
            </div>

        </div>

        <div class="container-fluid">

            @include('partials.navbar')

            @include('partials.jumbotron')

        </div>

    </header>