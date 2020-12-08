@extends('layouts.app')

@section('content')
    <div class="sand-blue-gradient">
        <div class="container">
            <div class="row justify-content-center align-items-center py-5"
                 style="min-height: 450px;">
                <div class="col-md-6">

                    <div class="card">

                        <div class="card-body">

                            <h2 class="text-center mt-2 mb-4">Verkoper worden <a href="{{route('mijnaccount')}}"
                                                                                 class="btn btn-primary">Terug</a>
                            </h2>

                            @if(Session::has("error"))
                                <div class="alert alert-danger" role="alert" id="alert-danger">
                                    <span class="error" id="error" style="margin-top:10px; margin-bottom: 10px;">{{Session::get("error")}}</span>
                                </div>
                            @endif

                            @if(Session::has("success"))
                                <div class="alert alert-success" role="alert" id="alert-success">
                                    <span class="success" id="success" style="margin-top:10px; margin-bottom: 10px;">{{Session::get("success")}}</span>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('verkoperworden.verifieren') }}">
                                @csrf

                                <small>Vul de code in die staat in de e-mail die u heeft gekregen.</small>

                                <div class="form-group row mb-2">
                                    <label for="code"
                                           class="col-md-4 col-form-label text-md-right">Verificatiecode</label>

                                    <div class="col-md-8">
                                        <input id="code" type="text"
                                               class="form-control @error('code') is-invalid @enderror"
                                               name="code"
                                               value="{{ old('code') }}" autofocus>

                                        @error('code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <small>Als de code correct is en u klikt op "Verzenden" wordt u verkoper op onze website.</small>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Verzenden
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
