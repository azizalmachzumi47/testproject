<div class="menu-list">
  <nav class="navbar navbar-expand-lg navbar-light">
    <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav flex-column">
        <li class="nav-divider">
          Menu
        </li>

        @php
        $role_id = Auth::user()->role_id;

        $queryMenu = "SELECT users_menu.id, menu, icon_menu
        FROM users_menu
        JOIN users_access_menu
        ON users_menu.id = users_access_menu.menu_id
        WHERE users_access_menu.role_id = ?
        ORDER BY users_access_menu.menu_id ASC";

        $menu = DB::select($queryMenu, [$role_id]);
        @endphp

        @foreach ($menu as $m)
        <li class="nav-item">
          <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-{{ $m->id }}"
            aria-controls="submenu-{{ $m->id }}">
            <i class="{{ $m->icon_menu }}"></i>{{ $m->menu }}
          </a>
          <div id="submenu-{{ $m->id }}" class="collapse submenu" style="">
            <ul class="nav flex-column">
              @php
              $subMenus = DB::table('users_sub_menu')
              ->join('users_menu', 'users_sub_menu.menu_id', '=', 'users_menu.id')
              ->where('users_sub_menu.menu_id', $m->id)
              ->where('users_sub_menu.is_active', 1)
              ->get();
              @endphp
              @foreach ($subMenus as $sm)
              <li class="nav-item">
                <a class="nav-link" href="{{ url($sm->url) }}">{{ $sm->title }}</a>
              </li>
              @endforeach
            </ul>
          </div>
        </li>
        @endforeach
      </ul>
    </div>
  </nav>
</div>