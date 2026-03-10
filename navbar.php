<!-- navbar.php — include di setiap halaman -->
<nav class="navbar navbar-dark px-4 py-3 mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="index.php" class="navbar-brand mb-0"><i class="bi bi-laptop me-2"></i><?= APP_NAME ?></a>
        <div class="nav-pages d-flex gap-1">
            <a href="index.php" class="nav-btn <?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : '' ?>"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a>
            <a href="total-laptop.php" class="nav-btn <?= basename($_SERVER['PHP_SELF']) === 'total-laptop.php' ? 'active' : '' ?>"><i class="bi bi-laptop me-1"></i>Total Laptop</a>
            <a href="tersedia.php" class="nav-btn <?= basename($_SERVER['PHP_SELF']) === 'tersedia.php' ? 'active' : '' ?>"><i class="bi bi-check-circle me-1"></i>Tersedia</a>
            <a href="dipinjam.php" class="nav-btn <?= basename($_SERVER['PHP_SELF']) === 'dipinjam.php' ? 'active' : '' ?>"><i class="bi bi-person-check me-1"></i>Dipinjam</a>
            <a href="maintenance.php" class="nav-btn <?= basename($_SERVER['PHP_SELF']) === 'maintenance.php' ? 'active' : '' ?>"><i class="bi bi-tools me-1"></i>Maintenance</a>
            <a href="riwayat.php" class="nav-btn <?= basename($_SERVER['PHP_SELF']) === 'riwayat.php' ? 'active' : '' ?>"><i class="bi bi-clock-history me-1"></i>Riwayat</a>
        </div>
    </div>
    <div class="d-flex align-items-center gap-3">
        <span class="text-white-50 small d-none d-md-block" id="clock"></span>
        <div class="dropdown">
            <button class="btn btn-sm btn-outline-light rounded-pill dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle me-1"></i><?= htmlspecialchars($_SESSION['admin_nama']) ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#" onclick="openGantiPassword()"><i class="bi bi-key me-2"></i>Ganti Password</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
