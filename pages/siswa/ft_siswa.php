<?php
// Menyisipkan header dan script konfirmasi login
include '../../index_header.php';
include '../../konfirm_login.php';

// Ambil error dari query string jika ada (untuk validasi input)
$error_nis = isset($_GET['error_nis']) ? $_GET['error_nis'] : '';
$error_tingkat = isset($_GET['error_tingkat']) ? $_GET['error_tingkat'] : '';
$error_prodi = isset($_GET['error_prodi']) ? $_GET['error_prodi'] : '';
$error_kelas = isset($_GET['error_kelas']) ? $_GET['error_kelas'] : '';
$error_jk = isset($_GET['error_jk']) ? $_GET['error_jk'] : '';

// Ambil data input sebelumnya agar user tidak perlu mengisi ulang jika terjadi error
$nis = isset($_GET['nis']) ? $_GET['nis'] : '';
$nama = isset($_GET['nama']) ? $_GET['nama'] : '';
$tingkat = isset($_GET['tingkat']) ? $_GET['tingkat'] : '';
$prodi = isset($_GET['prodi']) ? $_GET['prodi'] : '';
$kelas = isset($_GET['kelas']) ? $_GET['kelas'] : '';
$jk = isset($_GET['jk']) ? $_GET['jk'] : '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Perpustakaan</title>
    <!-- Pengaturan meta dan pemanggilan stylesheet -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="../../layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .error { color: red; font-size: 14px; } /* Gaya teks untuk pesan error */
    </style>
</head>
<body>
<!-- Header dan background -->
<div class="row0 bgded" style="background-image:url('../../images/bg_kiri.jpg');">
<main class="hoc container clear"> 
    <div class="fl_right">
        <h1 class="fl_left bold font-x2">Tambah Data Siswa</h1>
        <!-- Form untuk input data siswa -->
        <form method="post" action="../../proses.php?action=add_siswa">
            <table>
                <tr>
                    <td><label for="nis">NIS</label></td>
                    <td>
                        <!-- Input NIS, hanya angka -->
                        <input type="number" id="nis" name="nis" value="<?= htmlspecialchars($nis) ?>" required>
                        <br><span class="error"><?= $error_nis ?></span>
                    </td>
                </tr>
                <tr>
                    <td><label for="nama">Nama</label></td>
                    <td>
                        <!-- Input nama otomatis kapital -->
                        <input type="text" id="nama" name="nama" style="text-transform: uppercase;" 
                            value="<?= htmlspecialchars($nama) ?>" oninput="this.value = this.value.toUpperCase();" required>
                    </td>
                </tr>
                <tr>
                    <td><label for="tingkat">Tingkat</label></td>
                    <td>
                        <!-- Pilihan tingkat 10, 11, 12 -->
                        <input type="radio" id="tingkat1" name="tingkat" value="1" <?= ($tingkat == '1') ? 'checked' : '' ?> />
                        <label for="tingkat1">10</label>
                        <input type="radio" id="tingkat2" name="tingkat" value="2" <?= ($tingkat == '2') ? 'checked' : '' ?> />
                        <label for="tingkat2">11</label></br>
                        <input type="radio" id="tingkat3" name="tingkat" value="3" <?= ($tingkat == '3') ? 'checked' : '' ?> />
                        <label for="tingkat3">12</label>
                        <br><span class="error"><?= $error_tingkat ?></span>
                    </td>
                </tr>
                <tr>
                    <td><label for="prodi">Prodi</label></td>
                    <td>
                        <!-- Dropdown pilihan program studi -->
                        <select name="prodi" id="prodi">
                            <option value="1" <?= ($prodi == '1') ? 'selected' : '' ?>>NKPI</option>
                            <option value="2" <?= ($prodi == '2') ? 'selected' : '' ?>>APHPI</option>
                            <option value="3" <?= ($prodi == '3') ? 'selected' : '' ?>>TKJ</option>
                            <option value="4" <?= ($prodi == '4') ? 'selected' : '' ?>>RPL</option>
                            <option value="5" <?= ($prodi == '5') ? 'selected' : '' ?>>TAB</option>
                            <option value="6" <?= ($prodi == '6') ? 'selected' : '' ?>>Kuliner</option>
                            <option value="7" <?= ($prodi == '7') ? 'selected' : '' ?>>APAPL</option>
                            <option value="8" <?= ($prodi == '8') ? 'selected' : '' ?>>TP</option>
                        </select>
                        <br><span class="error"><?= $error_prodi ?></span>
                    </td>
                </tr>
                <tr>
                    <td><label for="kelas">Kelas</label></td>
                    <td>
                        <!-- Pilihan kelas 1, 2, 3 -->
                        <input type="radio" id="kelas1" name="kelas" value="1" <?= ($kelas == '1') ? 'checked' : '' ?> />
                        <label for="kelas1">1</label>
                        <input type="radio" id="kelas2" name="kelas" value="2" <?= ($kelas == '2') ? 'checked' : '' ?> />
                        <label for="kelas2">2</label>
                        <input type="radio" id="kelas3" name="kelas" value="3" <?= ($kelas == '3') ? 'checked' : '' ?> />
                        <label for="kelas3">3</label>
                        <br><span class="error"><?= $error_kelas ?></span>
                    </td>
                </tr>
                <tr>
                    <td><label for="jk">Jenis Kelamin</label></td>
                    <td>
                        <!-- Pilihan jenis kelamin -->
                        <input type="radio" id="jk1" name="jk" value="1" <?= ($jk == '1') ? 'checked' : '' ?> />
                        <label for="jk1">Laki-laki</label>
                        <input type="radio" id="jk2" name="jk" value="2" <?= ($jk == '2') ? 'checked' : '' ?> />
                        <label for="jk2">Perempuan</label>
                        <br><span class="error"><?= $error_jk ?></span>
                    </td>
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
</body>
</html>

<?php
// Menyisipkan footer
include '../../index_footer.html';
?>
