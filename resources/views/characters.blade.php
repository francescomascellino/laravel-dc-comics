@extends('layout.app')

@section('content')

<div class="container-fluid dc-mainContainer">

    <div class="row justify-content-center">


        <div class="col-8 py-5 position-relative">

<h1>{{Str::ucfirst(Route::currentRouteName())}}</h1>

        </div>


    </div>

</div>

@endsection