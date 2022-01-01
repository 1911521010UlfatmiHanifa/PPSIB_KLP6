<?php
    include "session.php";

    if(isset($_POST['simpan'])){
		$nama_lengkap= $_POST['nama_lengkap'];
        $username= $_POST['username'];
        $tanggal_lahir = $_POST['tanggal_lahir'];
        $no_hp = $_POST['no_hp'];
        $alamat = $_POST['alamat'];
        $password = md5($_POST['password']);
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $id_instansi = $_POST['id_instansi'];
        $jenis_user = $_POST['jenis_user'];

		$namaFile = $_FILES['gambar']['name'];
		$ukuranFile = $_FILES['gambar']['size'];
		$tmpName = $_FILES['gambar']['tmp_name'];
		$error = $_FILES['gambar']['error'];
        $sekarang = date('d-m-Y');
		$tgl1 = new DateTime($sekarang);
		$tgl2 = new DateTime($tanggal_lahir);
		$jarak = $tgl1->diff($tgl2);
		$diff2 = $jarak->y;
		
        if($diff2 >= 17){
            if ($error === 4) {
                $namaFile = 'default.png';
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
            } 
            else {
                $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
                $ekstensiGambar = explode('.', $namaFile);
                $ekstensiGambar = strtolower(end($ekstensiGambar));
                if (in_array($ekstensiGambar, $ekstensiGambarValid) === true) {
                    if ($ukuranFile < 1044070) {
                        move_uploaded_file($tmpName, 'img/' . $namaFile);

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
                    }
                }else{
                    $pesan_gagal= "Format File Tidak Sesuai!";
                }
            }
        }else{
            $pesan_gagal= "Umur belum mencukupi!";
        }
	} 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Form Tambah Data User</title>
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

    <?php include("header.php");?>

    <?php include("sidebar_admin.php");?>

    <main id="main" class="main">

        <div class="pagetitle">
        <h1>Data User</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item">Data User</li>
            </ol>
        </nav>
        </div><!-- End Page Title -->


        <section class="section">
        <div class="row">
            <div class="col-lg-12">

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

            <div class="card">
                <div class="card-body">
                <h5 class="card-title">Form Tambah Data User</h5>

                <!-- General Form Elements -->
                <form class="row g-3 needs-validation" method="post" novalidate enctype="multipart/form-data">
						<div class="col-6">
							<label for="yourName" class="form-label">Nama Lengkap</label>
							<input type="text" name="nama_lengkap" class="form-control" id="nama_lengkap" pattern="^[A-Za-z]+([\A-Za-z]+)*" autofocus required>
							<div class="invalid-feedback">Masukkan Nama Lengkap!</div>
						</div>

						<div class="col-6">
							<label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
							<input type="date" name="tanggal_lahir" class="form-control" id="tanggal_lahir" required>
							<div class="invalid-feedback">Masukkan Tanggal Lahir!</div>
						</div>

                        <div class="col-6">
							<label for="password" class="form-label">Password</label>
							<input type="password" name="password" class="form-control" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"required>
							<div class="invalid-feedback">Password Harus Berisi Minimal 1 Huruf Kapital, 1 Huruf Kecil, Tanda Baca, Angka, dan Minimal 8 Karakter!</div>
						</div>

						<div class="col-6">
							<label for="no_hp" class="form-label">Nomor HP</label>
							<input type="text" name="no_hp" class="form-control" id="no_hp" pattern="^(\+62|62|0)[0-9]{9,}$" required>
							<div class="invalid-feedback">Masukkan Nomor Hp!</div>
						</div>

                        <div class="col-6">
							<label for="yourName" class="form-label">Username</label>
							<input type="text" name="username" class="form-control" id="username" required>
							<div class="invalid-feedback">Masukkan Username!</div>
						</div>

						<div class="col-6">
							<label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
							<select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                <option selected disabled value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-Laki">Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option>
							</select>
							<div class="invalid-feedback">
								Masukkan Jenis Kelamin!
							</div>
						</div>

                        <div class="col-6 form-group">
							<label for="jenis_user" class="form-label">Jenis User</label>
							<select class="form-select" id="jenis_user" name="jenis_user" required>
                                <option selected disabled value="">Pilih Jenis User</option>
                                <option value="Admin">Admin</option>
                                <option value="Peminjam di Luar UKS">Peminjan di Luar UKS</option>
                                <option value="Divisi Rumah Tangga">Divisi Rumah Tangga</option>
                                <option value="Divisi Pemasaran">Divisi Pemasaran</option>
                                <option value="Pengurus UKS">Pengurus UKS</option>
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

						<div class="col-12">
							<label for="alamat" class="form-label">Alamat</label>
							<input type="text" name="alamat" class="form-control"id="alamat" required>
							<div class="invalid-feedback">Masukkan Alamat!</div>
						</div>

						<div class="col-md-12 form-group">
							<label for="gambar" class="form-label">Foto</label>
							<input type="file" class="form-control px-2 py-1" id="gambar" name="gambar" placeholder="Foto" required>
						</div>

						<div class="col-6">
						<a class="btn btn-warning w-100" href="user.php">Back</a>
						</div>
						<div class="col-6">
							<button class="btn btn-primary w-100" type="submit" name="simpan">Simpan</button>
						</div>
					</form><!-- End General Form Elements -->

                </div>
            </div>

            </div>
        </div>
        </section>

    </main><!-- End #main -->

    <?php include "footer.php"?>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.min.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-keterangan-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>