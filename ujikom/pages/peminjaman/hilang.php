<?php
// Mengimpor file header, konfirmasi login, dan koneksi ke database
include '../../index_header.php'; 
include '../../konfirm_login.php';
include '../../koneksi.php';

$db = new database();

// Mendapatkan ID pegawai dari session login
$kode_pg = $_SESSION['pegawai_id']; 
$pegawai = $db->get_logged_in_pegawai($kode_pg);

// Mendapatkan kode peminjaman dari query string
$kode_pm = $_GET['id'];

// Jika kode peminjaman tidak ditemukan, redirect ke halaman data_pengembalian
if (!is_null($kode_pm)) {
    // Ambil data peminjaman berdasarkan kode peminjaman
    $data_pengembalian = $db->get_by_id_peminjaman($kode_pm);
} else {
    // Redirect jika kode peminjaman tidak ditemukan
    header('location:data_pengembalian.php');
}

// Mendapatkan harga buku berdasarkan kode buku dari data peminjaman
$harga_buku = $db->get_harga_buku($data_pengembalian['kode_buku']); // Pastikan fungsi get_harga_buku sudah ada di class database
?>

<!DOCTYPE html>
<html>
<head>
    <title>Perpustakaan</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="../../layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<div class="row0 bgded" style="background-image:url('../../images/bg_kiri.jpg');">
<main class="hoc container clear"> 
    <div class="fl_right">
        <h1 class="fl_left bold font-x2">Form Buku Hilang</h1>
        <!-- Form untuk pengembalian buku dengan denda -->
        <form method="post" action="../../proses.php?action=update_pengembalian">
            <!-- Menyembunyikan data yang diperlukan untuk pengolahan server -->
            <input type="hidden" name="kode_pm" value="<?php echo $data_pengembalian['kode_pm']; ?>">
            <input type="hidden" name="kode_pg" value="<?php echo $pegawai['kode_pg']; ?>">
            <input type="hidden" name="tanggal" value="<?php echo $data_pengembalian['tanggal']; ?>">
            <input type="hidden" name="ket_terlambat" value="3">  <!-- Keterangan untuk terlambat (hilang) -->
            <input type="hidden" name="ket_selesai" value="2"> <!-- Keterangan selesai (belum selesai) -->
            <input type="hidden" id="harga_buku" value="<?php echo $harga_buku; ?>"> <!-- Menyimpan harga buku untuk perhitungan denda di JavaScript -->

            <!-- Form input untuk data peminjaman -->
            <table>
                <tr>
                    <td><label for="nis">NIS</label></td>
                    <td><input type="number" name="nis" value="<?php echo $data_pengembalian['nis']; ?>" readonly></td>
                </tr>
                <tr>
                    <td><label for="kode_buku">Kode Buku</label></td>
                    <td><input type="number" name="kode_buku" value="<?php echo $data_pengembalian['kode_buku']; ?>" readonly></td>
                </tr>
                <tr>
                    <td><label for="ptgl_kembali">Batas Tanggal</label></td>
                    <td><input type="date" id="ptgl_kembali" name="ptgl_kembali" value="<?php echo $data_pengembalian['ptgl_kembali']; ?>" readonly></td>
                </tr>
                <tr>
                    <td><label for="tgl_kembali">Tanggal Kembali</label></td>
                    <td><input type="date" id="tgl_kembali" name="tgl_kembali" value="<?php echo $data_pengembalian['tgl_kembali']; ?>" required></td>
                </tr>
                <tr>
                    <td><label for="ket_denda">Jumlah Denda</label></td>
                    <td><input type="number" id="ket_denda" name="ket_denda" value="<?php echo $data_pengembalian['ket_denda']; ?>" readonly>
                        <br>
                        <!-- Tampilkan harga buku dan denda terlambat -->
                        <span id="harga_buku_text">Harga Buku: Rp 0</span><br>
                        <span id="denda_terlambat_text">Denda Terlambat: Rp 0</span>
                    </td>
                </tr>
            </table>

            <!-- Tombol untuk submit dan reset form -->
            <div>
                <input class="inspace-10 btn" type="submit" name="submit" value="Submit Form">
                &nbsp;
                <input class="inspace-10 btn" type="reset" name="reset" value="Reset Form">
            </div>
        </form>
    </div>
</div>
</main>

<script>
// JavaScript untuk perhitungan denda berdasarkan tanggal pengembalian
document.getElementById('tgl_kembali').addEventListener('change', function () {
    const tglKembali = new Date(this.value);  // Mengambil tanggal kembali
    const pTglKembali = new Date(document.getElementById('ptgl_kembali').value);  // Mengambil batas tanggal pengembalian
    const ketDendaInput = document.getElementById('ket_denda');  // Input untuk menampilkan jumlah denda
    const hargaBuku = parseFloat(document.getElementById('harga_buku').value);  // Mengambil harga buku

    // Elemen untuk menampilkan harga buku dan denda terlambat
    const hargaBukuText = document.getElementById('harga_buku_text');
    const dendaTerlambatText = document.getElementById('denda_terlambat_text');

    let dendaTerlambat = 0;  // Inisialisasi denda terlambat

    // Jika tanggal kembali lebih dari batas pengembalian
    if (tglKembali > pTglKembali) {
        // Menghitung selisih hari terlambat
        const selisihHari = Math.floor((tglKembali - pTglKembali) / (1000 * 60 * 60 * 24));

        // Denda dikenakan jika terlambat lebih dari 10 hari
        if (selisihHari > 10) {
            const hariDidenda = selisihHari - 10;
            dendaTerlambat = hariDidenda * 1000;  // Denda Rp 1000 per hari setelah 10 hari
        }
    }

    // Total denda adalah harga buku ditambah dengan denda terlambat
    const totalDenda = hargaBuku + dendaTerlambat;

    // Update nilai input denda
    ketDendaInput.value = totalDenda;

    // Update tampilan informasi harga buku dan denda terlambat
    hargaBukuText.textContent = `Harga Buku: Rp ${hargaBuku.toLocaleString()}`;
    dendaTerlambatText.textContent = `Denda Terlambat: Rp ${dendaTerlambat.toLocaleString()}`;
});
</script>


</body>
</html>

<?php
include '../../index_footer.html'; 
?>
