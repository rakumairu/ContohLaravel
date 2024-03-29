<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ url('/dashboard')}}" class="brand-link">
    <img
      src="{{ asset('/img/i-logo.png') }}"
      alt="AdminLTE Logo"
      class="brand-image img-circle elevation-3"
      style="opacity: .8"
    >
    <span class="brand-text font-weight-light">IKI Portal
    </span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ Auth::user()->username }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar nav-child-indent flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="{{route('home')}}" class="nav-link
            @if ($tab_active == 'dashboard')
                active
            @endif">
            <i class="nav-icon fas fa-desktop"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>

        <li class="nav-item">
            <a href="{{route('city')}}" class="nav-link
              @if ($tab_active == 'city')
                  active
              @endif">
              <i class="nav-icon fas fa-building"></i>
              <p>
                City
              </p>
            </a>
          </li>

          <li class="nav-item">
              <a href="{{route('province')}}" class="nav-link
                @if ($tab_active == 'province')
                    active
                @endif">
                <i class="nav-icon fas fa-map"></i>
                <p>
                  Province
                </p>
              </a>
            </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>

