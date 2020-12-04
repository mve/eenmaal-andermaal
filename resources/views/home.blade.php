@extends('layouts.app')

@section('content')

    <div id="category-container-parent">
        <div class="container">
            <div class="row category-container">
                @php(\App\Category::getCategories())
            </div>
        </div>
    </div>

    <div id="category-container-copy">&nbsp;</div>

    <div class="hero-section">
        <h1 class="title text-white text-center">
            <i class="fas fa-gavel"></i> Eenmaal Andermaal
        </h1>
    </div>

    <div class="container pt-4">
        @include("includes.auctionsrow", [
                "title" => "Uitgelichte veilingen",
                "auctions" =>$popularAuctions ?? ''
            ])

        @foreach($personalAuctions as $category)
            @include("includes.auctionsrow", [
                    "title" => $category["name"],
                    "auctions" =>$category["auctions"]
            ])
        @endforeach

        @foreach($topCategoryAuctions as $topCAKey => $topCAValue)
                @include("includes.auctionsrow", [
                    "title" => "$topCAKey",
                    "auctions" => $topCAValue
                ])
        @endforeach
    </div>


@endsection
