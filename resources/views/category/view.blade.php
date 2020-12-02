@extends('layouts.app')

@section('content')

    <div class="container">

        @include("includes.auctionsrow", [
            "title" => $category->name,
            "auctions" =>$auctions
        ])

    </div>



@endsection
