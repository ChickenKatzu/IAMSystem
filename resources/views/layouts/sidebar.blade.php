<nav id="sidebar">
    <div class="sidebar-header">
        <h4 class="mb-0 text-white">
            <i class="bi bi-boxes"></i> IAM System
        </h4>
        <small class="text-white-50">Inventory & Asset Management</small>
    </div>

    <ul class="list-unstyled components">
        <li class="active">
            <a href="{{ route('dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="#inventorySubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="bi bi-box"></i> Inventory
            </a>
            <ul class="collapse list-unstyled" id="inventorySubmenu">
                <li><a href="{{ route('inventory.create') }}"><i class="bi bi-plus-circle"></i> Add Item</a></li>
                <li><a href="{{ route('inventory.index') }}"><i class="bi bi-list"></i> Item List</a></li>
                <li><a href="#"><i class="bi bi-tags"></i> Categories</a></li>
                <li><a href="#"><i class="bi bi-arrow-repeat"></i> Stock Opname</a></li>
            </ul>
        </li>
        <li>
            <a href="#assetsSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="bi bi-building"></i> Asset Management
            </a>
            <ul class="collapse list-unstyled" id="assetsSubmenu">
                <li><a href="#"><i class="bi bi-plus-square"></i> Register Asset</a></li>
                <li><a href="#"><i class="bi bi-grid-3x3"></i> Asset List</a></li>
                <li><a href="#"><i class="bi bi-tools"></i> Maintenance</a></li>
                <li><a href="#"><i class="bi bi-arrow-left-right"></i> Asset Transfer</a></li>
                <li><a href="#"><i class="bi bi-trash"></i> Disposal</a></li>
            </ul>
        </li>
        <li>
            <a href="#">
                <i class="bi bi-people"></i> Employees
            </a>
        </li>
        <li>
            <a href="#">
                <i class="bi bi-shop"></i> Suppliers
            </a>
        </li>
        <li>
            <a href="#">
                <i class="bi bi-file-text"></i> Reports
            </a>
        </li>
    </ul>

    <ul class="list-unstyled components">
        <li>
            <a href="#master" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="bi bi-building"></i> Masters
            </a>
            <ul class="collapse list-unstyled" id="master">
                <li><a href="#"><i class="bi bi-plus-square"></i> Master Barang </a></li>
                <li><a href="#"><i class="bi bi-grid-3x3"></i> Master Supplier</a></li>
                <li><a href="#"><i class="bi bi-tools"></i> Master Satuan</a></li>
                <li><a href="#"><i class="bi bi-arrow-left-right"></i> Master Kategori</a></li>
                <li><a href="#"><i class="bi bi-trash"></i> Master User</a></li>
            </ul>
        </li>
        <li>
            <a href="#">
                <i class="bi bi-gear"></i> Settings
            </a>
        </li>
        <li>
            <a href="#">
                <i class="bi bi-question-circle"></i> Help
            </a>
        </li>
    </ul>
</nav>
