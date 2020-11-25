@extends('layouts.app')

@section('content')

    <div class="hero-section">
        <h1 class="title text-white text-center">
            <i class="fas fa-gavel"></i> Eenmaal Andermaal
        </h1>
    </div>

    <div class="container pt-4">
{{--@php(dd($personalAuctions))--}}
        @include("includes.auctionsrow", [
                "title" => "Uitgelichte veilingen",
                "auctions" =>$popularAuctions
            ])

        @foreach($personalAuctions as $category)
            @include("includes.auctionsrow", [
                    "title" => $category["name"],
                    "auctions" =>$category["auctions"]
            ])
        @endforeach

    </div>

@endsection
