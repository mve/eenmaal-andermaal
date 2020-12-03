@extends('layouts.app')

@section('content')

    <div class="container">

        <div>
            Filters:

            <form method="post" action="/categorie/{{$category->id}}">
                @csrf

                <div class="mb-3">
                    <label for="inputMinPrice" class="form-label">Minimale prijs</label>
                    <input name="inputMinPrice" type="number" class="form-control" id="inputMinPrice" value="{{$filters['minPrice']}}">
                </div>

                <div class="mb-3">
                    <label for="inputMaxPrice" class="form-label">Maximale prijs</label>
                    <input name="inputMaxPrice" type="number" class="form-control" id="inputMaxPrice" value="{{$filters['maxPrice']}}">
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
