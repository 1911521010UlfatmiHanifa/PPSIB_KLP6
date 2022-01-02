<?php
    include "session.php";
    $id = $_SESSION['id_user'];

    if(isset($_POST['delete'])){
        if(isset($_POST['aksi']) && $_POST['aksi'] == 'hapus'){
            $id_user = $_POST['id_user'];
 
            $stmt=$conn->prepare("DELETE FROM user WHERE id_user= ?");
            $stmt->bind_param('i', $id_user);
            $stmt->execute();
        
            if($conn->affected_rows > 0){
                $pesan_sukses= "Data user berhasil dihapus!";
            }
            else{
                $pesan_gagal= "Data user gagal dihapus!";
            }
            $stmt->close();
        }
    }

    if(!$hasil = $conn->query("SELECT * FROM user join instansi on user.id_instansi=instansi.id_instansi where id_user not in (Select id_user from user where id_user='$id') order by id_user")){
        die("gagal meminta data");
    }
    $no = 1;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Data User</title>
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
              <a href="user_tambah.php" class="btn btn-outline-info btn-mt">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-plus-circle" viewBox="1 1 15 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg> Tambah Data User
              </a><br><br>
              <!-- Table with stripped rows -->
              <table class="table datatable table-hover">
                <thead>
                  <tr height="20px">
                    <th scope="col">No.</th>
                    <th scope="col">Nama_User</th>
                    <th scope="col">Username</th>
                    <th scope="col">Instansi</th>
                    <th scope="col">Foto</th>
                    <th scope="col">Jenis</th>
                    <th scope="col">Tgl_Lahir</th>
                    <th scope="col">Nomor HP</th>
                    <th scope="col">JenKel</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                      while($row = $hasil->fetch_assoc()){
                  ?>
                  <tr>
                    <th scope="row"><?php echo $no++;?></th>
                    <td><?php echo $row['nama_lengkap']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['nama_instansi']; ?></td>
                    <td><img width="100px" src="img/<?php echo $row['foto'];?>"></td>
                    <td><?php echo $row['jenis_user']; ?></td>
                    <td><?php echo date('d F Y', strtotime($row['tanggal_lahir'])); ?></td>
                    <td><?php echo $row['no_hp']; ?></td>
                    <td><?php echo $row['jenis_kelamin']; ?></td>
                    <td><?php echo $row['alamat']; ?></td>
                    <td width="105px" class="text-center">
                      <form method="POST" action="">
                          <a role="button" href="user_edit.php?id_user=<?php echo $row['id_user'];?>" class="btn btn-outline-warning btn-sm bi bi-pen">
                          </a> &nbsp;`    
                          <input type="hidden" name="aksi" value="hapus">
                          <input type="hidden" name="id_user" value="<?php echo $row['id_user'];?>">
                          <button class="btn btn-outline-danger btn-sm" type="submit" name="delete" onclick="return confirm('Anda yakin akan menghapus data user ini?')">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 14 15">
                                  <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                              </svg>
                          </button> 
                      </td>
                      </form>
                    </td>
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