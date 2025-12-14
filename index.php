<?php
include 'index_header.php';

// Cek apakah pegawai sudah login
if (!isset($_SESSION['pegawai_id'])) {
  header("Location: login.php"); // Arahkan ke halaman login jika belum login
  exit();
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

// Ambil jabatan pegawai dari session
$jabatan = $_SESSION['pegawai_jabatan'];
?>
<!DOCTYPE html>
<html>
<head>
<title>Perpustakaan</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
<div class="bgded" style="background-image: url('images/bg_index.png');">
  <div id="pageintro" class="clear"> 
    <article>
      <div class="overlay inspace-30 btmspace-30">
        <p class="font-xs nospace">Selamat Datang di Perpustakaan Sekolah</p>
        <h2 class="heading">Menjelajahi Dunia Melalui Buku dan Pengetahuan</h2>
        <p>Temukan berbagai koleksi buku, jurnal, dan sumber belajar lainnya untuk memperluas wawasan dan meningkatkan minat baca. Mari jadikan membaca sebagai kebiasaan yang menyenangkan dan bermanfaat!</p>
      </div>
      <footer>
        <ul class="nospace inline">
          <li><a class="btn" href="pages/peminjaman/ft_peminjaman.php">Tambah Peminjaman</a></li>
          <?php if ($jabatan == "2") { ?>
          <li><a class="btn" href="pages/buku/data_buku.php">Daftar Buku</a></li>
          <li><a class="btn" href="pages/siswa/data_siswa.php">Daftar Siswa</a></li>
          <?php } ?> 
          <!-- Hanya tampilkan jika pegawai adalah Admin -->
          <?php if ($jabatan == "1") { ?>
          <li><a class="btn" href="pages/buku/ft_buku.php">Tambah Buku</a></li>
          <li><a class="btn" href="pages/siswa/ft_siswa.php">Tambah Siswa</a></li>
          <li><a class="btn" href="pages/pegawai/ft_pegawai.php">Tambah Petugas</a></li>
          <?php } ?>        
        </ul>
      </footer>
    </article>
    </div>

      <div class="container coloured">
        <div class="inspace-30 margin1">
          <video class="btmspace-30" width="600" height="320" controls>
              <source src="images/video.mp4" type="video/mp4">
              Browser Anda tidak mendukung tag video.
          </video>
          </div>
          <div class="margin1">
            <p class="bold font-x2">Peraturan Peminjaman dan Pengembalian</p>
                <li>Buku yang dipinjam harus dikembalikan tepat waktu.</li>
                <li>Keterlambatan pengembalian buku dikenakan denda sebesar Rp.1000/hari terlambat untuk setiap buku.</li>
                <li>Kehilangan buku harus diganti dengan uang seharga buku yang hilang 
                  <br>dan laporan terlambat paling lambat 10 hari, jika melebihi maka hari ke-11 dan seterusnya 
                  <br>akan dikenai denda Rp.1000/hari.</li>
                <li>Hal-hal yang belum diatur dalam peraturan ini akan diputuskan oleh pengelola perpustakaan.</li>
        </div>
        <div class="hoc container center"> 
        <p class="bold font-x2 center btmspace-30">Deskripsi Tombol</p>
          <ul class="group center btmspace-30">
            <li class="one_third first">
              <article><i class="btmspace-15 fa fa-4x fa-square-plus"></i>
                <h6 class="font-x1">Tambah</h6>
                <p class="nospace">Menambah data, jika di bagian peminjaman digunakan untuk tambah kode buku untuk peminjaman lebih dari 1 buku. </p>
              </article>
            </li>
            <li class="one_third">
              <article><i class="btmspace-15 fa fa-4x fa-pen-to-square"></i>
                <h6 class="font-x1">Edit</h6>
                <p class="nospace">Untuk mengubah data, jika di bagian peminjaman digunkan untuk menginput data pengembalian.</p>
              </article>
            </li>
            <li class="one_third">
              <article><i class="btmspace-15 fa fa-4x fa-file-circle-exclamation"></i>
                <h6 class="font-x1">Buku Hilang</h6>
                <p class="nospace">Berada di bagian pengembalian, digunakan ketika ada laporan buku yang dipinjam hilang.</p>
              </article>
            </li>
            </ul>
          <ul class="group center">
            <li class="one_third first">
              <article><i class="btmspace-15 fa fa-4x fa-trash"></i>
                <h6 class="font-x1">Hapus</h6>
                <p class="nospace">Menghapus data.</p>
              </article>
            </li>
            <li class="one_third">
              <article><i class="btmspace-15 fa fa-4x fa-search"></i>
                <h6 class="font-x1">Cari</h6>
                <p class="nospace">Tombol pencarian berdasarkan setiap data.</p>
              </article>
            </li>
            <li class="one_third">
              <article><i class="btmspace-15 fa fa-4x fa-right-from-bracket"></i>
                <h6 class="font-x1">Logout</h6>
                <p class="nospace">Jika logout maka akan keluar dari semua halaman</p>
              </article>
            </li>
          </ul>
          </div>
      </div>
</div>



</body>
</html>
<?php
include 'index_footer.html';
?>