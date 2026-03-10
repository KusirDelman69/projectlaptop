<?php
// ============================================================
//  config.php — Konfigurasi DB & Session
// ============================================================

// Railway inject env variables otomatis, fallback ke localhost untuk dev
define('DB_HOST', getenv('MYSQLHOST')     ?: getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('MYSQLUSER')     ?: getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('MYSQLPASSWORD') ?: getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('MYSQLDATABASE') ?: getenv('DB_NAME') ?: 'peminjaman_laptop');
define('DB_PORT', getenv('MYSQLPORT')     ?: 3306);
define('APP_NAME', 'Sistem Peminjaman Laptop IT');

function getDB() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, (int)DB_PORT);
    if ($conn->connect_error) die("Koneksi DB gagal: " . $conn->connect_error);
    $conn->set_charset('utf8mb4');
    return $conn;
}
