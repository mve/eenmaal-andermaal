@extends('layouts.app')

@section('content')

    <div class="container pt-4">
        @foreach($allAuctions as $category)
            @if(count($category["auctions"]))
                @include("includes.auctionsrow", [
                        "title" => $category["name"],
                        "auctions" =>$category["auctions"],
                        "large" => true
                ])
            @else
                <h2>{{$category["name"]}}</h2>
                <p class="py-4">Geen veilingen gevonden</p>
            @endif
        @endforeach
    </div>

@endsection
