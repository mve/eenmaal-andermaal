@extends('layouts.app')

@section('content')

    <div class="container pt-4">
        <h2>Gewonnen veilingen</h2>
        @if(count($auctions))

            <div class="row py-4">

                @if(Session::has("success"))
                    <div class="alert alert-success" role="alert" id="alert-success">
                        <span class="success" id="success" style="margin-top:10px; margin-bottom: 10px;">{!! Session::get("success") !!}</span>
                    </div>
                @endif

                @if(Session::has("error"))
                    <div class="alert alert-danger" role="alert" id="alert-danger">
                        <span class="error" id="error" style="margin-top:10px; margin-bottom: 10px;">{!! Session::get("error") !!}</span>
                    </div>
                @endif

                @foreach($auctions as $auction)
                    <div class="col-lg-3 col-md-6 mb-4 no-link">
                        <div class="hover-effect auction-card">
                            <a href="{{route("auctions.show",$auction->id)}}" class="no-link">
                                <div class="auction-card-image" style="background-image: url('{{$auction->getFirstImage()}}');">
                                </div>
                            </a>
                            <div class="auction-card-body">
                                <a href="{{route("auctions.show",$auction->id)}}" class="no-link">
                                    <h4>{{$auction->title}}</h4>

                                    <div class="flex-centered">
                                        <div class="auction-card-data">€ {{$auction->getLatestBid()}}</div>
                                    </div>
                                </a>


                                <div class="flex-centered mt-2">
                                    <a href="{{route("beoordeling.toevoegen", ["id"=>$auction->id])}}" class="btn btn-outline-primary">
                                        Beoordeling plaatsen
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

        @else
            <p class="py-4">Geen veilingen gevonden</p>
        @endif
    </div>

@endsection
