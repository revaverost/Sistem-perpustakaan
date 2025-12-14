<?php
// Menyisipkan file header, verifikasi login, dan koneksi ke database
include '../../index_header.php';
include '../../konfirm_login.php';
include '../../koneksi.php';

$db = new database();
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Memanggil method untuk mengambil data peminjaman berdasarkan input pencarian
$data_peminjaman = $db->tampil_data_peminjaman($search);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Perpustakaan</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">    <link href="../../layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" 
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

<div class="wrapper row0">
<main class="hoc container clear"> 
    <h1 class="fl_left bold font-x2">Data Peminjaman</h1>

    <!-- Bagian pencarian dan tombol tambah -->
    <div class="fl_right inline">
      <!-- Form pencarian data berdasarkan NIS -->
      <form class="inline clear btmspace-15" method="GET" action="#">
            <!-- Menampilkan jumlah hasil jika pencarian dilakukan -->
            <?php if ($search !== ''): ?>
              <p class="bold"> <small> <?php echo count($data_peminjaman); ?> hasil ditemukan</small></p>
            <?php endif; ?>

          <!-- Input pencarian -->
          <input type="text" name="search" placeholder="Cari NIS..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
          <button class="fa fa-search" type="submit"></button>
      </form>

      <!-- Tombol untuk menambahkan data peminjaman baru -->
      <a class="fl_right inspace-10 btn btmspace-15" href="ft_peminjaman.php">
        <i class="fa-solid fa-square-plus"></i> Tambah Peminjaman
      </a>
    </div>

    <!-- Tabel data peminjaman -->
    <div class="clear">
        <table>
          <thead>
            <tr>
              <th>Kode</th>
              <th>NIS</th>
              <th>Kode Buku</th>
              <th>Kode Pegawai</th>
              <th>Tanggal Pinjam</th>
              <th>Batas Tanggal</th>
              <th class="wide-column">Action</th>
            </tr>
          </thead>
          <tbody>
          <?php
	          // Menampilkan data peminjaman dalam bentuk tabel
	          foreach ($data_peminjaman as $row) {
		      ?>
            <tr>
              <td><?php echo $row['kode_pm'] ?></td>
              <td><?php echo $row['nis'] ?> <br> <small><?php echo $row['nama'] ?></small> </td>
              <td><?php echo $row['kode_buku'] ?> <br> <small><?php echo $row['judul'] ?></small> </td>
              <td><?php echo $row['kode_pg'] ?> <br> <small><?php echo $row['nama_pg'] ?></small> </td>
              <td><?php echo $row['tanggal'] ?></td>
              <td><?php echo $row['ptgl_kembali'] ?></td>

              <td class="center">
                <!-- Edit data pengembalian -->
                <a href="edit_pengembalian.php?action=update_pengembalian&id=<?php echo $row['kode_pm']; ?>" 
                  class="fa-solid fa-pen-to-square font-x2"></a>
                
                <!-- Menandai buku sebagai hilang -->
                <a href="hilang.php?action=update_pengembalian&id=<?php echo $row['kode_pm']; ?>" 
                  class="fa-solid fa-file-circle-exclamation font-x2"></a>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
</div>
</main>
</body>
</html>

<?php
// Menyisipkan footer
include '../../index_footer.html'; 
?>
