<nav class="navbar navbar-expand-lg bg-white fixed-top">
  <a class="navbar-brand" href="{{route('dashboard.index')}}">
    <img src="{{asset('favicon_pstechno.png')}}" alt="Logo PSTECHNO" style="width: 100px; height: auto;" class="light-logo" />
    PSTECHNO
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse"
      data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
      aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse " id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto navbar-right-top">
         
          <li class="nav-item dropdown notification">
              <a class="nav-link nav-icons" href="#" id="navbarDropdownMenuLink1" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-bell"></i> <span
                      class="indicator"></span></a>
              <ul class="dropdown-menu dropdown-menu-right notification-dropdown">
                  <li>
                      <div class="notification-title"> Notification</div>
                      <div class="notification-list">
                          <div class="list-group">
                              {{-- <a href="#" class="list-group-item list-group-item-action active">
                                  <div class="notification-info">
                                      <div class="notification-list-user-img"><img
                                              src="{{asset('assetsapp/images/avatar-2.jpg')}}" alt=""
                                              class="user-avatar-md rounded-circle"></div>
                                      <div class="notification-list-user-block"><span
                                              class="notification-list-user-name">Jeremy
                                              Rakestraw</span>accepted your invitation to join the team.
                                          <div class="notification-date">2 min ago</div>
                                      </div>
                                  </div>
                              </a> --}}
                             
                          </div>
                      </div>
                  </li>
                  <li>
                      <div class="list-footer"></div>
                  </li>
              </ul>
          </li>
        
          <li class="nav-item dropdown nav-user">
              <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <img src="{{ Str::startsWith(Auth::user()->image, 'https') ? Auth::user()->image : asset('images/' . (Auth::user()->image ?: 'default.png')) }}" 
                    alt="Gambar" class="user-avatar-md rounded-circle">
                </a>
              <div class="dropdown-menu dropdown-menu-right nav-user-dropdown"
                  aria-labelledby="navbarDropdownMenuLink2">
                  <div class="nav-user-info">
                      <h5 class="mb-0 text-white nav-user-name">{{ Auth::user()->name }}</h5>
                  </div>
                  <a class="dropdown-item" href="#"><i class="fas fa-user mr-2"></i>Account</a>
                  <a class="dropdown-item" href="#"><i class="fas fa-cog mr-2"></i>Setting</a>
                  <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-power-off mr-2"></i>Logout
                  </a>
              </div>
          </li>
      </ul>
  </div>
</nav>