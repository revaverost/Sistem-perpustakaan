<?php
// Menyertakan file koneksi, header, dan konfirmasi login
include '../../index_header.php';
include '../../konfirm_login.php';
include '../../koneksi.php';

// Membuat instance objek database
$db = new database();

// Mengambil input pencarian jika ada
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Mengambil data buku dari database berdasarkan input pencarian
$data_buku = $db->tampil_data_buku($search);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Perpustakaan</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- file CSS layout dan ikon font awesome -->
    <link href="../../layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

<div class="wrapper row0">
<main class="hoc container clear"> 
    <h1 class="fl_left bold font-x2">Data Buku</h1>

    <!-- Form pencarian buku -->
    <div class="fl_right inline">
        <form class="clear" method="GET" action="">
            <?php if ($search !== ''): ?>
                <!-- Menampilkan jumlah hasil yang ditemukan -->
                <p class="bold"> <small><?php echo count($data_buku); ?> hasil ditemukan</small></p>
            <?php endif; ?>
            <input type="text" name="search" placeholder="Cari judul buku..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button class="fa fa-search" type="submit"></button>
        </form>
    </div>

    <!-- tombol tambah data hanya muncul jika user adalah admin -->
    <?php if ($jabatan == "1") { ?>
    <div class="clear fl_right btmspace-15">
        <a class="inspace-10 btn" href="ft_buku.php"><i class="fa-solid fa-square-plus"></i> Tambah Buku</a>
    </div>
    <?php } ?>

    <!-- tabel data buku -->
    <div class="clear">
        <table>
            <thead>
                <tr>
                    <th>Kode Buku</th>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Penerbit</th>
                    <th>Tahun Terbit</th>
                    <th>Jenis Buku</th>
                    <th>Jumlah Awal</th>
                    <th>Jumlah Buku</th>
                    <th>Stok</th>
                    <th>Harga</th>
                    <?php if ($jabatan == "1") { ?>  
                    <th class="wide-column">Action</th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php
                // kamus jenis buku
                $jenis_buku = [
                    1 => 'Novel',
                    2 => 'Sejarah',
                    3 => 'Pelajaran',
                    4 => 'Ensiklopedia',
                    5 => 'Resep',
                    6 => 'Kamus',
                    7 => 'Majalah'
                ];

                // Perulangan untuk menampilkan data buku
                foreach ($data_buku as $row) {

                    // Mengambil jenis buku berdasarkan kode
                    $kj_buku = $row['kj_buku'];
                    $nama_buku = isset($jenis_buku[$kj_buku]) ? $jenis_buku[$kj_buku] : 'Tidak Diketahui';
                ?>
                <tr>
                    <td><?php echo $row['kode_buku'] ?></td>
                    <td><?php echo $row['judul'] ?></td>
                    <td><?php echo $row['pengarang'] ?></td>
                    <td><?php echo $row['penerbit'] ?></td>
                    <td><?php echo $row['tahun_terbit'] ?></td>
                    <td><?php echo $nama_buku ?></td>
                    <td><?php echo $row['jml_awal'] ?></td>
                    <td><?php echo $row['jml_buku'] ?></td>
                    <td><?php echo $row['stok'] ?></td>
                    <td><?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                    
                    <!-- Tombol aksi hanya ditampilkan jika user admin -->
                    <?php if ($jabatan == "1") { ?>
                    <td class="center">
                        <!-- Tombol edit -->
                        <a href="edit_buku.php?action=update_buku&id=<?php echo $row['kode_buku']; ?>"
                           class="fa-solid fa-pen-to-square font-x2"></a>

                        <!-- Tombol hapus dengan konfirmasi -->
                        <a href="../../proses.php?action=delete_buku&id=<?php echo $row['kode_buku']; ?>"
                           class="fa-solid fa-trash font-x2"
                           onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');"></a>
                    </td>
                    <?php } ?>
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
// Menyertakan file footer
include '../../index_footer.html'; 
?>
