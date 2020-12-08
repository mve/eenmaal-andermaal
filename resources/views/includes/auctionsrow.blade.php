<h2>{{$title}}</h2>

<div class="row py-4">

    @foreach($auctions as $auction)
        <a href="{{route("auctions.show",$auction->id)}}" class="@if($large) col-lg-4 @else col-lg-3 @endif col-md-6 mb-4 no-link">
            <div class="auction-card hover-effect">
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
                            Bieden
                        </div>
                    </div>

                </div>
            </div>
        </a>
    @endforeach

</div>
