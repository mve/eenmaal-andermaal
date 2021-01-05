@extends('layouts.admin-app')

@section('content')

<div class="admin">
    <div class="container">
        <h1>Veiling bewerken</h1>
        <form method="POST" action="{{ route('admin.auctions.edit.save', $auction->id) }}" enctype="multipart/form-data">
            @csrf
            <h3>Titel</h3>
            <div class="form-group row mb-2">
                <div class="col-md">
                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title')?:$auction->title }}" required autocomplete="title" autofocus>
                    <span id="limit-title-length" class="text-right float-right text-white">Maximaal 100 tekens: 0/100</span>
                    @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <h3>Omschrijving</h3>
            <div class="mb-3 col-md">
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="exampleFormControlTextarea1" rows="3" maxlength="500" required>{{old("description")?:$auction->description}}</textarea>
                <span id="limit-description-length" class="text-right float-right text-white">Maximaal 500 tekens: 0/500</span>
            </div>
            @error('description')
            <span class="invalid-feedback" style="display: block" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <div class="col-md-12">
                <label for="paymentInstruction" class="form-label">Extra betalingsinstructies</label>
                <textarea name="paymentInstruction" class="form-control @error('paymentInstruction') is-invalid @enderror" maxlength="255">{{old("paymentInstruction")?:$auction->payment_instruction}}</textarea>
                <span id="limit-payment-instruction-length" class="text-right float-right text-white">Maximaal 255 tekens: 0/255</span>
            </div>
            @error('paymentInstruction')
            <span class="invalid-feedback" style="display: block" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror

            <hr>
            <button type="submit" class="btn btn-primary text-right">Opslaan</button>
            <button class="btn btn-danger text-light" onclick="window.history.back(); return false;">Annuleren</button>
        </form>
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
        fitDescription();
    });

    var paymentInstruction = document.getElementsByName('paymentInstruction')[0];
        var payInsLimit = document.getElementById('limit-payment-instruction-length');
        paymentInstruction.addEventListener('keyup', e => {
            changeLimit(paymentInstruction, payInsLimit, 255);
        });

    function fitDescription() {
        numberOfLineBreaks = description.value.match(/\n/g).length;
        description.style.height = 30 + numberOfLineBreaks * 24 + 'px';
    }

    window.onload = () => {
        changeLimit(title, titleLimit, 100);
        changeLimit(description, descLimit, 500);
        fitDescription();
    }
</script>
@endsection