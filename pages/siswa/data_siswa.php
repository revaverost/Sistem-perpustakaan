<?php
include '../../index_header.php'; 
include '../../konfirm_login.php';
include '../../koneksi.php';

$db= new database();
$search = isset($_GET['search']) ? $_GET['search'] : '';
$data_siswa = $db->tampil_data_siswa($search);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Perpustakaan</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="../../layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<div class="wrapper row0">
<main class="hoc container clear"> 
    <h1 class="fl_left bold font-x2">Data Siswa</h1>
    <div class="fl_right inline">
      <form class="clear" method="GET" action="">
            <?php if ($search !== ''): ?>
              <p class="bold"> <small> <?php echo count($data_siswa); ?> hasil ditemukan</small></p>
            <?php endif; ?>
        <input type="text" name="search" placeholder="Cari nama/NIS..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        <button class="fa fa-search" type="submit"></button>
      </form>
    </div>
    <?php if ($jabatan == "1") { ?>
    <div class="clear fl_right btmspace-15">
      <a class="inspace-10 btn" href= "ft_siswa.php"><i class="fa-solid fa-square-plus"></i> Tambah Siswa</a>
    </div>
    <?php } ?>
    <div class="clear">
        <table>
          <thead>
            <tr>
              <th>No</th>
              <th>NIS</th>
              <th>Nama</th>
              <th>Kelas</th>
              <th>Jenis Kelamin</th>
              <?php if ($jabatan == "1") { ?>
              <th class="wide-column">Action</th>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
          <?php
          // Array untuk memetakan nilai ke prodi
            $jenis_prodi = [
            1 => 'NKPI',
            2 => 'APHPI',
            3 => 'TKJ',
            4 => 'RPL',
            5 => 'TAB',
            6 => 'Kuliner',
            7 => 'APAPL',
            8 => 'TP'];

            // Array untuk memetakan nilai ke tingkat
            $jenis_tingkat = [
              1 => '10',
              2 => '11',
              3 => '12'];

	          $no=1;
	          foreach ($data_siswa as $row) {
		      ?>
            <tr>
              <td><?php echo $no++ ?></td>
              <td><?php echo $row['nis'] ?></td>
              <td><?php echo $row['nama'] ?></td>
              <?php 
              $tingkat = $row['tingkat']; // Nama tingkat kamus data
              $nama_tingkat = isset($jenis_tingkat[$tingkat]) ? $jenis_tingkat[$tingkat] : 'Tidak Diketahui';

              $prodi = $row['prodi']; // Nama prodi kamus data
              $nama_prodi = isset($jenis_prodi[$prodi]) ? $jenis_prodi[$prodi] : 'Tidak Diketahui';
              ?>
              <td><?php echo $nama_tingkat . " " . $nama_prodi . " " . $row['kelas']; ?></td>
              <?php $jenis_kelamin = $row['jk'] == 1 ? 'Laki-laki' : 'Perempuan'; ?>
              <td><?php echo $jenis_kelamin ?></td>

              <?php if ($jabatan == "1") { ?>
              <td class="center">
                  <a href="edit_siswa.php?action=update_siswa&id=<?php echo $row['nis']; ?>"
                      class="fa-solid fa-pen-to-square font-x2"></a>
              
                  <a href="../../proses.php?action=delete_siswa&id=<?php echo $row['nis']; ?>"
                      class="fa-solid fa-trash font-x2"
                      onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');"></a>
              </td>
              <?php } ?>
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
