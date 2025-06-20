<!-- Sidebar Start -->
<div class="startbar d-print-none">
    <div class="brand">
        <a href="{{ url('/dashboard') }}" class="logo d-flex align-items-center">
            <span><img src="{{ asset('assets/images/logo-sm.png') }}" alt="logo" class="logo-sm"></span>
            <span><img src="{{ asset('assets/images/logo-light.png') }}" alt="logo" class="logo-lg logo-light"></span>
            <span><img src="{{ asset('assets/images/logo-dark.png') }}" alt="logo" class="logo-lg logo-dark"></span>
            <span class="fw-bold ms-2 text-dark">STRIVE</span>
        </a>
    </div>

    <div class="startbar-menu">
        <div class="startbar-collapse" id="startbarCollapse" data-simplebar>
            <ul class="navbar-nav">

                <li class="menu-label mt-2"><span>Core Modules</span></li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/dashboard') }}">
                        <i class="iconoir-home-screen me-2"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="iconoir-building me-2"></i> <span>Branch Management</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="iconoir-scissors me-2"></i> <span>Service Transactions</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="iconoir-receipt me-2"></i> <span>Daily Sales</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="iconoir-user-badge me-2"></i> <span>Clients</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="iconoir-money-bag me-2"></i> <span>Commissions</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="iconoir-package me-2"></i> <span>Inventory</span>
                    </a>
                </li>

                <li class="menu-label mt-2"><span>Analytics & Reports</span></li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="iconoir-stats-report me-2"></i> <span>Client Analytics</span>
                    </a>
                </li>

                <!-- Reports Dropdown -->
                <li class="nav-item">
                    <a class="nav-link" href="#sidebarReports" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarReports">
                        <i class="iconoir-bar-chart-circle me-2"></i> <span>Reports</span>
                    </a>
                    <div class="collapse" id="sidebarReports">
                        <ul class="nav flex-column">
                            <li class="nav-item"><a class="nav-link" href="#">Service Reports</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Sales Reports</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Commission Reports</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Client Visit Logs</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Inventory Reports</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Financial Summary</a></li>
                        </ul>
                    </div>
                </li>

                <li class="menu-label mt-2"><span>Configuration</span></li>

                <!-- Settings Dropdown -->
                <li class="nav-item">
                    <a class="nav-link" href="#sidebarSettings" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarSettings">
                        <i class="iconoir-settings me-2"></i> <span>Settings</span>
                    </a>
                    <div class="collapse" id="sidebarSettings">
                        <ul class="nav flex-column">
                            <li class="nav-item"><a class="nav-link" href="#">User Roles</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Service Catalog</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Commission Rules</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">System Preferences</a></li>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</div>
<div class="startbar-overlay d-print-none"></div>
<!-- Sidebar End -->
