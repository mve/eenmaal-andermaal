@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row py-3">

            <div class="my-5 offset-md-3 col-md-6">
                <div class="input-group ">
                    <input type="text" class="form-control" placeholder="Zoeken...">
                    <button id="btn-search" type="submit" class="btn btn-light"><i class="fas fa-search"></i></button>
                </div>
            </div>

            <h2 class="text-center my-3">Zoekresultaten voor: "testdata"</h2>

            <div class="search-item my-3 offset-md-2 col-md-8">
                <h3><a href="#">Testitem</a></h3>
                <p>omschrijving van item</p>
                <strong class="search-price">€ 45,00</strong>
            </div>
            <div class="search-item my-3 offset-md-2 col-md-8">
                <h3><a href="#">Testitem</a></h3>
                <p>omschrijving van item</p>
                <strong class="search-price">€ 45,00</strong>
            </div>
            <div class="search-item my-3 offset-md-2 col-md-8">
                <h3><a href="#">Testitem</a></h3>
                <p>omschrijving van item</p>
                <strong class="search-price">€ 45,00</strong>
            </div>
        </div>
    </div>

@endsection
