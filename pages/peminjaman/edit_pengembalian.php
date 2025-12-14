<?php
// Menyisipkan file header, verifikasi login, dan koneksi database
include '../../index_header.php'; 
include '../../konfirm_login.php';
include '../../koneksi.php';

$db = new database();

// Mengambil ID pegawai dari session
$kode_pg = $_SESSION['pegawai_id']; 

// Mengambil data pegawai yang sedang login
$pegawai = $db->get_logged_in_pegawai($kode_pg);

// Mengambil ID peminjaman dari parameter GET
$kode_pm = $_GET['id'];

// Mengecek apakah ID peminjaman tersedia, jika tidak redirect ke halaman data
if (!is_null($kode_pm)) {
    $data_pengembalian = $db->get_by_id_peminjaman($kode_pm);
} else {
    header('location:data_peminjaman.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Perpustakaan</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="../../layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>

<div class="row0 bgded" style="background-image:url('../../images/bg_kiri.jpg');">
<main class="hoc container clear"> 

    <div class="fl_right">
        <h1 class="fl_left bold font-x2">Update Data Pengembalian</h1>
        
        <!-- Form update data pengembalian -->
        <form method="post" action="../../proses.php?action=update_pengembalian">

            <!-- Data tersembunyi yang dikirim ke proses -->
            <input type="hidden" name="kode_pm" value="<?php echo $data_pengembalian['kode_pm']; ?>">
            <input type="hidden" name="kode_pg" value="<?php echo $pegawai['kode_pg']; ?>">
            <input type="hidden" name="tanggal" value="<?php echo $data_pengembalian['tanggal']; ?>">
            <input type="hidden" name="denda" value="0" required>

            <table>
                <tr>
                    <td><label for="nis">Nis</label></td>
                    <td><input type="number" name="nis" value="<?php echo $data_pengembalian['nis']; ?>" readonly></td>
                </tr>
                <tr>
                    <td><label for="kode_buku">Kode Buku</label></td>
                    <td><input type="number" name="kode_buku" value="<?php echo $data_pengembalian['kode_buku']; ?>" readonly></td>
                </tr>
                <tr>
                    <td><label for="ptgl_kembali">Batas_tanggal</label></td>
                    <td><input type="date" id="ptgl_kembali" name="ptgl_kembali" value="<?php echo $data_pengembalian['ptgl_kembali']; ?>" readonly></td>
                </tr>
                <tr>
                    <td><label for="tgl_kembali">Tanggal Kembali</label></td>
                    <td><input type="date" id="tgl_kembali" name="tgl_kembali" value="<?php echo $data_pengembalian['tgl_kembali']; ?>" required></td>
                </tr>

                <!-- Menampilkan status keterlambatan -->
                <tr>
                    <td><label for="ket_terlambat">Keterangan Terlambat</label></td>
                    <td>
                        <input type="hidden" id="ket_terlambat" name="ket_terlambat" value="<?php echo $data_pengembalian['ket_terlambat']; ?>">
                        <span id="ket_terlambat_text">
                            <?php echo ($data_pengembalian['ket_terlambat'] == '2') ? 'Terlambat' : 'Tidak Terlambat'; ?>
                        </span>
                    </td>
                </tr>

                <!-- Menampilkan jumlah denda -->
                <tr>
                    <td><label for="ket_denda">Jumlah Denda</label></td>
                    <td><input type="number" id="ket_denda" name="ket_denda" value="<?php echo $data_pengembalian['ket_denda']; ?>"></td>
                </tr>

                <!-- Menampilkan status selesai -->
                <tr>
                    <td><label for="ket_selesai">Keterangan Selesai</label></td>
                    <td>
                        <input type="hidden" id="ket_selesai" name="ket_selesai" value="<?php echo $data_pengembalian['ket_selesai']; ?>">
                        <span id="ket_selesai_text">
                            <?php echo ($data_pengembalian['ket_selesai'] == '1') ? 'Selesai' : ''; ?>
                        </span>
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

<!-- Script untuk mengatur status keterlambatan, denda, dan status selesai -->
<script>
    document.getElementById('tgl_kembali').addEventListener('change', function () {
        const tglKembali = new Date(this.value);
        const pTglKembali = new Date(document.getElementById('ptgl_kembali').value);
        const ketTerlambatInput = document.getElementById('ket_terlambat');
        const ketTerlambatText = document.getElementById('ket_terlambat_text');
        const ketSelesaiInput = document.getElementById('ket_selesai');
        const ketSelesaiText = document.getElementById('ket_selesai_text');
        const ketDendaInput = document.getElementById('ket_denda');

        // Logika jika pengembalian terlambat
        if (tglKembali > pTglKembali) {
            ketTerlambatInput.value = '2'; // Terlambat
            ketTerlambatText.textContent = 'Terlambat';
            ketSelesaiInput.value = '2'; // Belum selesai
            ketSelesaiText.textContent = 'Belum Selesai';

            // Hitung jumlah hari keterlambatan dan denda
            const selisihHari = Math.floor((tglKembali - pTglKembali) / (1000 * 60 * 60 * 24)); //milidetik
            const denda = selisihHari * 1000;

            ketDendaInput.value = denda;
        } else {
            // Jika tidak terlambat
            ketTerlambatInput.value = '1';
            ketTerlambatText.textContent = 'Tidak Terlambat';
            ketSelesaiInput.value = '1';
            ketSelesaiText.textContent = 'Selesai';
            ketDendaInput.value = '0';
        }
    });
</script>

</body>
</html>

<?php
// Menyisipkan file footer
include '../../index_footer.html'; 
?>
