<div class="container-fluid dc-menuCont">

    <div class="row justify-content-center">

        <div class="col-8 p-0">

            <div class="d-flex align-items-center justify-content-evenly flex-wrap p-4 dcMenuEl">

                @foreach (config('services-links') as $link)
                    <a href="{{$link['path']}}" class="text-uppercase m-3" ><img
                        src="{{Vite::asset($link['img'])}}" alt=""><span class="ms-4">{{ $link['text'] }}</span></a>
                @endforeach

            </div>

        </div>

    </div>

</div>