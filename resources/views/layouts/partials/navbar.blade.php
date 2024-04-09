<div class="sidenav">
    <a href="#services" class="text-white"><i class="fa-solid fa-chart-pie text-primary"></i> Strategienavigator</a>
    <a href="#services" ><i class="fa-solid fa-gauge"></i>  Dashboard</a>
    <button class="dropdown-btn"><i class="fa-solid fa-user-pen"></i> Benutzer verwalten
        <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-container">
        <a href="{{route('users.index')}}"><i class="fa-solid fa-arrow-right"></i> Benutzer verwalten</a>
        <a href="{{route('roles.index')}}"><i class="fa-solid fa-arrow-right"></i> Rollen verwalten</a>
    </div>
    <a href="#services"><i class="fa-solid fa-envelope"></i> Rundmail senden</a>
    <a href="{{route('statistics.index')}}"><i class="fa-solid fa-chart-column"></i> Datenbank Statistik anzeigen</a>
    <a href="{{route('tools.index')}}"><i class="fa-solid fa-gear"></i> Tools verwalten</a>
    <a href="#contact"><i class="fa-solid fa-toggle-off"></i> Watungsmodus an/aus</a>
</div>

