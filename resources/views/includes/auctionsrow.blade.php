<h2>{{$title}}</h2>

<div class="row py-4">

    @foreach($auctions as $auction)
        <a href="{{route("auctions.show",$auction->id)}}" class="@if($large) col-lg-4 @else col-lg-3 @endif col-md-6 mb-4 no-link">
            <div class="hover-effect auction-card @if(Session::has("user") && Session::get("user")->id===$auction->user_id) auction-card-mine @endif">
                @if(Session::has("user") && Session::get("user")->id===$auction->user_id)
                    <div class="mine"><i class="fas fa-user"></i></div>
                @endif
                <div class="auction-card-image" style="background-image: url('{{$auction->getFirstImage()}}');">
                </div>
                <div class="auction-card-body">
                    <h4>{{$auction->title}}</h4>
                    <h5><i class="fas fa-map-marker-alt"></i> {{$auction->getSeller()->city}}</h5>

                    <div class="flex-centered">
                        <div class="auction-card-data">€ {{$auction->getLatestBid()}}</div>
                        <div class="auction-card-data">{{$auction->getTimeLeft()}}</div>
                    </div>


                    <div class="flex-centered mt-2">
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
        </a>
    @endforeach

</div>
