@foreach ($comics as $id => $comic)
    <div class="col-2">

        <div class="card bg-transparent">

            {{-- LINK ALLA ROUTE comic.show USANDO L'ID DEL FUMETTO COME CALLBACK --}}
            <a href="{{ route('comics.show', $comic->id) }}">

                @if (str_contains($comic->thumb, 'http'))
                    <div class="p-1 dc-coverContainer" style="background-image: url({{ $comic->thumb }})">
                    @else
                        <div class="p-1 dc-coverContainer"
                            style="background-image: url({{ asset('storage/' . $comic->thumb) }})">
                @endif

        </div>

        <div class="card-body p-0 pt-3">

            <a href="{{ route('comics.show', $comic->id) }}">LINK FUMETTO ID {{ $comic->id }}</a>

            <p class="card-title text-uppercase">{{ $comic->series }}</p>
            <p class="card-text text-capitalize">{{ $comic->type }}, price: {{ $comic->price }}</p>}
        </div>
        </a>

    </div>

    </div>
@endforeach
