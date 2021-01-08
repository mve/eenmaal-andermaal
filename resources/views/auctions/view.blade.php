@extends('layouts.app')

@section('content')
<div class="mb-4"></div>

{{\App\Breadcrumbs::createAndPrint($auction, 5)}}

<div class="container">
    <h2>{{$auction->title}}</h2>
    <h5><span class="h3"><i class="fas fa-fire-alt"></i> {{$auctionHits}}</span> unieke bezoekers in het laatste uur.</h5>
    <div class="row">
        <div class="col-lg-7">
            <!-- CAROUSEL SLIDER -->
            <div id="carouselExampleIndicators" class="carousel slide " data-ride="carousel">
                <ol class="carousel-indicators">
                    @for($i = 0; $i < count($auctionImages); $i++) <li data-target="#carouselExampleIndicators" @if($i==0) class="active" @endif data-slide-to="{{$i}}">
                        </li>
                        @endfor
                </ol>
                <div class="carousel-inner">
                    @for($i = 0; $i < count($auctionImages); $i++) <div class="carousel-item @if($i==0) active @endif">
                        <img src="{{$auctionImages[$i]["file_name"]}}" class="d-block" alt="...">
                </div>
                @endfor
            </div>
            @if(count($auctionImages) > 1)
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </a>
            @endif
        </div>
        <div class="my-4 auction-details">
            <h4>Omschrijving</h4>
            <hr>
            <p>{!! nl2br($auction->description) !!}</p>
            <h4>Gegevens</h4>
            <hr>
            <p>
                Land: {{$auction->getCountry()}}<br />
                Plaats: {{$auction->city}}
                @foreach($auction->getSeller()->getPhoneNumbers() as $phoneNumber)
                <br />Telefoonnummer: {{$phoneNumber["phone_number"]}}<br />
                @endforeach
            </p>
            <h4>Betaling</h4>
            <hr>
            <p>
                @if($auction->payment_instruction!==null && !empty($auction->payment_instruction))
                Betalingsinstructies:<br />
                {{$auction->payment_instruction}}<br /><br />
                @endif
                De verkoper accepteert de volgende betalingsmethoden:<br />
            <ul>
                @foreach($auction->getPaymentMethods() as $paymentMethod)
                <li>{{$paymentMethod["method"]}}</li>
                @endforeach
            </ul>
            </p>
            <h4>Verzending</h4>
            <hr>
            <p>
                De verkoper accepteert de volgende verzendmethoden:<br />
            <ul>
                @foreach($auction->getShippingMethods() as $shippingMethod)
                <li>{{$shippingMethod["method"]}}: &euro;{{$shippingMethod["price"]}}</li>
                @endforeach
            </ul>
            </p>
        </div>
    </div>
    <div class="col-lg-5 col-xl-4 offset-xl-1">

        <div class="auction-card mb-5">
            @if(!Session::has('user'))
            <div class="bid-overlay">
                <div class="card-head flex-centered">
                    <h4>
                        @if(\Carbon\Carbon::now() >= \Carbon\Carbon::parse($auction->end_datetime))
                        Afgelopen
                        @else
                        <span class="ea-live-time" ea-live-time-big="true" ea-date="{{$auction->end_datetime}}">
                            Sluit over {{$auction->getTimeLeft()}}
                        </span>
                        @endif
                    </h4>
                </div>
                <div class="bid-overlay-body">
                    <h3 class="flex-centered">Ook mee bieden?</h3>
                    <div class="flex-centered">
                        <a href="{{ route('login') }}" class="btn btn-primary">
                            Log in en bied mee
                        </a>
                    </div>
                    @if (Route::has('register'))
                    <a class="flex-centered" href="{{ route('register') }}">Ik heb geen account</a>
                    @endif
                </div>
            </div>
            @endif
            <div class="auction-card-head flex-centered">
                <h4>
                    @if(\Carbon\Carbon::now() >= \Carbon\Carbon::parse($auction->end_datetime))
                    Afgelopen
                    @else
                    <span class="ea-live-time" ea-live-time-big="true" ea-date="{{$auction->end_datetime}}">
                        Sluit over {{$auction->getTimeLeft()}}
                    </span>
                    @endif
                </h4>
            </div>
            <div class="auction-card-body">
                <i class="fas fa-user profile-picture"></i>
                {{$auction->getSeller()->first_name}} {{$auction->getSeller()->last_name}}
                <p><i>Lid sinds {{date('d-m-Y', strtotime($auction->getSeller()->created_at))}}</i></p>

                <div class="my-3">
                    <a class="btn btn-outline-primary" @if(Session::has('user')) href="mailto:{{$auction->getSeller()->email}}">
                        @endif
                        <i class="fas fa-envelope"></i> Bericht
                    </a>
                    @if(count($auction->getSeller()->getPhoneNumbers()) > 0)
                    <a class="btn btn-primary" @if(Session::has('user')) href="tel:{{$auction->getSeller()->getPhoneNumbers()[0]["phone_number"]}}">
                        @endif
                        <i class="fas fa-phone-alt"></i> Neem contact op!
                    </a>
                    @endif

                </div>

            </div>
            <ul class="list-group">
                <li class="list-group-item text-center">
                    <div class="fw-bold">
                        Huidig bod: &euro;<span id="auction-current-bid">{{$auction->getLatestBid()}}</span>
                    </div>
                    <div>
                        <small>Startbod: &euro;{{$auction->start_price}}</small>
                    </div>
                </li>
            </ul>
            <div class="auction-card-body">
                <label for="Bieden" class="form-label fw-bold">Plaats bod</label>
                <div class="input-group mb-3">
                    <input type="hidden" id="auction-id" value="{{$auction->id}}" />
                    <input type="number" class="form-control" id="text-bid" aria-describedby="Plaats bod" value="{{$auction->getLatestBid()+$auction->getIncrement()}}">
                    <button id="btn-bid" type="submit" class="btn btn-primary">Bied</button>
                </div>
                <div class="alert alert-success d-none" role="alert" id="alert-success">
                    <span class="success" id="success" style="margin-top:10px; margin-bottom: 10px;"></span>
                </div>
                <div class="alert alert-danger d-none" role="alert" id="alert-danger">
                    <span class="error" id="error" style="margin-top:10px; margin-bottom: 10px;"></span>
                </div>
                <hr>
                <p class="fw-bold">Vorige bieders</p>
                <ul class="list-group" style="max-height: 200px; overflow-y: scroll" id="last-five-bids-list">
                    {!! $auction->getLastNBidsHTML(5) !!}
                </ul>

            </div>
        </div>
        <!-- RATINGS -->
        <div class="auction-card mb-5">
            <div class="flex-centered auction-card-head">
                <h4>Beoordelingen</h4>
            </div>
            <div class="auction-card-body ">
                <div class="flex-centered">
                    <div class="stars">
                        @if($reviewsData["average"] > 0) <i class="fas fa-star"></i> @endif
                        @if($reviewsData["average"] > 1) <i class="fas fa-star"></i> @endif
                        @if($reviewsData["average"] > 2) <i class="fas fa-star"></i> @endif
                        @if($reviewsData["average"] > 3) <i class="fas fa-star"></i> @endif
                        @if($reviewsData["average"] > 4) <i class="fas fa-star"></i> @endif
                        {{$reviewsData["average"]}} van de 5
                    </div>
                </div>
                <div class="flex-centered my-3">
                    <i>{{$reviewsData["count"]}} {{$reviewsData["count"]==1 ? "beoordeling" : "beoordelingen"}}</i>
                </div>

                <div class="flex-centered"><span class="auction-star-text">5 sterren</span>
                    <div class="rating-bar-empty">
                        <div class="rating-bar-filled" style="width:{{$reviewsData["fiveStars"]}};"></div>
                    </div>
                    {{$reviewsData["fiveStars"]}}
                </div>
                <div class="flex-centered"><span class="auction-star-text">4 sterren</span>
                    <div class="rating-bar-empty">
                        <div class="rating-bar-filled" style="width:{{$reviewsData["fourStars"]}};"></div>
                    </div>
                    {{$reviewsData["fourStars"]}}
                </div>
                <div class="flex-centered"><span class="auction-star-text">3 sterren</span>
                    <div class="rating-bar-empty">
                        <div class="rating-bar-filled" style="width:{{$reviewsData["threeStars"]}};"></div>
                    </div>
                    {{$reviewsData["threeStars"]}}
                </div>
                <div class="flex-centered"><span class="auction-star-text">2 sterren</span>
                    <div class="rating-bar-empty">
                        <div class="rating-bar-filled" style="width:{{$reviewsData["twoStars"]}};"></div>
                    </div>
                    {{$reviewsData["twoStars"]}}
                </div>
                <div class="flex-centered"><span class="auction-star-text">1 ster</span>
                    <div class="rating-bar-empty">
                        <div class="rating-bar-filled" style="width:{{$reviewsData["oneStars"]}};"></div>
                    </div>
                    {{$reviewsData["oneStars"]}}
                </div>

            </div>
        </div>
    </div>
</div>
</div>

@endsection
