<?php
    include "session.php";

    $bulan = $_GET['bulan'];
    $tahun = $_GET['tahun'];

    if(!$hasil = $conn->query("SELECT * FROM peminjaman where month(tanggal_kembali)='$bulan' and 
                                year(tanggal_kembali)='$tahun'")){
        die("gagal meminta data");
    }

    if($bulan == 1){ $nama_bulan="Januari";}
    else if($bulan == 2){ $nama_bulan="Februari";}
    else if($bulan == 3){ $nama_bulan="Maret";}
    else if($bulan == 4){ $nama_bulan="April";}
    else if($bulan == 5){ $nama_bulan="Mei";}
    else if($bulan == 6){ $nama_bulan="Juni";}
    else if($bulan == 7){ $nama_bulan="Julii";}
    else if($bulan == 8){ $nama_bulan="Agustus";}
    else if($bulan == 9){ $nama_bulan="September";}
    else if($bulan == 10){ $nama_bulan="Oktober";}
    else if($bulan == 11){ $nama_bulan="November";}
    else if($bulan == 12){ $nama_bulan="Desember";}

    $no = 1;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Data Peminjaman Inventaris</title>
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

    <section class="section">
      <div class="row">
        <div class="col-lg-20">
          <div class="card">
            <div class="card-body"><br>
                <h3 class="card-title text-center">DATA TRANSAKSI BULAN <?php echo strtoupper($nama_bulan), " ", $tahun?></h3>
              <!-- Table with stripped rows -->
              <table class="table datatable table-hover">
                <thead>
                  <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Tanggal Pengajuan Pinjaman</th>
                    <th scope="col">Tanggal Pinjaman</th>
                    <th scope="col">Tanggal Kembali</th>
                    <th scope="col">Status Peminjaman</th>
                    <th scope="col">Status Harga</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                      while($row = $hasil->fetch_assoc()){
                  ?>
                  <tr>
                    <th scope="row"><?php echo $no++;?></th>
                    <td><?php echo date('d F Y', strtotime($row['tanggal_pengajuan'])); ?></td>
                    <td><?php echo date('d F Y', strtotime($row['tanggal_pinjam'])); ?></td>
                    <td><?php echo date('d F Y', strtotime($row['tanggal_kembali'])); ?></td>
                    <td><?php echo $row['status_peminjaman']; ?></td>
                    <td><?php 
                          if($row['status_harga'] != null){
                            echo $row['status_harga'];
                          }else{
                            echo "-";
                          } 
                        ?>
                    </td>
                  </tr>
                <?php } ?>
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>
            <script>
                window.print();
            </script>
        </div>
      </div>
    </section>

  <?php include "footer.php"?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>