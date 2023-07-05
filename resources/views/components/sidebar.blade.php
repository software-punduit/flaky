<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="{{ config('app.name') }}"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ Auth::user()->avatar_url }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('profile.show') }}" class="d-block">
                    {{ Auth::user()->name }}<br>
                    <span class="text-secondary">
                        {{ Auth::user()->highest_role }}
                    </span>
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
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ Route::CurrentRouteName() === 'dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>

                </li>

                @can('users.view')
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}"
                            class="nav-link {{ Str::startsWith(Route::current()->uri(), 'users') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Users
                            </p>
                        </a>
                    </li>
                @endcan
                
                @can('restaurants.view')
                    <li class="nav-item">
                        <a href="{{ route('restaurants.index') }}"
                            class="nav-link {{ Str::startsWith(Route::current()->uri(), 'restaurants') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-store"></i>
                            <p>
                                Restaurants
                            </p>
                        </a>
                    </li>
                @endcan
                @can('restaurant-staff.view')
                    <li class="nav-item">
                        <a href="{{ route('restaurant-staff.index') }}"
                            class="nav-link {{ Str::startsWith(Route::current()->uri(), 'restaurant-staff') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-tie"></i>
                            <p>
                                Restaurant Staff
                            </p>
                        </a>
                    </li>
                @endcan
                @can('table.view')
                    <li class="nav-item">
                        <a href="{{ route('restaurant-tables.index') }}"
                            class="nav-link {{ Str::startsWith(Route::current()->uri(), 'restaurant-tables') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chair"></i>
                            <p>
                                Restaurant Table
                            </p>
                        </a>
                    </li>
                @endcan


                <li class="nav-header">MULTI LEVEL EXAMPLE</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-circle nav-icon"></i>
                        <p>Level 1</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-circle"></i>
                        <p>
                            Level 1
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Level 2</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Level 2
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Level 3</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Level 3</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Level 3</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Level 2</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-circle nav-icon"></i>
                        <p>Level 1</p>
                    </a>
                </li>
                <hr class="bg-secondary" width="100%">
                <li class="nav-item bg-danger">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="nav-link btn btn-link" type="submit">
                            <i class="nav-icon fas fa-sign-out-alt text-white"></i>
                            <p class="text-white">Logout</p>
                        </button>
                    </form>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        {{-- <i class="nav-icon far fa-circle text-danger"></i> --}}
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
