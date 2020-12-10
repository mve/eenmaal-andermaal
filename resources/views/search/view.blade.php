@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row py-3">
            @if (isset($auctions) && !empty($auctions))
                <h2 class="text-center my-3">Zoekresultaten voor: "@foreach ($keywords as $keyword) {{$keyword}} @endforeach"</h2>
                @foreach ($auctions as $auction)
                    <div class="search-item my-3 offset-md-2 col-md-8">
                    <h3><a href="{{ env('APP_URL') }}/auctions/{{$auction['id']}}">{{$auction['title']}}</a></h3>
                        <p>{{$auction['description']}}</p>
                        <strong class="search-price">{{$auction['start_price']}}</strong>
                    </div>
                @endforeach
            @elseif (isset($auctions) && empty($auctions))
            <h2 class="text-center my-3">Helaas geen resultaten voor: "@foreach ($keywords as $keyword) {{$keyword}} @endforeach"</h2>

            <p class="text-center" >Sorry, uw zoekopdracht heeft helaas niks opgeleverd, probeer het nogmaals met andere zoekwoorden.</p>
            @else
                <div class="not-found">
            <h2 class="text-center my-3">Je hebt geen zoekwoord of woorden gedefinitieerd</h2>

            <p class="text-center" >Vul een zoekwoord in om te zoeken.</p>
                </div>
            @endif
        </div>
    </div>

@endsection
