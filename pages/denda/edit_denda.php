<?php
// Memuat file header halaman, autentikasi login, dan koneksi database
include '../../index_header.php'; 
include '../../konfirm_login.php';
include '../../koneksi.php';

// Membuat objek dari class database
$db = new database();

// Mengambil ID pegawai dari sesi login
$kode_pg = $_SESSION['pegawai_id']; 
$pegawai = $db->get_logged_in_pegawai($kode_pg);

// Mengambil kode peminjaman dari parameter GET
$kode_pm= $_GET['id'];

// Jika kode peminjaman tersedia, ambil data denda berdasarkan ID tersebut
if (! is_null($kode_pm)) {
    $data_denda = $db->get_by_id_denda($kode_pm);
} else {
    // Jika tidak ada, arahkan kembali ke halaman data denda
    header('location:data_denda.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Perpustakaan</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="../../layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<div class="row0 bgded" style="background-image:url('../../images/bg_kiri.jpg');">
<main class="hoc container clear"> 
    <div class="fl_right">
        <h1 class="fl_left bold font-x2">Update Data Denda</h1>

        <!-- Formulir untuk memperbarui data denda -->
        <form method="post" action="../../proses.php?action=update_denda">
            <!-- Data tersembunyi yang dibutuhkan -->
            <input type="hidden" name="kode_pm" value="<?php echo $data_denda['kode_pm']; ?>">
            <input type="hidden" name="kode_pg" value="<?php echo $pegawai['kode_pg']; ?>">
            <input type="hidden" name="tanggal" value="<?php echo $data_denda['tanggal']; ?>">

            <table>
                <tr>
                    <td><label for="nis">Nis</label></td>
                    <td><input type="number" name="nis" value="<?php echo $data_denda['nis']; ?>" readonly></td>
                </tr>

                <tr>
                    <td><label for="kode_buku">Kode Buku</label></td>
                    <td><input type="number" name="kode_buku" value="<?php echo $data_denda['kode_buku']; ?>" readonly></td>
                </tr>

                <tr>
                    <td><label for="ptgl_kembali">Perkiraan Tanggal Kembali</label></td>
                    <td><input type="date" id="ptgl_kembali" name="ptgl_kembali" value="<?php echo $data_denda['ptgl_kembali']; ?>" readonly></td>
                </tr>

                <tr>
                    <td><label for="tgl_kembali">Tanggal Kembali</label></td>
                    <td><input type="date" id="tgl_kembali" name="tgl_kembali" value="<?php echo $data_denda['tgl_kembali']; ?>" readonly></td>
                </tr>

                <input type="hidden" id="ket_terlambat" name="ket_terlambat" value="<?php echo $data_denda['ket_terlambat'] ?>" readonly>

                <!-- Jumlah denda yang harus dibayar -->
                <tr>
                    <td><label for="ket_denda">Jumlah Denda</label></td>
                    <td><input type="number" id="ket_denda" name="ket_denda" value="<?php echo $data_denda['ket_denda']; ?>"></td>
                </tr>

                <!-- Denda tambahan yang akan diinputkan -->
                <tr>
                    <td><label for="denda_baru">Denda Tambahan</label></td>
                    <td>
                        <input style="width: 75px;" type="number" id="denda_lama" value="<?php echo $data_denda['denda']; ?>" readonly> + 
                        <input style="width: 75px;" type="number" id="denda_baru" value="" required>
                    </td>
                </tr>

                <!-- Total denda setelah dijumlahkan -->
                <tr>
                    <td><label for="denda">Total Denda</label></td>
                    <td>
                        <input type="number" id="denda" name="denda" value="<?php echo $data_denda['denda']; ?>" readonly required>
                    </td>
                </tr>

                <!-- Keterangan apakah denda sudah selesai dibayar -->
                <tr>
                    <td><label for="ket_selesai">Keterangan Selesai</label></td>
                    <td>
                        <input type="hidden" id="ket_selesai" name="ket_selesai" value="<?php echo $data_denda['ket_selesai']; ?>" readonly>
                        <span id="ket_selesai_text">
                            <?php echo ($data_denda['ket_selesai'] == '1') ? 'Selesai' : 'Belum Selesai'; ?>
                        </span>
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
</div>
</main>

<!-- Script JavaScript untuk menghitung total denda dan memperbarui status -->
<script>
    function updateDendaTotal() {
        // Mengambil nilai denda lama dan denda baru
        const dendaLama = parseInt(document.getElementById('denda_lama').value, 10) || 0;
        const dendaBaru = parseInt(document.getElementById('denda_baru').value, 10) || 0;
        const total = dendaLama + dendaBaru;

        // Menampilkan total denda pada field input
        document.getElementById('denda').value = total;

        // Bandingkan dengan jumlah denda yang seharusnya dibayar
        const ketDendaInput = parseInt(document.getElementById('ket_denda').value, 10);
        const ketSelesaiInput = document.getElementById('ket_selesai');
        const ketSelesaiText = document.getElementById('ket_selesai_text');

        // Jika total sesuai dengan ket_denda, tandai sebagai selesai
        if (total === ketDendaInput) {
            ketSelesaiInput.value = '1';
            ketSelesaiText.textContent = 'Selesai';
        } else {
            // Jika tidak sesuai, status belum selesai
            ketSelesaiInput.value = '2';
            ketSelesaiText.textContent = 'Belum Selesai';
        }
    }

    // Menambahkan event listener untuk memantau input denda baru
    document.getElementById('denda_baru').addEventListener('input', updateDendaTotal);
</script>

</body>
</html>

<?php
// Memuat footer dari halaman
include '../../index_footer.html'; 
?>
