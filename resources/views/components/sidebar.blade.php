<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('home') }}">{{ env('APP_NAME') }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('home') }}">{{ env('APP_NAME_INITIAL') }}</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ $title == 'Dashboard' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('home') }}"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            <li class="{{ $title == 'Onboarding' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('onboarding.index') }}"><i
                        class="fas fa-fire"></i><span>Onboarding</span></a>
            </li>
            <li class="{{ $title == 'Laporan' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('home') }}"><i
                        class="fas fa-calendar-check"></i><span>Laporan</span></a>
            </li>

            <li class="{{ $title == 'HMKM' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('hmkms.index') }}"><i
                        class="fas fas fa-thumbtack"></i><span>HMKM</span></a>
            </li>
            <li class="{{ $title == 'Data Oil' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('oils.index') }}">
                    <i class="fas fa-cubes"></i><span>Oil Coolant</span>
                </a>
            </li>
            @if ($user->is_admin())
                <li class="menu-header">Master</li>
                @php
                    $array = ['Data User', 'Data Unit', 'Data Category', 'Data Product', 'Data Component'];
                @endphp
                <li class="nav-item dropdown {{ in_array($title, $array) ? 'active show' : '' }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                            class="fas fa-database"></i>
                        <span>Master Data</span></a>
                    <ul class="dropdown-menu {{ in_array($title, $array) ? 'active' : '' }}">
                        <li class="{{ $title == 'Data User' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('users.index') }}">User</a>
                        </li>
                        <li class="{{ $title == 'Data Unit' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('units.index') }}">Unit</a>
                        </li>
                        <li class="{{ $title == 'Data Product' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('products.index') }}">Product</a>
                        </li>
                        <li class="{{ $title == 'Data Component' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('components.index') }}">Component</a>
                        </li>
                    </ul>
                </li>
            @endif

        </ul>

    </aside>
</div>
