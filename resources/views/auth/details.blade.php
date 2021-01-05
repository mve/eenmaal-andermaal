@extends('layouts.app')

@section('content')

    <div class="san sand-blue-gradient">
        <div class="container">
            <div class="row justify-content-center align-items-center py-5">
                <div class="col-md-8">

                    <div class="card">

                        <div class="card-body">

                            <h2 class="text-center mt-2 mb-4">Mijn account <a href="{{route("mijnaccount.bewerken")}}" class="btn btn-primary">Bewerken</a> <button type="submit" id="verwijderen" class="btn btn-danger"> Account verwijderen </button></h2>
                            
                            @if(Session::has("error"))
                                <div class="alert alert-danger" role="alert" id="alert-danger">
                                    <span class="error" id="error" style="margin-top:10px; margin-bottom: 10px;">{!! Session::get("error") !!}</span>
                                </div>
                            @endif

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
                                <div class="col-lg-8">
                                    @if($user->is_seller == true)
                                        Verkoper
                                    @else
                                        Koper
                                        <a href="{{route("verkoperworden")}}" class="btn-primary btn-sm no-link text-white">Verkoper worden</a>
                                    @endif
                                </div>
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

                            <hr/>

                            <div class="row">
                                <div class="col-lg-4 fw-bold">Lid sinds</div>
                                <div class="col-lg-8">{{date('d-m-Y', strtotime($user->created_at))}}</div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div id="backdrop" class="d-none">
    <div class="modal" id="exampleModalCenter" role="dialog" aria-labelledby="exampleModalCenterTitle">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content rounded-5">
            <div class="modal-header text-center">
            <h5 class="modal-title float-center" id="exampleModalLongTitle">Account verwijderen</h5>
            </div>
            <div class="modal-body">
                <h6>Vul ter bevestiging het wachtwoord in </h6>
                <h6>Let op! Na deze stap wordt het account verwijderd en dit kan niet meer teruggedraaid worden! </h6>
            <form method="POST" action="{{ route('mijnaccount.verwijderen') }}">
                @csrf
               
                <div class="form-group row mb-2">
                    <label for="password"
                           class="col-md-4 col-form-label text-md-right">Wachtwoord</label>

                    <div class="col-md-6">
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" required autocomplete="current-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" value="Account verwijderen" name="Verwijderen" class="btn btn-primary">
            </form>
            </div>
        </div>
        </div>
    </div>
        <div class="modal-backdrop fade show"> </div>
</div>
    <script>
      document.getElementById("verwijderen").addEventListener("click", (event) => {
          document.getElementById("backdrop").classList.remove('d-none');
          document.getElementById("exampleModalCenter").style.display = "block";
       })
      </script>
@endsection

