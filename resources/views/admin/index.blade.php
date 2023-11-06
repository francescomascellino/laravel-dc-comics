@extends('layout.app')

@section('content')
    <div class="container-fluid dc-mainContainer">

        <div class="row justify-content-center">

            <div class="col-8 py-5">

                @include('partials.admin_alert')

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
                                <th scope="col">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($comics as $comic)
                                <tr class="">
                                    <td class="align-middle" scope="row">{{ $comic->id }}
                                    </td>

                                    <td class="align-middle">{{ $comic->title }} - <a
                                            href="{{ route('comics.show', $comic) }}">Details</a>
                                        @if ($comic->trashed())
                                            <p class="text-danger"><strong>This record has been deleted on
                                                    {{ $comic->deleted_at }}</strong></p>
                                            {{-- <button onclick="{{$comic->restore()}}">Restore</button> --}}
                                        @endif
                                    </td>

                                    <td class="align-middle">{{ $comic->price }}</td>

                                    <td class="align-middle">{{ $comic->series }}</td>

                                    <td class="align-middle">{{ $comic->sale_date }}</td>

                                    <td class="align-middle">{{ $comic->type }}</td>

                                    @if (str_contains($comic->thumb, 'http'))
                                        <td class="text-center align-middle"><img class="img-fluid" style="height: 100px"
                                                src="{{ $comic->thumb }}" alt="{{ $comic->title }}"></td>
                                    @else
                                        <td class="text-center align-middle"><img class="img-fluid" style="height: 100px"
                                                src="{{ asset('storage/' . $comic->thumb) }}"></td>
                                    @endif
                                    <td class="align-middle">

                                        {{-- EDIT --}}
                                        <a class="btn btn-warning m-2" href="{{ route('comics.edit', $comic) }}">Edit</a>

                                        {{-- DELETE --}}
                                        <!-- Modal trigger button -->
                                        <button type="button" class="btn btn-danger m-2" data-bs-toggle="modal"
                                            data-bs-target="#modalComic{{ $comic->id }}">
                                            Delete
                                        </button>

                                        <!-- Modal Body -->
                                        <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                        <div class="modal fade" id="modalComic{{ $comic->id }}" tabindex="-1"
                                            data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                                            aria-labelledby="modalTitleId" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-muted" id="modalTitleId">DELETE COMIC ID
                                                            {{ $comic->id }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <p>Do you want to delete "{{ $comic->title }}"?</p>

                                                        <p>The record will be moved to the recycle bin!</p>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-success"
                                                            data-bs-dismiss="modal">Cancel</button>

                                                        <form action="{{ route('comics.destroy', $comic) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger m-2"
                                                                type="submit">DELETE</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            @empty
                                <h1>Database is empty</h1>
                            @endforelse

                        </tbody>
                    </table>
                </div>

                <h1 class="text-center">Recycle Bin</h1>

                <div class="table-responsive rounded rounded-3">
                    <table class="table ">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">TITOLO</th>
                                <th scope="col">PREZZO</th>
                                <th scope="col">SERIE</th>
                                <th scope="col">ELIMINATO IL</th>
                                <th scope="col">TIPO</th>
                                <th scope="col">THUMB</th>
                                <th scope="col">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($trashed_comics as $comic)
                                <tr class="">
                                    <td class="align-middle" scope="row">{{ $comic->id }}
                                    </td>

                                    <td class="align-middle">{{ $comic->title }} - <a
                                            href="{{ route('comics.show', $comic) }}">Details</a>
                                    </td>

                                    <td class="align-middle">{{ $comic->price }}</td>

                                    <td class="align-middle">{{ $comic->series }}</td>

                                    <td class="align-middle">{{ $comic->deleted_at }}</td>

                                    <td class="align-middle">{{ $comic->type }}</td>

                                    @if (str_contains($comic->thumb, 'http'))
                                        <td class="text-center align-middle"><img class="img-fluid" style="height: 100px"
                                                src="{{ $comic->thumb }}" alt="{{ $comic->title }}"></td>
                                    @else
                                        <td class="text-center align-middle"><img class="img-fluid" style="height: 100px"
                                                src="{{ asset('storage/' . $comic->thumb) }}"></td>
                                    @endif
                                    <td class="align-middle">

                                        {{-- EDIT --}}
                                        <a class="btn btn-warning m-2" href="{{ route('comics.edit', $comic) }}">Edit</a>

                                        {{-- DELETE --}}
                                        <!-- Modal trigger button -->
                                        <button type="button" class="btn btn-danger m-2" data-bs-toggle="modal"
                                            data-bs-target="#modalComic{{ $comic->id }}">
                                            Delete
                                        </button>

                                        <!-- Modal Body -->
                                        <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                        <div class="modal fade" id="modalComic{{ $comic->id }}" tabindex="-1"
                                            data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                                            aria-labelledby="modalTitleId" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-muted" id="modalTitleId">DELETE COMIC
                                                            ID
                                                            {{ $comic->id }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <p>Do you want to delete "{{ $comic->title }}"?</p>

                                                        <p>This operation is not reversible!</p>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-success"
                                                            data-bs-dismiss="modal">Cancel</button>

                                                        <form action="{{ route('comics.destroy', $comic) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger m-2"
                                                                type="submit">DELETE</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            @empty
                                <h1>Recycle Bin is empty</h1>
                            @endforelse

                        </tbody>
                    </table>
                </div>

                <a class="btn btn-primary" href="{{ route('comics.create') }}">ADD ENTRY</a>

            </div>

        </div>

    </div>
@endsection
