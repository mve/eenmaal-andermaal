@extends('layouts.app')

@section('content')
    <div class="sand-blue-gradient content-height">
        <div class="container">
            <div class="row justify-content-center align-items-center py-5">
                <div class="col-md-6">

                    <div class="card">

                        <div class="card-body">

                            <h2 class="text-center mt-2 mb-4">Wachtwoord resetten</h2>

                            <form method="POST" action="{{ route('wachtwoordreset') }}">
                                @csrf

                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="form-group row mb-2">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">E-mailadres</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email"
                                               class="form-control @error('email') is-invalid @enderror" name="email"
                                               value="{{ $email ?? old('email') }}" required autocomplete="email"
                                               autofocus>

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="password"
                                           class="col-md-4 col-form-label text-md-right">Wachtwoord</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               name="password" required autocomplete="new-password">
                                        <small id="passwordHelpInline" class="text-muted">
                                            Wachtwoord moet minimaal 7 tekens, 1 cijfer, 1 kleine letter en 1 hoofdletter bevatten
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
                                           class="col-md-4 col-form-label text-md-right">Bevestig wachtwoord</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control"
                                               name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Reset wachtwoord
                                        </button>
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
