@extends('layouts.app')

@section('content')

    <div class="container py-3">
        @if (isset($auctions) && !empty($auctions))

            <h2 class="text-center my-3">Zoekresultaten voor: "{{implode(", ",$keywords)}}"</h2>

            @foreach ($auctions as $auction)

                <a href="{{route("auctions.show",$auction->id)}}" class="mb-4 no-link">

                    <div class="row hover-effect auction-card mb-4 auction-card--side">

                        <div class="col-md-3 img-fluid auction-card--side-image" style="background-image: url('{{$auction->getFirstImage()}}'); background-size: cover;"></div>

                        <div class="col-md-9 p-4 d-flex justify-content-between flex-column">

                            <div>
                                <h4 class="line-clamp-1" title="{{$auction->title}}">
                                    {{ $auction->title }}
                                </h4>

                                <p class="line-clamp-2">
                                    {{$auction->description}}
                                </p>
                            </div>

                            <div class="d-flex justify-content-between">

                                <div class="d-flex flex-md-row flex-column" style="flex: 1;">

                                    <h5 class="mr-3 text-nowrap">
                                        <i class="fas fa-map-marker-alt"></i> {{(empty($auction->city) ? "" : $auction->city . ", ") . $auction->country_code}}
                                    </h5>

                                    <div>
                                        @if(\Carbon\Carbon::now() >= \Carbon\Carbon::parse($auction->end_datetime))
                                            Afgelopen
                                        @else
                                            <span class="ea-live-time-big"
                                                  ea-date="{{$auction->end_datetime}}">Sluit over {{$auction->getTimeLeft()}}</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="d-flex flex-row justify-content-end align-items-center" style="flex: 1;">

                                    <div class="mr-3">
                                        <div class="auction-card-data">€ {{$auction->getLatestBid()}}</div>
                                    </div>

                                    <div class="btn btn-outline-primary">
                                        @if(\Carbon\Carbon::now() < \Carbon\Carbon::parse($auction->end_datetime))
                                            @if(Session::has("user") && Session::get("user")->id===$auction->user_id)
                                                Voortgang bekijken
                                            @else
                                                Bieden
                                            @endif
                                        @else
                                            Veiling bekijken
                                        @endif
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                </a>

            @endforeach

        @elseif (isset($auctions) && empty($auctions))
            <div class="not-found">
                <h2 class="text-center my-3">Helaas geen resultaten voor: "{{implode(", ",$keywords)}}"</h2>

                <p class="text-center">Sorry, uw zoekopdracht heeft helaas niks opgeleverd, probeer het nogmaals met
                    andere zoekwoorden.</p>
            </div>
        @else
            <div class="not-found">
                <h2 class="text-center my-3">Je hebt geen zoekwoord of woorden gedefinitieerd</h2>

                <p class="text-center">Vul een zoekwoord in om te zoeken.</p>
            </div>
        @endif

        @include("includes.pagination", $paginationData)

    </div>

@endsection
