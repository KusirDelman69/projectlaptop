<?php
// ============================================================
//  api.php — Semua logic AJAX/API
// ============================================================
session_start();
if (!isset($_SESSION['admin_id'])) { http_response_code(401); echo json_encode(['error'=>'Unauthorized']); exit; }

require_once 'config.php';
header('Content-Type: application/json');

$db     = getDB();
$action = $_GET['action'] ?? '';

// ─── GET: Semua laptop ───────────────────────────────────────
if ($action === 'get_laptops') {
    $filter = $_GET['filter'] ?? 'all';
    $where  = $filter !== 'all' ? "WHERE l.status = '" . $db->real_escape_string($filter) . "'" : '';
    $result = $db->query("
        SELECT l.*, p.nama_user, p.departemen, p.tgl_pinjam, p.id as pinjam_id
        FROM laptops l
        LEFT JOIN peminjaman p ON l.id = p.laptop_id AND p.status = 'dipinjam'
        $where ORDER BY l.kode ASC
    ");
    $rows = [];
    while ($r = $result->fetch_assoc()) $rows[] = $r;
    echo json_encode($rows);
}

// ─── GET: Stats ──────────────────────────────────────────────
elseif ($action === 'get_stats') {
    $r = $db->query("SELECT
        COUNT(*) as total,
        SUM(status='tersedia') as tersedia,
        SUM(status='dipinjam') as dipinjam,
        SUM(status='maintenance') as maintenance
        FROM laptops")->fetch_assoc();
    echo json_encode($r);
}

// ─── GET: Riwayat ────────────────────────────────────────────
elseif ($action === 'get_riwayat') {
    $result = $db->query("
        SELECT p.*, l.kode, l.merk, l.model
        FROM peminjaman p JOIN laptops l ON p.laptop_id = l.id
        ORDER BY p.created_at DESC LIMIT 100
    ");
    $rows = [];
    while ($r = $result->fetch_assoc()) $rows[] = $r;
    echo json_encode($rows);
}

// ─── POST: Tambah laptop ─────────────────────────────────────
elseif ($action === 'tambah_laptop' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Support FormData (multipart) karena ada upload foto
    $kode  = $db->real_escape_string($_POST['kode'] ?? '');
    $merk  = $db->real_escape_string($_POST['merk'] ?? '');
    $model = $db->real_escape_string($_POST['model'] ?? '');
    $spek  = $db->real_escape_string($_POST['spesifikasi'] ?? '');
    $status = in_array($_POST['status'] ?? '', ['tersedia','dipinjam','maintenance']) ? $_POST['status'] : 'tersedia';

    if ($db->query("SELECT id FROM laptops WHERE kode='$kode'")->num_rows > 0) {
        echo json_encode(['success'=>false,'message'=>'Kode laptop sudah ada!']); exit;
    }
    $db->query("INSERT INTO laptops (kode,merk,model,spesifikasi,status) VALUES ('$kode','$merk','$model','$spek','$status')");
    $laptop_id = $db->insert_id;

    // Jika status dipinjam, insert juga ke tabel peminjaman
    if ($status === 'dipinjam' && !empty($_POST['pinjam_nama'])) {
        $p_nama = $db->real_escape_string($_POST['pinjam_nama']);
        $p_dept = $db->real_escape_string($_POST['pinjam_dept'] ?? '');
        $p_kerl = $db->real_escape_string($_POST['pinjam_kerl'] ?? 'Data lama (diinput manual)');
        $db->query("INSERT INTO peminjaman (laptop_id,nama_user,departemen,keperluan,tgl_pinjam) VALUES ($laptop_id,'$p_nama','$p_dept','$p_kerl',NOW())");
    }

    echo json_encode(['success'=>true,'message'=>'Laptop berhasil ditambahkan!']);
}

// ─── POST: Edit laptop ───────────────────────────────────────
elseif ($action === 'edit_laptop' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Support FormData (multipart) karena ada upload foto
    $id    = (int)($_POST['id'] ?? 0);
    $kode  = $db->real_escape_string($_POST['kode'] ?? '');
    $merk  = $db->real_escape_string($_POST['merk'] ?? '');
    $model = $db->real_escape_string($_POST['model'] ?? '');
    $spek  = $db->real_escape_string($_POST['spesifikasi'] ?? '');
    $status = in_array($_POST['status'] ?? '', ['tersedia','dipinjam','maintenance']) ? $_POST['status'] : 'tersedia';
    $db->query("UPDATE laptops SET kode='$kode',merk='$merk',model='$model',spesifikasi='$spek',status='$status' WHERE id=$id");
    echo json_encode(['success'=>true,'message'=>'Laptop berhasil diupdate!']);
}

// ─── POST: Hapus laptop ──────────────────────────────────────
elseif ($action === 'hapus_laptop' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $d  = json_decode(file_get_contents('php://input'), true);
    $id = (int)$d['id'];
    if ($db->query("SELECT id FROM peminjaman WHERE laptop_id=$id AND status='dipinjam'")->num_rows > 0) {
        echo json_encode(['success'=>false,'message'=>'Laptop sedang dipinjam, tidak bisa dihapus!']); exit;
    }
    $db->query("DELETE FROM laptops WHERE id=$id");
    echo json_encode(['success'=>true,'message'=>'Laptop berhasil dihapus!']);
}

// ─── POST: Pinjam ────────────────────────────────────────────
elseif ($action === 'pinjam' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $d   = json_decode(file_get_contents('php://input'), true);
    $lid = (int)$d['laptop_id'];
    $nama = $db->real_escape_string($d['nama_user']);
    $dept = $db->real_escape_string($d['departemen']);
    $kerl = $db->real_escape_string($d['keperluan']);
    

    if ($db->query("SELECT status FROM laptops WHERE id=$lid")->fetch_assoc()['status'] !== 'tersedia') {
        echo json_encode(['success'=>false,'message'=>'Laptop tidak tersedia!']); exit;
    }
    $db->query("INSERT INTO peminjaman (laptop_id,nama_user,departemen,keperluan,tgl_pinjam) VALUES ($lid,'$nama','$dept','$kerl',NOW())");
    $db->query("UPDATE laptops SET status='dipinjam' WHERE id=$lid");
    echo json_encode(['success'=>true,'message'=>'Peminjaman berhasil dicatat!']);
}

// ─── POST: Kembali ───────────────────────────────────────────
elseif ($action === 'kembali' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $d       = json_decode(file_get_contents('php://input'), true);
    $pid     = (int)$d['pinjam_id'];
    $kondisi = $db->real_escape_string($d['kondisi_kembali']);
    $catatan = $db->real_escape_string($d['catatan'] ?? '');
    $lid     = $db->query("SELECT laptop_id FROM peminjaman WHERE id=$pid")->fetch_assoc()['laptop_id'];

    $db->query("UPDATE peminjaman SET status='dikembalikan',tgl_kembali_aktual=NOW(),kondisi_kembali='$kondisi. $catatan' WHERE id=$pid");
    $db->query("UPDATE laptops SET status='tersedia' WHERE id=$lid");
    echo json_encode(['success'=>true,'message'=>'Pengembalian berhasil dicatat!']);
}

// ─── POST: Ganti password ────────────────────────────────────
elseif ($action === 'ganti_password' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $d       = json_decode(file_get_contents('php://input'), true);
    $old     = $d['password_lama'];
    $new     = $d['password_baru'];
    $id      = (int)$_SESSION['admin_id'];

    $row = $db->query("SELECT password FROM admins WHERE id=$id")->fetch_assoc();
    if (!password_verify($old, $row['password'])) {
        echo json_encode(['success'=>false,'message'=>'Password lama salah!']); exit;
    }
    $hash = password_hash($new, PASSWORD_DEFAULT);
    $db->query("UPDATE admins SET password='$hash' WHERE id=$id");
    echo json_encode(['success'=>true,'message'=>'Password berhasil diubah!']);
}

else {
    echo json_encode(['error'=>'Action tidak dikenal']);
}

$db->close();
