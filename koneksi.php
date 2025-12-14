<?php 
class database {

	var $host = "localhost";
	var $username = "root";
	var $password = "";
	var $database = "dataperpus";
	var $koneksi = "";

	// Konstruktor untuk melakukan koneksi ke database saat objek dibuat
	function __construct(){
		$this->koneksi = mysqli_connect($this->host, $this->username, $this->password, $this->database);
		if (mysqli_connect_errno()) {
			echo "Koneksi database gagal" . mysqli_connect_error();
		}
	}

// Menampilkan semua data pegawai, dengan fitur pencarian berdasarkan nama atau kode
	function tampil_data_pegawai($search = ""){
		$query = "SELECT * FROM pegawai";

		if (!empty($search)) {
			$query .= " WHERE nama_pg LIKE '%$search%' OR kode_pg LIKE '%$search%'";
		}

		$data = mysqli_query($this->koneksi, $query);
		$hasil = [];

		while ($row = mysqli_fetch_array($data)) {
			$hasil[] = $row;
		}

		return $hasil;
	}

	// Menambahkan data pegawai baru ke dalam database
	function tambah_data_pegawai($kode_pg, $nama_pg, $jabatan, $jk, $username, $password) {
		// Hash password sebelum menyimpan
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);
	
		// Gunakan prepared statement untuk mencegah SQL Injection
		$stmt = $this->koneksi->prepare("INSERT INTO pegawai (kode_pg, nama_pg, jabatan, jk, username, password) VALUES (?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("ssisss", $kode_pg, $nama_pg, $jabatan, $jk, $username, $hashed_password);
		$stmt->execute();
	}

	//kode_pg otomatis
	function kode_pg_auto() {
		$usedNumbers = [];
	
		// Ambil semua kode_pg dari tabel pegawai
		$query = "SELECT kode_pg FROM pegawai ORDER BY kode_pg ASC";
		$result = mysqli_query($this->koneksi, $query);
	
		if ($result) {
			while ($row = mysqli_fetch_assoc($result)) {
				// Ambil angka dari kode_pg, misalnya dari "pg02" ambil "2"
				$number = (int) substr($row['kode_pg'], 2);
				$usedNumbers[] = $number;
			}
		}
	
		// Cari nomor terkecil yang belum digunakan
		$nextNumber = 1;
		while (in_array($nextNumber, $usedNumbers)) {
			$nextNumber++;
		}
	
		// Format jadi "pg01", "pg02", dll
		return 'pg' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
	}
	
	
	// Mengambil data pegawai berdasarkan kode_pg
	function get_by_id_pegawai ($kode_pg){
		$query = mysqli_query ($this->koneksi, "select * from pegawai where kode_pg = '$kode_pg'");
		return $query->fetch_array();
	}

	// Mengupdate data pegawai
	function update_data_pegawai ($nama_pg, $jabatan, $jk, $kode_pg){
		$query = mysqli_query ($this->koneksi, "update pegawai set nama_pg='$nama_pg', jabatan='$jabatan', jk='$jk' where kode_pg='$kode_pg'");
	}

	// Menghapus data pegawai
	function delete_data_pegawai ($kode_pg){
		$query= mysqli_query($this->koneksi, "delete from pegawai where kode_pg='$kode_pg'");
	}


	// Menampilkan semua data buku dengan fitur pencarian
	function tampil_data_buku($search = "") {
		$query = "SELECT * FROM buku";

		// Tambahkan kondisi pencarian jika ada
		if (!empty($search)) {
			$query .= " WHERE judul LIKE '%$search%' OR tahun_terbit LIKE '%$search%'";
		}

		$query .= " ORDER BY kode_buku DESC";
		$data = mysqli_query($this->koneksi, $query);

		// Cek error query
		if (!$data) {
			die("Query error: " . mysqli_error($this->koneksi));
		}

		$hasil = [];
		while ($row = mysqli_fetch_array($data)) {
			$hasil[] = $row;
		}

		return $hasil;
	}


	// Menambahkan data buku baru
	function tambah_data_buku($kode_buku, $judul, $penerbit, $pengarang, $tahun_terbit, $kj_buku, $jml_awal, $jml_buku, $stok, $harga){
		mysqli_query($this->koneksi, "insert into buku values ('$kode_buku', '$judul', '$penerbit', '$pengarang', '$tahun_terbit', '$kj_buku', '$jml_awal', '$jml_buku', '$stok', '$harga')");
	}

	//kode buku otomatis
	function kode_buku_auto() {
		// Ambil semua kode_buku dari tabel buku dan urutkan
		$query = "SELECT kode_buku FROM buku ORDER BY kode_buku ASC";
		$result = mysqli_query($this->koneksi, $query);
	
		$existingCodes = [];
	
		if ($result) {
			while ($row = mysqli_fetch_assoc($result)) {
				$existingCodes[] = (int)$row['kode_buku'];
			}
		}
	
		// Cari nomor terkecil yang belum digunakan dari 1 sampai jumlah data + 1
		$nextKode = 1;
		while (in_array($nextKode, $existingCodes)) {
			$nextKode++;
		}
	
		// Format menjadi empat digit
		return str_pad($nextKode, 4, '0', STR_PAD_LEFT);
	}

	// Mengambil data buku berdasarkan kode
	function get_by_id_buku ($kode_buku)
	{
		$query = mysqli_query ($this->koneksi, "select * from buku where kode_buku = '$kode_buku'");
		return $query->fetch_array();
	}

	// Mengupdate data buku
	function update_data_buku ($judul, $penerbit, $pengarang, $tahun_terbit, $kj_buku, $jml_awal, $jml_buku, $stok, $harga, $kode_buku)
	{
		$query = mysqli_query ($this->koneksi, "update buku set judul='$judul', penerbit='$penerbit', pengarang='$pengarang', 
        tahun_terbit='$tahun_terbit', kj_buku='$kj_buku', jml_awal='$jml_awal', jml_buku='$jml_buku', stok='$stok', harga='$harga' where kode_buku='$kode_buku'");
	}

	// Menghapus data buku
	function delete_data_buku ($kode_buku)
	{
		$query= mysqli_query($this->koneksi, "delete from buku where kode_buku='$kode_buku'");
	}


// Menampilkan data siswa dengan fitur pencarian
	function tampil_data_siswa($search = ""){
		$query = "SELECT * FROM siswa";

		if (!empty($search)) {
			$query .= " WHERE nama LIKE '%$search%' OR nis LIKE '%$search%'"; //pencarian dengan nama dan nis
		}

		$data = mysqli_query($this->koneksi, $query);
		$hasil = [];

		while ($row = mysqli_fetch_array($data)) {
			$hasil[] = $row;
		}

		return $hasil;
	}

	// Menambah data siswa
	function tambah_data_siswa($nis, $nama, $kelas, $prodi, $tingkat, $jk){
		mysqli_query($this->koneksi, "insert into siswa values ('$nis', '$nama', '$kelas', '$prodi', '$tingkat', '$jk')");
	}

	// Mengambil data siswa berdasarkan NIS
	function get_by_id_siswa ($nis){
		$query = mysqli_query ($this->koneksi, "select * from siswa where nis = '$nis'");
		return $query->fetch_array();
	}

	// Mengupdate data siswa
	function update_data_siswa ($nama, $kelas, $prodi, $tingkat, $jk, $nis)
	{
		$query = mysqli_query ($this->koneksi, "update siswa set nama='$nama', kelas='$kelas', prodi='$prodi', 
        tingkat='$tingkat', jk='$jk' where nis='$nis'");
	}

	// Menghapus data siswa
	function delete_data_siswa ($nis){
		$query= mysqli_query($this->koneksi, "delete from siswa where nis='$nis'");
	}

	// Menampilkan daftar peminjaman aktif (belum dikembalikan)
    function tampil_data_peminjaman($search = "") {
		$query = "SELECT daftar_pm.kode_pm, daftar_pm.nis, siswa.nama, daftar_pm.kode_buku, buku.judul, 
					daftar_pm.kode_pg, pegawai.nama_pg, daftar_pm.tanggal, daftar_pm.ptgl_kembali FROM daftar_pm
				JOIN siswa ON daftar_pm.nis = siswa.nis
				JOIN buku ON daftar_pm.kode_buku = buku.kode_buku
				JOIN pegawai ON daftar_pm.kode_pg = pegawai.kode_pg
				WHERE daftar_pm.tgl_kembali IS NULL";
	
		if (!empty($search)) {
			$query .= " AND (daftar_pm.nis LIKE '%$search%' OR siswa.nama LIKE '%$search%' )";
		}
	
		$query .= " ORDER BY daftar_pm.kode_pm DESC";
	
		$data = mysqli_query($this->koneksi, $query);
		$hasil = [];
	
		while ($row = mysqli_fetch_array($data)) {
			$hasil[] = $row;
		}
	
		return $hasil;
	}

	// Menambahkan transaksi peminjaman
	function tambah_data_peminjaman($kode_pm, $nis, $kode_buku, $kode_pg, $tanggal, $ptgl_kembali) {
		$query = "INSERT INTO daftar_pm (kode_pm, nis, kode_buku, kode_pg, tanggal, ptgl_kembali)
				  VALUES ('$kode_pm', '$nis', '$kode_buku', '$kode_pg', '$tanggal', '$ptgl_kembali')";
		$result = mysqli_query($this->koneksi, $query);
	}
	
	// Mengambil data peminjaman berdasarkan kode
	function get_by_id_peminjaman ($kode_pm){
		$query = mysqli_query ($this->koneksi, "select kode_pm, nis, kode_buku, kode_pg, tanggal, ptgl_kembali, tgl_kembali, ket_terlambat, ket_denda, denda, ket_selesai from daftar_pm where kode_pm = '$kode_pm'");
		return $query->fetch_array();
	}

	// Mengupdate data pengembalian
	function update_data_pengembalian ($nis, $kode_buku, $kode_pg, $tanggal, $ptgl_kembali, $tgl_kembali, $ket_terlambat,$ket_denda, $ket_selesai, $denda, $kode_pm)
	{
		$query = mysqli_query ($this->koneksi, "update daftar_pm set nis='$nis', kode_buku='$kode_buku', kode_pg='$kode_pg', 
        tanggal='$tanggal', ptgl_kembali='$ptgl_kembali', tgl_kembali='$tgl_kembali', ket_terlambat='$ket_terlambat', ket_denda='$ket_denda', ket_selesai='$ket_selesai', denda='$denda' where kode_pm='$kode_pm'");
	}

	// Menghapus data peminjaman
	function delete_data_peminjaman ($kode_pm){
		$query= mysqli_query($this->koneksi, "delete from daftar_pm where kode_pm='$kode_pm'");
	}

	// Menghitung total peminjaman (digunakan untuk kode peminjaman otomatis)
	function hitung_peminjaman() {
		$query = "SELECT COUNT(*) as total FROM daftar_pm"; // Menghitung jumlah transaksi agar kode transaksi bisa otomatis
		$result = $this->koneksi->query($query);
		$row = $result->fetch_assoc();
		return $row['total'];
	}

// Fungsi pembantu untuk validasi data & perhitungan
	// Fungsi untuk memeriksa keberadaan siswa berdasarkan NIS
    function cek_data_siswa($nis) {
        $query = "SELECT * FROM siswa WHERE nis = '$nis'";
        $result = mysqli_query($this->koneksi, $query);
        return mysqli_num_rows($result) > 0;
    }
    
    // Fungsi untuk memeriksa keberadaan buku berdasarkan kode buku
    function cek_data_buku($kode_buku) {
        $query = "SELECT * FROM buku WHERE kode_buku = '$kode_buku'";
        $result = mysqli_query($this->koneksi, $query);
        return mysqli_num_rows($result) > 0; 
    }

	//Mengambil data pegawai yang sedang login berdasarkan kode_pg.
	function get_logged_in_pegawai($kode_pg) {
		$query = mysqli_query($this->koneksi, "SELECT * FROM pegawai WHERE kode_pg = '$kode_pg'");
		return $query->fetch_array();
	}

	//Mengecek apakah siswa sudah mencapai batas maksimal peminjaman buku.
	function cek_batas_peminjaman($nis) {
		$query = "SELECT COUNT(*) as jumlah FROM daftar_pm 
				  WHERE nis = '$nis' AND (ket_selesai IS NULL OR ket_selesai != '1')";
		$result = mysqli_query($this->koneksi, $query);
		$data = mysqli_fetch_assoc($result);
		return $data['jumlah'] >= 3; // Jika sudah 3 atau lebih, kembalikan true
	}

	//Menghitung jumlah peminjaman aktif (belum selesai) oleh siswa.
	function hitung_peminjaman_buku($nis) {
		$query = "SELECT COUNT(*) as jumlah FROM daftar_pm 
				  WHERE nis = '$nis' AND (ket_selesai IS NULL OR ket_selesai != '1')";
		$result = mysqli_query($this->koneksi, $query);
		$data = mysqli_fetch_assoc($result);
		return $data['jumlah'];
	}

	//Mengambil harga buku berdasarkan kode buku.
	function get_harga_buku($kode_buku){
		// Escape input untuk mencegah SQL Injection
		$kode_buku = mysqli_real_escape_string($this->koneksi, $kode_buku);

		// Query untuk mendapatkan harga buku berdasarkan kode_buku
		$query = mysqli_query($this->koneksi, "SELECT harga FROM buku WHERE kode_buku = '$kode_buku'");

		// Cek apakah data ditemukan
		if ($query) {
			$result = $query->fetch_array();
			return $result ? $result['harga'] : 0; // Jika data ditemukan, kembalikan harga, jika tidak, kembalikan 0
		} else {
			return 0; // Jika query gagal, kembalikan 0
		}
	}

	// Menampilkan data peminjam yang terkena denda dan belum selesai
    function tampil_data_denda($search = "") {
		$query = "SELECT daftar_pm.*, siswa.nama, buku.judul, pegawai.nama_pg FROM daftar_pm
				JOIN siswa ON daftar_pm.nis = siswa.nis
				JOIN buku ON daftar_pm.kode_buku = buku.kode_buku
				JOIN pegawai ON daftar_pm.kode_pg = pegawai.kode_pg
				WHERE daftar_pm.ket_terlambat != '1' AND NOT daftar_pm.ket_selesai = '1'";
	
		if (!empty($search)) {
			$query .= " AND (daftar_pm.nis LIKE '%$search%' OR siswa.nama LIKE '%$search%')";
		}
	
		$query .= " ORDER BY daftar_pm.kode_pm DESC";
		$data = mysqli_query($this->koneksi, $query);
		$hasil = [];
	
		while ($row = mysqli_fetch_array($data)) {
			$hasil[] = $row;
		}
	
		return $hasil;
	}
	
	// Mengambil data denda berdasarkan kode_pm
	function get_by_id_denda ($kode_pm){
		$query = mysqli_query ($this->koneksi, "select * from daftar_pm where kode_pm = '$kode_pm'");
		return $query->fetch_array();
	}

	// Mengupdate data denda
	function update_data_denda ($nis, $kode_buku, $kode_pg, $tanggal, $ptgl_kembali, $tgl_kembali, $ket_terlambat, $ket_denda, $denda, $ket_selesai, $kode_pm)
	{
		$query = mysqli_query ($this->koneksi, "update daftar_pm set nis='$nis', kode_buku='$kode_buku', kode_pg='$kode_pg', 
        tanggal='$tanggal', ptgl_kembali='$ptgl_kembali', tgl_kembali='$tgl_kembali', ket_terlambat='$ket_terlambat', ket_denda='$ket_denda', denda='$denda', ket_selesai='$ket_selesai'  where kode_pm='$kode_pm'");
	}

	// Menampilkan data denda yang sudah selesai (lunas) dengan filter
	function tampil_data_selesaidenda($filter_ket = null, $filter_pg = null) {
		$conn = $this->koneksi;
		$query = "SELECT daftar_pm.*, siswa.nama, buku.judul, pegawai.nama_pg FROM daftar_pm
				  JOIN siswa ON daftar_pm.nis = siswa.nis 
				  JOIN buku ON daftar_pm.kode_buku = buku.kode_buku 
				  JOIN pegawai ON daftar_pm.kode_pg = pegawai.kode_pg 
				  WHERE ket_terlambat !='1' AND ket_selesai = '1'";
	
		if (!empty($filter_ket)) {
			$query .= " AND daftar_pm.ket_terlambat = '$filter_ket'";
		}
	
		if (!empty($filter_pg)) {
			$query .= " AND daftar_pm.kode_pg = '$filter_pg'";
		}
	
		$result = mysqli_query($conn, $query);
		$hasil = [];
		while ($row = mysqli_fetch_assoc($result)) {
			$hasil[] = $row;
		}
		return $hasil;
	}

	// Menampilkan data pengembalian normal yang selesai dengan filter
	function tampil_data_selesai($filter_pg = null) {
		$conn = $this->koneksi;
		$query = "SELECT daftar_pm.*, siswa.nama, buku.judul, pegawai.nama_pg from daftar_pm
				JOIN siswa ON daftar_pm.nis = siswa.nis
	 			JOIN buku ON daftar_pm.kode_buku = buku.kode_buku
				JOIN pegawai ON daftar_pm.kode_pg = pegawai.kode_pg
				where ket_selesai='1' and ket_terlambat='1'";
	
		if (!empty($filter_pg)) {
			$query .= " AND daftar_pm.kode_pg = '$filter_pg'";
		}
	
		$result = mysqli_query($conn, $query);
		$hasil = [];
		while ($row = mysqli_fetch_assoc($result)) {
			$hasil[] = $row;
		}
		return $hasil;
	}

	// Menghitung total denda berdasarkan kategori denda
	function hitung_denda() {
		$hasil = ['denda_terlambat' => 0, 'denda_hilang' => 0, 'denda_total' => 0];
	
		$query = "SELECT dp.ket_terlambat, dp.ket_denda, b.harga
				  FROM daftar_pm dp 
				  JOIN buku b ON dp.kode_buku = b.kode_buku 
				  WHERE dp.ket_selesai = '1' AND (dp.ket_terlambat = '2' OR dp.ket_terlambat = '3')";
	
		$data = mysqli_query($this->koneksi, $query);
	
		while ($row = mysqli_fetch_assoc($data)) {
			$total_denda = (int) $row['ket_denda'];
			$harga_buku = (int) $row['harga'];
	
			if ($row['ket_terlambat'] == '2') {
				// Hanya terlambat
				$hasil['denda_terlambat'] += $total_denda;
			} elseif ($row['ket_terlambat'] == '3') {
				// Hilang (denda = terlambat + harga buku)
				$denda_terlambat = $total_denda - $harga_buku;
				$denda_hilang = $harga_buku;
	
				// Tambahkan keduanya secara terpisah
				$hasil['denda_terlambat'] += $denda_terlambat;
				$hasil['denda_hilang'] += $denda_hilang;
			}
	
			// Tambahkan total denda baris ini
			$hasil['denda_total'] += $total_denda;
		}
	
		return $hasil;
	}
	

}
?>