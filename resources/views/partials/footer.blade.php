<div class="container-fluid">

    <div class="row flex-column justify-content-flex-end dc-footerCont">

        <footer class="p-0 ">

            <div class="d-flex justify-content-center dc-footerLinks">

                <div class="col-8 pt-5 d-flex flex-column flex-wrap align-content-start dc-bigLogo">

                    @foreach (config('footer-links') as $element)
                        <div class="col-2 dc-listContainer">

                            <h5 class="text-uppercase">{{ $element['title'] }}</h5>

                            <ol class="list-unstyled">

                                @foreach ($element['links'] as $link)
                                    <li class="text-capitalize"><a href="{{$link['path']}}">{{$link['text']}}</a></li>
                                @endforeach

                            </ol>

                        </div>

                    @endforeach

                </div>

            </div>

            <div class="d-flex justify-content-center dc-contacts">

                <div class="col-8 d-flex align-items-center justify-content-between">

                    <button class="btn text-uppercase dc-signUpBtn">sign-up now!</button>

                    <div class="d-flex align-items-center dc-followCont">

                        <h4 class="text-uppercase m-0">follow us</h4>

                        @foreach (config('social-links') as $link)
                        <a href="{{$link['path']}}" class="ms-3"><img src="{{Vite::asset($link['img'])}}" alt="{{$link['name']}}"></a>
                        @endforeach

                    </div>

                </div>

            </div>

        </footer>

    </div>

</div>