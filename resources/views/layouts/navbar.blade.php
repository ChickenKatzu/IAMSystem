<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-outline-secondary">
            <i class="bi bi-list"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <!-- Dashboard Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dashboardDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-pie-chart"></i> Overview</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-graph-up"></i> Analytics</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-calendar"></i> Reports</a></li>
                    </ul>
                </li>

                <!-- Inventory Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="inventoryDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-box"></i> Inventory
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('inventory.create') }}"><i class="bi bi-plus-circle"></i> Add Item</a></li>
                        <li><a class="dropdown-item" href="{{ route('inventory.index') }}"><i class="bi bi-list-ul"></i> List Items</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-category"></i> Categories</a></li>
                    </ul>
                </li>

                <!-- Assets Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="assetsDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-building"></i> Assets
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-plus-square"></i> Register Asset</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-grid"></i> Asset List</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-tools"></i> Maintenance</a></li>
                    </ul>
                </li>

                <!-- User Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> Admin
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
