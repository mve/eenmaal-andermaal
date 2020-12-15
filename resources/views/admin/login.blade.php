@extends('layouts.noheader-app')

@section('content')
    <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-gavel"></i> {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="sand-blue-gradient">
        <div class="container">
            <div class="row justify-content-center align-items-center py-5"
                 style="height: calc(100vh - 392px); min-height: 450px;">
                <div class="col-md-6">

                    <div class="card">

                        <div class="card-body">

                            <h2 class="text-center mt-2 mb-4">Admin inloggen</h2>

                            <form method="POST" action="{{ route('Admin.login') }}">
                                @csrf

                                <div class="form-group row mb-2">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">E-mailadres</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email"
                                               class="form-control @error('email') is-invalid @enderror" name="email"
                                               value="{{ old('email') }}" required autocomplete="email" autofocus>

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
                                               name="password" required autocomplete="current-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember"
                                                   id="remember" {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Onthouden') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Inloggen
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
