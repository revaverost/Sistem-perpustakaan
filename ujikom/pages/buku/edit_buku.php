<?php
// Menyertakan file header, konfirmasi login, dan koneksi database
include '../../index_header.php'; 
include '../../konfirm_login.php';
include '../../koneksi.php';

// Membuat instance dari class database
$db = new database();

// Mengambil kode buku
$kode_buku = $_GET['id'];

// Jika kode buku ada, ambil data berdasarkan ID, jika tidak redirect ke halaman data buku
if (!is_null($kode_buku)) {
    $data_buku = $db->get_by_id_buku($kode_buku);
} else {
    header('location:data_buku.php');
}
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

<div class="row0 bgded" style="background-image:url('../../images/bg_kiri.jpg');">
<main class="hoc container clear"> 
    <div class="fl_right">
        <h1 class="fl_left bold font-x2">Update Data Buku</h1>

        <!-- Form update data buku -->
        <form method="post" action="../../proses.php?action=update_buku">
            <!-- Input tersembunyi untuk kode buku -->
            <input type="hidden" name="kode_buku" value="<?php echo $data_buku['kode_buku']; ?>">

            <table>
                <tr>
                    <td><label for="judul">Judul</label></td>
                    <td><input type="text" name="judul" value="<?php echo $data_buku['judul']; ?>"></td>
                </tr>
                <tr>
                    <td><label for="pengarang">Pengarang</label></td>
                    <!-- oninput digunakan untuk otomatis mengubah huruf menjadi kapital -->
                    <td><input type="text" name="pengarang" value="<?php echo $data_buku['pengarang']; ?>" oninput="this.value = this.value.toUpperCase();"></td>
                </tr>
                <tr>
                    <td><label for="tahun_terbit">Tahun Terbit</label></td>
                    <td><input type="number" name="tahun_terbit" value="<?php echo $data_buku['tahun_terbit']; ?>"></td>
                </tr>
                <tr>
                    <td><label for="penerbit">Penerbit</label></td>
                    <td><input type="text" name="penerbit" value="<?php echo $data_buku['penerbit']; ?>"></td>
                </tr>
                <tr>
                    <td><label for="kj_buku">Jenis Buku</label></td>
                    <td>
                        <!-- Dropdown jenis buku, dengan nilai yang sesuai akan otomatis terpilih -->
                        <select name="kj_buku" id="kj_buku">
                            <option value="1" <?php echo ($data_buku['kj_buku'] === '1') ? 'selected' : ''; ?>>Novel</option>
                            <option value="2" <?php echo ($data_buku['kj_buku'] === '2') ? 'selected' : ''; ?>>Sejarah</option>
                            <option value="3" <?php echo ($data_buku['kj_buku'] === '3') ? 'selected' : ''; ?>>Pelajaran</option>
                            <option value="4" <?php echo ($data_buku['kj_buku'] === '4') ? 'selected' : ''; ?>>Ensiklopedia</option>
                            <option value="5" <?php echo ($data_buku['kj_buku'] === '5') ? 'selected' : ''; ?>>Resep</option>
                            <option value="6" <?php echo ($data_buku['kj_buku'] === '6') ? 'selected' : ''; ?>>Kamus</option>
                            <option value="7" <?php echo ($data_buku['kj_buku'] === '7') ? 'selected' : ''; ?>>Majalah</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="jml_awal">Jumlah Awal</label></td>
                    <td><input type="number" name="jml_awal" value="<?php echo $data_buku['jml_awal']; ?>"></td>
                </tr>
                <tr>
                    <td><label for="jml_buku">Jumlah Buku</label></td>
                    <td><input type="number" name="jml_buku" value="<?php echo $data_buku['jml_buku']; ?>"></td>
                </tr>
                <tr>
                    <td><label for="stok">Stok Buku</label></td>
                    <td><input type="number" name="stok" value="<?php echo $data_buku['stok']; ?>"></td>
                </tr>
                <tr>
                    <td><label for="harga">Harga Buku</label></td>
                    <td><input type="number" name="harga" value="<?php echo $data_buku['harga']; ?>" required></td>
                </tr>
            </table>

            <!-- Tombol submit dan reset form -->
            <div>
                <input class="inspace-10 btn" type="submit" name="submit" value="Submit Form">
                &nbsp;
                <input class="inspace-10 btn" type="reset" name="reset" value="Reset Form">
            </div>
        </form>
    </div>
</div>
</main>
</body>
</html>

<?php
// Menyertakan footer
include '../../index_footer.html'; 
?>
