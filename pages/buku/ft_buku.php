<?php
// Menyertakan file header, konfirmasi login, dan koneksi database
include '../../index_header.php'; 
include '../../konfirm_login.php';
include '../../koneksi.php';

// Membuat instance dari class database
$koneksi = new database();

// Mengambil semua data buku untuk keperluan generate kode buku otomatis
$data_buku = $koneksi->tampil_data_buku();
$kode_buku_baru = $koneksi->kode_buku_auto();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Perpustakaan</title>
    <!-- Pengaturan meta dan stylesheet -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="../../layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

<!-- Background dan kontainer utama -->
<div class="row0 bgded" style="background-image:url('../../images/bg_kiri.jpg');">
<main class="hoc container clear"> 
    <div class="fl_right">
        <!-- Judul halaman -->
        <h1 class="bold font-x2">Tambah Data Buku</h1>

        <!-- Form untuk menambah data buku -->
        <form method="post" action="../../proses.php?action=add_buku">
            <table>
                <!-- Input kode buku otomatis -->
                <tr>
                    <td><label for="kode_buku">Kode Buku</label></td>
                    <td>
                        <input type="text" id="kode_buku" name="kode_buku" 
                            value="<?php echo $kode_buku_baru ?>" readonly>
                    </td>
                </tr>
                <tr>
                    <td><label for="judul">Judul</label></td>
                    <td><textarea id="judul" name="judul" required></textarea></td>
                </tr>
                <tr>
                    <td><label for="pengarang">Pengarang</label></td>
                    <!-- Input pengarang otomatis huruf kapital -->
                    <td><input type="text" id="pengarang" name="pengarang" 
                        oninput="this.value = this.value.toUpperCase();" required></td>
                </tr>
                <tr>
                    <td><label for="tahun_terbit">Tahun Terbit</label></td>
                    <td><input type="number" id="tahun_terbit" name="tahun_terbit" required></td>
                </tr>
                <tr>
                    <td><label for="penerbit">Penerbit</label></td>
                    <td><input type="text" id="penerbit" name="penerbit" required></td>
                </tr>
                <tr>
                    <td><label for="kj_buku">Jenis Buku</label></td>
                    <td>
                        <!-- Dropdown pilihan jenis buku -->
                        <select name="kj_buku" id="kj_buku" required>
                            <option value="1">Novel</option>
                            <option value="2">Sejarah</option>
                            <option value="3">Pelajaran</option>
                            <option value="4">Ensiklopedia</option>
                            <option value="5">Resep</option>
                            <option value="6">Kamus</option>
                            <option value="7">Majalah</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="input_all">Jumlah</label></td>
                    <!-- Input jumlah buku (diatur sekali, lalu disalin ke 3 field hidden) -->
                    <td>
                        <input type="number" id="input_all" required>
                        <input type="hidden" id="jml_awal" name="jml_awal">
                        <input type="hidden" id="jml_buku" name="jml_buku">
                        <input type="hidden" id="stok" name="stok">
                    </td>
                </tr>
                <tr>
                    <td><label for="harga">Harga Buku</label></td>
                    <td><input type="number" id="harga" name="harga" required></td>
                </tr>
            </table>

            <!-- Tombol submit dan reset -->
            <div>
                <input class="inspace-10 btn" type="submit" name="submit" value="Submit Form">
                &nbsp;
                <input class="inspace-10 btn" type="reset" name="reset" value="Reset Form">
            </div>
        </form>
    </div>
</div>
</main>

<!-- Script untuk menyamakan input jml_awal , jml_buku , dan stok -->
<script>
    const inputAll = document.getElementById('input_all');
    const jmlAwal = document.getElementById('jml_awal');
    const jmlBuku = document.getElementById('jml_buku');
    const stok = document.getElementById('stok');

    inputAll.addEventListener('input', function() {
        const value = this.value;
        jmlAwal.value = value;
        jmlBuku.value = value;
        stok.value = value;
    });
</script>

</body>
</html>

<?php
// Menyertakan file footer
include '../../index_footer.html'; 
?>
