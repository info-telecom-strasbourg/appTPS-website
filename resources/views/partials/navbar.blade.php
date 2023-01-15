<nav class="navbar navbar-icon-top navbar-expand-lg navbar-dark bg-dark">
    @php
    $currentURL = url()->current();
    @endphp

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button><br><br>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <img src="/images/logo/InsidePSBS.png" width="50" />
        &nbsp;&nbsp;&nbsp;

        <ul class="navbar-nav mr-auto">
            @if ($currentURL=="https://app.its-tps.fr")
            <li class="nav-item active">
                @else
            <li class="nav-item">
                @endif
                <a class="nav-link" href="https://app.its-tps.fr/">
                    <i class="fa fa-home"></i>
                    Accueil
                </a>
            </li>
            @if ($currentURL=="https://app.its-tps.fr/fouaille")
            <li class="nav-item active">
                @else
            <li class="nav-item">
                @endif
                <a class="nav-link" href="https://app.its-tps.fr/fouaille">
                    <i class="fa fa-dollar-sign"></i>
                    Fouaille
                </a>
            </li>

            @if ($currentURL=="https://app.its-tps.fr/logos")
            <li class="nav-item active">
                @else
            <li class="nav-item">
                @endif
                <a class="nav-link" href="https://app.its-tps.fr/logos">
                    <i class="fa fa-icons">
                    </i>
                    Logos
                </a>
            </li>

            @if (session()->get('cas_role')=="admin" || session()->get('cas_role')=="rédacteur")
            @if ($currentURL=="https://app.its-tps.fr/create-article")
            <li class="nav-item active">
                @else
            <li class="nav-item">
                @endif
                <a class="nav-link" href="https://app.its-tps.fr/create-article">
                    <i class="fa fa-pen-to-square"></i>
                    Rédaction article
                </a>
            </li>
            @endif

            @if (session()->get('cas_role')=="admin")
            @if ($currentURL=="https://app.its-tps.fr/users")
            <li class="nav-item active">
                @else
            <li class="nav-item">
                @endif
                <a class="nav-link" href="https://app.its-tps.fr/users">
                    <i class="fa fa-users">
                        <!--              <span class="badge badge-danger">11</span> -->
                    </i>
                    Utilisateurs
                </a>
            </li>
            @endif
        </ul>
        <span style="color: rgb(200, 200, 200);">
            @php
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . session()->get('cas_name') . " : " . session()->get('cas_role') . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            @endphp
        </span>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="https://app.its-tps.fr/logout">
                    <i class="fa fa-right-from-bracket"></i>
                    Déconnexion
                </a>
            </li>
    </div>
</nav>