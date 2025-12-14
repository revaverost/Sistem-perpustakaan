<?php
// Include file header, validasi login, dan koneksi database
include '../../index_header.php';
include '../../konfirm_login.php';
include '../../koneksi.php';

// Membuat objek database
$db = new database();

// Mengambil parameter pencarian dari URL jika ada
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Menampilkan data denda, dengan pencarian jika ada input
$data_denda = $db->tampil_data_denda($search);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Perpustakaan</title>
    <!-- Meta dan stylesheet -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="../../layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" 
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" 
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

<!-- Tampilan wrapper -->
<div class="wrapper row0">
<main class="hoc container clear"> 

    <!-- Judul halaman -->
    <h1 class="fl_left bold font-x2">Data Denda</h1>

    <!-- Form pencarian -->
    <div class="fl_right inline">
      <form class="clear" method="GET" action="#">
            <?php if ($search !== ''): ?>
              <!-- Tampilkan jumlah hasil pencarian jika ada -->
              <p class="bold"><small><?php echo count($data_denda); ?> hasil ditemukan</small></p>
            <?php endif; ?>
            <input type="text" name="search" placeholder="Cari NIS..." 
                   value="<?php echo htmlspecialchars($search); ?>">
            <button class="fa fa-search" type="submit"></button>
      </form>
    </div>

    <div class="clear">
        <!-- Tabel data denda -->
        <table>
          <thead>
            <tr>
              <th>Kode</th>
              <th>NIS</th>
              <th>Kode Buku</th>
              <th>Kode Pegawai</th>
              <th>Keterangan</th>
              <th>Jumlah Denda</th>
              <th>Denda</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // kamus data status keterlambatan
            $kt = [
              1 => 'Tepat Waktu',
              2 => 'Terlambat',
              3 => 'Hilang'
            ];

            // Loop data denda
            foreach ($data_denda as $row) {
            ?>
            <tr>
              <td><?php echo $row['kode_pm'] ?></td>
              <td><?php echo $row['nis'] ?> <br><small><?php echo $row['nama'] ?></small></td>
              <td><?php echo $row['kode_buku'] ?> <br><small><?php echo $row['judul'] ?></small></td>
              <td><?php echo $row['kode_pg'] ?> <br><small><?php echo $row['nama_pg'] ?></small></td>
                  <?php 
                    // Konversi kode ket_terlambat ke teks
                    $ket_ter = $row['ket_terlambat'];
                    $nama_ket = isset($kt[$ket_ter]) ? $kt[$ket_ter] : '';
                  ?>
              <td><?php echo $nama_ket ?></td>
              <td><?php echo number_format($row['ket_denda'], 0, ',', '.');  ?></td>
              <td><?php echo number_format($row['denda'], 0, ',', '.'); ?></td>
              <td class="center">
                <!-- Tombol edit -->
                <a href="edit_denda.php?action=update_denda&id=<?php echo $row['kode_pm']; ?>" 
                   class="fa-solid fa-pen-to-square font-x2"></a>
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
// Include footer halaman
include '../../index_footer.html'; 
?>
