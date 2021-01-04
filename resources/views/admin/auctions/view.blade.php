@extends('layouts.admin-app')

@section('content')

<div class="container-fluid admin">
    <h2>{{$auction->title}}</h2>
    <div class="row">
        <div class="col-lg-7">
            <!-- CAROUSEL SLIDER -->
            <div id="carouselExampleIndicators" class="carousel slide " data-ride="carousel">
                <ol class="carousel-indicators">
                    @for($i = 0; $i < count($auctionImages); $i++) <li data-target="#carouselExampleIndicators" @if($i==0) class="active" @endif data-slide-to="{{$i}}">
                        </li>
                        @endfor
                </ol>
                <div class="carousel-inner">
                    @for($i = 0; $i < count($auctionImages); $i++) <div class="carousel-item @if($i==0) active @endif">
                        <img src='{{$auctionImages[$i]["file_name"]}}' class="d-block" alt="...">
                </div>
                @endfor
            </div>
            @if(count($auctionImages) > 1)
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </a>
            @endif
            <!-- END OF CAROUSEL SLIDER -->
        </div>
        <div class="col-lg-5 text-center">
            <h2>Informatie</h2>
            <div class="row rounded-top border-top pt-2 mx-1">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col text-left">Naam</div>
                                                <div class="col text-right">

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col text-left">E-mail</div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col text-left">Geboortedatum</div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col text-left">Woonplaats</div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col text-left">Land</div>

                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col text-left">Registratiedatum</div>

                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <form method="post" action="">
                                @csrf

                                <button class="btn btn-success btn-lg" type="submit" name="unblock" onclick="return confirm('Weet u zeker dat u deze gebruiker wilt deblokkeren?')">Deblokkeren</button>

                                <button class="btn btn-danger text-light btn-lg" type="submit" name="block" onclick="return confirm('Weet u zeker dat u deze gebruiker wilt blokkeren?')">Blokkeren</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="rol">
            <div class="my-4">
                <h4>Omschrijving</h4>
                <hr>
                <p>{!! nl2br($auction->description) !!}</p>
                <h4>Gegevens</h4>
                <hr>
                <p>
                    Land: {{$auction->getCountry()}}<br />
                    Plaats: {{$auction->city}}
                    @foreach($auction->getSeller()->getPhoneNumbers() as $phoneNumber)
                    <br />Telefoonnummer: {{$phoneNumber["phone_number"]}}<br />
                    @endforeach
                </p>
                <h4>Betaling</h4>
                <hr>
                <p>
                    @if($auction->payment_instruction!==null && !empty($auction->payment_instruction))
                    Betalingsinstructies:<br />
                    {{$auction->payment_instruction}}<br /><br />
                    @endif
                    De verkoper accepteert de volgende betalingsmethoden:<br />
                <ul>
                    @foreach($auction->getPaymentMethods() as $paymentMethod)
                    <li>{{$paymentMethod["method"]}}</li>
                    @endforeach
                </ul>
                </p>
                <h4>Verzending</h4>
                <hr>
                <p>
                    De verkoper accepteert de volgende verzendmethoden:<br />
                <ul>
                    @foreach($auction->getShippingMethods() as $shippingMethod)
                    <li>{{$shippingMethod["method"]}}: &euro;{{$shippingMethod["price"]}}</li>
                    @endforeach
                </ul>
                </p>
            </div>
        </div>
    </div>
</div>

@endsection