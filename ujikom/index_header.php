<?php
session_start();

// Ambil jabatan pegawai dari session
$jabatan = $_SESSION['pegawai_jabatan'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Perpustakaan</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
</head>
<body>
<div class="wrapper row1">
  <header id="header" class="hoc clear"> 
    <div id="logo" class="fl_left">
      <h1>Perpustakaan Sekolah</h1>
      <i class="fa-sharp fa-regular fa-map"></i>
      <p>SMK Negeri 2 Indramayu</p>
    </div>
    <nav id="mainav" class="fl_right">
      <ul class="clear">
        <li><a href="/ujikom/index.php">Home</a></li>
        <li><a class="drop">Peminjaman</a>
          <ul>
            <li><a href="/ujikom/pages/peminjaman/data_peminjaman.php">Daftar Peminjaman</a></li>
            <li><a href="/ujikom/pages/denda/data_denda.php">Daftar Denda</a></li>
            <?php if ($jabatan == "1") { ?>
            <li><a href="/ujikom/pages/selesai/data_tepatwaktu.php">Selesai Tepat waktu</a></li>
            <li><a href="/ujikom/pages/selesai/data_selesaidenda.php">Selesai Terlambat & Hilang</a></li>
            <?php } ?>
          </ul>
        </li>
        <li><a class="drop">Manajemen Data</a>
          <ul>
            <li><a href="/ujikom/pages/buku/data_buku.php">Data Buku</a></li>
            <li><a href="/ujikom/pages/siswa/data_siswa.php">Data Siswa</a></li>
            <?php if ($jabatan == "1") { ?>
            <li><a href="/ujikom/pages/pegawai/data_pegawai.php">Data Petugas</a></li>
            <?php } ?>
          </ul>
        </li>
        <li><a href="/ujikom/pages/profil/info_profil.php">Profile</a></li>
        <li><a href="/ujikom/logout.php" class="fa-solid fa-right-from-bracket font-x2"
              onclick="return confirm('Apakah Anda yakin ingin logout?')"></a></li>
      </ul>
    </nav>
  </header>
</div>
</body>
</html>