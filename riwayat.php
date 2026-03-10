<?php require_once 'config.php'; require_once 'auth.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head><?php include 'head.php'; ?><title>Riwayat Peminjaman — <?= APP_NAME ?></title></head>
<body>
<?php include 'navbar.php'; ?>
<div class="container-fluid px-4">
    <div class="page-header">
        <div>
            <h5><i class="bi bi-clock-history me-2 text-primary"></i>Riwayat Peminjaman</h5>
            <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="index.php">Dashboard</a></li><li class="breadcrumb-item active">Riwayat</li></ol></nav>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm" onclick="cetakPDFRiwayat()"><i class="bi bi-file-earmark-pdf me-1"></i>Cetak PDF</button>
            <button class="btn btn-sm btn-outline-primary" onclick="loadData()"><i class="bi bi-arrow-clockwise"></i></button>
        </div>
    </div>
    <!-- Search bar -->
    <div class="mb-3">
        <div class="input-group" style="max-width:360px">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
            <input type="text" class="form-control border-start-0 ps-0" id="search-input"
                placeholder="Cari nama peminjam, kode laptop..." oninput="filterRiwayat(this.value)">
            <button class="btn btn-outline-secondary" onclick="clearSearch()" title="Reset"><i class="bi bi-x"></i></button>
        </div>
    </div>
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="ps-3">Laptop</th>
                            <th>Peminjam</th>
                            <th>Departemen</th>
                            <th>Tgl Pinjam</th>
                            <th>Kondisi Pinjam</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="riwayat-body">
                        <tr><td colspan="6" class="text-center py-4"><div class="spinner-border spinner-border-sm text-primary"></div></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
<script>
let _riwayatData = [];

async function loadData() {
    const res = await fetch('api.php?action=get_riwayat');
    _riwayatData = await res.json();
    const tbody = document.getElementById('riwayat-body');
    if (!_riwayatData.length) {
        tbody.innerHTML = '<tr><td colspan="6"><div class="empty-state"><i class="bi bi-clock-history"></i><p class="mt-2">Belum ada riwayat peminjaman</p></div></td></tr>';
        return;
    }
    renderTable(_riwayatData);
}

function cetakPDFRiwayat() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({ orientation:'landscape' });
    doc.setFontSize(14); doc.setFont(undefined,'bold');
    doc.text('Laporan Riwayat Peminjaman Laptop IT', 14, 15);
    doc.setFontSize(9); doc.setFont(undefined,'normal');
    doc.text(`Dicetak: ${new Date().toLocaleString('id-ID')}`, 14, 22);
    doc.autoTable({
        startY: 27,
        head: [['Kode','Laptop','Peminjam','Departemen','Tgl Pinjam','Kondisi Pinjam','Status']],
        body: _riwayatData.map(r => [
            r.kode, `${r.merk} ${r.model}`, r.nama_user, r.departemen||'-',
            r.tgl_pinjam, r.kondisi_pinjam||'-',
            r.status==='dipinjam'?'Dipinjam':'Dikembalikan'
        ]),
        styles:{fontSize:7}, headStyles:{fillColor:[26,86,219],fontSize:7,fontStyle:'bold'},
        alternateRowStyles:{fillColor:[245,248,255]}
    });
    doc.save(`riwayat-peminjaman-${Date.now()}.pdf`);
}

function filterRiwayat(q) {
    q = q.toLowerCase().trim();
    const filtered = !q ? _riwayatData : _riwayatData.filter(r =>
        (r.kode||'').toLowerCase().includes(q) ||
        (r.nama_user||'').toLowerCase().includes(q) ||
        (r.departemen||'').toLowerCase().includes(q) ||
        (r.merk||'').toLowerCase().includes(q) ||
        (r.model||'').toLowerCase().includes(q)
    );
    renderTable(filtered);
}
function clearSearch() {
    document.getElementById('search-input').value = '';
    renderTable(_riwayatData);
}
function renderTable(data) {
    const tbody = document.getElementById('riwayat-body');
    if (!data.length) {
        tbody.innerHTML = '<tr><td colspan="6"><div class="empty-state"><i class="bi bi-search"></i><p class="mt-2">Tidak ditemukan</p></div></td></tr>';
        return;
    }
    tbody.innerHTML = data.map(r => `
        <tr>
            <td class="ps-3"><b>${r.kode}</b><br><small class="text-muted">${r.merk} ${r.model}</small></td>
            <td>${r.nama_user}</td>
            <td>${r.departemen||'-'}</td>
            <td><small>${r.tgl_pinjam}</small></td>
            <td><small>${r.kondisi_pinjam||'Baik'}</small></td>
            <td>${r.status==='dipinjam'?'<span class="badge-dipinjam">Dipinjam</span>':'<span class="badge-dikembalikan">Dikembalikan</span>'}</td>
        </tr>
    `).join('');
}

loadData();
</script>
</body>
</html>
