@extends('layout.app')

@section('content')
    <div class="container-fluid dc-mainContainer">

        <div class="row justify-content-center">

            {{-- CARDS CONTAINER --}}
            <div class="col-8 py-5 position-relative">

                {{-- CURRENT SERIES BADGE --}}
                <div class="py-2 px-4 position-absolute top-0 translate-middle dc-currentSeries">
                    <h5 class="text-uppercase m-0">Current Series</h5>
                </div>

                <div class="row row-cols-6 g-3">

                    {{-- CARDS --}}
                    @include('partials.cards')

                    <div class="col-12 d-flex justify-content-center align-items-center">
                        <a href="#" class="btn text-uppercase px-5 dc-more">load more</a>
                    </div>

                </div>

            </div>
            {{-- END CARDS CONTAINER --}}

        </div>

    </div>
@endsection

{{--  --}}

{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite('resources/js/app.js')

</head>

<body>
<h1>test</h1>
    <main class="bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @foreach ($comics as $comic)
                        {{ $comic->title }}
                    @endforeach
                </div>
            </div>

        </div>
    </main>

</body>

</html> --}}
