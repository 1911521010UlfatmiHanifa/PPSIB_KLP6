<?php
    include "session.php";

    if(isset($_POST['simpan'])){
		$nama_inventaris = $_POST['nama_inventaris'];
		$harga_mahasiswa= $_POST['harga_mahasiswa'];
		$harga_nonmahasiswa = $_POST['harga_nonmahasiswa'];
		$keterangan = $_POST['keterangan'];

		$namaFile = $_FILES['gambar']['name'];
		$ukuranFile = $_FILES['gambar']['size'];
		$tmpName = $_FILES['gambar']['tmp_name'];
		$error = $_FILES['gambar']['error'];
		
		if ($error === 4) {
			$namaFile = 'default.png';
			$stmt=$conn->prepare('INSERT INTO inventaris(nama_inventaris, harga_mahasiswa, harga_nonmahasiswa, gambar, keterangan) 
									VALUES (?,?,?,?,?)');
			$stmt->bind_param("siiss", $nama_inventaris, $harga_mahasiswa, $harga_nonmahasiswa, $namaFile, $keterangan);
			$stmt->execute();

			if($conn->affected_rows > 0){
				$pesan_sukses= "Data inventaris berhasil disimpan!";
			}
			else{
				$pesan_gagal= "Data inventaris gagal disimpan!";
			}
			$stmt->close();
		} 

		$ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
		$ekstensiGambar = explode('.', $namaFile);
		$ekstensiGambar = strtolower(end($ekstensiGambar));
		if (in_array($ekstensiGambar, $ekstensiGambarValid) === true) {
			if ($ukuranFile < 1044070) {
				move_uploaded_file($tmpName, 'img/' . $namaFile);

				$stmt=$conn->prepare('INSERT INTO inventaris(nama_inventaris, harga_mahasiswa, harga_nonmahasiswa, gambar, keterangan) 
									VALUES (?,?,?,?,?)');
                $stmt->bind_param("siiss", $nama_inventaris, $harga_mahasiswa, $harga_nonmahasiswa, $namaFile, $keterangan);
                $stmt->execute();

				if($conn->affected_rows > 0){
					$pesan_sukses= "Data inventaris berhasil disimpan!";
				}
				else{
					$pesan_gagal= "Data inventaris gagal disimpan!";
				}
				$stmt->close();
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

    <title>Form Tambah Data Inventaris</title>
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
        <h1>Inventaris</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item">Inventaris</li>
            <li class="breadcrumb-item active">Form Tambah Data Inventaris</li>
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
                <h5 class="card-title">Form Tambah Data Inventaris</h5>

                <!-- General Form Elements -->
                <form class="row g-3 needs-validation" method="post" novalidate enctype="multipart/form-data">
                    <div class="col-6">
                        <label for="yourName" class="form-label">Nama Inventaris</label>
                        <input type="text" name="nama_inventaris" class="form-control" id="nama_inventaris" pattern="^[A-Za-z]+([\A-Za-z]+)*" autofocus required>
                        <div class="invalid-feedback">Masukkan Nama Inventaris!</div>
                    </div>

                    <div class="col-6">
                        <label for="yourketerangan" class="form-label">Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" id="keterangan" required>
                        <div class="invalid-feedback">Masukkan Keterangan!</div>
                    </div>

                    <div class="col-6">
                        <label for="yourharga_mahasiswa" class="form-label">Harga Mahasiswa</label>
                        <div class="input-group has-validation">
                            <input type="number" min="0" name="harga_mahasiswa" class="form-control" id="harga_mahasiswa" required>
                            <div class="invalid-feedback">Masukkan Harga Mahasiswa!</div>
                        </div>
                    </div>

                    <div class="col-6">
                        <label for="yourharga_nonmahasiswa" class="form-label">Harga Non Mahasiswa</label>
                        <div class="input-group has-validation">
                            <input type="number" min="0" name="harga_nonmahasiswa" class="form-control" id="harga_nonmahasiswa" required>
                            <div class="invalid-feedback">Masukkan Harga Non Mahasiswa!</div>
                        </div>
                    </div>

                    <div class="col-md-12 form-group">
                        <label for="gambar" class="form-label">Foto</label>
                        <input type="file" class="form-control px-2 py-1" id="gambar" name="gambar" placeholder="Foto" required>
                        <div class="invalid-feedback">
                            Masukkan Foto  Dengan Benar!
                        </div>
                    </div>

                    <div class="col-6">
                        <a class="btn btn-warning w-100" href="inventaris.php">Back</a>
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