<?php
// Menyisipkan file header, konfirmasi login, dan koneksi database
include '../../index_header.php'; 
include '../../konfirm_login.php';
include '../../koneksi.php';

$db = new database();
$nis = $_GET['id'];

// Mengecek apakah NIS tidak kosong, jika tidak arahkan ke halaman data siswa
if (!is_null($nis)) {
    // Mengambil data siswa berdasarkan NIS
    $data_siswa = $db->get_by_id_siswa($nis);
} else {
    header('location:data_siswa.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Perpustakaan</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="../../layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="..." crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

<div class="row0 bgded" style="background-image:url('../../images/bg_kiri.jpg');">
<main class="hoc container clear"> 
    <div class="fl_right">
        <h1 class="fl_left bold font-x2">Update Data Siswa</h1>

        <!-- Form untuk mengupdate data siswa -->
        <form method="post" action="../../proses.php?action=update_siswa">
            <!-- NIS bersifat hidden karena tidak bisa diubah -->
            <input type="hidden" name="nis" value="<?php echo $data_siswa['nis']; ?>">

            <table>
                <!-- Input nama -->
                <tr>
                    <td><label for="nama">Nama</label></td>
                    <td><input type="text" name="nama" value="<?php echo $data_siswa['nama']; ?>" oninput="this.value = this.value.toUpperCase();"></td>
                </tr>

                <!-- Pilihan tingkat -->
                <tr>
                    <td><label for="tingkat">Tingkat</label></td>
                    <td>
                        <!-- Menampilkan radio button tingkat 10, 11, dan 12 -->
                        <input type="radio" id="tingkat1" name="tingkat" value="1" onchange="handleRadioChange(this)" <?php echo ($data_siswa['tingkat'] === '1') ? 'checked' : ''; ?> />
                        <label for="tingkat1">10</label>

                        <input type="radio" id="tingkat2" name="tingkat" value="2" onchange="handleRadioChange(this)" <?php echo ($data_siswa['tingkat'] === '2') ? 'checked' : ''; ?>/>
                        <label for="tingkat2">11</label><br>

                        <input type="radio" id="tingkat3" name="tingkat" value="3" onchange="handleRadioChange(this)" <?php echo ($data_siswa['tingkat'] === '3') ? 'checked' : ''; ?>/>
                        <label for="tingkat3">12</label>
                    </td>
                </tr>

                <!-- Pilihan Prodi -->
                <tr>
                    <td><label for="prodi">Prodi</label></td>
                    <td>
                        <!-- Menampilkan dropdown pilihan prodi -->
                        <select name="prodi" id="prodi">
                            <option value="1" <?php echo ($data_siswa['prodi'] === '1') ? 'selected' : ''; ?>>NKPI</option>
                            <option value="2" <?php echo ($data_siswa['prodi'] === '2') ? 'selected' : ''; ?>>APHPI</option>
                            <option value="3" <?php echo ($data_siswa['prodi'] === '3') ? 'selected' : ''; ?>>TKJ</option>
                            <option value="4" <?php echo ($data_siswa['prodi'] === '4') ? 'selected' : ''; ?>>RPL</option>
                            <option value="5" <?php echo ($data_siswa['prodi'] === '5') ? 'selected' : ''; ?>>TAB</option>
                            <option value="6" <?php echo ($data_siswa['prodi'] === '6') ? 'selected' : ''; ?>>Kuliner</option>
                            <option value="7" <?php echo ($data_siswa['prodi'] === '7') ? 'selected' : ''; ?>>APAPL</option>
                            <option value="8" <?php echo ($data_siswa['prodi'] === '8') ? 'selected' : ''; ?>>TP</option>
                        </select>
                    </td>
                </tr>

                <!-- Pilihan Kelas -->
                <tr>
                    <td><label for="kelas">Kelas</label></td>
                    <td>
                        <!-- Menampilkan radio button kelas 1, 2, dan 3 -->
                        <input type="radio" id="kelas1" name="kelas" value="1" onchange="handleRadioChange(this)" <?php echo ($data_siswa['kelas'] === '1') ? 'checked' : ''; ?> />
                        <label for="kelas1">1</label>

                        <input type="radio" id="kelas2" name="kelas" value="2" onchange="handleRadioChange(this)" <?php echo ($data_siswa['kelas'] === '2') ? 'checked' : ''; ?>/>
                        <label for="kelas2">2</label>

                        <input type="radio" id="kelas3" name="kelas" value="3" onchange="handleRadioChange(this)" <?php echo ($data_siswa['kelas'] === '3') ? 'checked' : ''; ?> />
                        <label for="kelas3">3</label>
                    </td>
                </tr>

                <!-- Pilihan Jenis Kelamin -->
                <tr>
                    <td><label for="jk">Jenis Kelamin</label></td>
                    <td>
                        <!-- Menampilkan radio button jenis kelamin -->
                        <input type="radio" id="jk1" name="jk" value="1" onchange="handleRadioChange(this)" <?php echo ($data_siswa['jk'] === '1') ? 'checked' : ''; ?> />
                        <label for="jk1">Laki-laki</label>

                        <input type="radio" id="jk2" name="jk" value="2" onchange="handleRadioChange(this)" <?php echo ($data_siswa['jk'] === '2') ? 'checked' : ''; ?>/>
                        <label for="jk2">Perempuan</label>
                    </td>
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
include '../../index_footer.html'; 
?>
