<div class="modal"  id="exampleModalCenter" role="dialog" aria-labelledby="exampleModalCenterTitle" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content rounded-5">
        <div class="modal-header text-center">
          <h5 class="modal-title float-center" id="exampleModalLongTitle">EenmaalAndermaal maakt gebruik van cookies</h5>
        </div>
        <div class="modal-body">
          Deze website verzameld met cookies informatie over je locatie en surfgedrag.<p>&nbsp;</p> 

          We gebruiken dit voor de volgende doeleinden: analyseren van de activiteit op de website, 
          personaliseren van content, informatie op een apparaat opslaan en/of openen, 
          gepersonaliseerde content, inzichten in het publiek en productontwikkeling.<p>&nbsp;</p> 

          Mocht je de cookies niet toestaan dan gebruiken we alleen noodzakelijke gegevens om de werking van deze site te garanderen.
          Je keuze geldt voor deze media. Lees meer in ons privacy- en cookiestatement.
        </div>
        <div class="modal-footer">
     
          <form method="POST" action="{{ route('cookie') }}">
            @csrf
            <input type="submit" value="Cookies niet toestaan" name="cookie_disallow" class="btn btn-secondary">
            <input type="submit" value="Cookies toestaan" name="cookie_allow" class="btn btn-primary">
          </form>
        </div>
      </div>
    </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', (event) => {
    document.getElementById("exampleModalCenter").style.display = "block";
    document.getElementById("exampleModalCenter").classList.add("modal-backdrop fade show");
 })
</script>

<div id="backdrop" class="modal-backdrop fade show"> </div>

  