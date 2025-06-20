<!-- Sidebar Start -->
<div class="startbar d-print-none">
    <div class="brand">
        <a href="{{ url('/dashboard') }}" class="logo">
            <span><img src="{{ asset('assets/images/logo-sm.png') }}" alt="logo" class="logo-sm"></span>
            <span><img src="{{ asset('assets/images/logo-light.png') }}" alt="logo" class="logo-lg logo-light"></span>
            <span><img src="{{ asset('assets/images/logo-dark.png') }}" alt="logo" class="logo-lg logo-dark"></span>
        </a>
    </div>
    <div class="startbar-menu">
        <div class="startbar-collapse" id="startbarCollapse" data-simplebar>
            <ul class="navbar-nav">
                <li class="menu-label mt-2"><span>Core Modules</span></li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <i class="iconoir-dashboard"></i><span>Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('branches.index') }}">
                        <i class="iconoir-home-simple-door"></i><span>Branch Management</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('sales.index') }}">
                        <i class="iconoir-dollar-square"></i><span>Daily Sales</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('services.index') }}">
                        <i class="iconoir-cut-alt"></i><span>Service Transactions</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('clients.index') }}">
                        <i class="iconoir-user-square"></i><span>Clients</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('commissions.index') }}">
                        <i class="iconoir-coins"></i><span>Commissions</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('inventory.index') }}">
                        <i class="iconoir-box"></i><span>Inventory</span>
                    </a>
                </li>

                <li class="menu-label mt-2"><span>Reports & Settings</span></li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('reports.index') }}">
                        <i class="iconoir-bar-chart-circle"></i><span>Reports</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('settings.index') }}">
                        <i class="iconoir-settings"></i><span>Settings</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="startbar-overlay d-print-none"></div>
<!-- Sidebar End -->
