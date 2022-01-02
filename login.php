<?php
    session_start();
    include "koneksi.php"; 

    if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = md5($_POST['password']);
    
        $login = $conn->query("select * from user where username='$username' and password='$password'");
        $cek = mysqli_num_rows($login);
        if ($cek > 0) {
            $data = mysqli_fetch_array($login);
    
			$_SESSION['id_user'] = $data['id_user'];
			$_SESSION['nama_lengkap'] = $data['nama_lengkap'];
			$_SESSION['jenis_user'] = $data['jenis_user'];
			$_SESSION['foto'] = $data['foto'];

			header("Location: dashboard.php");
    
        } else {
            $pesan_gagal="Anda Gagal Login";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">

	<title>Login</title>
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
</head>

<body>

	<main>
		<div class="container">

		<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
			<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-5  col-md-6 d-flex flex-column align-items-center justify-content-center">

				<div class="card mb-3">

					<div class="card-body">

					<div class="pt-4 pb-2">
						<?php
						if(isset($pesan_gagal)){
						?>
						<div class="alert alert-danger" role="alert">
						<?php echo '<img src="logo/cross.png" width="18" class="me-2">'.$pesan_gagal; ?>
						</div>
						<?php
						}
						?>
						<h5 class="card-title text-center pb-0 fs-4">Masuk ke Aplikasi</h5>
						<p class="text-center small">Silahkan Masukkan Data Untuk Masuk Ke Aplikasi!</p>
					</div>

					<form class="row g-3 needs-validation" method="post" novalidate>

						<div class="col-12">
						<label for="yourUsername" class="form-label">Username</label>
						<div class="input-group has-validation">
							<input type="text" name="username" class="form-control" id="yourUsername" required>
							<div class="invalid-feedback">Please enter your username.</div>
						</div>
						</div>

						<div class="col-12">
						<label for="yourPassword" class="form-label">Password</label>
						<input type="password" name="password" class="form-control" id="yourPassword" required>
						<div class="invalid-feedback">Please enter your password!</div>
						</div>
						
						<div class="col-6">
						<a class="btn btn-warning w-100" href="index.php">Back</a>
						</div>
						<div class="col-6">
						<button class="btn btn-primary w-100" type="submit" name="submit">Login</button>
						</div>
						<div class="col-12">
						<p class="small mb-0">Peminjam Tidak Memiliki Akun? <a href="register.php">Buat Akun</a></p>
						</div>
					</form>

					</div>
				</div>

				<div class="credits">
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