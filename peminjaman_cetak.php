<?php
    include "session.php";

    if(isset($_POST['simpan'])){
		$bulan = $_POST['bulan'];
        $tahun = $_POST['tahun'];

        $data = $conn->query("SELECT count(detail_pinjaman.id_peminjaman) as id FROM detail_pinjaman join peminjaman on
                            peminjaman.id_peminjaman=detail_pinjaman.id_peminjaman where month(tanggal_kembali)='$bulan' and 
                            year(tanggal_kembali)='$tahun'");
        while ($row1 = $data->fetch_assoc()) {
            $brag = $row1['id'];
        }

        if ($brag == 0) {
            $pesan_gagal = "Tidak ada transaksi!";
        } else {
            header("location:cetak_transaksi_bulanan.php?bulan=$bulan&&tahun=$tahun");
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
                    <div class="col-12">
                        <label for="yourbulan" class="form-label">Bulan Transaksi</label>
                        <div class="input-group has-validation">
                            <input type="number" min="1" max="12" name="bulan" class="form-control" id="bulan" required>
                            <div class="invalid-feedback">Masukkan Bulan Transaksi!</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="yourtahun" class="form-label">Tahun Transaksi</label>
                        <div class="input-group has-validation">
                            <input type="number" min="2000" name="tahun" class="form-control" id="tahun" required>
                            <div class="invalid-feedback">Masukkan Tahun Transaksi!</div>
                        </div>
                    </div>

                    <div class="col-12">
                        <button class="btn btn-primary w-100" type="submit" name="simpan">Cetak Transaksi</button>
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