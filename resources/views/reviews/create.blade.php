@extends('layouts.app')

@section('content')
    <div class="sand-blue-gradient">
        <div class="container">
            <div class="row justify-content-center align-items-center py-5"
                 style="min-height: 450px;">
                <div class="col-md-8">

                    <div class="card">

                        <div class="card-body">

                            <h2 class="text-center mt-2 mb-4">Beoordeling schrijven <a href="{{url("/")}}"
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
<script>
    // function removeBtnClick(e,id) {
    //     e.preventDefault();
    //     var phoneFields = document.querySelectorAll(".form-phone-number");
    //     for(var i = 0; i < phoneFields.length; i++){
    //         if(phoneFields[i].getAttribute("p-id") == id){
    //             phoneFields[i].parentNode.remove();
    //         }
    //     }
    // }
    // function addPhoneField(e) {
    //     e.preventDefault();
    //     var formPhoneFieldsContainer = document.querySelector("#formPhoneFieldsContainer");
    //     var phoneFields = document.querySelectorAll(".form-phone-number");
    //     var maxId = 0;
    //     for(var i = 0; i < phoneFields.length; i++){
    //         var curInt = parseInt(phoneFields[i].getAttribute("p-id"));
    //         if(curInt > maxId){
    //             maxId = curInt;
    //         }
    //     }
    //
    //     var xhttp = new XMLHttpRequest();
    //     xhttp.onreadystatechange = function() {
    //         if (this.readyState == 4 && this.status == 200) {
    //             var div = document.createElement('div');
    //             div.innerHTML = this.responseText;
    //             formPhoneFieldsContainer.appendChild(div);
    //         }
    //     };
    //     xhttp.open("GET", "/mijnaccount/phonefield/"+(maxId+1), true);
    //     xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    //     xhttp.send();
    // }
</script>
