@extends('layouts.app')

@section('content')

    <div class="container pt-4">
        @include("includes.auctionsrow", [
                            "title" => "Geboden veilingen",
                            "auctions" =>$auctions,
                            "large" => false
                            ])
        @if(!count($auctions))
            U heeft nog niet geboden op een veiling
        @endif
    </div>

@endsection
