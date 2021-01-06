@extends('layouts.app')

@section('content')

    <div class="container pt-4">
        @include("includes.auctionsrow", [
                            "title" => "Geboden veilingen",
                            "auctions" =>$auctions,
                            "large" => false
                            ])
        @if(!count($auctions))

            <div class="alert alert-primary mb-5" role="alert">
                U heeft nog niet geboden op een veiling.
            </div>

        @endif
    </div>

@endsection
