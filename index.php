<?php
require_once 'config.php';
require_once 'auth.php';
?>
<!DOCTYPE html>
<html lang="id">
<head><?php include 'head.php'; ?><title>Dashboard — <?= APP_NAME ?></title></head>
<body>
<?php include 'navbar.php'; ?>
<div class="container-fluid px-4">

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <a href="total-laptop.php" class="text-decoration-none">
                <div class="stat-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon" style="background:#eff6ff;color:#1a56db"><i class="bi bi-laptop"></i></div>
                        <div>
                            <div class="number" id="stat-total">-</div>
                            <div class="label">Total Laptop</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="tersedia.php" class="text-decoration-none">
                <div class="stat-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon" style="background:#d1fae5;color:#057a55"><i class="bi bi-check-circle"></i></div>
                        <div>
                            <div class="number" id="stat-tersedia">-</div>
                            <div class="label">Tersedia</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="dipinjam.php" class="text-decoration-none">
                <div class="stat-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon" style="background:#fed7aa;color:#b45309"><i class="bi bi-person-check"></i></div>
                        <div>
                            <div class="number" id="stat-dipinjam">-</div>
                            <div class="label">Sedang Dipinjam</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="maintenance.php" class="text-decoration-none">
                <div class="stat-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon" style="background:#f1f5f9;color:#64748b"><i class="bi bi-tools"></i></div>
                        <div>
                            <div class="number" id="stat-maintenance">-</div>
                            <div class="label">Maintenance</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Laptop dipinjam sekarang -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="bi bi-person-check me-2 text-warning"></i>Laptop Sedang Dipinjam</span>
            <a href="dipinjam.php" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="ps-3">Laptop</th>
                            <th>Peminjam</th>
                            <th>Departemen</th>
                            <th>Keperluan</th>
                            <th>Tgl Pinjam</th>
                        </tr>
                    </thead>
                    <tbody id="tbl-dipinjam">
                        <tr><td colspan="6" class="text-center py-3"><div class="spinner-border spinner-border-sm text-primary"></div></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<?php include 'footer.php'; ?>
<script>
async function loadData() {
    const res  = await fetch('api.php?action=get_stats');
    const stat = await res.json();
    document.getElementById('stat-total').textContent       = stat.total;
    document.getElementById('stat-tersedia').textContent    = stat.tersedia;
    document.getElementById('stat-dipinjam').textContent    = stat.dipinjam;
    document.getElementById('stat-maintenance').textContent = stat.maintenance;

    const res2 = await fetch('api.php?action=get_laptops&filter=dipinjam');
    _laptopsData = await res2.json();
    const tbody = document.getElementById('tbl-dipinjam');
    if (!_laptopsData.length) {
        tbody.innerHTML = '<tr><td colspan="6"><div class="empty-state"><i class="bi bi-check-circle"></i><p class="mt-2">Tidak ada laptop yang sedang dipinjam</p></div></td></tr>';
        return;
    }
    tbody.innerHTML = _laptopsData.map(l => `
        <tr>
            <td class="ps-3"><b>${l.kode}</b><br><small class="text-muted">${l.merk} ${l.model}</small></td>
            <td>${l.nama_user}</td>
            <td>${l.departemen||'-'}</td>
            <td><small>${l.keperluan||'-'}</small></td>
            <td><small>${l.tgl_pinjam}</small></td>
        </tr>
    `).join('');
}
loadData();
</script>
</body>
</html>
