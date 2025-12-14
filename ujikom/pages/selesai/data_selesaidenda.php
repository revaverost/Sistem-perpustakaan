<?php
// Mengimpor file yang diperlukan
include_once('../../koneksi.php'); // Koneksi ke database
include '../../index_header.php'; // Header halaman
include '../../konfirm_login.php'; // Verifikasi login pengguna

$db = new database();

// Mendapatkan filter yang dipilih dari URL (GET parameter)
$filter_ket = $_GET['filter_ket'] ?? null; // Filter berdasarkan keterangan (Terlambat / Hilang)
$filter_pg = $_GET['filter_pg'] ?? null; // Filter berdasarkan kode pegawai

// Mendapatkan data selesai denda berdasarkan filter yang dipilih
$data_selesaidenda = $db->tampil_data_selesaidenda($filter_ket, $filter_pg);

// Menghitung total denda
$denda = $db->hitung_denda();

// Mendapatkan data pegawai untuk filter pegawai
$data_pegawai = $db->tampil_data_pegawai();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Perpustakaan</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="../../layout/styles/layout.css" rel="stylesheet" type="text/css" media="all"> <!-- Pastikan path benar -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<div class="wrapper row0">
<main class="hoc container clear"> 
    <h1 class="fl_left bold font-x2 btmspace-50">Data Peminjaman Selesai (Denda)</h1>
    
    <!-- Menampilkan informasi denda -->
    <div class="group btmspace-30 demo center">
        <div class="one_third first"><strong>Denda Terlambat:</strong> Rp <?php echo number_format($denda['denda_terlambat'], 0, ',', '.'); ?></div>
        <div class="one_third"><strong>Denda Hilang:</strong> Rp <?php echo number_format($denda['denda_hilang'], 0, ',', '.'); ?></div>
        <div class="one_third"><strong>Denda Total:</strong> Rp <?php echo number_format($denda['denda_total'], 0, ',', '.'); ?></div>
    </div>

    <!-- Form Filter untuk memilih kategori dan pegawai -->
    <div class="group btmspace-30 demo center">
        <form method="GET">
            <div class="one_third first">
                <label for="filter_ket">Filter Keterangan:</label>
                <select name="filter_ket" id="filter_ket">
                    <option value="">Semua</option>
                    <option value="2" <?php if (isset($_GET['filter_ket']) && $_GET['filter_ket'] == '2') echo 'selected'; ?>>Terlambat</option>
                    <option value="3" <?php if (isset($_GET['filter_ket']) && $_GET['filter_ket'] == '3') echo 'selected'; ?>>Hilang</option>
                </select>
            </div>
            <div class="one_third">
                <label for="filter_pg">Filter Kode Pegawai:</label>
                <select name="filter_pg" id="filter_pg">
                    <option value="">Semua</option>
                    <?php foreach ($data_pegawai as $pg): ?>
                        <option value="<?php echo $pg['kode_pg']; ?>" <?php echo (isset($_GET['filter_pg']) && $_GET['filter_pg'] == $pg['kode_pg']) ? 'selected' : ''; ?>>
                            <?php echo $pg['kode_pg'] . ' - ' . $pg['nama_pg']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="one_third">
                <input type="submit" value="Filter" class="btn small">
                <?php if (!empty($_GET['filter_pg']) || !empty($_GET['filter_ket'])): ?>
                    <p class="bold">
                        <small><?php echo count($data_selesaidenda); ?> hasil ditemukan dari filter</small>
                    </p>
                <?php else: ?>
                    <p class="bold">
                        <small><?php echo count($data_selesaidenda); ?> data selesai denda ditampilkan</small>
                    </p>
                <?php endif; ?>
            </div>
        </form>
    </div>
    
    <!-- Menampilkan tabel data selesai denda -->
    <div class="clear">
        <table>
        <?php 
        // Memfilter data berdasarkan filter yang diterima dari GET
        if (isset($_GET['filter_pg']) && $_GET['filter_pg'] != '') {
            $filter_pg = $_GET['filter_pg'];
            $data_selesaidenda = array_filter($data_selesaidenda, function ($item) use ($filter_pg) {
                return $item['kode_pg'] === $filter_pg;
            });
        } 
        if (isset($_GET['filter_ket']) && $_GET['filter_ket'] != '') {
            $data_selesaidenda = array_filter($data_selesaidenda, function ($item) {
                return $item['ket_terlambat'] == $_GET['filter_ket'];
            });
        }
        ?>
          <thead>
            <tr>
              <th>Kode</th>
              <th>NIS</th>
              <th>Kode Buku</th>
              <th>Kode Pegawai</th>
              <th>Batas Tanggal</th>
              <th>Tanggal Kembali/Hilang</th>
              <th>Keterangan</th>
              <th>Jumlah Denda</th>
            </tr>
          </thead>
          <tbody>
          <?php
          // Array untuk keterangan terlambat
          $kt = [
            2 => 'Terlambat',
            3 => 'Hilang'];
          
          // Loop untuk menampilkan data
          foreach ($data_selesaidenda as $row) {
          ?>
            <tr>
              <td><?php echo $row['kode_pm'] ?></td>
              <td><?php echo $row['nis'] ?> <br> <small><?php echo $row['nama'] ?></small> </td>
              <td><?php echo $row['kode_buku'] ?> <br> <small><?php echo $row['judul'] ?></small> </td>
              <td><?php echo $row['kode_pg'] ?> <br> <small><?php echo $row['nama_pg'] ?></small> </td>
              <td><?php echo $row['ptgl_kembali'] ?></td>
              <td><?php echo $row['tgl_kembali'] ?></td>
              <?php 
              // Menentukan keterangan berdasarkan ket_terlambat
              $ket_ter = $row['ket_terlambat']; 
              $nama_ket = isset($kt[$ket_ter]) ? $kt[$ket_ter] : '';
              ?>
              <td><?php echo $nama_ket ?></td>
              <td><?php echo number_format($row['ket_denda'], 0, ',', '.');  ?></td>
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
include '../../index_footer.html'; 
?> 
