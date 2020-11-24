@extends('layouts.app')

@section('content')

    <div class="san sand-blue-gradient">
        <div class="container">
            <div class="row justify-content-center align-items-center py-5">
                <div class="col-md-6">

                    <div class="card">

                        <div class="card-body">

                            <h2 class="text-center mt-2 mb-4">Registreren</h2>
                            <span class="success" id="success" style="color:green; margin-top:10px; margin-bottom: 10px;"></span>
                            <span class="error" id="error" style="color:red; margin-top:10px; margin-bottom: 10px;"></span>

                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                            <div id="form_1">
                                <div class="form-group row mb-2">
                                    <label for="Username"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                                    <div class="col-md-6">
                                        <input id="username" type="text"
                                               class="form-control @error('username') is-invalid @enderror"
                                               name="username" value="{{ old('username') }}" required
                                               autocomplete="username">

                                        @error('username')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">Email adres</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               name="email"
                                               value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button class="btn btn-primary" onclick="Send_verify()" id="send_verify">
                                            Verifieer email
                                        </button>
                                    </div>
                                </div>

                            </div>

                            <div id="form_2" class="d-none">

                                <div class="form-group row mb-2">
                                    <label for="verificatie_code" class="col-md-4 col-form-label text-md-right">Verificatie code</label>

                                    <div class="col-md-6">
                                        <input id="verificatie_code" type="text"
                                               class="form-control @error('verificatie_code') is-invalid @enderror"
                                               name="verificatie_code"
                                               value="{{ old('verificatie_code') }}" required autocomplete="verificatie_code">
                                        @error('verificatie_code')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-0">

                                    <div class="col-md-6">

                                        <button class="btn btn-primary d-none" onclick="Send_verify()" id="send_verify_again">
                                            Herstuur code email
                                        </button>



                                    </div>
                                    <div class="col-md-6">

                                        <button type="button" class="btn btn-primary check_verify" id="check_verify">
                                            Verifieer code
                                        </button>

                                    </div>



                                </div>

                            </div>

                            <div id="form_3" class="d-none">
                                <div class="form-group row mb-2">
                                    <label for="password"
                                           class="col-md-4 col-form-label text-md-right">Wachtwoord</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               name="password" required autocomplete="new-password">
                                        <small id="passwordHelpInline" class="text-muted">
                                          Wachtwoord moet minimaal 8 tekens bevatten, 1 hoofdletter en 1 speciaal teken
                                        </small>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="password-confirm"
                                           class="col-md-4 col-form-label text-md-right">Wachtwoord bevestigen</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control"
                                               name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="first_name"
                                           class="col-md-4 col-form-label text-md-right">{{ __('First name') }}</label>

                                    <div class="col-md-6">
                                        <input id="first_name" type="text"
                                               class="form-control @error('first_name') is-invalid @enderror"
                                               name="first_name" value="{{ old('first_name') }}" required
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
                                           class="col-md-4 col-form-label text-md-right">{{ __('Last name') }}</label>

                                    <div class="col-md-6">
                                        <input id="last_name" type="text"
                                               class="form-control @error('last_name') is-invalid @enderror"
                                               name="last_name" value="{{ old('last_name') }}" required
                                               autocomplete="last_name">

                                        @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="address"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="address" type="text"
                                               class="form-control @error('address') is-invalid @enderror"
                                               name="address" value="{{ old('address') }}" required
                                               autocomplete="address">

                                        @error('address')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="postal_code"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Postal code') }}</label>

                                    <div class="col-md-6">
                                        <input id="postal_code" type="text"
                                               class="form-control @error('postal_code') is-invalid @enderror"
                                               name="postal_code" value="{{ old('postal_code') }}" required
                                               autocomplete="postal_code">

                                        @error('postal_code')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="city"
                                           class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>

                                    <div class="col-md-6">
                                        <input id="city" type="text"
                                               class="form-control @error('city') is-invalid @enderror" name="city"
                                               value="{{ old('city') }}" required autocomplete="city">

                                        @error('city')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="country"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Country') }}</label>

                                    <div class="col-md-6">
                                        <input id="country" type="text"
                                               class="form-control @error('country') is-invalid @enderror"
                                               name="country" value="{{ old('country') }}" required
                                               autocomplete="country">

                                        @error('country')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="birth_date"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Birth date') }}</label>

                                    <div class="col-md-6">
                                        <input id="birth_date" type="date" value="2000-12-28"
                                               class="form-control @error('birth_date') is-invalid @enderror"
                                               name="birth_date" value="{{ old('birth_date') }}" required
                                               autocomplete="birth_date">

                                        @error('birth_date')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="security_question_id"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Security question') }}</label>

                                    <div class="col-md-6">
                                        <select name="security_question_id" id="security_question_id"
                                                class="form-control @error('security_question_id') is-invalid @enderror"
                                                required autocomplete="security_question_id">
                                            <option value="">Select a question...</option>
                                            @foreach($securityQuestions as $securityQuestion)
                                                <option value="{{$securityQuestion["id"]}}"
                                                        @if(old("security_question_id")==$securityQuestion["id"]) selected @endif>{{$securityQuestion["question"]}}</option>
                                            @endforeach
                                        </select>

                                        @error('security_question_id')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="security_answer"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Security answer') }}</label>

                                    <div class="col-md-6">
                                        <input id="security_answer" type="text"
                                               class="form-control @error('security_answer') is-invalid @enderror"
                                               name="security_answer" value="{{ old('security_answer') }}" required
                                               autocomplete="security_answer">

                                        @error('security_answer')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary submit">
                                            Registreer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>

<script>

function Send_verify() {
    event.preventDefault();

    let username = document.getElementById("username").value;
    let email = document.getElementById("email").value;
    let _token = document.getElementsByName("_token")[0].value;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if(JSON.parse(this.responseText).success) {
            document.getElementById("error").innerHTML = ""
            document.getElementById("success").innerHTML =
            JSON.parse(this.responseText).success

            document.getElementById("form_1").className = "d-none";
            document.getElementById("form_2").className = "block";
        }

    }
    };
    xhttp.open("POST", "/registreren/verify", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("type=1&username="+username+"&email="+email+"&_token="+_token);

}

//controlleer verificatie code
document.getElementById("check_verify").addEventListener("click", function() {
    event.preventDefault();
    let code = document.getElementById("verificatie_code").value;
    let _token = document.getElementsByName("_token")[0].value;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(JSON.parse(this.responseText).success) {
                document.getElementById("error").innerHTML = ""
                document.getElementById("success").innerHTML =
                JSON.parse(this.responseText).success

                document.getElementById("form_2").className = "d-none";
                document.getElementById("form_3").className = "block";
            }

            if( JSON.parse(this.responseText).error){
                document.getElementById("success").innerHTML = "";
                document.getElementById("error").innerHTML =
                JSON.parse(this.responseText).error

                document.getElementById("send_verify_again").className = "btn btn-primary block";
            }
        }
    };
    xhttp.open("POST", "/registreren/verify", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("type=2&code="+code+"&_token="+_token);

});

</script>
@endsection
