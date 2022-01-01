<?php
    include "session.php";

    if(!$hasil = $conn->query("SELECT * FROM peminjaman join user on user.id_user=peminjaman.id_user join instansi on
                            user.id_instansi=instansi.id_instansi where status_peminjaman='Diajukan'")){
        die("gagal meminta data");
    }
    $no = 1;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Data Inventaris</title>
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
      <h1>Data Pengajuan Peminjaman Inventaris</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item">Home</li>
          <li class="breadcrumb-item">Data Pengajuan Peminjaman</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
        <?php if(isset($pesan_sukses)){?>
              <div class="alert alert-success" role="alert">
                  <?php echo '<img src="logo/check.png" width="27" class="me-2">  '.$pesan_sukses; ?>
              </div>
          <?php } else if(isset($pesan_gagal)){ ?>
              <div class="alert alert-danger" role="alert">
                  <?php echo '<img src="logo/cross.png" width="20" class="me-2">  '.$pesan_gagal; ?>
              </div>
          <?php } ?>

          <div class="card">
            <div class="card-body"><br>
              <!-- Table with stripped rows -->
              <table class="table datatable table-hover">
                <thead>
                  <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Nama Peminjam</th>
                    <th scope="col">Nama Instansi</th>
                    <th scope="col">Tanggal Pengajuan Pinjaman</th>
                    <th scope="col">Tanggal Pinjaman</th>
                    <th scope="col">Tanggal Kembali</th>
                    <?php if ($_SESSION['jenis_user'] == "Admin" || $_SESSION['jenis_user'] == "Divisi Rumah Tangga"){ ?>
                      <th scope="col">Aksi</th>
                    <?php } ?>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                      while($row = $hasil->fetch_assoc()){
                  ?>
                  <tr>
                    <th scope="row"><?php echo $no++;?></th>
                    <td><?php echo $row['nama_lengkap']; ?></td>
                    <td><?php echo $row['nama_instansi']; ?></td>
                    <td><?php echo date('d F Y', strtotime($row['tanggal_pengajuan'])); ?></td>
                    <td><?php echo date('d F Y', strtotime($row['tanggal_pinjam'])); ?></td>
                    <td><?php echo date('d F Y', strtotime($row['tanggal_kembali'])); ?></td>
                    <?php if ($_SESSION['jenis_user'] == "Admin"){ ?>
                      <td width="105px" class="text-center">
                          <a role="button" href="peminjaman_detail.php?id_peminjaman=<?php echo $row['id_peminjaman'];?>" class="btn btn-outline-warning btn-sm bi bi-eye">
                          </a> &nbsp;
                      </td>
                    <?php } else if ($_SESSION['jenis_user'] == "Divisi Rumah Tangga"){ ?>
                      <td width="105px" class="text-center">
                          <a role="button" href="peminjaman_persetujuan_rmt.php?id_peminjaman=<?php echo $row['id_peminjaman'];?>" class="btn btn-outline-warning btn-sm bi bi-eye">
                          </a> &nbsp;
                      </td>
                    <?php } ?>  
                  </tr>
                <?php } ?>
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

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
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>