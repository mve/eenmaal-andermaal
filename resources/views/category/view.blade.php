@extends('layouts.app')

@section('content')

    <div class="container">

        <div>
            Filters:

            <form action="/categorie/{{$category->id}}">

                <div class="mb-3">
                    <label for="inputMinPrice" class="form-label">Minimale prijs</label>
                    <input type="number" class="form-control" id="inputMinPrice">
                </div>

                <div class="mb-3">
                    <label for="inputMaxPrice" class="form-label">Maximale prijs</label>
                    <input type="number" class="form-control" id="inputMaxPrice">
                </div>

                <button type="submit" class="btn btn-primary">Filter</button>
            </form>

        </div>

        @include("includes.auctionsrow", [
            "title" => $category->name,
            "auctions" =>$auctions
        ])

    </div>



@endsection
