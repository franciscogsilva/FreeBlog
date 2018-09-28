<ul id="dropdown-admin" class="dropdown-content dropdown-content-fgs">
    <li>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar Sesión<i class="material-icons right">exit_to_app</i></a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </li>
</ul>
<div class="navbar">
    <nav class="right-fgs-bar">
        <div class="nav-wrapper">
            <a class="brand-logo brand-logo-fgs">{{ $title_page }}</a>
            <a href="#" data-activates="slide-out" class="button-collapse right"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
                <li>
                    <a class="dropdown-button" href="#!" data-activates="dropdown-admin">
                        <i class="material-icons left dropdown-admin-icon-left">person</i>
                        {!! str_limit(Auth::user()->name, 16) !!}
                        <i class="material-icons right dropdown-admin-icon-right">arrow_drop_down</i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>    
</div>



