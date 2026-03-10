<?php require_once 'config.php'; require_once 'auth.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head><?php include 'head.php'; ?><title>Laptop Dipinjam — <?= APP_NAME ?></title></head>
<body>
<?php include 'navbar.php'; ?>
<div class="container-fluid px-4">
    <div class="page-header">
        <div>
            <h5><i class="bi bi-person-check me-2 text-warning"></i>Laptop Sedang Dipinjam</h5>
            <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php">Dashboard</a></li><li class="breadcrumb-item active">Dipinjam</li></ol></nav>
        </div>
        <button class="btn btn-outline-secondary btn-sm" onclick="cetakPDF()"><i class="bi bi-file-earmark-pdf me-1"></i>Cetak PDF</button>
    </div>
    <!-- Search bar -->
    <div class="mb-3">
        <div class="input-group" style="max-width:360px">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
            <input type="text" class="form-control border-start-0 ps-0" id="search-input"
                placeholder="Cari kode, merk, nama peminjam..." oninput="filterLaptop(this.value)">
            <button class="btn btn-outline-secondary" onclick="clearSearch()" title="Reset"><i class="bi bi-x"></i></button>
        </div>
    </div>
    <div class="row g-3" id="laptop-list">
        <div class="col-12 text-center py-4"><div class="spinner-border text-primary"></div></div>
    </div>
</div>
<?php include 'footer.php'; ?>
<script>
async function loadData() {
    const res = await fetch('api.php?action=get_laptops&filter=dipinjam');
    _laptopsData = await res.json();
    const container = document.getElementById('laptop-list');
    if (!_laptopsData.length) {
        container.innerHTML = '<div class="col-12"><div class="empty-state"><i class="bi bi-person-check"></i><p class="mt-2">Tidak ada laptop yang sedang dipinjam</p></div></div>';
        return;
    }
    container.innerHTML = _laptopsData.map(renderLaptopCard).join('');
}
function cetakPDF() { cetakPDFLaptop('Daftar Laptop Sedang Dipinjam', _laptopsData); }
function filterLaptop(q) {
    q = q.toLowerCase().trim();
    const filtered = !q ? _laptopsData : _laptopsData.filter(l =>
        (l.kode||'').toLowerCase().includes(q) ||
        (l.merk||'').toLowerCase().includes(q) ||
        (l.model||'').toLowerCase().includes(q) ||
        (l.nama_user||'').toLowerCase().includes(q) ||
        (l.departemen||'').toLowerCase().includes(q)
    );
    const container = document.getElementById('laptop-list');
    container.innerHTML = filtered.length
        ? filtered.map(renderLaptopCard).join('')
        : '<div class="col-12"><div class="empty-state"><i class="bi bi-search"></i><p class="mt-2">Tidak ditemukan</p></div></div>';
}
function clearSearch() {
    document.getElementById('search-input').value = '';
    filterLaptop('');
}

loadData();
</script>
</body>
</html>
