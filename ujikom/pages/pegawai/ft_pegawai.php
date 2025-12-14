<?php
// Memuat file header, konfirmasi login, dan koneksi ke database
include '../../index_header.php';
include '../../konfirm_login.php';
include '../../koneksi.php';

// Membuat objek database dan mengambil semua data pegawai
$koneksi = new database();
$data_pegawai = $koneksi->tampil_data_pegawai();
$kode_pg= $koneksi->kode_pg_auto();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Perpustakaan</title>
    <!-- Pengaturan charset dan viewport agar responsif -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Memuat CSS dan ikon -->
    <link href="../../layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="..." crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

<div class="row0 bgded" style="background-image:url('../../images/bg_kiri.jpg');">
<main class="hoc container clear"> 
    <div class="fl_right">
        <h1 class="fl_left bold font-x2">Tambah Data Pegawai</h1>

        <!-- Form untuk menambahkan pegawai baru -->
        <form method="post" action="../../proses.php?action=add_pg">
            <table>
                <!-- Input kode pegawai, otomatis dibuat dengan format "pg01", "pg02", dst -->
                <tr>
                    <td><label for="kode_pg">Kode Pegawai</label></td>
                    <td><input type="text" name="kode_pg" value="<?php echo $kode_pg ?>" readonly></td>
                </tr>

                <!-- Input nama pegawai, otomatis menjadi huruf kapital -->
                <tr>
                    <td><label for="nama_pg">Nama Pegawai</label></td>
                    <td><input type="text" name="nama_pg" required style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();" required></td>
                </tr>

                <tr>
                    <td><label for="jabatan">Jabatan</label></td>
                    <td>
                        <input type="radio" id="jabatan1" name="jabatan" value="1" />
                        <label for="jabatan1">Admin</label>

                        <input type="radio" id="jabatan2" name="jabatan" value="2" />
                        <label for="jabatan2">Petugas</label>
                    </td>
                </tr>

                <tr>
                    <td><label for="jk">Jenis Kelamin</label></td>
                    <td>
                        <input type="radio" id="jk1" name="jk" value="1" />
                        <label for="jk1">Laki-laki</label>

                        <input type="radio" id="jk2" name="jk" value="2" />
                        <label for="jk2">Perempuan</label>
                    </td>
                </tr>

                <tr>
                    <td><label for="username">Username</label></td>
                    <td><input type="text" name="username" required></td>
                </tr>

                <!-- Input password dengan minimal 8 karakter -->
                <tr>
                    <td><label for="password">Password</label></td>
                    <td><input type="password" name="password" minlength="8" required></td>
                </tr>
            </table>

            <!-- Tombol submit dan reset -->
            <input class="inspace-10 btn" type="submit" name="submit" value="Submit Form">
            &nbsp;
            <input class="inspace-10 btn" type="reset" name="reset" value="Reset Form">
        </form>
    </div>
</div>
</main>
</body>
</html>


<?php
include '../../index_footer.html'; 
?>
