<?php
include '../../index_header.php'; 
include '../../konfirm_login.php'; 
include '../../koneksi.php';

$db = new database();

// Mendapatkan kode pegawai yang sedang login dari session
$kode_pg = $_SESSION['pegawai_id']; 

// Mengambil data pegawai berdasarkan kode pegawai yang sedang login
$pegawai = $db->get_logged_in_pegawai($kode_pg);
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
<div class="row0">
<main class="hoc container clear"> 
    <h1 class="bold font-x2 center">Informasi Profil</h1>
    
    <!-- Menampilkan informasi profil pegawai -->
    <div id="comments">
            <article class="one_half first mar_art">
              <header class="btmspace-15">
                  <address class="font-x1">
                    <?php echo $pegawai['nama_pg'] ?>
                  </address>
                  <time><?php echo $pegawai['kode_pg'] ?></time>
              </header>
              <div>
                <!-- Menampilkan informasi jabatan pegawai -->
                <tr>
                    <td><label for="jabatan">Jabatan</label></td>
                    <td>
                    <?php 
                        $kd_jabatan = $pegawai['jabatan'] == 1 ? 'Admin' : 'Pegawai'; 
                    ?>
                    <input type="text" name="jabatan" value="<?php echo $kd_jabatan ?>" readonly>
                    </td>
                </tr>
                
                <!-- Menampilkan jenis kelamin pegawai -->
                <tr>
                    <td><label for="jk">Jenis Kelamin</label></td>
                    <td>
                    <?php 
                        $jenis_kelamin = $pegawai['jk'] == 1 ? 'Laki-laki' : 'Perempuan'; 
                    ?>
                    <input type="text" name="jk" value="<?php echo $jenis_kelamin ?>" readonly>
                    </td>
                </tr>
                
                <!-- Menampilkan username pegawai -->
                <tr>
                    <td><label for="username">Username</label></td>
                    <td><input type="text" name="username" value="<?php echo $pegawai['username'] ?>" readonly></td>
                </tr>
              </div>
            </article>
    </div>

    <!-- Bagian form untuk mengganti username dan password -->
    <div class="one_third fl_right">
      <header class="btmspace-30">
        <figure class="avatar fl_right"><img src="../../images/avatar.png" alt=""></figure>
        <p class="btmspace-15 bold">Ganti Username dan Password</p>
      </header>
      <div>
        <form action="update_profil.php" method="POST">
            <!-- Menyertakan kode pegawai sebagai input tersembunyi -->
            <input type="hidden" name="kode_pg" value="<?php echo $pegawai['kode_pg']; ?>">

            <!-- Input untuk mengganti username -->
            <label for="username">Username Baru</label></br>
            <input type="text" name="username" value="<?php echo $pegawai['username']; ?>" required></br></br>
          
            <!-- Input untuk mengganti password -->
            <label for="password">Password Baru</label></br>
            <input type="password" name="password" required></br></br>
          
            <!-- Input untuk password lama untuk verifikasi -->
            <label for="old_password">Password Lama</label></br>
            <input type="password" name="old_password" required></br></br>
          
            <!-- Tombol submit untuk memperbarui profil -->
            <input class="btn" type="submit" name="submit" value="ganti">
        </form>
      </div>
    </div>
</main>
</body>
</html>

<?php
include '../../index_footer.html';
?>  
