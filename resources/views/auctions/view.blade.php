@extends('layouts.app')

@section('content')
    <div class="mb-5"></div>

    <div class="container">
        <h2>{{$auction->title}}</h2>
        <div class="row">
            <div class="col-lg-7 col-xl-8">
                <!-- CAROUSEL SLIDER -->
                <div id="carouselExampleIndicators" class="carousel slide " data-ride="carousel">
                    <ol class="carousel-indicators">
                        @for($i = 0; $i < count($auctionImages); $i++)
                            <li data-target="#carouselExampleIndicators" @if($i==0) class="active" @endif data-slide-to="{{$i}}"></li>
                        @endfor
                    </ol>
                    <div class="carousel-inner">
                        @for($i = 0; $i < count($auctionImages); $i++)
                            <div class="carousel-item @if($i==0) active @endif">
                                <img src="{{$auctionImages[$i]["file_name"]}}" class="d-block w-100" alt="...">
                            </div>
                        @endfor
                    </div>
                    @if(count($auctionImages) > 1)
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                           data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                           data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </a>
                    @endif
                </div>
                <div class="my-4">
                    <h4>Omschrijving</h4>
                    <hr>
                    <p>{{nl2br($auction->description)}}</p>
                    <h4>Gegevens</h4>
                    <hr>
                    <p>
                        Land: {{$auction->getCountry()}}<br/>
                        Plaats: {{$auction->city}}
                        @foreach($auction->getSeller()->getPhoneNumbers() as $phoneNumber)
                            <br/>Telefoonnummer: {{$phoneNumber["phone_number"]}}<br/>
                        @endforeach
                    </p>
                    <h4>Betaling</h4>
                    <hr>
                    <p>
                        @if($auction->payment_instruction!==null && !empty($auction->payment_instruction))
                            Betalingsinstructies:<br/>
                            {{$auction->payment_instruction}}<br/><br/>
                        @endif
                        De verkoper accepteert de volgende betalingsmethoden:<br/>
                        @foreach($auction->getPaymentMethods() as $paymentMethod)
                            {{$paymentMethod["method"]}}<br/>
                        @endforeach
                    </p>
                    <h4>Verzending</h4>
                    <hr>
                    <p>
                        De verkoper accepteert de volgende verzendmethoden:<br/>
                        @foreach($auction->getShippingMethods() as $shippingMethod)
                            {{$shippingMethod["method"]}}:
                            &euro;{{$shippingMethod["price"]}}<br/>
                        @endforeach
                    </p>
                </div>
            </div>
            <div class="col-lg-5 col-xl-4">

                <div class="auction-card mb-5">
                    @if(!Session::has('user'))
                        <div class="bid-overlay">
                            <div class="card-head flex-centered">
                                <h4>Sluit over {{$auction->getTimeLeft()}}</h4>
                            </div>
                            <div class="bid-overlay-body">
                                <h3 class="flex-centered">Ook mee bieden?</h3>
                                <div class="flex-centered">
                                    <a href="{{ route('login') }}"  class="btn btn-primary">
                                        Log in en bied mee
                                    </a>
                                </div>
                                @if (Route::has('register'))
                                    <a class="flex-centered" href="{{ route('register') }}">ik heb geen account</a>
                                @endif
                            </div>
                        </div>
                    @endif
                    <div class="auction-card-head flex-centered">
                        <h4>Sluit over {{$auction->getTimeLeft()}}</h4>
                    </div>
                    <div class="auction-card-body">
                        <i class="fas fa-user profile-picture"></i>
                        <a href="#">{{$auction->getSeller()->first_name}} {{$auction->getSeller()->last_name}}</a>
                        <div class="my-3">
                            <div class="btn btn-outline-primary">
                                <i class="fas fa-envelope"></i> Bericht
                            </div>
                            @if(count($auction->getSeller()->getPhoneNumbers()) > 0)
                                <a class="btn btn-primary" href="tel:{{$auction->getSeller()->getPhoneNumbers()[0]["phone_number"]}}">
                                    <i class="fas fa-phone-alt"></i> Neem contact op!
                                </a>
                            @endif
                        </div>

                    </div>
                    <ul class="list-group">
                        <li class="list-group-item flex-centered"><strong>Startbod: &euro;{{$auction->start_price}}</strong></li>
                        <li class="list-group-item flex-centered"><strong>Huidig bod: &euro;{{$auction->getLatestBid()}}</strong></li>
                    </ul>
                    <div class="auction-card-body">
                        <label for="Bieden" class="form-label fw-bold">Plaats bod</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="Bieden" aria-describedby="Plaats bod"
                                   value="{{$auction->getLatestBid()+1}}">
                            <button type="submit" class="btn btn-primary">Bied</button>
                        </div>

                        <hr>
                        <p class="fw-bold">Vorige bieders</p>
                        <ul class="list-group" style="max-height: 200px; overflow-y: scroll">
                            @if(count($auctionBids))
                                @foreach($auctionBids as $bid)
                                    <li class="list-group-item flex-centered"><strong>{{$bid->getBidder()->first_name}}: &euro;{{$bid->amount}}</strong></li>
                                @endforeach
                            @else
                                <li class="list-group-item flex-centered"><strong>Er is nog niet geboden</strong></li>
                            @endif
                        </ul>

                    </div>
                </div>
                <!-- RATINGS -->
                <div class="auction-card">
                    <div class="flex-centered auction-card-head">
                        <h4>Beoordelingen</h4>
                    </div>
                    <div class="auction-card-body ">
                        <div class="flex-centered">
                            <div class="stars">
                                @if($auctionReviewAverage > 0) <i class="fas fa-star"></i> @endif
                                @if($auctionReviewAverage > 1) <i class="fas fa-star"></i> @endif
                                @if($auctionReviewAverage > 2) <i class="fas fa-star"></i> @endif
                                @if($auctionReviewAverage > 3) <i class="fas fa-star"></i> @endif
                                @if($auctionReviewAverage > 4) <i class="fas fa-star"></i> @endif
                                {{$auctionReviewAverage}} van de 5
                            </div>
                        </div>
                        <div class="flex-centered my-3">
                            <i>{{count($auction->getReviews())}} beoordelingen</i>
                        </div>

                        <div class="flex-centered">Positief
                            <div class="rating-bar-empty">
                                <div class="rating-bar-filled" style="width:{{$auctionReviewsPositivePercent}};"></div>
                            </div>
                            {{$auctionReviewsPositivePercent}}
                        </div>
                        <div class="flex-centered">Negatief
                            <div class="rating-bar-empty">
                                <div class="rating-bar-filled" style="width:{{$auctionReviewsNegativePercent}};"></div>
                            </div>
                            {{$auctionReviewsNegativePercent}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
