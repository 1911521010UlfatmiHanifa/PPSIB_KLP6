<?php
  include("session.php");
  $tahun = date("Y");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard</title>
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
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item">Home</li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-3 col-md-6">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Jumlah <span>Pengguna</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                    <?php
                      $query16 = $conn->query("SELECT count(id_user) as id_user from user");
                      $data16 = $query16->fetch_assoc();
                      $jumlah_transaksi16 = $data16['id_user'];
                      if($jumlah_transaksi16==null){?>
                        <h6>0</h6>
                      <?php }else{ ?>
                        <h6><?php echo $jumlah_transaksi16;?></h6>
                      <?php } ?>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-3 col-md-6">
              <div class="card info-card revenue-card">
                <div class="card-body">
                  <h5 class="card-title">Total <span>Peminjaman</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-list"></i>
                    </div>
                    <div class="ps-3">
                    <?php
                    $query16 = $conn->query("SELECT count(id_peminjaman) as id_peminjaman from peminjaman where status_peminjaman='Disetujui Divisi Rumah Tangga' and status_harga='Disetujui Divisi Pemasaran'");
                    $data16 = $query16->fetch_assoc();
                    $jumlah_transaksi16 = $data16['id_peminjaman'];
                    if($jumlah_transaksi16==null){?>
                      <h6>0</h6>
                    <?php }else{ ?>
                      <h6><?php echo $jumlah_transaksi16;?></h6>
                    <?php } ?>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-3 col-xl-12">

              <div class="card info-card customers-card">
                <div class="card-body">
                  <h5 class="card-title">Total <span>Pengajuan Peminjaman</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-list"></i>
                    </div>
                    <div class="ps-3">
                    <?php
                    $query16 = $conn->query("SELECT count(id_peminjaman) as id_peminjaman from peminjaman WHERE status_peminjaman='Diajukan'");
                    $data16 = $query16->fetch_assoc();
                    $jumlah_transaksi16 = $data16['id_peminjaman'];
                    if($jumlah_transaksi16==null){?>
                      <h6>0</h6>
                    <?php }else{ ?>
                      <h6><?php echo $jumlah_transaksi16;?></h6>
                    <?php } ?>
                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-3 col-xl-12">

              <div class="card info-card revenue-card">
                <div class="card-body">
                  <h5 class="card-title">Total <span>Pengembalian Inventaris</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-list"></i>
                    </div>
                    <div class="ps-3">
                    <?php
                    $query16 = $conn->query("SELECT count(id_peminjaman) as id_peminjaman from peminjaman where status_peminjaman='Sudah Dikembalikan'");
                    $data16 = $query16->fetch_assoc();
                    $jumlah_transaksi16 = $data16['id_peminjaman'];
                    if($jumlah_transaksi16==null){?>
                      <h6>0</h6>
                    <?php }else{ ?>
                      <h6><?php echo $jumlah_transaksi16;?></h6>
                    <?php } ?>
                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Revenue Card -->

            <!-- Reports -->
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Reports <span>/Data Total Peminjaman Per Bulan Pada Tahun <?php echo $tahun?></span></h5>

                  <!-- Line Chart -->
                  <div id="reportsChart"></div>

                  <script>
                    document.addEventListener("DOMContentLoaded", () => {
                      new ApexCharts(document.querySelector("#reportsChart"), {
                        series: [{
                          name: 'Total Peminjaman',
                          data: [
                            <?php
                              $query8 = $conn->query("SELECT count(id_peminjaman) as id_peminjaman from peminjaman WHERE status_peminjaman='Sudah Dikembalikan' AND month(tanggal_kembali)='1' and year(tanggal_kembali)='$tahun'");
                              $data8 = $query8->fetch_assoc();
                              $jumlah_transaksi8 = $data8['id_peminjaman'];
                              if($jumlah_transaksi8 == null){
                                echo 0;
                              }else{
                                echo $jumlah_transaksi8;
                              }

                              ?>

                              ,

                              <?php

                              $query10 = $conn->query("SELECT count(id_peminjaman) as id_peminjaman from peminjaman WHERE status_peminjaman='Sudah Dikembalikan' AND month(tanggal_kembali)='2' and year(tanggal_kembali)='$tahun'");
                              $data10 = $query10->fetch_assoc();
                              $jumlah_transaksi10 = $data10['id_peminjaman'];
                              if($jumlah_transaksi10==null){
                                echo 0;
                              }else{
                                echo $jumlah_transaksi10;
                              }

                              ?>

                              ,

                              <?php

                              $query11 = $conn->query("SELECT count(id_peminjaman) as id_peminjaman from peminjaman WHERE status_peminjaman='Sudah Dikembalikan' AND month(tanggal_kembali)='3' and year(tanggal_kembali)='$tahun'");
                              $data11 = $query11->fetch_assoc();
                              $jumlah_transaksi11 = $data11['id_peminjaman'];
                              if($jumlah_transaksi11==null){
                                echo 0;
                              }else{
                                echo $jumlah_transaksi11;
                              }

                              ?>
                              
                              ,

                              <?php

                              $query12 = $conn->query("SELECT count(id_peminjaman) as id_peminjaman from peminjaman WHERE status_peminjaman='Sudah Dikembalikan' AND month(tanggal_kembali)='4' and year(tanggal_kembali)='$tahun'");
                              $data12 = $query12->fetch_assoc();
                              $jumlah_transaksi12 = $data12['id_peminjaman'];
                              if($jumlah_transaksi12==null){
                                echo 0;
                              }else{
                                echo $jumlah_transaksi12;
                              }

                              ?>
                              
                              ,

                              <?php

                              $query13 = $conn->query("SELECT count(id_peminjaman) as id_peminjaman from peminjaman WHERE status_peminjaman='Sudah Dikembalikan' AND month(tanggal_kembali)='5' and year(tanggal_kembali)='$tahun'");
                              $data13 = $query13->fetch_assoc();
                              $jumlah_transaksi13 = $data13['id_peminjaman'];
                              if($jumlah_transaksi13==null){
                                echo 0;
                              }else{
                                echo $jumlah_transaksi13;
                              }

                              ?>

                              ,

                              <?php

                              $query14 = $conn->query("SELECT count(id_peminjaman) as id_peminjaman from peminjaman WHERE status_peminjaman='Sudah Dikembalikan' AND month(tanggal_kembali)='6' and year(tanggal_kembali)='$tahun'");
                              $data14 = $query14->fetch_assoc();
                              $jumlah_transaksi14 = $data14['id_peminjaman'];
                              if($jumlah_transaksi14==null){
                                echo 0;
                              }else{
                                echo $jumlah_transaksi14;
                              }

                              ?>
                              ,

                              <?php

                              $query15 = $conn->query("SELECT count(id_peminjaman) as id_peminjaman from peminjaman WHERE status_peminjaman='Sudah Dikembalikan' AND month(tanggal_kembali)='7' and year(tanggal_kembali)='$tahun'");
                              $data15 = $query15->fetch_assoc();
                              $jumlah_transaksi15 = $data15['id_peminjaman'];
                              if($jumlah_transaksi15==null){
                                echo 0;
                              }else{
                                echo $jumlah_transaksi15;
                              }

                              ?>
                              ,

                              <?php

                              $query16 = $conn->query("SELECT count(id_peminjaman) as id_peminjaman from peminjaman WHERE status_peminjaman='Sudah Dikembalikan' AND month(tanggal_kembali)='8' and year(tanggal_kembali)='$tahun'");
                              $data16 = $query16->fetch_assoc();
                              $jumlah_transaksi16 = $data16['id_peminjaman'];
                              if($jumlah_transaksi16==null){
                                echo 0;
                              }else{
                                echo $jumlah_transaksi16;
                              }

                              ?>
                              ,

                              <?php

                              $query17 = $conn->query("SELECT count(id_peminjaman) as id_peminjaman from peminjaman WHERE status_peminjaman='Sudah Dikembalikan' AND month(tanggal_kembali)='9' and year(tanggal_kembali)='$tahun'");
                              $data17 = $query17->fetch_assoc();
                              $jumlah_transaksi17 = $data17['id_peminjaman'];
                              if($jumlah_transaksi17==null){
                                echo 0;
                              }else{
                                echo $jumlah_transaksi17;
                              }

                              ?>
                              ,

                              <?php

                              $query18 = $conn->query("SELECT count(id_peminjaman) as id_peminjaman from peminjaman WHERE status_peminjaman='Sudah Dikembalikan' AND month(tanggal_kembali)='10' and year(tanggal_kembali)='$tahun'");
                              $data18 = $query18->fetch_assoc();
                              $jumlah_transaksi18 = $data18['id_peminjaman'];
                              if($jumlah_transaksi18==null){
                                echo 0;
                              }else{
                                echo $jumlah_transaksi18;
                              }

                              ?>

                              ,

                              <?php

                              $query19 = $conn->query("SELECT count(id_peminjaman) as id_peminjaman from peminjaman WHERE status_peminjaman='Sudah Dikembalikan' AND month(tanggal_kembali)='11' and year(tanggal_kembali)='$tahun'");
                              $data19 = $query19->fetch_assoc();
                              $jumlah_transaksi19 = $data19['id_peminjaman'];
                              if($jumlah_transaksi19==null){
                                echo 0;
                              }else{
                                echo $jumlah_transaksi19;
                              }

                              ?>
                              ,

                              <?php

                              $query20 = $conn->query("SELECT count(id_peminjaman) as id_peminjaman from peminjaman WHERE status_peminjaman='Sudah Dikembalikan' AND month(tanggal_kembali)='12' and year(tanggal_kembali)='$tahun'");
                              $data20 = $query20->fetch_assoc();
                              $jumlah_transaksi20 = $data20['id_peminjaman'];
                              if($jumlah_transaksi20==null){
                                echo 0;
                              }else{
                                echo $jumlah_transaksi20;
                              }

                              ?>
                          ],
                        }],
                        chart: {
                          height: 350,
                          type: 'area',
                          toolbar: {
                            show: false
                          },
                        },
                        markers: {
                          size: 4
                        },
                        colors: ['#4154f1'],
                        fill: {
                          type: "gradient",
                          gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.3,
                            opacityTo: 0.4,
                            stops: [0, 90, 100]
                          }
                        },
                        dataLabels: {
                          enabled: false
                        },
                        stroke: {
                          curve: 'smooth',
                          width: 2
                        },
                        xaxis: {
                          type: 'string',
                          categories: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "November", "Desember"]
                        },
                        tooltip: {
                          x: {
                            format: 'dd/MM/yy HH:mm'
                          },
                        }
                      }).render();
                    });
                  </script>
                  <!-- End Line Chart -->

                </div>

              </div>
            </div><!-- End Reports -->
      </div>
    </section>

    <?php include "footer.php"?>

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