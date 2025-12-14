<?php
include '../../koneksi.php';
$db = new database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode_pg = $_POST['kode_pg'];
    $username = $_POST['username'];
    $new_password = $_POST['password']; // Password baru dari input form
    $old_password = $_POST['old_password']; // Password lama yang dimasukkan user

    // Ambil password lama dari database
    $query = "SELECT password FROM pegawai WHERE kode_pg = ?";
    $stmt = $db->koneksi->prepare($query);
    $stmt->bind_param("s", $kode_pg); // Gunakan "s" karena kode_pg string
    $stmt->execute();
    $stmt->bind_result($db_password);
    $stmt->fetch();
    $stmt->close();

    // Periksa apakah password lama yang dimasukkan benar
    if (password_verify($old_password, $db_password)) {
        // Jika password lama benar, hash password baru
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update username dan password baru ke database
        $query = "UPDATE pegawai SET username = ?, password = ? WHERE kode_pg = ?";
        $stmt = $db->koneksi->prepare($query);
        $stmt->bind_param("sss", $username, $hashed_password, $kode_pg); // Gunakan "sss" karena semua string

        if ($stmt->execute()) {
            echo "<script>alert('Profil berhasil diperbarui!'); window.location.href='info_profil.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat menyimpan perubahan!'); window.history.back();</script>";
        }
        $stmt->close();
    } else {
        // Jika password lama salah
        echo "<script>alert('Password lama salah!'); window.history.back();</script>";
    }
}
?>
