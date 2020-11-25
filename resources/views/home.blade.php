@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row category-container">

            <?php printf($categories) ?>

        </div>
    </div>

    <main>





{{--        <div class="container">--}}

{{--            <div class="row">--}}

{{--                @foreach($categories['main'] as $category)--}}

{{--                    <div class="col-md-3">--}}
{{--                        <div class="category-parent">--}}
{{--                            {{$category->name}}--}}

{{--                            <div class="category-first-child">--}}
{{--                                Auto's--}}
{{--                                <div class="category-final-child">Kleine auto's</div>--}}
{{--                                <div class="category-final-child">Middel grote auto's</div>--}}
{{--                                <div class="category-final-child">Grote auto's</div>--}}


{{--                            </div>--}}
{{--                            <div class="category-first-child">--}}
{{--                                Boten--}}

{{--                            </div>--}}
{{--                            <div class="category-first-child">--}}
{{--                                Vliegtuigen--}}

{{--                            </div>--}}

{{--                        </div>--}}


{{--                    </div>--}}

{{--                @endforeach--}}

{{--            </div>--}}

{{--        </div>--}}

        <div class="hero-section">
            <h1 class="title text-white">
                <i class="fas fa-gavel"></i> Eenmaal Andermaal
            </h1>
        </div>

        <div class="container pt-4">

            <h2>Uitgelichte veilingen</h2>

            <div class="row py-4">

                @foreach($auctions as $auction)
                    <a href="{{route("auctions.show",$auction->id)}}" class="col-lg-4 col-md-6 mb-4 no-link">
                        <div class="auction-card hover-effect">
                            <div class="auction-card-image"
                                 style="background-image: url('{{$auction->getFirstImage()}}');">
                            </div>
                            <div class="auction-card-body">
                                <h4>{{$auction->title}}</h4>

                                <div class="flex-centered">
                                    <div class="auction-card-data">€ {{$auction->getLatestBid()}}</div>
                                    <div class="auction-card-data">{{$auction->getTimeLeft()}}</div>
                                </div>

                                <div class="flex-centered mt-2">
                                    <div class="btn btn-outline-primary">
                                        Bieden
                                    </div>
                                </div>

                            </div>
                        </div>
                    </a>
                @endforeach

            </div>

        </div>

    </main>

@endsection
