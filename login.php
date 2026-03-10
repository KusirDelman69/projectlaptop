<?php
// ============================================================
//  login.php
// ============================================================
session_start();
if (isset($_SESSION['admin_id'])) { header('Location: index.php'); exit; }

require_once 'config.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username && $password) {
        $db = getDB();
        $u  = $db->real_escape_string($username);
        $res = $db->query("SELECT * FROM admins WHERE username='$u' LIMIT 1");
        if ($res && $row = $res->fetch_assoc()) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['admin_id']   = $row['id'];
                $_SESSION['admin_nama'] = $row['nama'];
                $_SESSION['admin_user'] = $row['username'];
                header('Location: index.php');
                exit;
            }
        }
        $error = 'Username atau password salah!';
        $db->close();
    } else {
        $error = 'Harap isi username dan password!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — <?= APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #1a56db 100%);
            display: flex; align-items: center; justify-content: center;
        }
        .login-box {
            background: white; border-radius: 24px;
            padding: 2.5rem; width: 100%; max-width: 400px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.3);
        }
        .logo { width: 56px; height: 56px; background: linear-gradient(135deg,#1a56db,#1344b8); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; color: white; margin: 0 auto 1.2rem; }
        h4 { font-weight: 800; text-align: center; color: #0f172a; }
        .subtitle { text-align: center; color: #64748b; font-size: 0.85rem; margin-bottom: 1.8rem; }
        .form-label { font-size: 0.83rem; font-weight: 600; color: #1e293b; }
        .form-control { border-radius: 12px; border: 1.5px solid #e2e8f0; padding: 10px 14px; font-size: 0.9rem; }
        .form-control:focus { border-color: #1a56db; box-shadow: 0 0 0 3px rgba(26,86,219,0.12); }
        .input-group .form-control { border-radius: 12px 0 0 12px; }
        .input-group .btn { border-radius: 0 12px 12px 0; border: 1.5px solid #e2e8f0; border-left: none; background: #f8fafc; color: #64748b; }
        .btn-login { background: linear-gradient(135deg,#1a56db,#1344b8); border: none; border-radius: 12px; padding: 11px; font-weight: 700; font-size: 0.95rem; width: 100%; color: white; transition: opacity 0.2s; }
        .btn-login:hover { opacity: 0.9; color: white; }
        .alert { border-radius: 12px; font-size: 0.85rem; }
        .default-hint { background: #f8fafc; border-radius: 10px; padding: 10px 14px; font-size: 0.78rem; color: #64748b; margin-top: 1rem; text-align: center; }
    </style>
</head>
<body>
<div class="login-box">
    <div class="logo"><i class="bi bi-laptop"></i></div>
    <h4><?= APP_NAME ?></h4>
    <p class="subtitle">Masuk untuk mengelola peminjaman laptop</p>

    <?php if ($error): ?>
        <div class="alert alert-danger py-2"><i class="bi bi-exclamation-circle me-2"></i><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Masukkan username"
                   value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" autofocus>
        </div>
        <div class="mb-4">
            <label class="form-label">Password</label>
            <div class="input-group">
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" id="pwd">
                <button type="button" class="btn" onclick="togglePwd()"><i class="bi bi-eye" id="eye-icon"></i></button>
            </div>
        </div>
        <button type="submit" class="btn-login"><i class="bi bi-box-arrow-in-right me-2"></i>Masuk</button>
    </form>

    
</div>
<script>
function togglePwd() {
    const p = document.getElementById('pwd');
    const i = document.getElementById('eye-icon');
    p.type = p.type === 'password' ? 'text' : 'password';
    i.className = p.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}
</script>
</body>
</html>
