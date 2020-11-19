@extends('layouts.app')

@section('content')
    <div class="mb-5"></div>

    <div class="container">
        <h2>TITEL VAN VEILING ITEM</h2>
        <div class="row">
            <div class="col-lg-7 col-xl-8">
                <!-- CAROUSEL SLIDER -->
                <div id="carouselExampleIndicators" class="carousel slide " data-ride="carousel">
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
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                       data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                       data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </a>
                </div>
                <div class="my-4">
                    <h4>Omschrijving</h4>
                    <hr>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dapibus condimentum dignissim.
                        Vivamus sodales enim sapien, sed dignissim nunc placerat eu. Fusce finibus malesuada justo a
                        laoreet. Aliquam condimentum convallis erat, et pharetra leo tempus sit amet. Ut at aliquam
                        lorem, nec bibendum metus. Vivamus ac sollicitudin lorem. Nunc feugiat feugiat sem. Etiam vel
                        eros eu sapien tincidunt pellentesque. Mauris finibus rutrum scelerisque. Fusce tempus quam
                        posuere enim congue congue. Mauris quis libero ut erat rutrum pretium. Mauris lectus neque,
                        mattis sit amet lacus eget, ultrices aliquam ligula. Quisque in tortor metus. Quisque et ex
                        pellentesque, porttitor tellus a, viverra diam.
                        Phasellus hendrerit nunc nec cursus tempor. Donec eu egestas metus, non sodales enim. Aliquam
                        erat volutpat. Pellentesque at convallis eros. Duis semper ante et euismod maximus. Mauris
                        aliquet elit massa. Pellentesque dictum, purus eget iaculis cursus, nisi mauris fringilla ipsum,
                        id pulvinar odio nulla et est. Aliquam iaculis nisi sit amet arcu vehicula, egestas convallis
                        nibh congue. In eu pharetra odio. Integer scelerisque eleifend pharetra. Mauris quis varius
                        nunc. Ut consectetur metus sed aliquam consequat. Quisque id lorem vitae elit lobortis fermentum
                        maximus vel elit. Curabitur quis velit sagittis, suscipit tortor eget, ultrices enim. Nulla
                        sodales pellentesque ex vitae vulputate.</p>
                    <h4>Gegevens</h4>
                    <hr>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dapibus condimentum dignissim.
                        Vivamus sodales enim sapien, sed dignissim nunc placerat eu. Fusce finibus malesuada justo a
                        laoreet. Aliquam condimentum convallis erat, et pharetra leo tempus sit amet. Ut at aliquam
                        lorem, nec bibendum metus. Vivamus ac sollicitudin lorem. Nunc feugiat feugiat sem. Etiam vel
                        eros eu sapien tincidunt pellentesque. Mauris finibus rutrum scelerisque. Fusce tempus quam
                        posuere enim congue congue. Mauris quis libero ut erat rutrum pretium. Mauris lectus neque,
                        mattis sit amet lacus eget, ultrices aliquam ligula. Quisque in tortor metus. Quisque et ex
                        pellentesque, porttitor tellus a, viverra diam.
                        Phasellus hendrerit nunc nec cursus tempor. Donec eu egestas metus, non sodales enim. Aliquam
                        erat volutpat. Pellentesque at convallis eros. Duis semper ante et euismod maximus. Mauris
                        aliquet elit massa. Pellentesque dictum, purus eget iaculis cursus, nisi mauris fringilla ipsum,
                        id pulvinar odio nulla et est. Aliquam iaculis nisi sit amet arcu vehicula, egestas convallis
                        nibh congue. In eu pharetra odio. Integer scelerisque eleifend pharetra. Mauris quis varius
                        nunc. Ut consectetur metus sed aliquam consequat. Quisque id lorem vitae elit lobortis fermentum
                        maximus vel elit. Curabitur quis velit sagittis, suscipit tortor eget, ultrices enim. Nulla
                        sodales pellentesque ex vitae vulputate.
                    </p>
                    <h4>Verzending</h4>
                    <hr>
                    <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer dapibus condimentum dignissim.
                        Vivamus sodales enim sapien, sed dignissim nunc placerat eu. Fusce finibus malesuada justo a
                        laoreet. Aliquam condimentum convallis erat, et pharetra leo tempus sit amet. Ut at aliquam
                        lorem, nec bibendum metus. Vivamus ac sollicitudin lorem. Nunc feugiat feugiat sem. Etiam vel
                        eros eu sapien tincidunt pellentesque. Mauris finibus rutrum scelerisque. Fusce tempus quam
                        posuere enim congue congue. Mauris quis libero ut erat rutrum pretium. Mauris lectus neque,
                        mattis sit amet lacus eget, ultrices aliquam ligula. Quisque in tortor metus. Quisque et ex
                        pellentesque, porttitor tellus a, viverra diam.
                        Phasellus hendrerit nunc nec cursus tempor. Donec eu egestas metus, non sodales enim. Aliquam
                        erat volutpat. Pellentesque at convallis eros. Duis semper ante et euismod maximus. Mauris
                        aliquet elit massa. Pellentesque dictum, purus eget iaculis cursus, nisi mauris fringilla ipsum,
                        id pulvinar odio nulla et est. Aliquam iaculis nisi sit amet arcu vehicula, egestas convallis
                        nibh congue. In eu pharetra odio. Integer scelerisque eleifend pharetra. Mauris quis varius
                        nunc. Ut consectetur metus sed aliquam consequat. Quisque id lorem vitae elit lobortis fermentum
                        maximus vel elit. Curabitur quis velit sagittis, suscipit tortor eget, ultrices enim. Nulla
                        sodales pellentesque ex vitae vulputate.
                    </p>
                </div>
            </div>
            <div class="col-lg-5 col-xl-4">
                <div class="auction-card mb-5">
                    <div class="auction-card-head flex-centered">
                        <h4>Sluit over 5d 8u 15m 9s</h4>
                    </div>
                    <div class="auction-card-body">
                        <i class="fas fa-user profile-picture"></i>
                        <a href="#">Verkopersnaam</a>
                        <div class="my-3">
                            <div class="btn btn-outline-primary">
                                <i class="fas fa-envelope"></i> Bericht
                            </div>
                            <div class="btn btn-primary">
                                <i class="fas fa-phone-alt"></i> Neem contact op!
                            </div>
                        </div>

                    </div>
                    <ul class="list-group">
                        <li class="list-group-item flex-centered"><strong>Startbod: €100.000</strong></li>
                        <li class="list-group-item flex-centered"><strong>Huidig bod: 120.000</strong></li>
                    </ul>
                    <div class="auction-card-body">
                        <label for="Bieden" class="form-label">Plaats bod</label>
                        <div class="input-group">

                            <input type="number" class="form-control" id="Bieden" aria-describedby="Plaats bod"
                                   value="125000">
                            <button type="submit" class="btn btn-primary">Bied</button>
                        </div>

                        <hr>
                        <p>vorige bieders</p>
                        <ul>
                            <li>persoon €120.000</li>
                            <li>persoon €115.000</li>
                            <li>persoon €110.000</li>
                            <li>persoon €105.000</li>
                        </ul>
                    </div>
                </div>
                <!-- RATINGS -->
                <div class="auction-card">
                    <div class="flex-centered auction-card-head">
                        <h4>Beoordelingen</h4>
                    </div>
                    <div class="auction-card-body ">
                        <div class="flex-centered">
                            <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            4.7 van de 5
                            </div>
                        </div>
                        <div class="flex-centered my-3">
                            <i>40 beoordelingen</i>
                        </div>

                            <div class="flex-centered">5 star <div class="rating-bar-empty"><div class="rating-bar-filled five-star"></div></div> 78%</div>
                            <div class="flex-centered">4 star <div class="rating-bar-empty"><div class="rating-bar-filled four-star"></div></div> 9%</div>
                            <div class="flex-centered">3 star <div class="rating-bar-empty"><div class="rating-bar-filled three-star"></div></div> 4%</div>
                            <div class="flex-centered">2 star <div class="rating-bar-empty"><div class="rating-bar-filled two-star"></div></div> 2%</div>
                            <div class="flex-centered">1 star <div class="rating-bar-empty"><div class="rating-bar-filled one-star"></div></div> 1%</div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
