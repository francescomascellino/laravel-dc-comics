@extends('layout.app')

@section('content')
    <div class="container-fluid">

        <div class="row justify-content-center">

            <div class="col-8 py-5 position-relative">

                <div class="col-2">
                    <img src="{{ $comic['thumb'] }}" alt="{{ $comic['title'] }}" style="width: 100%">
                </div>

                <div class="row">

                    <div class="col-8">

                        <h2 class="text-uppercase fw-bold text-dark">{{ $comic['title'] }}</h2>

                        <p>{{ $comic['description'] }}</p>

                    </div>

                    <div class="col">

                        <img src="{{ Vite::asset('resources/img/adv.jpg') }}" alt="advertisement">

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
