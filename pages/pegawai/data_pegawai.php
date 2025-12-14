<?php
// Memuat bagian header, autentikasi login, dan koneksi database
include '../../index_header.php';
include '../../konfirm_login.php';
include '../../koneksi.php';

// Membuat objek database untuk menjalankan fungsi
$db = new database();

// Mengambil data dari query string jika ada pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Memanggil fungsi untuk menampilkan data pegawai, dengan parameter pencarian
$data_pegawai = $db->tampil_data_pegawai($search);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Perpustakaan</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- Link stylesheet utama dan font awesome -->
    <link href="../../layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<div class="wrapper row0">
<main class="hoc container clear"> 
    <!-- Judul Halaman -->
    <h1 class="fl_left bold font-x2">Data Pegawai</h1>

    <!-- Formulir pencarian data pegawai -->
    <div class="fl_right inline">
        <form class="clear" method="GET" action="#">
            <?php if ($search !== ''): ?>
                <p class="bold">
                    <small><?php echo count($data_pegawai); ?> hasil ditemukan</small>
                </p>
            <?php endif; ?>
            <input type="text" name="search" placeholder="Nama Pegawai..." value="<?php echo $search; ?>">
            <button class="fa fa-search" type="submit"></button>
        </form>
    </div>

    <!-- Tombol tambah pegawai -->
    <div class="clear fl_right btmspace-15">
        <a class="inspace-10 btn" href="ft_pegawai.php">
            <i class="fa-solid fa-square-plus"></i> Tambah Pegawai
        </a>
    </div>

    <!-- Tabel data pegawai -->
    <div class="scrollable clear">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Pegawai</th>
                    <th>Nama Pegawai</th>
                    <th>Jabatan</th>
                    <th>Jenis Kelamin</th>
                    <th>Username</th>
                    <th class="wide-column">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($data_pegawai as $row) {
                    // Menentukan teks jabatan dan jenis kelamin
                    $kd_jabatan = $row['jabatan'] == 1 ? 'Admin' : 'Pegawai';
                    $jenis_kelamin = $row['jk'] == 1 ? 'Laki-laki' : 'Perempuan';
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $row['kode_pg']; ?></td>
                    <td><?php echo $row['nama_pg']; ?></td>
                    <td><?php echo $kd_jabatan; ?></td>
                    <td><?php echo $jenis_kelamin; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td class="center">
                        <!-- Tombol edit -->
                        <a href="edit_pegawai.php?action=update_pg&id=<?php echo $row['kode_pg']; ?>" class="fa-solid fa-pen-to-square font-x2"></a>
                        <!-- Tombol hapus -->
                        <a href="../../proses.php?action=delete_pg&id=<?php echo $row['kode_pg']; ?>" 
                           class="fa-solid fa-trash font-x2"
                           onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');"></a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</main>
</div>
</body>
</html>

<?php
// Memuat bagian footer halaman
include '../../index_footer.html'; 
?>
