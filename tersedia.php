<?php require_once 'config.php'; require_once 'auth.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head><?php include 'head.php'; ?><title>Laptop Tersedia — <?= APP_NAME ?></title></head>
<body>
<?php include 'navbar.php'; ?>
<div class="container-fluid px-4">
    <div class="page-header">
        <div>
            <h5><i class="bi bi-check-circle me-2 text-success"></i>Laptop Tersedia</h5>
            <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php">Dashboard</a></li><li class="breadcrumb-item active">Tersedia</li></ol></nav>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm" onclick="cetakPDF()"><i class="bi bi-file-earmark-pdf me-1"></i>Cetak PDF</button>
            <button class="btn btn-primary btn-sm" onclick="openTambahLaptop()"><i class="bi bi-plus-lg me-1"></i>Tambah Laptop</button>
        </div>
    </div>
    <!-- Search bar -->
    <div class="mb-3">
        <div class="input-group" style="max-width:360px">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
            <input type="text" class="form-control border-start-0 ps-0" id="search-input"
                placeholder="Cari kode, merk, model..." oninput="filterLaptop(this.value)">
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
    const res = await fetch('api.php?action=get_laptops&filter=tersedia');
    _laptopsData = await res.json();
    const container = document.getElementById('laptop-list');
    if (!_laptopsData.length) {
        container.innerHTML = '<div class="col-12"><div class="empty-state"><i class="bi bi-check-circle"></i><p class="mt-2">Tidak ada laptop tersedia saat ini</p></div></div>';
        return;
    }
    container.innerHTML = _laptopsData.map(renderLaptopCard).join('');
}
function cetakPDF() { cetakPDFLaptop('Daftar Laptop Tersedia', _laptopsData); }
function filterLaptop(q) {
    q = q.toLowerCase().trim();
    const filtered = !q ? _laptopsData : _laptopsData.filter(l =>
        (l.kode||'').toLowerCase().includes(q) ||
        (l.merk||'').toLowerCase().includes(q) ||
        (l.model||'').toLowerCase().includes(q) ||
        (l.spesifikasi||'').toLowerCase().includes(q)
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
