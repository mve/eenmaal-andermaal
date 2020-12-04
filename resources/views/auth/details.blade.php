@extends('layouts.app')

@section('content')

    <div class="san sand-blue-gradient">
        <div class="container">
            <div class="row justify-content-center align-items-center py-5">
                <div class="col-md-8">

                    <div class="card">

                        <div class="card-body">

                            <h2 class="text-center mt-2 mb-4">Mijn account <a href="{{route("mijnaccount.bewerken")}}" class="btn btn-primary">Bewerken</a></h2>

                            <div class="row">
                                <div class="col-lg-4 fw-bold">Gebruikersnaam</div>
                                <div class="col-lg-8">{{$user->username}}</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 fw-bold">E-mailadres</div>
                                <div class="col-lg-8">{{$user->email}}</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 fw-bold">Type account</div>
                                <div class="col-lg-8">{{$user->is_seller ? "Verkoper" : "Koper" }}</div>
                            </div>

                            @if($user->is_seller===1 && ($sellerVerification = $user->getSellerVerification()))

                                <hr/>

                                <div class="row">
                                    <div class="col-lg-4 fw-bold">Verificatiemethode</div>
                                    <div class="col-lg-8">{{$sellerVerification["method"]}}</div>
                                </div>

                                @if($sellerVerification["method"] == "Bank")
                                    <div class="row">
                                        <div class="col-lg-4 fw-bold">Bank</div>
                                        <div class="col-lg-8">{{$sellerVerification["bank_name"]}}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4 fw-bold">IBAN</div>
                                        <div class="col-lg-8">{{$sellerVerification["bank_account_number"]}}</div>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-lg-4 fw-bold">Creditcard</div>
                                        <div class="col-lg-8">{{$sellerVerification["creditcard_number"]}}</div>
                                    </div>
                                @endif

                            @endif

                            <hr/>

                            <div class="row">
                                <div class="col-lg-4 fw-bold">Voornaam</div>
                                <div class="col-lg-8">{{$user->first_name}}</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 fw-bold">Achternaam</div>
                                <div class="col-lg-8">{{$user->last_name}}</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 fw-bold">Geboortedatum</div>
                                <div class="col-lg-8">{{date("d-m-Y ",strtotime(substr($user->birth_date,0,11)))}}</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 fw-bold">Adres</div>
                                <div class="col-lg-8">{{$user->address}}</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 fw-bold">Woonplaats</div>
                                <div class="col-lg-8">{{$user->city}}</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 fw-bold">Postcode</div>
                                <div class="col-lg-8">{{$user->postal_code}}</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 fw-bold">Land</div>
                                <div class="col-lg-8">{{$user->getCountry()}}</div>
                            </div>

                            @if(count($phoneNumbers = $user->getPhoneNumbers()) > 0)

                                <hr/>

                                @for($i = 0; $i < count($phoneNumbers); $i++)
                                    <div class="row">
                                        <div class="col-lg-4 fw-bold">Telefoonnummer {{$i+1}}</div>
                                        <div class="col-lg-8">{{$phoneNumbers[$i]["phone_number"]}}</div>
                                    </div>
                                @endfor
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
