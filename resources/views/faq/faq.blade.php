@extends('layouts.app')

@section('content')

    <div class="container">

        <h2 class="text-center mt-5">Veelgestelde vragen</h2>

        <div class="accordion" id="vragenlijst">
            <div class="accordion-item my-3">
                <h2 class="accordion-header" id="vraag1">
                    <button class="accordion-button" type="button" data-toggle="collapse" data-target="#collapse1"
                            aria-expanded="true" aria-controls="collapse1">
                        Hoe bied ik op een veiling?
                    </button>
                </h2>
                <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="vraag1"
                     data-parent="#vragenlijst">
                    <div class="accordion-body">
                        <ul>
                            <li>Zorg dat je bent ingelogd met een account.</li>
                            <li>Klik op een veiling waar je op wil je bieden. Vervolgens heb je hier de mogelijkheid om
                                de veilingdetails te bekijken en een bod uit te brengen.
                            </li>
                            <li>Is de veiling verlopen en heb jij het hoogste bod? Je ontvangt dan een bericht met de
                                details van de veiling.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="accordion-item my-3">
                <h2 class="accordion-header" id="vraag2">
                    <button class="accordion-button collapsed" type="button" data-toggle="collapse"
                            data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                        Hoe maak ik een account aan?
                    </button>
                </h2>
                <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="vraag2"
                     data-parent="#vragenlijst">
                    <div class="accordion-body">
                        <ul>
                            <li>Ga naar de registreerpagina. Volg hier de volgende stappen:</li>
                            <li>Stap 1: Voer je gebruikersnaam en je email adres in. Vervolgens ontvang je een verificatie code op je e-mailadres.</li>
                            <li>Stap 2: Voer de ontvangen verificatiecode in.</li>
                            <li>Stap 3: Wanneer de verificatie code klopt kun je de rest van de accountgegevens invoeren en de registratie afronden.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
