<?php 
// Menghubungkan ke file koneksi dan membuat objek koneksi database
include ('koneksi.php');
$koneksi = new database();

// Ambil nilai parameter action dari URL
$action = $_GET['action'];

// Aksi Tambah Data Pegawai
// =====================================
if ($action == "add_pg") {
    $koneksi->tambah_data_pegawai($_POST['kode_pg'], $_POST['nama_pg'], $_POST['jabatan'], $_POST['jk'], $_POST['username'], $_POST['password']);
    echo "<script>
        alert('Data pegawai berhasil ditambahkan!');
        window.location.href='pages/pegawai/data_pegawai.php';
    </script>";
    exit();
}

// Aksi Update Data Pegawai
// =====================================
elseif ($action == "update_pg") {
    $koneksi->update_data_pegawai($_POST['nama_pg'], $_POST['jabatan'], $_POST['jk'], $_POST['kode_pg']);
    echo "<script>
        alert('Data pegawai berhasil diperbarui!');
        window.location.href='pages/pegawai/data_pegawai.php';
    </script>";
    exit();
}

// Aksi Hapus Data Pegawai
// =====================================
elseif ($action == "delete_pg") {
    $kode_pg = $_GET['id'];

    // Cek apakah pegawai tersebut masih digunakan dalam transaksi peminjaman
    $cek_transaksi_pg = mysqli_query($koneksi->koneksi, "SELECT * FROM daftar_pm WHERE kode_pg = '$kode_pg'");

    // Jika data pegawai ditemukan dalam tabel transaksi, tampilkan pesan dan batalkan penghapusan
    if (mysqli_num_rows($cek_transaksi_pg) > 0) {
        echo "<script>
            alert('Data tidak dapat dihapus karena masih digunakan di tabel transaksi.');
            window.location.href='pages/pegawai/data_pegawai.php';
        </script>";
    } else {
        // Jika tidak digunakan dalam transaksi, hapus data pegawai
        $koneksi->delete_data_pegawai($kode_pg);
        header('location:pages/pegawai/data_pegawai.php');
    }
}


// Aksi Tambah Data Buku
// =====================================
elseif ($action == "add_buku") {
    $koneksi->tambah_data_buku($_POST['kode_buku'], $_POST['judul'], $_POST['penerbit'], $_POST['pengarang'], 
    $_POST['tahun_terbit'], $_POST['kj_buku'], $_POST['jml_awal'], $_POST['jml_buku'], $_POST['stok'], $_POST['harga']);

    //Tampil pesan jika berhasil
    echo "<script>
        alert('Data buku berhasil ditambahkan!');
        window.location.href='pages/buku/data_buku.php';
    </script>";
    exit();
}

// Aksi Update Data Buku
// =====================================
elseif ($action == "update_buku") {
    $koneksi->update_data_buku($_POST['judul'], $_POST['penerbit'], $_POST['pengarang'], 
    $_POST['tahun_terbit'], $_POST['kj_buku'], $_POST['jml_awal'], $_POST['jml_buku'], $_POST['stok'], $_POST['harga'], $_POST['kode_buku']);
    echo "<script>
        alert('Data buku berhasil diperbarui!');
        window.location.href='pages/buku/data_buku.php';
    </script>";
    exit();
}

// Aksi Hapus Data Buku
// =====================================
elseif ($action == "delete_buku") {
    $kode_buku = $_GET['id'];
    $cek_transaksi_buku = mysqli_query($koneksi->koneksi, "SELECT * FROM daftar_pm WHERE kode_buku = '$kode_buku'");

    // Jika data buku ditemukan dalam tabel transaksi, tampilkan pesan dan batalkan penghapusan
    if (mysqli_num_rows($cek_transaksi_buku) > 0) {
        echo "<script>
            alert('Data tidak dapat dihapus karena masih digunakan di tabel transaksi.');
            window.location.href='pages/buku/data_buku.php';
        </script>";
    } else {
        $koneksi->delete_data_buku($kode_buku);
        header('location:pages/buku/data_buku.php');
    }
}

// Aksi Tambah Data Siswa
// ==========================================
elseif ($action == "add_siswa") {
    // Ambil data dari form POST
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $tingkat = $_POST['tingkat'];
    $prodi = $_POST['prodi'];
    $kelas = $_POST['kelas'];
    $jk = $_POST['jk'];

    // Array untuk menyimpan pesan error
    $errors = [];

    // Validasi NIS (harus 8 digit, diawali angka 2)
    if (strlen($nis) != 8 || $nis[0] != '2' || !is_numeric($nis)) {
        $errors['error_nis'] = "NIS harus terdiri dari 8 digit dan digit pertama harus angka 2.";
    } else {
        // Cek apakah NIS sudah terdaftar di database
        if ($koneksi->cek_data_siswa($nis)) {
            $errors['error_nis'] = "NIS sudah terdaftar. Data gagal ditambahkan.";
        }
    }

    // Validasi Input Lainnya
    if (empty($tingkat)) $errors['error_tingkat'] = "Tingkat tidak boleh kosong.";
    if (empty($prodi)) $errors['error_prodi'] = "Program studi tidak boleh kosong.";
    if (empty($kelas)) $errors['error_kelas'] = "Kelas tidak boleh kosong.";
    if (!in_array($jk, ['1', '2'])) $errors['error_jk'] = "Jenis kelamin harus 'L' (Laki-laki) atau 'P' (Perempuan).";

    // Jika terdapat error, redirect kembali ke form dengan data dan pesan error
    if (!empty($errors)) {
        // Gabungkan error dan data input ke dalam query string
        $query_params = http_build_query(array_merge($errors, [
            "nis" => $nis,
            "nama" => $nama,
            "tingkat" => $tingkat,
            "prodi" => $prodi,
            "kelas" => $kelas,
            "jk" => $jk
        ]));

        // Redirect ke form tambah siswa
        header("Location: pages/siswa/ft_siswa.php?$query_params");
        exit();
    }

    // Jika tidak ada error, tambahkan data ke database
    $koneksi->tambah_data_siswa($nis, $nama, $tingkat, $prodi, $kelas, $jk);

    // Tampilkan notifikasi sukses dan redirect ke halaman data siswa
    echo "<script>
        alert('Data Siswa berhasil ditambahkan!');
        window.location.href='pages/siswa/data_siswa.php';
    </script>";
    exit();
}


// Aksi Update Data Siswa
// =====================================
elseif ($action == "update_siswa") {
    $koneksi->update_data_siswa($_POST['nama'], $_POST['tingkat'], $_POST['prodi'], $_POST['kelas'], $_POST['jk'], $_POST['nis']);
    echo "<script>
        alert('Data siswa berhasil diperbarui!');
        window.location.href='pages/siswa/data_siswa.php';
    </script>";
    exit();
}

// Aksi Hapus Data Siswa
// =====================================
elseif ($action == "delete_siswa") {
    $nis = $_GET['id'];
    $cek_transaksi_siswa = mysqli_query($koneksi->koneksi, "SELECT * FROM daftar_pm WHERE nis = '$nis'");

    if (mysqli_num_rows($cek_transaksi_siswa) > 0) {
        echo "<script>
            alert('Data tidak dapat dihapus karena masih digunakan di tabel transaksi.');
            window.location.href='pages/siswa/data_siswa.php';
        </script>";
    } else {
        $koneksi->delete_data_siswa($nis);
        header('location:pages/siswa/data_siswa.php');
    }
}

// Aksi Tambah Peminjaman Buku
// =====================================
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_peminjaman"])) {
    // Mengambil data dari form input
    $nis = $_POST['nis'];
    $kode_buku_list = $_POST['kode_buku']; // Array dari kode buku yang dipinjam
    $tanggal = $_POST['tanggal']; // Tanggal peminjaman
    $ptgl_kembali = $_POST['ptgl_kembali']; // Perkiraan tanggal pengembalian
    $kode_pg = $_POST['kode_pg']; // Kode petugas

    // Inisialisasi variabel error untuk validasi
    $error_nis = $error_kode_buku = $error_batas = "";

    // Validasi NIS cek apakah siswa dengan NIS tersebut ada di database
    if (!$koneksi->cek_data_siswa($nis)) {
        $error_nis = "NIS tidak ditemukan!";
    }

    // Validasi batas jumlah buku yang bisa dipinjam
    $jumlah_dipinjam = $koneksi->hitung_peminjaman_buku($nis); // Hitung jumlah buku yang sedang dipinjam
    $jumlah_buku_baru = count($kode_buku_list); // Jumlah buku yang ingin dipinjam sekarang
    $sisa_buku_dapat_dipinjam = 3 - $jumlah_dipinjam; // Sisa kuota peminjaman

    // Cek apakah peminjaman baru melebihi batas maksimal (3 buku)
    if ($jumlah_dipinjam + $jumlah_buku_baru > 3) {
        $error_batas = "Anda hanya bisa meminjam maksimal 3 buku.<br>Saat ini Anda sudah meminjam $jumlah_dipinjam buku.<br>
                        Anda masih bisa meminjam $sisa_buku_dapat_dipinjam buku.";
    }

    // Validasi setiap kode buku: apakah buku tersebut ada di database
    foreach ($kode_buku_list as $kode_buku) {
        if (!$koneksi->cek_data_buku($kode_buku)) {
            $error_kode_buku .= "Kode Buku $kode_buku tidak ditemukan!<br>";
        }
    }

    // Jika ada kesalahan, redirect kembali ke form dengan membawa pesan error dan data yang telah diisi
    if (!empty($error_nis) || !empty($error_kode_buku) || !empty($error_batas)) {
        $kode_buku_str = implode(',', $kode_buku_list); // Gabungkan kode buku jadi satu string
        header("Location: pages/peminjaman/ft_peminjaman.php?" .
            "error_nis=" . urlencode($error_nis) . //string ke url
            "&error_kode_buku=" . urlencode($error_kode_buku) . 
            "&error_batas=" . urlencode($error_batas) . 
            "&nis=" . urlencode($nis) . 
            "&tanggal=" . urlencode($tanggal) . 
            "&ptgl_kembali=" . urlencode($ptgl_kembali) . 
            "&kode_buku=" . urlencode($kode_buku_str)
        );
        exit(); // Hentikan eksekusi jika error
    }

    // Jika tidak ada error, lakukan penyimpanan data ke database untuk setiap buku
    foreach ($kode_buku_list as $kode_buku) {
        $jumlah_peminjaman = $koneksi->hitung_peminjaman(); // Hitung total data peminjaman saat ini
        $kode_pm = str_pad($jumlah_peminjaman + 1, 6, '0', STR_PAD_LEFT); // Buat kode peminjaman baru, 6 digit
        $koneksi->tambah_data_peminjaman($kode_pm, $nis, $kode_buku, $kode_pg, $tanggal, $ptgl_kembali); // Simpan ke database
    }

    // Tampilkan notifikasi berhasil dan redirect ke halaman data peminjaman
    echo "<script>
        alert('Data peminjaman berhasil ditambahkan!');
        window.location.href='pages/peminjaman/data_peminjaman.php';
    </script>";
    exit();
}


// Aksi Hapus Data Peminjaman
// =====================================
elseif ($action == "delete_peminjaman") {
    $kode_pm= $_GET['id'];
    $koneksi->delete_data_peminjaman($kode_pm);
    header('location:pages/peminjaman/data_peminjaman.php');
}

// Aksi Update Data Pengembalian
// =====================================
elseif ($action == "update_pengembalian") {
    $koneksi->update_data_pengembalian($_POST['nis'], $_POST['kode_buku'], $_POST['kode_pg'], $_POST['tanggal'], 
    $_POST['ptgl_kembali'], $_POST['tgl_kembali'], $_POST['ket_terlambat'], $_POST['ket_denda'], $_POST['ket_selesai'], $_POST['denda'], $_POST['kode_pm']);
    echo "<script>
        alert('Data pengembalian berhasil diperbarui!');
        window.location.href='pages/peminjaman/data_peminjaman.php';
    </script>";
    exit();
}

// Aksi Update Data Denda
// =====================================
elseif ($action == "update_denda") {
    $koneksi->update_data_denda($_POST['nis'], $_POST['kode_buku'], $_POST['kode_pg'], $_POST['tanggal'], 
    $_POST['ptgl_kembali'], $_POST['tgl_kembali'], $_POST['ket_terlambat'], $_POST['ket_denda'], $_POST['denda'], $_POST['ket_selesai'], $_POST['kode_pm']);
    echo "<script>
        alert('Data denda berhasil diperbarui!');
        window.location.href='pages/denda/data_denda.php';
    </script>";
    exit();
}

?>
