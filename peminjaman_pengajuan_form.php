<?php
    include "session.php";

    if($_SESSION['jenis_user']== 'Peminjam di Luar UKS'){
        if(isset($_POST['simpan'])){

            $tanggal_pinjam = $_POST['tanggal_pinjam'];
            $tanggal_kembali = $_POST['tanggal_kembali'];
            $id_user = $_SESSION['id_user'];
            $status = "Diajukan";
            $tanggal_pengajuan = date('Y/m/d');

            $namaFile = $_FILES['gambar']['name'];
            $ukuranFile = $_FILES['gambar']['size'];
            $tmpName = $_FILES['gambar']['tmp_name'];
            $error = $_FILES['gambar']['error'];

            $ekstensiGambarValid = ['pdf', 'docx'];
            $ekstensiGambar = explode('.', $namaFile);
            $ekstensiGambar = strtolower(end($ekstensiGambar));
            if (in_array($ekstensiGambar, $ekstensiGambarValid) === true) {
                if ($ukuranFile < 10044070) {
                    move_uploaded_file($tmpName, 'surat/' . $namaFile);
                    if(($tanggal_kembali > $tanggal_pinjam) && ($tanggal_pengajuan > $tanggal_kembali)){
                        $stmt=$conn->prepare('INSERT INTO peminjaman(id_user, tanggal_pinjam, tanggal_kembali, status_peminjaman, surat_peminjaman, tanggal_pengajuan) VALUES (?,?,?,?,?,?)');
                        $stmt->bind_param("isssss", $id_user, $tanggal_pinjam, $tanggal_kembali, $status, $namaFile, $tanggal_pengajuan);
                        $stmt->execute();

                        if($conn->affected_rows > 0){
                            $data = $conn->query("SELECT MAX(id_peminjaman) as id_peminjaman FROM peminjaman");
                            while($n = mysqli_fetch_assoc($data)){
                                $id_peminjaman  = $n['id_peminjaman'];
                            }
                            header("Location:peminjaman_pengajuan_tambah_ive.php?id_peminjaman=$id_peminjaman");
                        }
                        else{
                            $pesan_gagal= "Data pengajuan peminjaman gagal disimpan!";
                            echo mysqli_error($conn);
                        }
                    }else{
                        $pesan_gagal= "Tanggal salah!";
                        echo mysqli_error($conn);
                    }
                }else{
                    $pesan_gagal= "Ukuran file terlalu besar!";
                }
            }else{
                $pesan_gagal= "Format salah!";
            }
        } 
    }else{
        if(isset($_POST['simpan'])){
            $tanggal_pinjam = $_POST['tanggal_pinjam'];
            $tanggal_kembali = $_POST['tanggal_kembali'];
            $id_user = $_SESSION['id_user'];
            $status = "Diajukan";
            $tanggal_pengajuan = date('Y/m/d');

            if(($tanggal_kembali > $tanggal_pinjam) && ($tanggal_pinjam > date('Y-m-d'))){
                $stmt=$conn->prepare('INSERT INTO peminjaman(id_user, tanggal_pinjam, tanggal_kembali, status_peminjaman, tanggal_pengajuan) VALUES (?,?,?,?,?)');
                $stmt->bind_param("issss", $id_user, $tanggal_pinjam, $tanggal_kembali, $status, $tanggal_pengajuan);
                $stmt->execute();

                if($conn->affected_rows > 0){
                    $data = $conn->query("SELECT MAX(id_peminjaman) as id_peminjaman FROM peminjaman");
                    while($n = mysqli_fetch_assoc($data)){
                        $id_peminjaman  = $n['id_peminjaman'];
                    }
                    header("Location:peminjaman_pengajuan_tambah_ive.php?id_peminjaman=$id_peminjaman");
                }
                else{
                    $pesan_gagal= "Data pengajuan peminjaman gagal disimpan!";
                    echo mysqli_error($conn);
                }
            }else{
                $pesan_gagal= "Tanggal salah!";
                echo mysqli_error($conn);
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Form Tambah Data Pengajuan Peminjaman</title>
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

	<?php 
		if ($_SESSION['jenis_user'] == "Admin"){ 
		include("sidebar_admin.php");
		}else if($_SESSION['jenis_user'] == "Divisi Rumah Tangga"){
		include("sidebar_divisi_rumah_tangga.php");
		}else if($_SESSION['jenis_user'] == "Divisi Pemasaran"){
		include("sidebar_divisi_pemasaran.php");
		}else if($_SESSION['jenis_user'] == "Peminjam di Luar UKS"){
		include("sidebar_peminjam.php");
		}else if($_SESSION['jenis_user'] == "Pengurus UKS"){
		include("sidebar_pengurus.php");
		} 
	?>

    <main id="main" class="main">

        <div class="pagetitle">
        <h1>Data Peminjaman</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item">Form Tambah Data Pengajuan Peminjaman</li>
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
                <h5 class="card-title">Form Tambah Data Pengajuan Peminjaman</h5>

                <!-- General Form Elements -->
                <form class="row g-3 needs-validation" method="post" novalidate enctype="multipart/form-data">

						<div class="col-6">
							<label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
							<input type="date" name="tanggal_pinjam" class="form-control" id="tanggal_pinjam" required>
							<div class="invalid-feedback">Masukkan Tanggal Pinjam!</div>
						</div>

						<div class="col-6">
							<label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
							<input type="date" name="tanggal_kembali" class="form-control" id="tanggal_kembali" required>
							<div class="invalid-feedback">Masukkan Tanggal Kembali!</div>
						</div>

                        <?php if($_SESSION['jenis_user'] == "Peminjam di Luar UKS"){ ?>
                            <div class="col-md-12 form-group">
                                <label for="gambar" class="form-label">Surat Peminjaman</label>
                                <input type="file" class="form-control px-2 py-1" id="gambar" name="gambar" required>
                            </div>
                        <?php } ?>

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