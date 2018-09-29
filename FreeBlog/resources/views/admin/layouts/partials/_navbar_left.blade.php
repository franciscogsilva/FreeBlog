    <ul id="slide-out" class="side-nav fixed side-nav-fgs">
      <li>
        <div class="brand-sidenav-fgs valign-wrapper center-align" style="background-color: #212121;">
          <a href="{{ route('welcome') }}">
            <img class="responsive-img logo-fgs" src="{{ asset('img/system32/logo-CMS.png') }}">
          </a>
        </div>
      </li>
      <li><div class="divider-fgs"></div></li>
      <li>
        <div class="menu-item-fgs valign-wrapper">
          <a href="{{ route('admin.index') }}" {{ $menu_item == 0 ? 'class=active-fgs' : '' }}><i class="material-icons">dashboard</i>Administración</a>         
        </div>
      </li>
      <li><div class="divider-fgs"></div></li>
      <li>
        <div class="menu-item-fgs valign-wrapper">
          <a href="{{ route('users.index') }}" {{ $menu_item == 2 ? 'class=active-fgs' : '' }}><i class="material-icons">people</i>Usuarios</a>         
        </div>
      </li>
      <li><div class="divider-fgs"></div></li>
      <li>
        <div class="menu-item-fgs valign-wrapper">
          <a href="{{ route('articles.index') }}" {{ $menu_item == 1 ? 'class=active-fgs' : '' }}><i class="material-icons">description</i>Articulos</a>         
        </div>
      </li>
      <li>
        <div class="menu-item-fgs valign-wrapper">
          <a href="{{ route('categories.index') }}" {{ $menu_item == 3 ? 'class=active-fgs' : '' }}><i class="material-icons">tune</i>Categorias</a>         
        </div>
      </li>
      <li>
        <div class="menu-item-fgs valign-wrapper">
          <a href="{{ route('tags.index') }}" {{ $menu_item == 4 ? 'class=active-fgs' : '' }}><i class="material-icons">sort</i>Tags</a>         
        </div>
      </li>
      <li id="menu-messages-fgs"><div class="divider-fgs"></div></li>
      <li id="menu-messages-fgs">
        <div class="menu-item-fgs valign-wrapper">
          <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="material-icons">exit_to_app</i>Cerrar Sesión
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
          </form>
        </div>
      </li>
      <li><div class="divider-fgs"></div></li>
    </ul>
            