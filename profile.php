<?php
    include "session.php";
    $id_user = $_SESSION['id_user'];
    $stmt = $conn->prepare("SELECT * FROM user join instansi on user.id_instansi=instansi.id_instansi WHERE id_user = ?");
    $stmt->bind_param("s", $id_user);
    $stmt->execute();
    $result = $stmt->get_result();

    while($data = $result->fetch_assoc()){
        $id_user = $data['id_user'];
        $nama_lengkap = $data['nama_lengkap'];
        $alamat = $data['alamat'];
        $no_hp = $data['no_hp'];
        $username = $data['username'];
        $gambar = $data['foto'];
        $instansi = $data['nama_instansi'];
        $id_instansi = $data['id_instansi'];
        $jenis_user = $data['jenis_user'];
        $jenis_kelamin = $data['jenis_kelamin'];
        $tanggal_lahir = $data['tanggal_lahir'];
    }

    if(isset($_POST['edit'])){
      $nama_lengkap1 = $_POST['nama_lengkap'];
      $alamat1 = $_POST['alamat'];
      $no_hp1 = $_POST['no_hp'];
      $username1 = $_POST['username'];
      $id_instansi1 = $_POST['id_instansi'];
      $jenis_kelamin1 = $_POST['jenis_kelamin'];
      $tanggal_lahir1 = $_POST['tanggal_lahir'];
  
      $namaFile = $_FILES['gambar']['name'];
      $ukuranFile = $_FILES['gambar']['size'];
      $tmpName = $_FILES['gambar']['tmp_name'];
      $error = $_FILES['gambar']['error'];

      $sekarang = date('d-m-Y');
      $tgl1 = new DateTime($sekarang);
      $tgl2 = new DateTime($tanggal_lahir1);
      $jarak = $tgl1->diff($tgl2);
      $diff2 = $jarak->y;
      
      if ($error === 4) {
        if($diff2 >= 17){
          $stmt1=$conn->prepare('UPDATE user SET nama_lengkap=?, id_instansi=?, username=?, tanggal_lahir=?, no_hp=?, jenis_kelamin=?, alamat=?, foto=? where id_user=?');
          $stmt1->bind_param("sissssssi", $nama_lengkap1, $id_instansi1, $username1, $tanggal_lahir1, $no_hp1, $jenis_kelamin1, $alamat1, $gambar, $id_user);
          $stmt1->execute();
    
          if($conn->affected_rows > 0){
            echo "<script>document.location.href='profile.php';</script>";
          }
          else{
            $pesan_gagal= "Data user gagal disimpan!";
          }
          $stmt1->close();
        }else{
          $pesan_gagal= "Umur belum mencukupi!";
        }
      }else{
        $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
        $ekstensiGambar = explode('.', $namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        if (in_array($ekstensiGambar, $ekstensiGambarValid) === true) {
          if ($ukuranFile < 1044070) {
            move_uploaded_file($tmpName, 'img/' . $namaFile);
            if($diff2 >= 17){
              $stmt2=$conn->prepare('UPDATE user SET nama_lengkap=?, id_instansi=?, username=?, tanggal_lahir=?, no_hp=?, jenis_kelamin=?, alamat=?, foto=? where id_user=?');
              $stmt2->bind_param("sissssssi", $nama_lengkap1, $id_instansi1, $username1, $tanggal_lahir1, $no_hp1, $jenis_kelamin1, $alamat1, $namaFile, $id_user);
              $stmt2->execute();
      
              if($conn->affected_rows > 0){
                echo "<script>document.location.href='profile.php';</script>";
              }
              else{
                $pesan_gagal= "Data user gagal disimpan!";
              }
              $stmt2->close();
            }else{
              $pesan_gagal= "Umur belum mencukupi!";
            }
          }
        }else{
          $pesan_gagal= "Format File Tidak Sesuai!";
        }
      }
    }
    
    if(isset($_POST['ubah_pw'])){
      $password_sekarang = md5($_POST['password_sekarang']);
      $password_baru = md5($_POST['password_baru']);
      $password_konfir = md5($_POST['password_konfir']);

      $stmt1=$conn->prepare('SELECT * from user WHERE id_user = ?');
      $stmt1->bind_param("i", $id_user);
      $stmt1->execute();
      $ku=$stmt1->get_result();
      while($data2 = $ku->fetch_assoc()){
        $pw = $data2['password'];
      }
      
      if($pw == $password_sekarang){
        if ($password_baru == $password_konfir) {
          $stmt2=$conn->prepare('UPDATE user SET password=? where id_user=?');
          $stmt2->bind_param("si", $password_baru, $id_user);
          $stmt2->execute();
          if($conn->affected_rows > 0){
            echo "<script>document.location.href='profile.php';</script>";
          }else{
            $pesan_gagal= "Data user gagal disimpan!";
          }
        }else{
          $pesan_gagal= "Password baru dan konfirmasi tidak cocok!";
        }
      }else{
        $pesan_gagal= "Password sekarang salah!";
      } 
    } 
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Profil Akun</title>
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

<body OnLoad="loadHalaman()">
<?php include("header.php");?>

<?php include("sidebar_admin.php");?>  

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item">Home</li>
          <li class="breadcrumb-item">Users</li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img src="img/<?php echo $gambar?>" alt="Profile" class="rounded-circle">
              <h2><?php echo $nama_lengkap?></h2>
              <h3><?php echo $jenis_user?></h3>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Profil</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profil</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Ubah Password</button>
                </li>

              </ul>
              <div class="tab-content pt-2">
              <?php if(isset($pesan_gagal)){
                ?>
                    <div class="alert alert-danger" role="alert">
                    <?php echo '<img src="logo/cross.png" width="18" class="me-2">'.$pesan_gagal; ?>
                    </div>
                <?php
                }
                ?> 

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title">Detail Profil</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                    <div class="col-lg-9 col-md-8"><?php echo $nama_lengkap?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Nama Instansi</div>
                    <div class="col-lg-9 col-md-8"><?php echo $instansi?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Username</div>
                    <div class="col-lg-9 col-md-8"><?php echo $username?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Tanggal Lahir</div>
                    <div class="col-lg-9 col-md-8"><?php echo date('d F Y', strtotime($tanggal_lahir))?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Nomor HP</div>
                    <div class="col-lg-9 col-md-8"><?php echo $no_hp?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Jenis Kelamin</div>
                    <div class="col-lg-9 col-md-8"><?php echo $jenis_kelamin?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Alamat</div>
                    <div class="col-lg-9 col-md-8"><?php echo $alamat?></div>
                  </div>

                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                  <!-- Profile Edit Form -->
                  <form class="row g-3 needs-validation" method="post" novalidate enctype="multipart/form-data">
                    <div class="row mb-3">
                      <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                      <div class="col-md-8 col-lg-9">
                        <img src="img/<?php echo $gambar?>" alt="Profile">
                        <div class="pt-2">
                          <input type="file" class="form-control px-2 py-1" id="gambar" name="gambar" placeholder="Foto">
                        </div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nama Lengkap</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="text" name="nama_lengkap" class="form-control" id="nama_lengkap" value="<?php echo $nama_lengkap?>" pattern="^[A-Za-z]+([\A-Za-z]+)*" autofocus required>
                        <div class="invalid-feedback">Masukkan Nama Lengkap!</div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="about" class="col-md-4 col-lg-3 col-form-label">Instansi</label>
                      <div class="col-md-8 col-lg-9">
                        <select class="form-select" id="id_instansi" name="id_instansi" required>
                          <option selected disabled value="">Pilih Instansi</option>
                              <?php
                                $stmt25 = $conn->query("SELECT * FROM instansi");
                                while($row = $stmt25->fetch_assoc()){
                              ?>
                              <option value="<?php echo $row['id_instansi']; ?>"
                                <?php if($id_instansi == $row['id_instansi']) {
                                    echo 'selected';
                                }?>>
                                <?php echo $row['nama_instansi']; ?>
                              </option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="invalid-feedback">
                        Masukkan Instansi!
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="company" class="col-md-4 col-lg-3 col-form-label">Username</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="text" name="username" class="form-control" id="username" value="<?php echo $username?>" pattern="^[A-Za-z]+([\A-Za-z]+)*" required>
                        <div class="invalid-feedback">Masukkan Username!</div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Job" class="col-md-4 col-lg-3 col-form-label">Tanggal Lahir</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="date" name="tanggal_lahir" class="form-control" id="tanggal_lahir" value="<?php echo $tanggal_lahir?>" required>
                        <div class="invalid-feedback">Masukkan Tanggal Lahir!</div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Country" class="col-md-4 col-lg-3 col-form-label">Nomor HP</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="text" name="no_hp" class="form-control" id="no_hp" pattern="^(\+62|62|0)[0-9]{9,}$" value="<?php echo $no_hp?>" required>
                        <div class="invalid-feedback">Masukkan Nomor Hp!</div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Address" class="col-md-4 col-lg-3 col-form-label">Jenis Kelamin</label>
                      <div class="col-md-8 col-lg-9">
                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                          <option selected disabled value="">Pilih Jenis Kelamin</option>
                              <?php
                                if($jenis_kelamin == "Perempuan") {
                                    echo"<option value='Perempuan' selected>Perempuan</option>";
                                }else {
                                    echo "<option value='Perempuan'>Perempuan</option>";
                                }

                                if($jenis_kelamin =="Laki-Laki") {
                                    echo"<option value='Laki-Laki' selected>Laki-Laki</option>";
                                }else {
                                    echo "<option value='Laki-Laki'>Laki-Laki</option>";
                                }
                              ?>
                        </select>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Alamat</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="text" class="form-control" id="validationCustom06" pattern="^[A-Za-z]+([\A-Za-z]+)*" name="alamat" value="<?php echo $alamat?>" required>
                        <div class="invalid-feedback">
                            Masukkan Alamat Dengan Benar!
                        </div>
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary" name="edit">Simpan Perubahan</button>
                    </div>
                  </form><!-- End Profile Edit Form -->

                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password">
                <br>
                  <!-- Change Password Form -->
                  <form class="row g-3 needs-validation" method="post" novalidate enctype="multipart/form-data">

                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-4 col-form-label">Password Sekarang</label>
                      <div class="col-md-8 col-lg-8">
                        <input type="password" name="password_sekarang" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" class="form-control" id="password_sekarang" required>
							          <div class="invalid-feedback">Password Harus Berisi Minimal 1 Huruf Kapital, 1 Huruf Kecil, Tanda Baca, Angka, dan Minimal 8 Karakter!</div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-4 col-form-label">Password Baru</label>
                      <div class="col-md-8 col-lg-8">
                        <input type="password" name="password_baru" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" class="form-control" id="password_baru" required>
							          <div class="invalid-feedback">Password Harus Berisi Minimal 1 Huruf Kapital, 1 Huruf Kecil, Tanda Baca, Angka, dan Minimal 8 Karakter!</div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-4 col-form-label">Konfirmasi Password</label>
                      <div class="col-md-8 col-lg-8">
                        <input type="password" name="password_konfir" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" class="form-control" id="password_konfir" required>
							          <div class="invalid-feedback">Password Harus Berisi Minimal 1 Huruf Kapital, 1 Huruf Kecil, Tanda Baca, Angka, dan Minimal 8 Karakter!</div>
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary" name="ubah_pw">Simpan Perubahan</button>
                    </div>
                  </form><!-- End Change Password Form -->

                </div>

              </div><!-- End Bordered Tabs -->

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