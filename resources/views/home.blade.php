@extends('layouts.app')

@section('content')

    <div class="hero-section">
        <h1 class="title text-white">
            <i class="fas fa-gavel"></i> Eenmaal Andermaal
        </h1>
    </div>

    <div class="container pt-4">

        <h2>Uitgelichte veilingen</h2>

        <div class="row py-4">

            @foreach($auctions as $auction)
                <a href="#" class="col-lg-4 col-md-6 mb-4 no-link">
                    <div class="auction-card hover-effect">
                        <div class="auction-card-image" style="background-image: url('/images/unsplash-ferrari.jpg');">
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

@endsection
