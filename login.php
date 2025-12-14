<?php
session_start();
include 'koneksi.php';

$db = new database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($db->koneksi, $_POST['username']);
    $password = $_POST['password']; // Tidak perlu escape karena password tidak akan langsung dimasukkan ke query SQL

    // Gunakan prepared statement untuk keamanan
    $stmt = $db->koneksi->prepare("SELECT kode_pg, nama_pg, jabatan, password FROM pegawai WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Periksa apakah username ditemukan
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Verifikasi password dengan hash
        if (password_verify($password, $row['password'])) {
            $_SESSION['pegawai_id'] = $row['kode_pg'];
            $_SESSION['pegawai_nama'] = $row['nama_pg'];
            $_SESSION['pegawai_jabatan'] = $row['jabatan'];
            header("Location: index.php"); // Ganti dengan halaman tujuan setelah login
            exit();
        } else {
            $error = "Username atau password salah!";
        }
    } else {
        $error = "Username atau password salah!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Login Pegawai</title>
</head>
<body style="display: flex; justify-content: center; align-items: center; height: 100vh;">

<div>
    <h2 class="center">Login Pegawai</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST" action="">
        <table>
        <tr><div class="btmspace-15">
            <td><label class="fa-sharp fa-solid fa-user font-x2"></label></td>
            <td><input type="text" name="username" class="form-control" required></td>
        </div></tr>
        <tr><div class="btmspace-30">
            <td><label class="fa-sharp fa-solid fa-lock font-x2"></label></td>
            <td><input type="password" name="password" class="form-control" required></td>
        </div></tr>
        </table>
        <input class="inspace-10 btn btnlogin" type="submit" name="submit" value="Login">
    </form>
</div>
</body>
</html>
