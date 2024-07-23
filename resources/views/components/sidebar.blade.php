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
            <li class="{{ $title == 'Onboarding' || $title == 'Menu' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('onboarding.index') }}"><i
                        class="fas fa-th"></i><span>Onboarding</span></a>
            </li>
            {{-- <li class="{{ $title == 'Dashboard' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('home') }}"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li> --}}
            <li class="menu-header">Services</li>
            @if (!empty(request()->query('pool')))
                <li class="{{ $title == 'Data HMKM' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('hmkms.index') }}?pool={{ request()->query('pool') }}"><i
                            class="fas fa-bus"></i><span>HMKM</span></a>
                </li>
                <li class="{{ $title == 'Data Oil' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('oils.index') }}?pool={{ request()->query('pool') }}">
                        <i class="fas fa-cubes"></i><span>Oil Coolant</span>
                    </a>
                </li>
                <li class="{{ $title == 'Data CBM' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('cbms.index') }}?pool={{ request()->query('pool') }}"><i
                            class="fas fa-wrench"></i><span>CBM</span></a>
                </li>
                <li class="{{ $title == 'Data CBM Project' ? 'active' : '' }}">
                    <a class="nav-link"
                        href="{{ route('cbm_projects.index') }}?pool={{ request()->query('pool') }}"><i
                            class="fas fa-tools"></i><span>CBM Project</span></a>
                </li>
                <li class="{{ $title == 'Data DMCR' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('dmcrs.index') }}?pool={{ request()->query('pool') }}"><i
                            class="fas fa-list"></i><span>DMCR</span></a>
                </li>
                <li class="{{ $title == 'Data Keluhan' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('keluhans.index') }}?pool={{ request()->query('pool') }}"><i
                            class="fas fa-comments"></i><span>Keluhan / Temuan</span></a>
                </li>
                <li class="{{ $title == 'Data Speed Limit' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('speeds.index') }}?pool={{ request()->query('pool') }}"><i
                            class="fas fa-tachometer-alt"></i><span>Speed Limit</span></a>
                </li>
            @endif
            <li class="{{ $title == 'Data Logbook Storing' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('logbooks.index') }}"><i class="fas fa-tags"></i><span>LogBook
                        Storing</span></a>
            </li>
            <li class="{{ $title == 'Data PPM' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('ppms_data.index') }}"><i
                        class="fas fa-file-pdf"></i><span>PPM</span></a>
            </li>
            @if ($user->is_admin())
                <li class="menu-header">Master</li>
                @php
                    $array = [
                        'Data User',
                        'Data Unit',
                        'Data Category',
                        'Data Product',
                        'Data Component',
                        'Data Pool',
                        'Data List PPM',
                    ];
                @endphp
                <li class="nav-item dropdown {{ in_array($title, $array) ? 'active show' : '' }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                            class="fas fa-database"></i>
                        <span>Master Data</span></a>
                    <ul class="dropdown-menu {{ in_array($title, $array) ? 'active' : '' }}">
                        <li class="{{ $title == 'Data Pool' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('pools.index') }}">Pool</a>
                        </li>
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
                        <li class="{{ $title == 'Data List PPM' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('ppms.index') }}">PPM</a>
                        </li>
                    </ul>
                </li>
            @endif

        </ul>

    </aside>
</div>
