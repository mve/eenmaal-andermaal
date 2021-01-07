@extends('layouts.app')

@section('content')
    <div class="sand-blue-gradient content-height">
        <div class="container">
            <div class="row justify-content-center align-items-center py-5">
                <div class="col-md-6">

                    <div class="card">

                        <div class="card-body">
                            @if (session('msg'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('msg') }}
                                </div>
                            @endif

                            <h2 class="text-center mt-2 mb-3">Wachtwoord vergeten</h2>

                                <p class="text-center mb-3">Vul je e-mailadres in en ontvang een link om je wachtwoord te resetten.</p>

                            <form method="POST" action="{{ route('wachtwoordvergeten') }}">
                                @csrf

                                <div class="form-group row mb-3">
                                    <label for="email"
                                           class="col-md-4 col-form-label text-md-right">E-mailadres</label>

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
                                    <label for="security_question_id"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Beveiligingsvraag') }}</label>

                                    <div class="col-md-6">
                                        <select name="security_question_id" id="security_question_id"
                                                class="form-control @error('security_question_id') is-invalid @enderror"
                                                required autocomplete="security_question_id">
                                            <option value="">Kies een vraag...</option>
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
                                           class="col-md-4 col-form-label text-md-right">{{ __('Beveiligingsantwoord') }}</label>

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
                                        <button type="submit" class="btn btn-primary">
                                            Stuur wachtwoordresetlink
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
