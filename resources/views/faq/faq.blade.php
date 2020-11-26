@extends('layouts.app')

@section('content')

    <div class="container">

        <h2 class="text-center mt-5">Veelgestelde vragen</h2>

        <div class="accordion" id="vragenlijst">
            <div class="accordion-item my-3">
                <h2 class="accordion-header" id="vraag1">
                    <button class="accordion-button" type="button" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                        Hoe kan ik meebieden?
                    </button>
                </h2>
                <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="vraag1"
                     data-parent="#vragenlijst">
                    <div class="accordion-body">
                        door een account aan te maken op de volgende link url
                    </div>
                </div>
            </div>
            <div class="accordion-item my-3">
                <h2 class="accordion-header" id="vraag2">
                    <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                        Hoe maak ik een account aan
                    </button>
                </h2>
                <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="vraag2"
                     data-parent="#vragenlijst">
                    <div class="accordion-body">
                        stappen plan
                    </div>
                </div>
            </div>
            <div class="accordion-item my-3">
                <h2 class="accordion-header" id="vraag3">
                    <button class="accordion-button collapsed" type="button" data-toggle="collapse"  data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                        vraag 3
                    </button>
                </h2>
                <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="vraag3"
                     data-parent="#vragenlijst">
                    <div class="accordion-body">
                        test
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
