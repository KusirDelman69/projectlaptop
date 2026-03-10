<!-- footer.php — Modal bersama + JS (with photo support) -->

<!-- Modal Tambah/Edit Laptop -->
<div class="modal fade" id="modalLaptop" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-laptop-title"><i class="bi bi-laptop me-2 text-primary"></i>Tambah Laptop</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <input type="hidden" id="laptop-id">
                <input type="hidden" id="laptop-foto-existing">
                <div class="row g-3">
                    <div class="col-6">
                        <label class="form-label">Kode <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="laptop-kode" placeholder="LT-006">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="laptop-status">
                            <option value="tersedia">Tersedia</option>
                            <option value="dipinjam">Dipinjam</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Merk <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="laptop-merk" placeholder="Lenovo, Dell...">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Model <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="laptop-model" placeholder="ThinkPad E14...">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Spesifikasi</label>
                        <input type="text" class="form-control" id="laptop-spek" placeholder="Intel i5, RAM 8GB...">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Foto Laptop</label>
                        <input type="file" class="form-control" id="laptop-foto" accept="image/jpeg,image/png,image/webp" onchange="previewFoto(this)">
                        <small class="text-muted">Format: JPG, PNG, WEBP. Ukuran bebas.</small>
                        <div id="foto-preview-wrap" class="mt-2" style="display:none">
                            <img id="foto-preview" src="" alt="Preview"
                                style="width:100%;max-height:160px;object-fit:cover;border-radius:10px;border:1.5px solid #e2e8f0;cursor:pointer"
                                onclick="lihatFotoBesar(this.src,'Preview')">
                            <button type="button" class="btn btn-sm btn-outline-danger mt-1 w-100" onclick="hapusFotoInput()">
                                <i class="bi bi-x me-1"></i>Hapus Foto
                            </button>
                        </div>
                    </div>
                    <!-- Field peminjam — hanya muncul saat status = dipinjam -->
                    <div class="col-12" id="wrap-peminjam" style="display:none">
                        <hr class="my-1">
                        <div class="alert alert-warning py-2 px-3 mb-2" style="font-size:0.8rem">
                            <i class="bi bi-info-circle me-1"></i>Isi data peminjam untuk laptop yang sudah terlanjur dipinjam
                        </div>
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="form-label">Nama Peminjam <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="laptop-pinjam-nama" placeholder="Nama lengkap">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Departemen</label>
                                <input type="text" class="form-control" id="laptop-pinjam-dept" placeholder="Marketing...">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Keperluan</label>
                                <input type="text" class="form-control" id="laptop-pinjam-kerl" placeholder="Keperluan peminjaman">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="simpanLaptop()"><i class="bi bi-check-lg me-1"></i>Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="modalHapus" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <div style="font-size:2.5rem;color:#dc2626"><i class="bi bi-trash3"></i></div>
                <h6 class="fw-bold mt-2">Hapus Laptop?</h6>
                <p class="text-muted small" id="hapus-info">-</p>
                <input type="hidden" id="hapus-id">
                <div class="d-flex gap-2 justify-content-center mt-3">
                    <button class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-danger btn-sm" onclick="konfirmasiHapus()">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Peminjaman -->
<div class="modal fade" id="modalPinjam" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-box-arrow-in-right me-2 text-primary"></i>Form Peminjaman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-primary py-2 px-3 mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-laptop"></i><span id="pinjam-laptop-info">-</span>
                </div>
                <input type="hidden" id="pinjam-laptop-id">
                <div class="mb-3">
                    <label class="form-label">Nama Peminjam <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="pinjam-nama" placeholder="Nama lengkap">
                </div>
                <div class="mb-3">
                    <label class="form-label">Departemen</label>
                    <input type="text" class="form-control" id="pinjam-departemen" placeholder="Marketing, Finance...">
                </div>
                <div class="mb-3">
                    <label class="form-label">Keperluan <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="pinjam-keperluan" rows="2"></textarea>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="submitPinjam()"><i class="bi bi-check-lg me-1"></i>Konfirmasi</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pengembalian -->
<div class="modal fade" id="modalKembali" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-box-arrow-left me-2 text-warning"></i>Form Pengembalian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-warning py-2 px-3 mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-info-circle"></i><span id="kembali-info">-</span>
                </div>
                <input type="hidden" id="kembali-pinjam-id">
                <div class="mb-3">
                    <label class="form-label">Kondisi Laptop <span class="text-danger">*</span></label>
                    <select class="form-select" id="kembali-kondisi">
                        <option value="Baik">Baik - Tidak ada kerusakan</option>
                        <option value="Baik (ada goresan minor)">Baik (ada goresan minor)</option>
                        <option value="Perlu service">Perlu service</option>
                        <option value="Rusak">Rusak</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Catatan Tambahan</label>
                    <textarea class="form-control" id="kembali-catatan" rows="2"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-warning text-white" onclick="submitKembali()"><i class="bi bi-check-lg me-1"></i>Konfirmasi</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ganti Password -->
<div class="modal fade" id="modalPassword" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-key me-2"></i>Ganti Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label">Password Lama</label>
                    <input type="password" class="form-control" id="pwd-lama">
                </div>
                <div class="mb-3">
                    <label class="form-label">Password Baru</label>
                    <input type="password" class="form-control" id="pwd-baru">
                </div>
                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" class="form-control" id="pwd-konfirm">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="submitGantiPassword()"><i class="bi bi-check-lg me-1"></i>Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Foto Besar -->
<div class="modal fade" id="modalFoto" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="background:rgba(0,0,0,0.85);border:none">
            <div class="modal-body p-3 text-center position-relative">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-2"
                    data-bs-dismiss="modal" style="z-index:10"></button>
                <img id="foto-besar-img" src="" alt=""
                    style="max-width:100%;max-height:78vh;border-radius:10px;object-fit:contain">
                <div id="foto-besar-caption" class="text-white mt-2 fw-600 small"></div>
            </div>
        </div>
    </div>
</div>

<!-- Toast -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="toast" class="toast align-items-center border-0 text-white" role="alert">
        <div class="d-flex">
            <div class="toast-body" id="toast-msg"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
let _modals = {}, _toast, _laptopsData = [], _editMode = false;

document.addEventListener('DOMContentLoaded', () => {
    ['modalLaptop','modalHapus','modalPinjam','modalKembali','modalPassword','modalFoto'].forEach(id => {
        const el = document.getElementById(id);
        if (el) _modals[id] = new bootstrap.Modal(el);
    });
    _toast = new bootstrap.Toast(document.getElementById('toast'), { delay: 3000 });
    updateClock();
    setInterval(updateClock, 1000);

    // Toggle field peminjam saat status berubah
    document.getElementById('laptop-status').addEventListener('change', function() {
        const wrap = document.getElementById('wrap-peminjam');
        wrap.style.display = this.value === 'dipinjam' ? '' : 'none';
        if (this.value !== 'dipinjam') {
            ['laptop-pinjam-nama','laptop-pinjam-dept','laptop-pinjam-kerl'].forEach(i => document.getElementById(i).value = '');
        }
    });
});

function updateClock() {
    const el = document.getElementById('clock');
    if (el) el.textContent = new Date().toLocaleString('id-ID', {
        weekday:'long', year:'numeric', month:'long', day:'numeric', hour:'2-digit', minute:'2-digit'
    });
}

function previewFoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('foto-preview').src = e.target.result;
            document.getElementById('foto-preview-wrap').style.display = '';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function hapusFotoInput() {
    document.getElementById('laptop-foto').value = '';
    document.getElementById('foto-preview-wrap').style.display = 'none';
    document.getElementById('foto-preview').src = '';
    document.getElementById('laptop-foto-existing').value = '';
}

function lihatFotoBesar(src, caption) {
    document.getElementById('foto-besar-img').src = src;
    document.getElementById('foto-besar-caption').textContent = caption || '';
    _modals.modalFoto.show();
}

function openTambahLaptop() {
    _editMode = false;
    document.getElementById('modal-laptop-title').innerHTML = '<i class="bi bi-plus-circle me-2 text-primary"></i>Tambah Laptop';
    ['laptop-id','laptop-kode','laptop-merk','laptop-model','laptop-spek','laptop-foto-existing'].forEach(i => document.getElementById(i).value = '');
    document.getElementById('laptop-status').value = 'tersedia';
    document.getElementById('laptop-foto').value = '';
    document.getElementById('foto-preview-wrap').style.display = 'none';
    document.getElementById('wrap-peminjam').style.display = 'none';
    ['laptop-pinjam-nama','laptop-pinjam-dept','laptop-pinjam-kerl'].forEach(i => document.getElementById(i).value = '');
    _modals.modalLaptop.show();
}

function openEditLaptop(id) {
    const l = _laptopsData.find(x => x.id == id); if (!l) return;
    _editMode = true;
    document.getElementById('modal-laptop-title').innerHTML = '<i class="bi bi-pencil me-2 text-primary"></i>Edit Laptop';
    document.getElementById('laptop-id').value     = l.id;
    document.getElementById('laptop-kode').value   = l.kode;
    document.getElementById('laptop-merk').value   = l.merk;
    document.getElementById('laptop-model').value  = l.model;
    document.getElementById('laptop-spek').value   = l.spesifikasi || '';
    document.getElementById('laptop-foto').value   = '';
    document.getElementById('laptop-foto-existing').value = l.foto || '';

    // Kunci status jika dipinjam — harus lewat Catat Pengembalian
    const statusEl = document.getElementById('laptop-status');
    statusEl.value    = l.status;
    statusEl.disabled = (l.status === 'dipinjam');

    // Sembunyikan wrap-peminjam saat edit (tidak relevan)
    document.getElementById('wrap-peminjam').style.display = 'none';
    ['laptop-pinjam-nama','laptop-pinjam-dept','laptop-pinjam-kerl'].forEach(i => {
        document.getElementById(i).value    = '';
        document.getElementById(i).readOnly = false;
        document.getElementById(i).style.background = '';
    });

    if (l.foto) {
        document.getElementById('foto-preview').src = 'uploads/' + l.foto;
        document.getElementById('foto-preview-wrap').style.display = '';
    } else {
        document.getElementById('foto-preview-wrap').style.display = 'none';
    }
    _modals.modalLaptop.show();
}

async function simpanLaptop() {
    const kode  = document.getElementById('laptop-kode').value.trim();
    const merk  = document.getElementById('laptop-merk').value.trim();
    const model = document.getElementById('laptop-model').value.trim();
    if (!kode || !merk || !model) { showToast('Kode, merk, dan model wajib diisi!','danger'); return; }

    const form = new FormData();
    form.append('id',            document.getElementById('laptop-id').value);
    form.append('kode',          kode);
    form.append('merk',          merk);
    form.append('model',         model);
    form.append('spesifikasi',   document.getElementById('laptop-spek').value);
    // Kalau select status di-disabled (laptop dipinjam), ambil dari data asli
    const statusVal = document.getElementById('laptop-status').disabled
        ? (_laptopsData.find(x => x.id == document.getElementById('laptop-id').value) || {}).status || 'dipinjam'
        : document.getElementById('laptop-status').value;
    form.append('status',        statusVal);
    form.append('foto_existing', document.getElementById('laptop-foto-existing').value);

    const fotoFile = document.getElementById('laptop-foto').files[0];
    if (fotoFile) form.append('foto', fotoFile);

    // Kirim data peminjam jika status dipinjam
    if (document.getElementById('laptop-status').value === 'dipinjam' && !_editMode) {
        const namaPinjam = document.getElementById('laptop-pinjam-nama').value.trim();
        if (!namaPinjam) { showToast('Nama peminjam wajib diisi!','danger'); return; }
        form.append('pinjam_nama', namaPinjam);
        form.append('pinjam_dept', document.getElementById('laptop-pinjam-dept').value);
        form.append('pinjam_kerl', document.getElementById('laptop-pinjam-kerl').value);
    }

    const action = _editMode ? 'edit_laptop' : 'tambah_laptop';
    const res  = await fetch('api.php?action=' + action, { method:'POST', body: form });
    const data = await res.json();
    _modals.modalLaptop.hide();
    showToast(data.message, data.success ? 'success' : 'danger');
    if (data.success && typeof loadData === 'function') loadData();
}

function openHapusLaptop(id, kode) {
    document.getElementById('hapus-id').value = id;
    document.getElementById('hapus-info').textContent = 'Laptop ' + kode + ' akan dihapus permanen.';
    _modals.modalHapus.show();
}

async function konfirmasiHapus() {
    const res  = await fetch('api.php?action=hapus_laptop', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({ id: document.getElementById('hapus-id').value })});
    const data = await res.json();
    _modals.modalHapus.hide();
    showToast(data.message, data.success ? 'success' : 'danger');
    if (data.success && typeof loadData === 'function') loadData();
}

function openPinjam(id, kode, nama) {
    document.getElementById('pinjam-laptop-id').value = id;
    document.getElementById('pinjam-laptop-info').textContent = kode + ' — ' + nama;
    ['pinjam-nama','pinjam-departemen','pinjam-keperluan'].forEach(i => document.getElementById(i).value = '');
    _modals.modalPinjam.show();
}

async function submitPinjam() {
    const nama = document.getElementById('pinjam-nama').value.trim();
    const kerl = document.getElementById('pinjam-keperluan').value.trim();
    if (!nama || !kerl) { showToast('Harap isi semua field wajib!','danger'); return; }

    const res  = await fetch('api.php?action=pinjam', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({
        laptop_id: document.getElementById('pinjam-laptop-id').value,
        nama_user: nama, departemen: document.getElementById('pinjam-departemen').value,
        keperluan: kerl
    })});
    const data = await res.json();
    _modals.modalPinjam.hide();
    showToast(data.message, data.success ? 'success' : 'danger');
    if (data.success && typeof loadData === 'function') loadData();
}

function openKembali(pinjamId, kode, nama, user) {
    if (!pinjamId || pinjamId === 'null' || pinjamId === 'undefined') {
        showToast('Data peminjaman tidak ditemukan.', 'danger');
        return;
    }
    document.getElementById('kembali-pinjam-id').value = pinjamId;
    document.getElementById('kembali-info').textContent = kode + ' — ' + nama + ' | Peminjam: ' + user;
    document.getElementById('kembali-catatan').value = '';
    document.getElementById('kembali-kondisi').value = 'Baik';

    const el = document.getElementById('modalKembali');
    // Dispose instance lama lalu buat baru — ini yang paling reliable
    const existing = bootstrap.Modal.getInstance(el);
    if (existing) existing.dispose();
    const m = new bootstrap.Modal(el, { backdrop: true, keyboard: true });
    m.show();
}

async function submitKembali() {
    const res  = await fetch('api.php?action=kembali', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({
        pinjam_id: document.getElementById('kembali-pinjam-id').value,
        kondisi_kembali: document.getElementById('kembali-kondisi').value,
        catatan: document.getElementById('kembali-catatan').value
    })});
    const data = await res.json();
    showToast(data.message, data.success ? 'success' : 'danger');

    if (data.success) {
        // Tunggu modal selesai animasi tutup DULU, baru reload data
        const el = document.getElementById('modalKembali');
        el.addEventListener('hidden.bs.modal', function handler() {
            el.removeEventListener('hidden.bs.modal', handler);
            // Bersihkan backdrop sisa
            document.querySelectorAll('.modal-backdrop').forEach(e => e.remove());
            document.body.classList.remove('modal-open');
            document.body.style.removeProperty('overflow');
            document.body.style.removeProperty('padding-right');
            if (typeof loadData === 'function') loadData();
        });
        bootstrap.Modal.getOrCreateInstance(el).hide();
    } else {
        bootstrap.Modal.getOrCreateInstance(document.getElementById('modalKembali')).hide();
    }
}



function openGantiPassword() { _modals.modalPassword.show(); }

async function submitGantiPassword() {
    const lama    = document.getElementById('pwd-lama').value;
    const baru    = document.getElementById('pwd-baru').value;
    const konfirm = document.getElementById('pwd-konfirm').value;
    if (!lama || !baru) { showToast('Harap isi semua field!','danger'); return; }
    if (baru !== konfirm) { showToast('Password baru tidak cocok!','danger'); return; }

    const res  = await fetch('api.php?action=ganti_password', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({ password_lama: lama, password_baru: baru })});
    const data = await res.json();
    _modals.modalPassword.hide();
    showToast(data.message, data.success ? 'success' : 'danger');
}

function renderLaptopCard(l) {
    const fotoUrl  = l.foto ? 'uploads/' + l.foto : null;
    const namaLaptop = (l.merk + ' ' + l.model).replace(/'/g, "\\'");
    const namaUser   = (l.nama_user || '').replace(/'/g, "\\'");

    const fotoHtml = fotoUrl
        ? '<div class="laptop-thumb" onclick="lihatFotoBesar(\'' + fotoUrl + '\',\'' + l.kode + '\')">' +
          '<img src="' + fotoUrl + '" alt="' + l.kode + '" loading="lazy">' +
          '<div class="thumb-overlay"><i class="bi bi-zoom-in"></i></div></div>'
        : '<div class="laptop-thumb no-foto"><i class="bi bi-laptop"></i></div>';

    return '<div class="col-12 col-sm-6 col-md-4 col-lg-3"><div class="laptop-card ' + l.status + '">' +
        '<div class="action-icons">' +
        '<button class="btn-icon btn-edit" onclick="openEditLaptop(' + l.id + ')" title="Edit"><i class="bi bi-pencil"></i></button>' +
        '<button class="btn-icon btn-del" onclick="openHapusLaptop(' + l.id + ',\'' + l.kode + '\')" title="Hapus"><i class="bi bi-trash3"></i></button>' +
        '</div>' + fotoHtml +
        '<div class="d-flex justify-content-between align-items-start mt-2">' +
        '<span class="kode">' + l.kode + '</span>' +
        '<span class="badge-' + l.status + '">' + (l.status==='tersedia'?'✓ Tersedia':l.status==='dipinjam'?'⏳ Dipinjam':'🔧 Maintenance') + '</span>' +
        '</div>' +
        '<div class="nama">' + l.merk + ' ' + l.model + '</div>' +
        '<div class="spek">' + (l.spesifikasi||'-') + '</div>' +
        (l.status==='dipinjam' ?
            '<div class="user-info"><div class="user-name"><i class="bi bi-person-fill me-1"></i>' + (l.nama_user||'-') + '</div>' +
            '<div class="text-muted mt-1">' + (l.departemen||'-') + '</div>' +
            '<button class="btn btn-warning btn-sm mt-2 w-100 text-white" style="font-size:0.76rem;padding:4px" onclick="openKembali(' + l.pinjam_id + ',\'' + l.kode + '\',\'' + namaLaptop + '\',\'' + namaUser + '\')">' +
            '<i class="bi bi-box-arrow-left me-1"></i>Catat Pengembalian</button></div>' : '') +
        (l.status==='tersedia' ?
            '<button class="btn btn-primary btn-sm mt-2 w-100" style="font-size:0.76rem;padding:4px" onclick="openPinjam(' + l.id + ',\'' + l.kode + '\',\'' + namaLaptop + '\')">' +
            '<i class="bi bi-box-arrow-in-right me-1"></i>Pinjam Laptop</button>' : '') +
        '</div></div>';
}

function cetakPDFLaptop(title, data) {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    doc.setFontSize(14); doc.setFont(undefined,'bold');
    doc.text(title, 14, 15);
    doc.setFontSize(9); doc.setFont(undefined,'normal');
    doc.text('Dicetak: ' + new Date().toLocaleString('id-ID'), 14, 22);
    doc.autoTable({
        startY: 27,
        head: [['Kode','Merk','Model','Spesifikasi','Status','Peminjam']],
        body: data.map(l => [l.kode, l.merk, l.model, l.spesifikasi||'-',
            l.status.charAt(0).toUpperCase()+l.status.slice(1),
            l.status==='dipinjam' ? l.nama_user + ' (' + (l.departemen||'-') + ')' : '-'
        ]),
        styles:{fontSize:8}, headStyles:{fillColor:[26,86,219],fontSize:8,fontStyle:'bold'},
        alternateRowStyles:{fillColor:[245,248,255]}
    });
    doc.save('laptop-' + Date.now() + '.pdf');
}

function showToast(msg, type) {
    type = type || 'success';
    const colors = {success:'#057a55', danger:'#dc2626', warning:'#b45309'};
    const el = document.getElementById('toast');
    el.style.background = colors[type] || colors.success;
    document.getElementById('toast-msg').textContent = msg;
    _toast.show();
}
</script>