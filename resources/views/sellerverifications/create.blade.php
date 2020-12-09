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

                            <form method="POST" action="{{ route('verkoperworden') }}">
                                @csrf

                                <small>Om verkoper te worden moet u uw betaalgegevens aan ons doorgeven. U kunt kiezen tussen creditcard of IBAN.</small>

                                <div class="form-group row mb-2">
                                    <label for="creditcard_number"
                                           class="col-md-4 col-form-label text-md-right">Creditcardnummer</label>

                                    <div class="col-md-8">
                                        <input id="creditcard_number" type="text"
                                               class="form-control @error('creditcard_number') is-invalid @enderror"
                                               name="creditcard_number"
                                               value="{{ old('creditcard_number') }}" autofocus>

                                        @error('creditcard_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <h3 class="col fw-bolder text-center" style="font-size: 24px;">OF</h3>

                                <div class="form-group row mb-2">
                                    <label for="bank_name"
                                           class="col-md-4 col-form-label text-md-right">Naam bank</label>

                                    <div class="col-md-8">
                                        <input id="bank_name" type="text"
                                               class="form-control @error('bank_name') is-invalid @enderror"
                                               name="bank_name"
                                               value="{{ old('bank_name') }}" autofocus>

                                        @error('bank_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="bank_account_number"
                                           class="col-md-4 col-form-label text-md-right">IBAN</label>

                                    <div class="col-md-8">
                                        <input id="bank_account_number" type="text"
                                               class="form-control @error('bank_account_number') is-invalid @enderror"
                                               name="bank_account_number"
                                               value="{{ old('bank_account_number') }}" autofocus>

                                        @error('bank_account_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <small>Na het klikken op "Verzenden" wordt er een e-mail gestuurd naar <span
                                            class="fw-bold">{{Session::get("user")->email}}</span>. Deze e-mail bevat een code
                                        die u op de volgende pagina moet invoeren.</small>

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
