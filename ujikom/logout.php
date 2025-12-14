<?php
session_start();
session_destroy(); // Hapus semua sesi

// Hapus semua data sesi di browser
setcookie(session_name(), '', 0, '/');

// Mencegah cache agar halaman sebelumnya tidak bisa diakses kembali
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Expired di masa lalu
header("Location: login.php"); // Redirect ke halaman login
exit();
?>
