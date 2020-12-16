<div class="sidebar">
    <div class="hamburgermenu">
        <div id="mySidepanel" class="sidepanel">
            <div id="closebtn" class="closebtn">&times;</div>
            <div class="text-center mb-3 fw-bold title">Eenmaal Andermaal</div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-fw fa-chart-line"></i>Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-fw fa-users"></i>Gebruikers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-fw fa-gavel"></i>Veilingen</a>
                </li>
            </ul>


            <div class="bottom-info">
                <ul class="nav flex-column ">
                    <li class="nav-item">
                        <i>U bent ingelogd als:</i>
                    </li>
                    <li class="nav-item">
                        <b>"admin"</b>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('Admin.logout') }}">Uitloggen</a>
                    </li>
                </ul>
            </div>

        </div>

        <button id="openbtn" class="openbtn">&#9776;</button>

    </div>
</div>



