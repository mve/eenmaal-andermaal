@extends('layouts.app')

@section('content')
    <div class="sand-blue-gradient">
        <div class="container">
            <div class="row justify-content-center align-items-center py-5" style="height: calc(100vh - 392px); min-height: 450px;">
                <div class="col-md-6">

                    <div class="card">

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <h2 class="text-center mt-2 mb-3">Wachtwoord vergeten</h2>

                                <p class="text-center mb-3">Vul je email adres in en ontvang een link om je wachtwoord te resetten.</p>

                            <form method="POST" action="{{ route('wachtwoordvergeten') }}">
                                @csrf

                                <div class="form-group row mb-3">
                                    <label for="email"
                                           class="col-md-4 col-form-label text-md-right">Email adres</label>

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

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Stuur wachtwoord reset link
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
