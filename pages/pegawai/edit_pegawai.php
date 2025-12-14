<?php
// Memuat bagian header, autentikasi login, dan koneksi database
include '../../index_header.php'; 
include '../../konfirm_login.php';
include '../../koneksi.php';

// Membuat objek database dan mengambil ID pegawai dari parameter URL
$db = new database();
$kode_pg = $_GET['id'];

// Jika ID tersedia, ambil datanya dari database. Jika tidak, arahkan kembali ke halaman data pegawai
if (!is_null($kode_pg)) {
    $data_pegawai = $db->get_by_id_pegawai($kode_pg);
} else {
    header('location:data_pegawai.php');
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Perpustakaan</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- Link stylesheet dan ikon font-awesome -->
    <link href="../../layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

<div class="row0 bgded" style="background-image:url('../../images/bg_kiri.jpg');">
<main class="hoc container clear"> 
    <div class="fl_right">
        <h1 class="fl_left bold font-x2">Update Data Pegawai</h1>

        <!-- Form untuk update data -->
        <form method="post" action="../../proses.php?action=update_pg">
            <input type="hidden" name="kode_pg" value="<?php echo $data_pegawai['kode_pg']; ?>">

            <table>
                <tr>
                    <td><label for="nama_pg">Nama Pegawai</label></td>
                    <td>
                        <input type="text" name="nama_pg" value="<?php echo $data_pegawai['nama_pg']; ?>" oninput="this.value = this.value.toUpperCase();">
                    </td>
                </tr>

                <tr>
                    <td><label for="jabatan">Jabatan</label></td>
                    <td>
                        <input type="radio" id="jabatan1" name="jabatan" value="1"
                            onchange="handleRadioChange(this)"
                            <?php echo ($data_pegawai['jabatan'] === '1') ? 'checked' : ''; ?>>
                        <label for="jabatan1">Admin</label>

                        <input type="radio" id="jabatan2" name="jabatan" value="2"
                            onchange="handleRadioChange(this)"
                            <?php echo ($data_pegawai['jabatan'] === '2') ? 'checked' : ''; ?>>
                        <label for="jabatan2">Petugas</label>
                    </td>
                </tr>

                <tr>
                    <td><label for="jk">Jenis Kelamin</label></td>
                    <td>
                        <input type="radio" id="jk1" name="jk" value="1"
                            onchange="handleRadioChange(this)"
                            <?php echo ($data_pegawai['jk'] === '1') ? 'checked' : ''; ?>>
                        <label for="jk1">Laki-laki</label>

                        <input type="radio" id="jk2" name="jk" value="2"
                            onchange="handleRadioChange(this)"
                            <?php echo ($data_pegawai['jk'] === '2') ? 'checked' : ''; ?>>
                        <label for="jk2">Perempuan</label>
                    </td>
                </tr>
            </table>

            <!-- Tombol aksi -->
            <div>
                <input class="inspace-10 btn" type="submit" name="submit" value="Submit Form">
                &nbsp;
                <input class="inspace-10 btn" type="reset" name="reset" value="Reset Form">
            </div>
        </form>
    </div>
</main>
</div>
</body>
</html>

<?php
// Menutup dengan footer
include '../../index_footer.html'; 
?>
