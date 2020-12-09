@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row not-found">


            <h2 class="text-center my-3">Helaas geen resultaten voor: "testdata"</h2>

            <p class="text-center" >Sorry, uw zoekopdracht heeft helaas niks opgeleverd, probeer het nogmaals met andere zoekwoorden.</p>

            <div class="my-5 offset-md-3 col-md-6">
                <div class="input-group ">
                    <input type="text" class="form-control" placeholder="Zoeken...">
                    <button id="btn-search" type="submit" class="btn btn-light"><i class="fas fa-search"></i></button>
                </div>
            </div>

        </div>
    </div>

@endsection
