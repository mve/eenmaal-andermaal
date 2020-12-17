@extends('layouts.app')

@section('content')

    <div id="category-container-parent">
        <div class="container">
            <div class="row category-container">
                @php(print($categoryMenuHTML))
            </div>
        </div>
    </div>


    <div id="category-container-copy">&nbsp;</div>
    <script>document.querySelector("#category-container-copy").style.height = document.querySelector("#category-container-parent").offsetHeight + "px";</script>

    <div class="hero-section">
        <h1 class="title text-white text-center">
            <i class="fas fa-gavel"></i> Eenmaal Andermaal
        </h1>
    </div>

    <div class="container pt-4">
        @include("includes.auctionsrow", [
                "title" => "Populaire veilingen",
                "auctions" =>$popularAuctions,
                "large" => false

            ])

        @include("includes.auctionsrow", [
                "title" => "Recent toegevoegd",
                "auctions" =>$recentlyAddedAuctions,
                "large" => false

            ])

        @foreach($personalAuctions as $category)
            @include("includes.auctionsrow", [
                    "title" => $category["name"],
                    "auctions" =>$category["auctions"],
                    "large" => false
            ])
        @endforeach

        @foreach($topCategoryAuctions as $topCAKey => $topCAValue)
            @include("includes.auctionsrow", [
                "title" => "$topCAKey",
                "auctions" => $topCAValue,
                "large" => false
            ])
        @endforeach
    </div>


@endsection
