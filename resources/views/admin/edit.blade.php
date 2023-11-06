@extends('layout.app')

@section('content')
    <div class="container-fluid dc-mainContainer">

        <div class="row justify-content-center">

            <div class="col-8 py-5">

                <h1 class="text-center">Edit Comic ID: {{ $comic->id }} - {{ $comic->title }} </h1>

                <div class="bg-light-subtle p-3 rounded rounded-3">

                    <form action="{{ route('comics.update', $comic) }}" method="POST" enctype="multipart/form-data">

                        @csrf
                        {{-- EDITA IL METODO AFFINCHE' USI IL METODO put() DEL RESOURCE CONTROLLER --}}
                        @method('PUT')

                        @include('partials.error_alert')

                        <div class="mb-3">

                            <label for="title" class="form-label"><strong>Titolo</strong></label>

                            <input type="text" class="form-control" name="title" id="title"
                                aria-describedby="helpTitle" value="{{ old('title') ? old('title') : $comic->title}}" required>

                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="mb-3">

                            <label for="price" class="form-label"><strong>Prezzo</strong></label>

                            <input type="text" class="form-control" name="price" id="price"
                                aria-describedby="helpprice" value="{{ old('price') ? old('price') : $comic->price}}" required>

                            @error('price')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="mb-3">

                            <label for="series" class="form-label"><strong>Serie</strong></label>

                            <input type="text" class="form-control" name="series" id="series"
                                aria-describedby="helpseries" value="{{ old('series') ? old('series') : $comic->series}}">

                            @error('series')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="mb-3">

                            <div class="mb-3">

                                @if (str_contains($comic->thumb, 'http'))
                                    <td><img class=" img-fluid" style="height: 100px" src="{{ $comic->thumb }}"
                                            alt="{{ $comic->title }}"></td>
                                @else
                                    <td><img class=" img-fluid" style="height: 100px"
                                            src="{{ asset('storage/' . $comic->thumb) }}"></td>
                                @endif

                            </div>

                            <label for="thumb" class="form-label"><strong>Scegli un file per la
                                    copertina</strong></label>

                            <input type="file" class="form-control" name="thumb" id="thumb" placeholder="Cerca..."
                                aria-describedby="fileHelpThumb">

                            @error('thumb')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                        </div>

                        <button type="submit" class="btn btn-success my-3">SAVE</button> <a class="btn btn-primary m-3"
                            href="{{ route('comics.index') }}">Back to Dashboard</a>

                    </form>


                </div>



            </div>

        </div>

    </div>
@endsection
