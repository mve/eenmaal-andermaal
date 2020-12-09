@extends('layouts.app')

@section('content')
    <div class="sand-blue-gradient">
        <div class="container">
            <div class="row justify-content-center align-items-center py-5"
                 style="min-height: 450px;">
                <div class="col-md-8">

                    <div class="card">

                        <div class="card-body">

                            <h2 class="text-center mt-2 mb-4">Beoordeling schrijven <a href="{{route("veilingen.gewonnen")}}"
                                                                                       class="btn btn-primary">Terug</a>
                            </h2>
                            <p class="text-center">Beoordeling schrijven over <span
                                    class="fw-bold">{{$seller->first_name}} {{$seller->last_name}}</span> voor:
                                <span class="fw-bold">{{$auction->title}}</span>
                            </p>

                            <form method="POST" action="{{ route('beoordeling.toevoegen',["id"=>$auction->id]) }}">
                                @csrf

                                <div class="form-group row mb-2">
                                    <div class="col-12">
                                        <div class="rating">
                                            @for($i = 5; $i >= 1; $i--)
                                                <label class="@if($i<=old("rating")) fa @else far @endif fa-star" aria-hidden="true">
                                                    <input type="radio" style="display: none" name="rating" value="{{$i}}" title="{{$i}} sterren" @if($i==old("rating")) checked @endif>
                                                </label>
                                            @endfor
                                        </div>

                                        @if($errors->has("rating"))
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $errors->get("rating")[0] }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row mb-2">
                                    <label for="comment"
                                           class="col-12 col-form-label">Beoordeling</label>

                                    <div class="col-12">
                                        <textarea class="form-control @error('comment') is-invalid @enderror" name="comment" id="comment" rows="3" maxlength="255" autofocus>{{ old('comment') }}</textarea>

                                        @error('comment')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Beoordeling versturen
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
