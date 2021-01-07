@extends('layouts.app')

@section('content')
    <div class="sand-blue-gradient">
        <div class="container">
            <div class="row justify-content-center align-items-center py-5"
                 style="min-height: 450px;">
                <div class="col-md-6">

                    <div class="card">

                        <div class="card-body">

                            <h2 class="text-center mt-2 mb-4">Account bewerken </h2>

                            @if(\Illuminate\Support\Facades\Session::has("success"))
                                <div class="alert alert-success" role="alert" id="alert-success">
                                    <span class="success" id="success" style="margin-top:10px; margin-bottom: 10px;">{{\Illuminate\Support\Facades\Session::get("success")}}</span>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('mijnaccount.bewerken') }}">
                                @csrf

                                <div class="form-group row mb-2">
                                    <label for="username"
                                           class="col-md-4 col-form-label text-md-right">Gebruikersnaam</label>

                                    <div class="col-md-8">
                                        <input id="username" type="text"
                                               class="form-control @error('username') is-invalid @enderror"
                                               name="username"
                                               value="{{ old('username')?:$user->username }}" required
                                               autocomplete="username" autofocus>

                                        @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="first_name"
                                           class="col-md-4 col-form-label text-md-right">Voornaam</label>

                                    <div class="col-md-8">
                                        <input id="first_name" type="text"
                                               class="form-control @error('first_name') is-invalid @enderror"
                                               name="first_name"
                                               value="{{ old('first_name')?:$user->first_name }}" required
                                               autocomplete="first_name">

                                        @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="last_name"
                                           class="col-md-4 col-form-label text-md-right">Achternaam</label>

                                    <div class="col-md-8">
                                        <input id="last_name" type="text"
                                               class="form-control @error('last_name') is-invalid @enderror"
                                               name="last_name"
                                               value="{{ old('last_name')?: $user->last_name }}" required
                                               autocomplete="last_name">

                                        @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="address" class="col-md-4 col-form-label text-md-right">Adres</label>

                                    <div class="col-md-8">
                                        <input id="address" type="text"
                                               class="form-control @error('address') is-invalid @enderror"
                                               name="address"
                                               value="{{ old('address')?: $user->address }}" required
                                               autocomplete="address">

                                        @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="city" class="col-md-4 col-form-label text-md-right">Woonplaats</label>

                                    <div class="col-md-8">
                                        <input id="city" type="text"
                                               class="form-control @error('city') is-invalid @enderror" name="city"
                                               value="{{ old('city')?: $user->city }}" required autocomplete="city">

                                        @error('city')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="postal_code"
                                           class="col-md-4 col-form-label text-md-right">Postcode</label>

                                    <div class="col-md-8">
                                        <input id="postal_code" type="text"
                                               class="form-control @error('postal_code') is-invalid @enderror"
                                               name="postal_code"
                                               value="{{ old('postal_code')?: $user->postal_code }}" required
                                               autocomplete="postal_code">
                                        @error('postal_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="country_code"
                                           class="col-md-4 col-form-label text-md-right">Landcode</label>

                                    <div class="col-md-8">
                                        <select name="country_code" class="form-select @error('country_code') is-invalid @enderror" aria-label="Default select example">
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->country_code }}" @if(old('country_code')==$country->country_code || !old('country_code')&&$country->country_code==$user->country_code) selected @endif>{{ $country->country }}</option>
                                            @endforeach
                                        </select>

                                        @error('country_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <hr/>
                                <div id="formPhoneFieldsContainer">
                                @php($phoneNumbers = $user->getPhoneNumbers())
                                @php($oldPhoneNumbers = isset(\Illuminate\Support\Facades\Session::all()["_old_input"])?\Illuminate\Support\Facades\Session::all()["_old_input"]:[])
                                @php($oldPhoneNumbers = isset($oldPhoneNumbers["phone_number"])?$oldPhoneNumbers["phone_number"]:[])
                                @if(isset(\Illuminate\Support\Facades\Session::all()["_old_input"]))
                                    @for($i = 0; $i < count($oldPhoneNumbers); $i++)
                                        <div>@include("includes.phonefield", ["id"=>$i, "phoneNumber"=>old('phone_number.'.$i)?: $oldPhoneNumbers[$i]['phone_number'], "errors"=>$errors])</div>
                                    @endfor
                                @elseif(count($phoneNumbers))
                                    @for($i = 0; $i < count($phoneNumbers); $i++)
                                        <div>@include("includes.phonefield", ["id"=>$i, "phoneNumber"=>old('phone_number.'.$i)?: $phoneNumbers[$i]['phone_number'], "errors"=>$errors])</div>
                                    @endfor
                                @else

                                @endif
                                </div>

                                <div class="form-group row mb-1">
                                    <div class="col-md-8 offset-md-4">
                                        <a class="btn btn-secondary" href="javascript:void(0);" onclick="addPhoneField(event);">
                                            Telefoonnummer toevoegen
                                        </a>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary mr-1">
                                            Opslaan
                                        </button>
                                        <a href="{{route('mijnaccount')}}" class="btn btn-outline-primary">Terug</a>
                                    </div>
                                </div>
                            </form>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    function removeBtnClick(e,id) {
        e.preventDefault();
        var phoneFields = document.querySelectorAll(".form-phone-number");
        for(var i = 0; i < phoneFields.length; i++){
            if(phoneFields[i].getAttribute("p-id") == id){
                phoneFields[i].parentNode.remove();
            }
        }
    }
    function addPhoneField(e) {
        e.preventDefault();
        var formPhoneFieldsContainer = document.querySelector("#formPhoneFieldsContainer");
        var phoneFields = document.querySelectorAll(".form-phone-number");
        var maxId = 0;
        for(var i = 0; i < phoneFields.length; i++){
            var curInt = parseInt(phoneFields[i].getAttribute("p-id"));
            if(curInt > maxId){
                maxId = curInt;
            }
        }

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var div = document.createElement('div');
                div.innerHTML = this.responseText;
                formPhoneFieldsContainer.appendChild(div);
            }
        };
        xhttp.open("GET", "/mijnaccount/phonefield/"+(maxId+1), true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send();
    }
</script>
