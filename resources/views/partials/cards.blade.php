@foreach ($comics as $comic)
    <div class="col-2">

        <div class="card bg-transparent">

            {{-- details = name DELLA ROUTE comic_details --}}
            <a href="{{ route('details', $comic) }}">

                @if (str_contains($comic->thumb, 'http'))
                    <div class="p-1 dc-coverContainer" style="background-image: url({{ $comic->thumb }})"></div>
                @else
                    <div class="p-1 dc-coverContainer"
                        style="background-image: url({{ asset('storage/' . $comic->thumb) }})">
                    </div>
                @endif



                <div class="card-body p-0 pt-3">

                    {{-- <a href="{{ route('details', $comic) }}">LINK FUMETTO ID {{ $comic->id }}</a> --}}

                    <p class="card-title text-uppercase">{{ $comic->series }}</p>
                    <p class="card-text text-capitalize">{{ $comic->type }}, price: {{ $comic->price }}</p>
                </div>

            </a>

        </div>


    </div>
@endforeach
