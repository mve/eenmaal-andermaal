
<div>
    Beste {{ $data->username}}<br><br>

    @if ($data->type == "2")

        Iemand heeft een wachtwoord herstel aanvraag ingedient alleen de beveiligings vraag en/ of wachtwoord in onjuist<br>
        Wanneer jij dit niet geweest bent herstel dan nu je wachtwoord op: <a href="{{ env('APP_URL') }}/wachtwoordvergeten">{{ env('APP_URL') }}/wachtwoordvergeten</a>

    @elseif ($data->type == "1")

        Er is een wachtwoord herstel aanvraag ingediend klik op de volgende knop:<br>
        <a style="box-sizing:border-box;font-family:Arial,'Helvetica Neue',Helvetica,sans-serif;display:inline-block;width:200px;min-height:20px;padding:10px;background-color:#3869d4;border-radius:3px;color:#ffffff;font-size:15px;line-height:25px;text-align:center;text-decoration:none" href="{{ env('APP_URL') }}/wachtwoordvergeten/{{$data->token}}"> Wachtwoord herstellen</a> <br>

        Heb jij deze aanvraag niet ingediend verander je beveiligs vraag en vraag een nieuw wachtwoord herstell aan op de volgende url: <a href="{{ env('APP_URL') }}/wachtwoordvergeten">{{ env('APP_URL') }}:8000/wachtwoordvergeten</a>

    @elseif ($data->type == "3")

        Je wachtwoord is succesvol gewijzigd!<br>
        Ben jij dit niet geweest herstel je wachtwoord dan meteen via de onderstaande knop<br>
        <a style="box-sizing:border-box;font-family:Arial,'Helvetica Neue',Helvetica,sans-serif;display:inline-block;width:200px;min-height:20px;padding:10px;background-color:#3869d4;border-radius:3px;color:#ffffff;font-size:15px;line-height:25px;text-align:center;text-decoration:none" href="{{ env('APP_URL') }}/wachtwoordvergeten"> Wachtwoord herstellen</a> <br>


    @endif


</div>
