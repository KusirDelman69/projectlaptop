<?php require_once 'config.php'; require_once 'auth.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head><?php include 'head.php'; ?><title>Maintenance — <?= APP_NAME ?></title></head>
<body>
<?php include 'navbar.php'; ?>
<div class="container-fluid px-4">
    <div class="page-header">
        <div>
            <h5><i class="bi bi-tools me-2 text-secondary"></i>Laptop Maintenance</h5>
            <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php">Dashboard</a></li><li class="breadcrumb-item active">Maintenance</li></ol></nav>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm" onclick="cetakPDF()"><i class="bi bi-file-earmark-pdf me-1"></i>Cetak PDF</button>
            <button class="btn btn-primary btn-sm" onclick="openTambahLaptop()"><i class="bi bi-plus-lg me-1"></i>Tambah Laptop</button>
        </div>
    </div>
    <div class="row g-3" id="laptop-list">
        <div class="col-12 text-center py-4"><div class="spinner-border text-primary"></div></div>
    </div>
</div>
<?php include 'footer.php'; ?>
<script>
async function loadData() {
    const res = await fetch('api.php?action=get_laptops&filter=maintenance');
    _laptopsData = await res.json();
    const container = document.getElementById('laptop-list');
    if (!_laptopsData.length) {
        container.innerHTML = '<div class="col-12"><div class="empty-state"><i class="bi bi-tools"></i><p class="mt-2">Tidak ada laptop dalam status maintenance</p></div></div>';
        return;
    }
    container.innerHTML = _laptopsData.map(renderLaptopCard).join('');
}
function cetakPDF() { cetakPDFLaptop('Daftar Laptop Maintenance', _laptopsData); }
loadData();
</script>
</body>
</html>
