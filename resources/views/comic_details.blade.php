@extends('layout.app')

@section('content')
    <div class="container-fluid">

        <div class="row justify-content-center">

            <div class="col-8 py-5 position-relative">

                <div class="col-2">
                    @if (str_contains($comic->thumb, 'http'))
                        <td><img class=" img-fluid" style="height: 250px" src="{{ $comic->thumb }}" alt="{{ $comic->title }}">
                        </td>
                    @else
                        <td><img class=" img-fluid" style="height: 250px" src="{{ asset('storage/' . $comic->thumb) }}">
                        </td>
                    @endif
                </div>

                <div class="row">

                    <div class="col-8">

                        <h2 class="text-uppercase fw-bold text-dark">{{ $comic->title }}</h2>

                        <p>{{ $comic->description }}</p>

                    </div>

                    <div class="col">

                        <img src="{{ Vite::asset('resources/img/adv.jpg') }}" alt="advertisement">

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
