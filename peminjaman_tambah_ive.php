<?php
    include "session.php";
    $id_peminjaman = $_REQUEST['id_peminjaman'];

    if(isset($_POST['simpan'])){

        $id_inventaris = $_POST['id_inventaris'];
		$jumlah = $_POST['jumlah'];

        $stmt=$conn->prepare('INSERT INTO detail_pinjaman VALUES (?,?,?)');
        $stmt->bind_param("iii", $id_peminjaman, $id_inventaris, $jumlah);
        $stmt->execute();

        if($conn->affected_rows > 0){
            $pesan_sukses= "Data inventaris berhasil disimpan!";
        }
        else{
            $pesan_gagal= "Data inventaris gagal disimpan!";
            echo mysqli_error($conn);
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

						<div class="col-12">
							<label for="id_inventaris" class="form-label">Tanggal Pinjam</label>
							<select class="form-select" id="id_inventaris" name="id_inventaris" required>
								<option selected disabled value="">Pilih inventaris</option>
								<?php 
									$stmt25 = $conn->query("SELECT * FROM inventaris WHERE id_inventaris not in (Select id_inventaris from detail_pinjaman where id_peminjaman=$id_peminjaman)");
									while($row = $stmt25->fetch_assoc()){
								?>
								<option value="<?php echo $row['id_inventaris']; ?>"><?php echo $row['nama_inventaris']; ?></option>
								<?php } ?>
							</select>
							<div class="invalid-feedback">
								Masukkan Inventaris!
							</div>
						</div>

						<div class="col-12">
							<label for="jumlah" class="form-label">Jumlah</label>
							<input type="number" name="jumlah" min="1" class="form-control" id="jumlah" required>
							<div class="invalid-feedback">Masukkan Jumlah!</div>
						</div>

						<div class="col-6">
						<a class="btn btn-warning w-100" href="peminjaman_pengajuan_tambah_ive.php?id_peminjaman=<?php echo $id_peminjaman?>">Back</a>
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