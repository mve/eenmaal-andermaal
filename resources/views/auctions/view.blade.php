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
				@if(isset($auction->city))
                Plaats: {{$auction->city}}
				@endif
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

				@if(count($auction->getPaymentMethods()) > 0)
				De verkoper accepteert de volgende betalingsmethoden:<br />
            	<ul>
                @foreach($auction->getPaymentMethods() as $paymentMethod)
                <li>{{$paymentMethod["method"]}}</li>
                @endforeach
            	</ul>
				@endif
            </p>
			@if(count($auction->getShippingMethods()) > 0)
            <h4>Verzending</h4>
            <hr>
            <p>
                De verkoper accepteert de volgende verzendmethoden:<br />
            <ul>
                @foreach($auction->getShippingMethods() as $shippingMethod)
                <li>{{$shippingMethod["method"]}}</li>
                @endforeach
            </ul>
            </p>
			@endif
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

				@if (Session::has('user') && $auction->user_id != Session::get('user')->id)
                <div class="my-3">
                    <button class="btn btn-outline-primary" id="bericht"><i class="fas fa-envelope"></i> Bericht</button>
                    @if(count($auction->getSeller()->getPhoneNumbers()) > 0)
                    <a class="btn btn-primary" @if(Session::has('user')) href="tel:{{$auction->getSeller()->getPhoneNumbers()[0]["phone_number"]}}">
                        @endif
                        <i class="fas fa-phone-alt"></i> Neem contact op!
                    </a>
                    @endif
                </div>
				@endif
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
				@if (Session::has('user') && $auction->user_id != Session::get('user')->id)
                <label for="Bieden" class="form-label fw-bold">Plaats bod</label>
                <div class="input-group mb-3">
                    <input type="hidden" id="auction-id" value="{{$auction->id}}" />
                    <input type="number" class="form-control" id="text-bid" aria-describedby="Plaats bod" value="{{number_format($auction->getLatestBid()+$auction->getIncrement(), 2)}}">
                    <button id="btn-bid" type="submit" class="btn btn-primary">Bied</button>
                </div>
                <div class="alert alert-success d-none" role="alert" id="alert-success">
                    <span class="success" id="success" style="margin-top:10px; margin-bottom: 10px;"></span>
                </div>
                <div class="alert alert-danger d-none" role="alert" id="alert-danger">
                    <span class="error" id="error" style="margin-top:10px; margin-bottom: 10px;"></span>
                </div>
                <hr>
				@endif
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
                    <span class="auction-star-percentage">{{$reviewsData["fiveStars"]}}</span>
                </div>
                <div class="flex-centered"><span class="auction-star-text">4 sterren</span>
                    <div class="rating-bar-empty">
                        <div class="rating-bar-filled" style="width:{{$reviewsData["fourStars"]}};"></div>
                    </div>
                    <span class="auction-star-percentage">{{$reviewsData["fourStars"]}}</span>
                </div>
                <div class="flex-centered"><span class="auction-star-text">3 sterren</span>
                    <div class="rating-bar-empty">
                        <div class="rating-bar-filled" style="width:{{$reviewsData["threeStars"]}};"></div>
                    </div>
                    <span class="auction-star-percentage">{{$reviewsData["threeStars"]}}</span>
                </div>
                <div class="flex-centered"><span class="auction-star-text">2 sterren</span>
                    <div class="rating-bar-empty">
                        <div class="rating-bar-filled" style="width:{{$reviewsData["twoStars"]}};"></div>
                    </div>
                    <span class="auction-star-percentage">{{$reviewsData["twoStars"]}}</span>
                </div>
                <div class="flex-centered"><span class="auction-star-text">1 ster</span>
                    <div class="rating-bar-empty">
                        <div class="rating-bar-filled" style="width:{{$reviewsData["oneStars"]}};"></div>
                    </div>
                    <span class="auction-star-percentage">{{$reviewsData["oneStars"]}}</span>
                </div>

            </div>
        </div>
    </div>
</div>
</div>

<div id="backdrop" class="d-none">
    <div class="modal" id="exampleModalCenter" role="dialog" aria-labelledby="exampleModalCenterTitle">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content rounded-5">
                <div class="modal-header text-center">
                    <h5 class="modal-title float-center" id="exampleModalLongTitle">Bericht versturen aan {{$auction->getSeller()->first_name}} {{$auction->getSeller()->last_name}}</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('messages.send') }}">
                        @csrf
                        <div class="form-group row mb-2">
                            <div class="mb-3 col-md-12">
                                <textarea name="message" class="form-control @error('message') is-invalid @enderror" id="exampleFormControlTextarea1" rows="3" maxlength="250" placeholder="Schrijf hier uw bericht..." required></textarea>
                                <span id="limit-message-length" class="text-right float-right">Maximaal 250 tekens: 0/250</span>
                            </div>
                            @error('message')
                            <span class="invalid-feedback" style="display: block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <input type="hidden" name="auctionId" value="{{$auction->id}}">
                        </div>
                </div>
                <div class="modal-footer">
                    <span class="btn btn-danger text-light" onclick="toggleModal()">Annuleren</span>
                    <input type="submit" value="Versturen" name="send" class="btn btn-primary">
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
</div>

<script>
    function toggleModal() {
        var backdrop = document.getElementById("backdrop");
        var modal = document.getElementById("exampleModalCenter");

        if (backdrop.classList.contains('d-none')) {
            // Modal is not visible
            backdrop.classList.remove('d-none');
            modal.style.display = "block";
        } else {
            // Modal is visible
            backdrop.classList.add('d-none');
            modal.style.display = "none";
        }
    }

    document.getElementById("bericht").addEventListener("click", (event) => {
        toggleModal();
    })

    function changeLimit(textElement, textLimitElement, limit) {
        textLimitElement.innerHTML = 'Maximaal ' + limit + ' tekens: ' + textElement.value.length + '/' + limit;
    }

    var description = document.getElementsByName('message')[0];
    var descLimit = document.getElementById('limit-message-length');
    description.addEventListener('keyup', e => {
        changeLimit(description, descLimit, description.maxLength);
    });
</script>

@endsection
