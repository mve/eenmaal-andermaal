@extends('layouts.app')

@section('content')

<div class="container">
	<h2 class="text-center mt-5">Veelgestelde vragen</h2>
	<div class="accordion" id="vragenlijst">

		<div class="accordion-item my-3">
			<h2 class="accordion-header" id="vraag1">
				<button class="accordion-button" type="button" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
					Wat is EenmaalAndermaal?
				</button>
			</h2>
			<div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="vraag1" data-parent="#vragenlijst">
				<div class="accordion-body">
					<p>EenmaalAndermaal is een platform waar leden veilingen kunnen openen waar geïnteresseerden vervolgens op kunnen bieden.
						Heeft u nadat de veiling afloopt het hoogste bod in handen?
						Dan mag u uzelf nu de nieuwe eigenaar noemen van het geveilde product!</p>
				</div>
			</div>
		</div>

		<h2 class="mt-4 pt-4">Account</h2>

		<div class="accordion-item my-3">
			<h2 class="accordion-header" id="vraag2">
				<button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
					Hoe word ik lid van EenmaalAndermaal?
				</button>
			</h2>
			<div id="collapse2" class="accordion-collapse collapse" aria-labelledby="vraag2" data-parent="#vragenlijst">
				<div class="accordion-body">
					<p>Ga naar de <a href="{{route('register')}}">registratiepagina</a> en volg de volgende stappen:</p>
					<ol>
						<li>Voer uw gebruikersnaam en je email adres in.
							Vervolgens ontvang je een verificatie code op je e-mailadres.</li>
						<li>Voer de ontvangen verificatiecode in.</li>
						<li>Wanneer de verificatie code klopt kun je de rest van de accountgegevens invoeren en de registratie afronden.</li>
					</ol>
					(Let op: Navigeren naar de registratiepagina is niet mogelijk wanneer u al ingelogd bent!)
				</div>
			</div>
		</div>

		<div class="accordion-item my-3">
			<h2 class="accordion-header" id="vraag3">
				<button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
					Hoe wijzig ik mijn accountgegevens?
				</button>
			</h2>
			<div id="collapse3" class="accordion-collapse collapse" aria-labelledby="vraag3" data-parent="#vragenlijst">
				<div class="accordion-body">
					<p>Navigeer naar <a href="{{route('mijnaccount')}}">Mijn Account</a> en klik op "Bewerken". Hier kunt u alle relevante gevens aanpassen maar ook bijvoorbeeld nieuwe telefoonnummers toevoegen.</p>
				</div>
			</div>
		</div>

		<h2 class="mt-4 pt-4">Veilingen</h2>

		<div class="accordion-item my-3">
			<h2 class="accordion-header" id="vraag4">
				<button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
					Hoe start ik een veiling?
				</button>
			</h2>
			<div id="collapse4" class="accordion-collapse collapse" aria-labelledby="vraag4" data-parent="#vragenlijst">
				<div class="accordion-body">
					<p>Om een veiling te kunnen starten, moet u geregistreerd zijn als Verkoper bij EenmaalAndermaal. Bent u dit nog niet? Ga dan naar <a href="{{route('mijnaccount')}}">Mijn Account</a> en volg de stappen.</p>
				</div>
			</div>
		</div>

		<div class="accordion-item my-3">
			<h2 class="accordion-header" id="vraag5">
				<button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
					Hoe bied ik op een veiling?
				</button>
			</h2>
			<div id="collapse5" class="accordion-collapse collapse" aria-labelledby="vraag5" data-parent="#vragenlijst">
				<div class="accordion-body">
					<ol>
						<li>Zorg dat u bent ingelogd op uw EenmaalAndermaal-account.</li>
						<li>Klik op een veiling die u interessant lijkt.
							Hier heeft u de mogelijkheid om de veilingdetails te bekijken en een bod uit te brengen als u kans wilt maken om te winnen.</li>
						<li>Wordt u overboden? U krijgt bericht en kunt opnieuw een bod uitbrengen als u dat wenst.</li>
						<li>Is de veiling afgelopen en heeft u het hoogste bod? U ontvangt dan per e-mail bericht!</li>
					</ol>
				</div>
			</div>
		</div>

		<h2 class="mt-4 pt-4">Websiteregels</h2>

		<div class="accordion-item my-3">
			<h2 class="accordion-header" id="vraag6">
				<button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
					Waar moet ik op letten bij het gebruik van de website?
				</button>
			</h2>
			<div id="collapse6" class="accordion-collapse collapse" aria-labelledby="vraag6" data-parent="#vragenlijst">
				<div class="accordion-body">
					<ul>
						<li>Gedraag u fatsoenlijk naar medegebruikers van de website.
							Geen enkele vorm van discriminatie of belediging wordt geaccepteerd en deze praktijken worden zwaar bestraft.</li>
						<li>Let op taalgebruik bij het aanmaken van een veiling en het schrijven van berichten naar medegebruikers.
							Zowel u als uw veiling kunnen geblokkeerd worden bij ongewenst gedrag of taalgebruik.</li>
					</ul>
				</div>
			</div>
		</div>

		<div class="accordion-item my-3">
			<h2 class="accordion-header" id="vraag7">
				<button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
					Help, ik ben geblokkeerd! Wat nu?
				</button>
			</h2>
			<div id="collapse7" class="accordion-collapse collapse" aria-labelledby="vraag7" data-parent="#vragenlijst">
				<div class="accordion-body">
					<p>Als u geblokkeerd bent, heeft u mogelijk een bericht van een administrator ontvangen met daarin een uitleg waarom.
						U kunt de gewenste aanpassingen doorvoeren en vervolgens een reactie sturen met de vraag of de blokkade opgeheven kan worden.</p>
				</div>
			</div>
		</div>

	</div>
</div>
@endsection