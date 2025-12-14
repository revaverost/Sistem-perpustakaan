<?php
include_once('../../koneksi.php');
include '../../index_header.php'; 
include '../../konfirm_login.php';
$db= new database();
$filter_pg = $_GET['filter_pg'] ?? null;
$data_selesai = $db->tampil_data_selesai($filter_pg);
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
    <h1 class="fl_left bold font-x2 btmspace-50">Data Peminjaman Selesai (Tepat waktu)</h1>
    <div class="group btmspace-30 demo center">
        <form method="GET">
        <div class="one_third first">
          <label for="filter_pg">Filter Kode Pegawai:</label>
            <select name="filter_pg" id="filter_pg">
              <option value="">Semua</option>
              <?php foreach ($data_pegawai as $pg): ?>
                <option value="<?php echo $pg['kode_pg']; ?>" <?php echo (isset($_GET['filter_pg']) && $_GET['filter_pg'] == $pg['kode_pg']) ? 'selected' : ''; ?>>
                  <?php echo $pg['kode_pg'] . ' - ' . $pg['nama_pg']; ?>
                </option>
              <?php endforeach; ?>
            </select></div>
        <div class="one_third">
          <input type="submit" value="Filter" class="btn small">
            <?php if (!empty($_GET['filter_ket'])): ?>
              <p class="bold">
                <small><?php echo count($data_selesai); ?> hasil ditemukan dari filter</small>
              </p>
            <?php else: ?>
              <p class="bold">
                <small><?php echo count($data_selesai); ?> data selesai denda ditampilkan</small>
              </p>
            <?php endif; ?>
        </div>
        </form>
      </div>
    <div class="clear">
        <table>
          <?php 
          if (isset($_GET['filter_pg']) && $_GET['filter_pg'] != '') {
            $filter_pg = $_GET['filter_pg'];
            $data_selesaidenda = array_filter($data_selesai, function ($item) use ($filter_pg) {
                return $item['kode_pg'] === $filter_pg;
            });
          } 
          ?>
          <thead>
            <tr>
              <th>Kode</th>
              <th>NIS</th>
              <th>Kode Buku</th>
              <th>Kode Pegawai</th>
              <th>Tanggal Pinjam</th>
              <th>Batas Tanggal</th>
              <th>Tanggal Kembali</th>
            </tr>
          </thead>
          <tbody>
          <?php
	          foreach ($data_selesai as $row) {
		      ?>
            <tr>
              <td><?php echo $row['kode_pm'] ?></td>
              <td><?php echo $row['nis'] ?> <br> <small><?php echo $row['nama'] ?></small> </td>
              <td><?php echo $row['kode_buku'] ?> <br> <small><?php echo $row['judul'] ?></small> </td>
              <td><?php echo $row['kode_pg'] ?> <br> <small><?php echo $row['nama_pg'] ?></small> </td>
              <td><?php echo $row['tanggal'] ?></td>
              <td><?php echo $row['ptgl_kembali'] ?></td>
              <td><?php echo $row['tgl_kembali'] ?></td>
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