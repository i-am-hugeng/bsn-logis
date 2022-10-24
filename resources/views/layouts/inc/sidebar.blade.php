<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/adminlte/index3.html" class="brand-link">
      <img src="/adminlte/dist/img/logo-Logis.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">LOGIS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/adminlte/dist/img/bsn-dashboard.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
          <a href="#" class="d-block">
            {{ Auth::user()->level == 0 ? '(Super Admin)' : '(Admin)' }}
          </a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      {{-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> --}}

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-header">FITUR</li>
          <li class="nav-item">
            <a href="{{url('/dashboard')}}" class="nav-link {{ Request::is('dashboard*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas"></i>
              </p>
            </a>
          </li>
          @if(Auth::user()->level == 0)
          <li class="nav-item">
            <a href="{{url('/sk-penetapan')}}" class="nav-link {{ Request::is('sk-penetapan*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-file-contract"></i>
              <p>
                SK Penetapan SNI
              </p>
            </a>
          </li>
          @else
          <li class="nav-item disabled">
            <a href="#" class="nav-link disabled-link">
              <i class="nav-icon fas fa-file-contract"></i>
              <p>
                SK Penetapan SNI &nbsp;&nbsp;
                <span class="pull-right-container">
                  <i class="fa fa-times"></i>
                </span>  
              </p>
            </a>
          </li>
          @endif
          <li class="nav-item">
            <a href="{{url('/identifikasi-sni')}}" class="nav-link {{ Request::is('identifikasi*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-magnifying-glass-chart"></i>
              <p>
                Identifikasi SNI
              </p>
            </a>
          </li>
          @if(Auth::user()->level == 0)
          <li class="nav-item">
            <a href="{{url('/jadwal-rapat')}}" class="nav-link {{ Request::is('jadwal-rapat*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-calendar-check"></i>
              <p>
                Jadwal Rapat
              </p>
            </a>
          </li>
          @else
          <li class="nav-item disabled">
            <a href="#" class="nav-link disabled-link">
              <i class="nav-icon fas fa-calendar-check"></i>
              <p>
                Jadwal Rapat &nbsp;&nbsp;
                <span class="pull-right-container">
                  <i class="fa fa-times"></i>
                </span>  
              </p>
            </a>
          </li>
          @endif
          <li class="nav-item">
            <a href="{{url('/rapat-pembahasan')}}" class="nav-link {{ Request::is('rapat-pembahasan*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-arrows-to-eye"></i>
              <p>
                Rapat Pembahasan
              </p>
            </a>
          </li>
          @if(Auth::user()->level == 0)
          <li class="nav-item">
            <a href="{{url('/nota-dinas')}}" class="nav-link {{ Request::is('nota-dinas*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-envelope"></i>
              <p>
                Nota Dinas
              </p>
            </a>
          </li>
          @else
          <li class="nav-item disabled">
            <a href="#" class="nav-link disabled-link">
              <i class="nav-icon fas fa-envelope"></i>
              <p>
                Nota Dinas &nbsp;&nbsp;
                <span class="pull-right-container">
                  <i class="fa fa-times"></i>
                </span>  
              </p>
            </a>
          </li>
          @endif
          <div class="dropdown-divider"></div>
          <li class="nav-item">
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
                <i class="fas fa-right-from-bracket nav-icon"></i>
                <p>Logout</p>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>