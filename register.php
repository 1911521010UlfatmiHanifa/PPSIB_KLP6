<?php
	include "koneksi.php";

	if(isset($_POST['simpan'])){
		$nama_lengkap = $_POST['nama_lengkap'];
		$username = $_POST['username'];
		$password = md5($_POST['password']);
		$tanggal_lahir = $_POST['tanggal_lahir'];
		$no_hp = $_POST['no_hp'];
		$jenis_kelamin = $_POST['jenis_kelamin'];
		$id_instansi = $_POST['id_instansi'];
		$alamat = $_POST['alamat'];
		$jenis_user = "Peminjam di Luar UKS";

		$namaFile = $_FILES['gambar']['name'];
		$ukuranFile = $_FILES['gambar']['size'];
		$tmpName = $_FILES['gambar']['tmp_name'];
		$error = $_FILES['gambar']['error'];

		$sekarang = date('d-m-Y');
		$tgl1 = new DateTime($sekarang);
		$tgl2 = new DateTime($tanggal_lahir);
		$jarak = $tgl1->diff($tgl2);
		$diff2 = $jarak->y;
		
		if ($error === 4) {
			$namaFile = 'default.png';
			if($diff2 >= 17){
				$stmt=$conn->prepare('INSERT INTO user(id_instansi, nama_lengkap, username, password, jenis_user, tanggal_lahir, no_hp, jenis_kelamin, alamat, foto) 
										VALUES (?,?,?,?,?,?,?,?,?,?)');
				$stmt->bind_param("isssssssss", $id_instansi, $nama_lengkap, $username, $password, $jenis_user, $tanggal_lahir, $no_hp, $jenis_kelamin, $alamat, $namaFile);
				$stmt->execute();

				if($conn->affected_rows > 0){
					$pesan_sukses= "Data user berhasil disimpan!";
				}
				else{
					$pesan_gagal= "Data user gagal disimpan!";
				}
				$stmt->close();
			}else{
				$pesan_gagal= "Umur belum mencukupi!";
			}
		} 

		$ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
		$ekstensiGambar = explode('.', $namaFile);
		$ekstensiGambar = strtolower(end($ekstensiGambar));
		if (in_array($ekstensiGambar, $ekstensiGambarValid) === true) {
			if ($ukuranFile < 1044070) {
				move_uploaded_file($tmpName, 'img/' . $namaFile);
				if($diff2 >= 17){
					$stmt=$conn->prepare('INSERT INTO user(id_instansi, nama_lengkap, username, password, jenis_user, tanggal_lahir, no_hp, jenis_kelamin, alamat, foto) 
									VALUES (?,?,?,?,?,?,?,?,?,?)');
					$stmt->bind_param("isssssssss", $id_instansi, $nama_lengkap, $username, $password, $jenis_user, $tanggal_lahir, $no_hp, $jenis_kelamin, $alamat, $namaFile);
					$stmt->execute();

					if($conn->affected_rows > 0){
						$pesan_sukses= "Data user berhasil disimpan!";
					}
					else{
						$pesan_gagal= "Data user gagal disimpan!";
					}
					$stmt->close();
				}else{
					$pesan_gagal= "Umur belum mencukupi!";
				}
			}
		}else{
			$pesan_gagal= "Format File Tidak Sesuai!";
		}
	} 
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">

	<title>Register Peminjam</title>
	<meta content="" name="description">
	<meta content="" name="keywords">

	<!-- Favicons -->
	<link href="assets2/img/logo.png" rel="icon">
	<link href="assets2/img/logo.png" rel="apple-touch-icon">

	<!-- Google Fonts -->
	<link href="https://fonts.gstatic.com" rel="preconnect">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

	<!-- Vendor CSS Files -->
	<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
	<link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
	<link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
	<link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
	<link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
	<link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

	<!-- Template Main CSS File -->
	<link href="assets/css/style.css" rel="stylesheet">

	<!-- =======================================================
	* Template Name: NiceAdmin - v2.2.0
	* Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
	* Author: BootstrapMade.com
	* License: https://bootstrapmade.com/license/
	======================================================== -->
</head>

<body>

	<main>
		<div class="container">

		<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
			<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-8 col-md-6 d-flex flex-column align-items-center justify-content-center">

				<div class="card mb-3">

					<div class="card-body">

					<div class="pt-4 pb-2">
						<?php
							if(isset($pesan_sukses)){
						?>
							<div class="alert alert-success" role="alert">
							<?php echo '<img src="logo/check.png" width="27" class="me-2">'.$pesan_sukses; ?>
							</div>
						<?php
						}
						else if(isset($pesan_gagal)){
						?>
							<div class="alert alert-danger" role="alert">
							<?php echo '<img src="logo/cross.png" width="18" class="me-2">'.$pesan_gagal; ?>
							</div>
						<?php
						}
						?>
						<h5 class="card-title text-center pb-0 fs-4">Buat Akun Peminjam Baru</h5>
						<p class="text-center small">Silahkan Lengkapi Data Berikut!</p>
					</div>

					<form class="row g-3 needs-validation" method="post" novalidate enctype="multipart/form-data">
						<div class="col-6">
							<label for="yourName" class="form-label">Nama Lengkap</label>
							<input type="text" name="nama_lengkap" class="form-control" id="nama_lengkap" pattern="^[A-Za-z]+([\A-Za-z]+)*" autofocus required>
							<div class="invalid-feedback">Masukkan Nama Lengkap!</div>
						</div>

						<div class="col-6">
							<label for="yourUsername" class="form-label">Username</label>
							<div class="input-group has-validation">
								<input type="text" name="username" class="form-control" id="username" required>
								<div class="invalid-feedback">Masukkan Username!</div>
							</div>
						</div>

						<div class="col-6">
							<label for="yourPassword" class="form-label">Password</label>
							<input type="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" class="form-control" id="password" required>
							<div class="invalid-feedback">Password Harus Berisi Minimal 1 Huruf Kapital, 1 Huruf Kecil, Tanda Baca, Angka, dan Minimal 8 Karakter!</div>
						</div>

						<div class="col-6">
							<label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
							<input type="date" name="tanggal_lahir" class="form-control" id="tanggal_lahir" required>
							<div class="invalid-feedback">Masukkan Tanggal Lahir!</div>
						</div>

						<div class="col-6">
							<label for="no_hp" class="form-label">Nomor HP</label>
							<input type="text" name="no_hp" class="form-control" id="no_hp" pattern="^(\+62|62|0)[0-9]{9,}$" required>
							<div class="invalid-feedback">Masukkan Nomor Hp!</div>
						</div>

						<div class="col-6">
							<label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
							<select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
								<option selected disabled value="">Pilih Jenis Kelamin</option>
								<option value="Laki-laki">Laki-laki</option>
								<option value="Perempuan">Perempuan</option>
							</select>
							<div class="invalid-feedback">
								Masukkan Jenis Kelamin!
							</div>
						</div>

						<div class="col-6">
							<label for="id_instansi" class="form-label">Instansi</label>
							<select class="form-select" id="id_instansi" name="id_instansi" required>
								<option selected disabled value="">Pilih Instansi</option>
								<?php 
									$stmt25 = $conn->query("SELECT * FROM instansi");
									while($row = $stmt25->fetch_assoc()){
								?>
								<option value="<?php echo $row['id_instansi']; ?>"><?php echo $row['nama_instansi']; ?></option>
								<?php } ?>
							</select>
							<div class="invalid-feedback">
								Masukkan Instansi!
							</div>
						</div>

						<div class="col-6">
							<label for="alamat" class="form-label">Alamat</label>
							<input type="text" name="alamat" class="form-control" id="alamat" required>
							<div class="invalid-feedback">Masukkan Alamat!</div>
						</div>

						<div class="col-md-12 form-group">
							<label for="gambar" class="form-label">Foto</label>
							<input type="file" class="form-control px-2 py-1" id="gambar" name="gambar" placeholder="Foto" required>
							<div class="invalid-feedback">
								Masukkan Foto  Dengan Benar!
							</div>
						</div>

						<div class="col-6">
						<a class="btn btn-warning w-100" href="index.php">Back</a>
						</div>
						<div class="col-6">
							<button class="btn btn-primary w-100" type="submit" name="simpan">Create Account</button>
						</div>
						<div class="col-12">
							<p class="small mb-0">Sudah Punya Akun? <a href="login.php">Log in</a></p>
						</div>
					</form>

					</div>
				</div>

				<div class="credits">
					<!-- All the links in the footer should remain intact. -->
					<!-- You can delete the links only if you purchased the pro version. -->
					<!-- Licensing information: https://bootstrapmade.com/license/ -->
					<!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
					Program by Kelompok 6 PPSI
				</div>

				</div>
			</div>
			</div>

		</section>

		</div>
	</main><!-- End #main -->

	<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

	<!-- Vendor JS Files -->
	<script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="assets/vendor/chart.js/chart.min.js"></script>
	<script src="assets/vendor/echarts/echarts.min.js"></script>
	<script src="assets/vendor/quill/quill.min.js"></script>
	<script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
	<script src="assets/vendor/tinymce/tinymce.min.js"></script>
	<script src="assets/vendor/php-email-form/validate.js"></script>

	<!-- Template Main JS File -->
	<script src="assets/js/main.js"></script>

</body>

</html>