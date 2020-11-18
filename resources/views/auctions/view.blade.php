@extends('layouts.app')

@section('content')
    <div class="mb-5"></div>

    <div class="container">
        <h2>TITEL VAN VEILING ITEM</h2>
        <div class="row">
            <div class="col-sm-8">

                <!-- CAROUSEL SLIDER -->
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="../images/unsplash-ferrari.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="../images/unsplash-ferrari.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="../images/unsplash-ferrari.jpg" class="d-block w-100" alt="...">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </a>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-6">
                        <h6>Verkoper</h6>
                        <div class="info-content d-flex align-items-center">
                            <i class="fas fa-user profile-picture"></i>
                            <a href="#">Verkopersnaam</a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <h6>Verzending</h6>
                        <div class="info-content d-flex align-items-center">
                            <p>afhalen graag</p>
                        </div>
                    </div>
                </div>
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="omschrijving-head">
                            <button class="accordion-button" type="button" data-toggle="collapse" data-target="#omschrijving" aria-expanded="true" aria-controls="omschrijving">
                                Omschrijving
                            </button>
                        </h2>
                        <div id="omschrijving" class="accordion-collapse collapse show" aria-labelledby="omschrijving-head" data-parent="#accordionExample">
                            <div class="accordion-body">
                                <strong>This is the first item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="gegevens-head">
                            <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#gegevens" aria-expanded="false" aria-controls="gegevens">
                                Gegevens
                            </button>
                        </h2>
                        <div id="gegevens" class="accordion-collapse collapse" aria-labelledby="gegevens-head" data-parent="#accordionExample">
                            <div class="accordion-body">
                                <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="verzending-head">
                            <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#verzending" aria-expanded="false" aria-controls="verzending">
                                Verzending
                            </button>
                        </h2>
                        <div id="verzending" class="accordion-collapse collapse" aria-labelledby="verzending-head" data-parent="#accordionExample">
                            <div class="accordion-body">
                                <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="auction-card">
                    <div class="auction-card-head flex-centered">
                        <h4>Sluit over 5d 8u 15m 9s</h4>
                    </div>

                    <ul class="list-group">
                        <li class="list-group-item flex-centered"><strong>Startbod: €100.000.</strong></li>
                        <li class="list-group-item flex-centered"><strong>Huidig bod: 120.000</strong></li>
                    </ul>
                    <div class="auction-card-body">
                        <label for="Bieden" class="form-label">Plaats bod</label>
                        <div class="input-group">

                            <input type="number" class="form-control" id="Bieden" aria-describedby="Plaats bod" value="125000">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
