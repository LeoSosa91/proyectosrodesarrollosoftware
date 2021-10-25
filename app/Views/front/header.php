<!-- top navigation bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
    <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="offcanvas"
        data-bs-target="#sidebar"
        aria-controls="offcanvasExample"
    >
        <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
    </button>
    <a class="navbar-brand me-auto ms-lg-0 ms-3 text-uppercase fw-bold" href="#">SRO</a>
    <div class="btn-group">
        <a class="nav-link dropdown-toggle text-white ms-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25" height="25"
                viewBox="0 0 172 172" style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g id="original-icon" fill="#ffffff"><path d="M86,17.2c-37.9948,0 -68.8,30.8052 -68.8,68.8c0,20.42213 8.95197,38.70699 23.07891,51.30886v-1.67969l0.79505,-1.33255c5.8824,-9.9072 28.13338,-19.62995 44.91484,-19.62995c16.79293,0 39.04937,9.71701 44.92604,19.62995l0.80625,1.34375v1.56771v0.10078c14.13267,-12.59613 23.07891,-30.88672 23.07891,-51.30886c0,-37.9948 -30.8052,-68.8 -68.8,-68.8zM86,51.6c12.64773,0 22.93333,10.2856 22.93333,22.93333v5.73333c0,12.64773 -10.2856,22.93333 -22.93333,22.93333c-12.64773,0 -22.93333,-10.2856 -22.93333,-22.93333v-5.73333c0,-12.64773 10.2856,-22.93333 22.93333,-22.93333zM86,63.06667c-6.32387,0 -11.46667,5.1428 -11.46667,11.46667v5.73333c0,6.32387 5.1428,11.46667 11.46667,11.46667c6.32387,0 11.46667,-5.1428 11.46667,-11.46667v-5.73333c0,-6.32387 -5.1428,-11.46667 -11.46667,-11.46667zM85.9888,126.13333c-13.30707,0 -29.61616,7.62452 -34.25443,12.93359l-0.0112,6.52839c10.0964,5.82507 21.77816,9.20469 34.27682,9.20469c12.49293,0 24.17469,-3.38536 34.27683,-9.20469c-0.00573,-2.0468 -0.01667,-4.21212 -0.0224,-6.52839c-4.63827,-5.30907 -20.95282,-12.93359 -34.26562,-12.93359z"></path></g></g></svg>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="<?php
        switch (session('group')) {
            case 'Administrador':
                echo base_url().'/admin/infoAdmin';
                break;
            case 'Chef':
                echo base_url().'/chef/infoChef';
                break;
            case 'Cliente':
                echo base_url().'/clients/infoClient';
                break;
        }
        ?>"><img src="https://img.icons8.com/ios-glyphs/30/000000/user--v1.png" width="20" height="20"/> Mi perfil</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="<?php
        switch (session('group')) {
            case 'Administrador':
                // echo route_to('signoutAdmin');
                echo base_url().'/admin/signout';
                break;
            case 'Chef':
                // echo route_to('signoutChef');
                echo base_url().'/chef/signout';
                break;
            case 'Cliente':
                echo base_url().'/clients/signout';
                break;
        }
        ?>"><i class="bi bi-box-arrow-right"></i> Cerrar sesion</a></li>
        </ul>
        </div>
    </div>
</nav>
<!-- top navigation bar -->
