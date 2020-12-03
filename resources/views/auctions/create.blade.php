@extends('layouts.app')

@section('content')

    <div class="container">
        <h2 class="text-center my-4">Veiling maken</h2>


        <div class="card my-3">
            <div class="card-body">
                <form class="make-auction" method="POST" action="#">
                    @csrf

                    <div class="row">

                        <h3>Wat wil je veilen?</h3>

                        <div class="mb-3 col-md-12">
                            <label for="name" class="form-label">Vul een titel in</label>
                            <input type="text" class="form-control" id="name">
                        </div>


                        <label for="name" class="form-label">Kies een rubriek</label>
                        <div class="mb-3 col-md-4">
                            <select class="form-select" aria-label="Default select example">
                                <option selected>Kies groep</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-4">
                            <select class="form-select" aria-label="Default select example">
                                <option selected>Kies subgroep</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-4">
                            <select class="form-select" aria-label="Default select example">
                                <option selected>Kies subgroep</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>


                        <h3 class="my-3">Details</h3>

                        <label for="formFile" class="form-label">Foto's</label>
                        <i>plaats hier de foto's van je product</i>
                        <div class="mb-3 col-md-3">
                            <input class="form-control" type="file" id="formFile">
                        </div>
                        <div class="mb-3 col-md-3">
                            <input class="form-control" type="file" id="formFile">
                        </div>
                        <div class="mb-3 col-md-3">
                            <input class="form-control" type="file" id="formFile">
                        </div>
                        <div class="mb-3 col-md-3">
                            <input class="form-control" type="file" id="formFile">
                        </div>
                        <label for="exampleFormControlTextarea1" class="form-label">Omschrijving</label>
                        <i>geef hier een omschrijving van je product</i>
                        <div class="mb-3 col-md-12">
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>
                        <label for="exampleFormControlTextarea1" class="form-label">Gegevens</label>
                        <i>vul hier extra gegevens in over het product</i>
                        <div class="mb-3 col-md-12">
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>

                        <h3 class="my-3">Betaling</h3>

                        <div class="col-md-3">
                            <label for="name" class="form-label">Prijs</label>
                            <div class="input-group mb-3 ">
                                <span class="input-group-text">€</span>
                                <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                                <span class="input-group-text">.00</span>
                            </div>
                        </div>


                        <div class="mb-3 col-md-4">
                            <label for="name" class="form-label">Betaalmethodes</label>
                            <select class="form-select" aria-label="Default select example">
                                <option selected>Kies methode</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>

                        <h3 class="my-3">Levering</h3>

                        <div class="mb-3 col-md-4">
                            <label for="name" class="form-label">Levering</label>
                            <select class="form-select" aria-label="Default select example">
                                <option selected>Kies Methode</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Veiling aanmaken</button>
                </form>
            </div>
        </div>
    </div>

@endsection
