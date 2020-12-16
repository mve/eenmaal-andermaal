@extends('layouts.app')

@section('content')



    <div class="container">
        <h2 class="text-center my-4">Veiling maken</h2>

        <div class="card my-3">
            <div class="card-body">
                <form class="make-auction" method="POST" action="/auctions" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <h3>Wat wil je veilen?</h3>

                        <div class="mb-3 col-md-12">
                            <label for="title" class="form-label">Vul een titel in</label>
                            <input name="title" type="text" class="form-control @error('title') is-invalid @enderror" id="title" value="{{old('title')}}" maxlength="100" required>
                            <span id="limit-title-length" class="text-right float-right">Maximaal 100 tekens: 0/100</span>
                        </div>
                        @error('title')
                            <span class="invalid-feedback" style="display: block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <label for="rubrieken" class="form-label">Kies een rubriek</label>
                        <div id="category-select-container" class="row">
                            @if(count(session()->getOldInput()))
                                @php($i = 0)
                                @php($last = 0)
                                @php($loopI = 0)
                                @foreach(session()->getOldInput()["category"] as $category)
                                    @php($cat = \App\Category::oneWhere("id", $category))
                                    @if($cat)

                                        @php($cats = \App\Category::allWhereOrderBy("parent_id", $cat->parent_id, 'name'))

                                        <div class="mb-3 col-md-2">
                                            @include("includes.categoryselection", ['categories'=>$cats, 'level' => $i++, 'selected' => $category])
                                        </div>
                                    @endif
                                    @if($loopI == count(session()->getOldInput()["category"])-2)

                                        @php($children = \App\Category::allWhereOrderBy("parent_id", $category, 'name'))

                                        @if(count($children))
                                            <div class="mb-3 col-md-2">
                                                @include("includes.categoryselection", ['categories'=>$children, 'level' => $i++, 'selected' => false])
                                            </div>
                                        @endif
                                    @endif
                                    @php($loopI++)
                                @endforeach
                            @else
                                <div class="mb-3 col-md-2">
                                    @include("includes.categoryselection", ['categories'=>$mainCategories, 'level' => 0, 'selected' => false])
                                </div>
                            @endif
                        </div>
                        @error('category')
                            <span class="invalid-feedback" style="display:block;" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <h3 class="my-3">Details</h3>
                        <label for="image" class="form-label">Foto's</label>
                        <i>Plaats hier de foto's van je product</i>
                        <div class="mb-3">
                            <input class="form-control @error('image') is-invalid @enderror" type="file" accept=".jpg,.jpeg,.png" name="image[]" id="formFileMultiple" multiple>
                        </div>
                        @if($errors->has("image.*"))
                            @foreach($errors->get("image.*") as $error)
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $error[0] }}</strong>
                                </span>
                            @endforeach
                        @endif

                        <label for="description" class="form-label">Omschrijving</label>
                        <i>Geef hier een omschrijving van je product</i>
                        <div class="mb-3 col-md-12">
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="exampleFormControlTextarea1" rows="3" maxlength="500" required>{{old("description")}}</textarea>
                            <span id="limit-description-length" class="text-right float-right">Maximaal 500 tekens: 0/500</span>
                        </div>
                        @error('description')
                            <span class="invalid-feedback" style="display: block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <label for="duration" class="form-label">Veiling duur</label>
                        <i>Vul hier het aantal dagen van je veiling in</i>
                        <div class="mb-3 col-md-4">
                            <select name="duration" id="duration" class="form-select @error('countryCode') is-invalid @enderror" required>
                                <option value="1" selected>1 dag</option>
                                <option value="3">3 dagen</option>
                                <option value="5">5 dagen</option>
                                <option value="7">7 dagen</option>
                                <option value="10">10 dagen</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        @error('duration')
                            <span class="invalid-feedback" style="display: block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <div class="mb-3 col-md-4">
                            <label for="countryCode" class="form-label">Land</label>
                            <select name="countryCode" class="form-select @error('countryCode') is-invalid @enderror" aria-label="Default select example">
                                @foreach ($countries as $country)
                                    <option value="{{ $country->country_code }}" @if(old('countryCode')==$country->country_code || !old('countryCode')&&$country->country_code=="NL") selected @endif>{{ $country->country }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('countryCode')
                            <span class="invalid-feedback" style="display: block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <div class="mb-3 col-md-4">
                        <label for="city" class="form-label">Stad</label>
                            <input type="text" name="city" value="{{old('city')}}" id="city" class="form-control @error('city') is-invalid @enderror" required>
                        </div>
                        @error('city')
                            <span class="invalid-feedback" style="display: block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <h3 class="my-3">Betaling</h3>

                        <div class="col-md-12">
                            <label for="paymentInstruction" class="form-label">Extra betalingsinstructies</label>
                            <textarea name="paymentInstruction" class="form-control @error('paymentInstruction') is-invalid @enderror" maxlength="255" required>{{old("paymentInstruction")}}</textarea>
                            <span id="limit-payment-instruction-length" class="text-right float-right">Maximaal 255 tekens: 0/255</span>
                        </div>
                        @error('paymentInstruction')
                            <span class="invalid-feedback" style="display: block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <div class="col-md-3">
                            <label for="startPrice" class="form-label">Startprijs</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">€</span>
                                    <input name="startPrice" value="{{old('startPrice')}}" type="number" class="form-control @error('startPrice') is-invalid @enderror" required>
                                <span class="input-group-text">.00</span>
                            </div>
                        </div>
                        @error('startPrice')
                            <span class="invalid-feedback" style="display: block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <div class="mb-3 col-md-12">
                            <label for="payment" class="form-label">Betaalmethodes</label>
                            @foreach ($paymentMethods as $paymentMethod)
                            <div class="form-check">

                                    <input name="payment[]" class="form-check-input" type="checkbox" value="{{ $paymentMethod->id }}" id="{{ $paymentMethod->method }}">

                                    <label class="form-check-label" for="{{ $paymentMethod->method }}">
                                        {{ $paymentMethod->method }}
                                    </label>
                            </div>
                            @endforeach
                        </div>
                        @error('payment')
                            <span class="invalid-feedback" style="display: block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <h3 class="my-3">Levering</h3>

                        <div class="mb-3 col-md-12">
                            <label for="shipping" class="form-label">Betaalmethodes</label>
                            @foreach ($shippingMethods as $shippingMethod)
                                <div class="form-check">

                                    <input name="shipping[]"  class="form-check-input" type="checkbox" value="{{ $shippingMethod->id }}" id="{{ $shippingMethod->method  }}">

                                    <label class="form-check-label" for="{{ $shippingMethod->method  }}">
                                        {{ $shippingMethod->method }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error('shipping')
                            <span class="invalid-feedback" style="display: block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror


                    </div>
                    <button type="submit" class="btn btn-primary">Veiling aanmaken</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function changeLimit(textElement, textLimitElement, limit) {
            textLimitElement.innerHTML = 'Maximaal ' + limit + ' tekens: ' + textElement.value.length + '/' + limit;
        }

        var title = document.getElementsByName('title')[0];
        var titleLimit = document.getElementById('limit-title-length');
        title.addEventListener('keyup', e => {
            changeLimit(title, titleLimit, 100);
        });

        var description = document.getElementsByName('description')[0];
        var descLimit = document.getElementById('limit-description-length');
        description.addEventListener('keyup', e => {
            changeLimit(description, descLimit, 500);
        });

        var paymentInstruction = document.getElementsByName('paymentInstruction')[0];
        var payInsLimit = document.getElementById('limit-payment-instruction-length');
        paymentInstruction.addEventListener('keyup', e => {
            changeLimit(paymentInstruction, payInsLimit, 255);
        });
    </script>

@endsection
