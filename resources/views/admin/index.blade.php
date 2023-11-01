@extends('layout.app')

@section('content')
    <div class="container-fluid dc-mainContainer">

        <div class="row justify-content-center">

            <div class="col-8 py-5">

                <h1 class="text-center">ADMIN DATABASE</h1>

                <div class="table-responsive rounded rounded-3">
                    <table class="table ">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">TITOLO</th>
                                <th scope="col">PREZZO</th>
                                <th scope="col">SERIE</th>
                                <th scope="col">IN VENDITA DAL</th>
                                <th scope="col">TIPO</th>
                                <th scope="col">THUMB</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($comics as $comic)
                                <tr class="">
                                    <td scope="row">{{ $comic->id }}</td>

                                    <td>{{ $comic->title }}</td>

                                    <td>{{ $comic->price }}</td>

                                    <td>{{ $comic->series }}</td>

                                    <td>{{ $comic->sale_date }}</td>

                                    <td>{{ $comic->type }}</td>

                                    @if (str_contains($comic->thumb, 'http'))
                                        <td><img class=" img-fluid" style="height: 100px" src="{{ $comic->thumb }}"
                                                alt="{{ $comic->title }}"></td>
                                    @else
                                        <td><img class=" img-fluid" style="height: 100px"
                                                src="{{ asset('storage/' . $comic->thumb) }}"></td>
                                    @endif

                                </tr>
                            @empty
                                <h1>Database is empty</h1>
                            @endforelse

                        </tbody>
                    </table>
                </div>

                <a class="btn btn-primary" href="{{ route('admin.create') }}">ADD ENTRY</a>

            </div>

        </div>

    </div>
@endsection