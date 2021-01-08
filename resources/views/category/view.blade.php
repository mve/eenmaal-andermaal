@extends('layouts.app')

@section('content')
    <div class="mb-4"></div>

    {{\App\Breadcrumbs::createAndPrint($category, 5)}}

    <div class="container">

        <div class="row py-4">

            <div class="col-md-2">
                <h2>Filters</h2>

                <form method="post" action="/categorie/{{$category->id}}">
                    @csrf

                    <div class="mb-3">
                        <label for="inputMinPrice" class="form-label">Minimale prijs</label>
                        <input name="inputMinPrice" type="number" class="form-control" id="inputMinPrice"
                               value="{{$filters['minPrice']}}">
                    </div>

                    <div class="mb-3">
                        <label for="inputMaxPrice" class="form-label">Maximale prijs</label>
                        <input name="inputMaxPrice" type="number" class="form-control" id="inputMaxPrice"
                               value="{{$filters['maxPrice']}}">
                    </div>

                    @if (Session::has('user'))

                    <div class="mb-3">
                        <label for="inputMaxDistance" class="form-label">Maximale afstand (km)</label>
                        <input name="inputMaxDistance" type="number" class="form-control" id="inputMaxDistance"
                               value="{{$filters['maxDistance']}}">
                    </div>

                    @endif

                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>

            </div>

            <div class="col-md-10">
                @if(count($auctions))
                    @include("includes.auctionsrow", [
                        "title" => $category->name,
                        "auctions" => $auctions,
                        "large" => true
                    ])
                @else
                    <h2>{{$category->name}}</h2>
                    Geen veilingen gevonden
                @endif
            </div>

        </div>


    </div>



@endsection
