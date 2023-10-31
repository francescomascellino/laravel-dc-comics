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