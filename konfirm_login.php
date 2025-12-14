<?php

// Jika pengguna belum login, arahkan ke halaman login
if (!isset($_SESSION['pegawai_id'])) {
    header("Location: ../../login.php");
    exit();
}

// Mencegah caching agar halaman tidak bisa diakses setelah logout
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
?>
