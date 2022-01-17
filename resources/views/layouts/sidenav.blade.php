<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-2">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link pl-0 pr-0">
        <img src="{{ asset('images/logo.png') }}" alt="System Logos" class="brand-text"
            style="max-width: 24%; margin: 0 auto; display: block;">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel pb-2 pt-3 text-center">
            <div class="info">
                <a href="#" class="d-block">Welcome {{Auth::user()->name}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ Nav::isRoute('home') }}">
                        <i class="nav-icon fas fa-tachometer-alt mr-2"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @canany(['roles-index','users-index'])
                    <li class="nav-item has-treeview {{ Nav::hasSegment(['roles','users']) ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Nav::hasSegment(['roles','users'])}}">
                        <i class="nav-icon fas fa-user-cog mr-2"></i>
                        <p>
                            User Management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                        </a>
                        <ul class="nav nav-treeview ">
                            @can('users-index')
                                <li class="nav-item pl-2">
                                    <a href="{{ route('users.index') }}" class="nav-link" style="{{ Nav::isResource('users') ? 'background-color:#303030' : '' }}">
                                    <i class="fas fa-users mr-2 ml-1"></i>
                                    <p>User</p>
                                    </a>
                                </li>
                            @endcan
                            @can('roles-index')
                            <li class="nav-item pl-2">
                                <a href="{{ route('roles.index') }}" class="nav-link" style="{{ Nav::isResource('roles') ? 'background-color:#303030' : '' }}">
                                <i class="fas fa-briefcase mr-2 ml-1"></i>
                                <p>Role</p>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
            </ul>
        </nav>
    </div>
</aside>