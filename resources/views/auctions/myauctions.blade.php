@extends('layouts.app')

@section('content')

    <div class="container pt-4">
        @if(Session::has("success"))
            <div class="alert alert-success" role="alert" id="alert-success">
                <span class="success" id="success" style="margin-top:10px; margin-bottom: 10px;">{{Session::get("success")}}</span>
            </div>
        @endif

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
