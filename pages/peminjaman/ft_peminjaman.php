<?php
// Memanggil file header, koneksi database, dan pengecekan login
include '../../index_header.php'; 
include '../../konfirm_login.php';
include '../../koneksi.php';

$db = new database();
$kode_pg = $_SESSION['pegawai_id']; 

// Mengambil data pegawai yang sedang login
$pegawai = $db->get_logged_in_pegawai($kode_pg);

// Mengambil jumlah peminjaman untuk membuat kode peminjaman otomatis
$jumlah_peminjaman = $db->hitung_peminjaman();

// Mengambil pesan error dari URL jika ada validasi gagal sebelumnya
$error_nis = isset($_GET['error_nis']) ? $_GET['error_nis'] : "";
$error_kode_buku = isset($_GET['error_kode_buku']) ? $_GET['error_kode_buku'] : "";
$error_batas = isset($_GET['error_batas']) ? $_GET['error_batas'] : "";

// Mengambil input lama dari URL agar tidak hilang saat form error
$old_nis = isset($_GET['nis']) ? $_GET['nis'] : "";
$old_kode_buku = isset($_GET['kode_buku']) ? explode(',', $_GET['kode_buku']) : [];
$old_tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : "";
$old_ptgl_kembali = isset($_GET['ptgl_kembali']) ? $_GET['ptgl_kembali'] : "";
?>


<!-- HTML Bagian Head -->
<!DOCTYPE html>
<html>
<head>
    <title>Perpustakaan</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="../../layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">

    <!-- Script JavaScript untuk logika form -->
    <script>
        // Mengatur tanggal kembali otomatis 3 hari setelah tanggal peminjaman
        function setReturnDate() {
            const tanggalInput = document.getElementById('tanggal');
            const ptglKembaliInput = document.getElementById('ptgl_kembali');

            const tanggal = new Date(tanggalInput.value);
            tanggal.setDate(tanggal.getDate() + 3); // Tambah 3 hari

            const year = tanggal.getFullYear();
            const month = String(tanggal.getMonth() + 1).padStart(2, '0');
            const day = String(tanggal.getDate()).padStart(2, '0');

            ptglKembaliInput.value = `${year}-${month}-${day}`;
        }

        // Menambahkan input kode buku tambahan (maksimal 3 buku)
        function addKodeBuku() {
            const container = document.getElementById('kodeBukuContainer');
            let jumlahDipinjam = document.querySelectorAll('.kode-buku-item').length;
            let maxBuku = 3;

            if (jumlahDipinjam < maxBuku) {
                const newField = document.createElement('div');
                newField.classList.add('kode-buku-item');
                newField.innerHTML = `
                    <input type="text" name="kode_buku[]" list="kode_buku_list" required>
                    <button type="button" onclick="removeKodeBuku(this)">-</button>
                `;
                container.appendChild(newField);
            } else {
                alert("Maksimal hanya bisa menambahkan 3 kode buku.");
            }
        }

        // Menghapus field kode buku jika lebih dari satu
        function removeKodeBuku(button) {
            const container = document.getElementById('kodeBukuContainer');
            if (container.children.length > 1) {
                button.parentElement.remove();
            }
        }
    </script>
</head>

<!-- Tampilan form tambah peminjaman -->
<body>
<div class="row0 bgded" style="background-image:url('../../images/bg_kiri.jpg');">
<main class="hoc container clear"> 
    <div class="fl_right">
        <h1 class="fl_left bold font-x2">Tambah Data Peminjaman</h1>
        
        <!-- Form input -->
        <form method="post" action="../../proses.php?action=add_peminjaman">
            <table>
                <!-- Kode peminjaman otomatis -->
                <input type="hidden" name="kode_pm" value="<?php echo str_pad($jumlah_peminjaman + 1, 6, '0', STR_PAD_LEFT); ?>">
                <input type="hidden" name="kode_pg" value="<?php echo $pegawai['kode_pg'] ?>">

                <!-- Input NIS siswa -->
                <tr>
                    <td><label for="nis">NIS</label></td>
                    <td>
                        <input list="nis_list" name="nis" id="nis" value="<?= htmlspecialchars($old_nis) ?>" required>
                        <datalist id="nis_list">
                            <?php
                            // Menampilkan pilihan siswa
                            $query = mysqli_query($db->koneksi, "SELECT nis, nama FROM siswa");
                            while ($row = mysqli_fetch_assoc($query)) {
                                echo '<option value="' . htmlspecialchars($row['nis']) . '">' . htmlspecialchars($row['nama']) . '</option>';
                            }
                            ?>
                        </datalist>
                        <!-- Pesan error jika NIS tidak valid -->
                        <small class="error" style="color: red;"><?= $error_nis ?></small>
                    </td>
                </tr>

                <!-- Input kode buku (bisa lebih dari 1) -->
                <tr>
                    <td><label for="kode_buku">Kode Buku</label></td>
                    <td>
                        <div id="kodeBukuContainer">
                            <?php 
                            // Menampilkan input kode buku lama jika ada error
                            if (!empty($old_kode_buku)) {
                                foreach ($old_kode_buku as $kode) {
                                    ?>
                                    <div class="kode-buku-item">
                                        <input type="text" name="kode_buku[]" value="<?= htmlspecialchars($kode) ?>" list="kode_buku_list" required>
                                        <button type="button" onclick="removeKodeBuku(this)">-</button>
                                    </div>
                                    <?php
                                }
                            } else {
                                // Jika tidak ada input lama, tampilkan 1 field default
                                ?>
                                <div class="kode-buku-item">
                                    <input type="text" name="kode_buku[]" list="kode_buku_list" required>
                                    <button type="button" onclick="addKodeBuku()">+</button>
                                </div>
                            <?php } ?>
                            <small class="error" style="color: red;"><?= $error_kode_buku ?></small>
                        </div>

                        <!-- Datalist kode buku + judul sebagai label -->
                        <datalist id="kode_buku_list">
                            <?php
                            $query = mysqli_query($db->koneksi, "SELECT kode_buku, judul FROM buku");
                            while ($row = mysqli_fetch_assoc($query)) {
                                echo '<option value="' . htmlspecialchars($row['kode_buku']) . '">' . htmlspecialchars($row['judul']) . '</option>';
                            }
                            ?>
                        </datalist>
                    </td>
                </tr>

                <!-- Tanggal peminjaman -->
                <tr>
                    <td><label for="tanggal">Tanggal</label></td>
                    <td>
                        <input type="date" id="tanggal" name="tanggal" required onchange="setReturnDate()" value="<?= htmlspecialchars($old_tanggal) ?>">
                    </td>
                </tr>

                <!-- Perkiraan tanggal kembali (readonly, otomatis 3 hari setelah tanggal pinjam) -->
                <tr>
                    <td><label for="ptgl_kembali">Perkiraan Tanggal Kembali</label></td>
                    <td>
                        <input type="date" id="ptgl_kembali" name="ptgl_kembali" required readonly value="<?= htmlspecialchars($old_ptgl_kembali) ?>">
                    </td>
                </tr>
            </table>

            <!-- Tampilkan error jika batas buku lebih dari ketentuan -->
            <?php if (!empty($error_batas)): ?>
                <p class="error" style="color: red;"><?= $error_batas ?></p>
            <?php endif; ?>

            <!-- Tombol submit dan reset -->
            <div>
                <input class="inspace-10 btn" type="submit" name="add_peminjaman" value="Submit Form">
                <input class="inspace-10 btn" type="reset" name="reset" value="Reset Form">
            </div>
        </form>
    </div>
</div>
</main>
</body>
</html>

<!-- Footer -->
<?php include '../../index_footer.html'; ?>
