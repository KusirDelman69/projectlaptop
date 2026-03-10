<?php
// ============================================================
//  auth.php — Cek Session (include di setiap halaman)
// ============================================================
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
