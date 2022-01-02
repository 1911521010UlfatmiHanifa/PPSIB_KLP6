<?php
    include "session.php";
    $id_user = $_REQUEST['id_user'];

    if(isset($_POST['simpan'])){
		$nama_lengkap1= $_POST['nama_lengkap'];
        $username1= $_POST['username'];
        $no_hp1 = $_POST['no_hp'];
        $alamat1 = $_POST['alamat'];
        $jenis_kelamin1 = $_POST['jenis_kelamin'];
        $id_instansi1 = $_POST['id_instansi'];
        $jenis_user1 = $_POST['jenis_user'];
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
		
		if($diff2 >= 17){
            if ($error === 4) {
                $stmt=$conn->prepare('UPDATE user SET nama_lengkap=?, username=?, tanggal_lahir=?, no_hp=?, alamat=?,
                                    jenis_kelamin=?, id_instansi=?, jenis_user=? where id_user=?');
                $stmt->bind_param("ssssssisi", $nama_lengkap1, $username1, $tanggal_lahir1, $no_hp1, $alamat1, $jenis_kelamin1,
                                    $id_instansi1, $jenis_user1, $id_user);
                $stmt->execute();

                if($conn->affected_rows > 0){
                    $pesan_sukses= "Data user berhasil disimpan!";
                }
                else{
                    $pesan_gagal= "Data user gagal disimpan!";
                }
                $stmt->close();
            } else{
                $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
                $ekstensiGambar = explode('.', $namaFile);
                $ekstensiGambar = strtolower(end($ekstensiGambar));
                if (in_array($ekstensiGambar, $ekstensiGambarValid) === true) {
                    if ($ukuranFile < 1044070) {
                        move_uploaded_file($tmpName, 'img/' . $namaFile);
                        $stmt=$conn->prepare('UPDATE user SET nama_lengkap=?, username=?, tanggal_lahir=?, no_hp=?, alamat=?,
                                        jenis_kelamin=?, id_instansi=?, jenis_user=?, foto=? where id_user=?');
                        $stmt->bind_param("ssssssissi", $nama_lengkap1, $username1, $tanggal_lahir1, $no_hp1, $alamat1, $jenis_kelamin1,
                                            $id_instansi1, $jenis_user1, $namaFile, $id_user);
                        $stmt->execute();

                        if($conn->affected_rows > 0){
                            $pesan_sukses= "Data user berhasil disimpan!";
                        }
                        else{
                            $pesan_gagal= "Data user gagal disimpan!";
                        }
                        $stmt->close();
                    }
                }else{
                    $pesan_gagal= "Format File Tidak Sesuai!";
                }
            }
        }else{
            $pesan_gagal= "Umur belum mencukupi!";
        }
	} 

    $stmt = $conn->prepare("SELECT * FROM user join instansi on user.id_instansi=instansi.id_instansi WHERE id_user = ?");
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $result = $stmt->get_result();

    while($data = $result->fetch_assoc()){
        $nama_lengkap= $data['nama_lengkap'];
        $username= $data['username'];
        $tanggal_lahir = $data['tanggal_lahir'];
        $no_hp = $data['no_hp'];
        $alamat = $data['alamat'];
        $jenis_kelamin = $data['jenis_kelamin'];
        $id_instansi = $data['id_instansi'];
        $jenis_user = $data['jenis_user'];
        $gambar2 = $data['foto'];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Form Edit Data User</title>
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
            <li class="breadcrumb-item">User</li>
            <li class="breadcrumb-item active">Form Edit Data User</li>
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
                <h5 class="card-title">Form Edit Data User</h5>

                <!-- General Form Elements -->
                <form class="row g-3 needs-validation" method="post" novalidate enctype="multipart/form-data">
						<div class="col-6">
							<label for="yourName" class="form-label">Nama Lengkap</label>
							<input type="text" name="nama_lengkap" class="form-control" id="nama_lengkap" value="<?php echo $nama_lengkap?>" pattern="^[A-Za-z]+([\A-Za-z]+)*" autofocus required>
							<div class="invalid-feedback">Masukkan Nama Lengkap!</div>
						</div>

						<div class="col-6">
							<label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
							<input type="date" name="tanggal_lahir" class="form-control" value="<?php echo $tanggal_lahir?>" id="tanggal_lahir" required>
							<div class="invalid-feedback">Masukkan Tanggal Lahir!</div>
						</div>

						<div class="col-6">
							<label for="no_hp" class="form-label">Nomor HP</label>
							<input type="text" name="no_hp" class="form-control" id="no_hp" value="<?php echo $no_hp?>" pattern="^(\+62|62|0)[0-9]{9,}$" required>
							<div class="invalid-feedback">Masukkan Nomor Hp!</div>
						</div>

                        <div class="col-6">
							<label for="yourName" class="form-label">Username</label>
							<input type="text" name="username" class="form-control" id="username" value="<?php echo $username?>" required>
							<div class="invalid-feedback">Masukkan Username!</div>
						</div>

						<div class="col-6">
							<label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
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
							<div class="invalid-feedback">
								Masukkan Jenis Kelamin!
							</div>
						</div>

                        <div class="col-6 form-group">
							<label for="jenis_user" class="form-label">Jenis User</label>
							<select class="form-select" id="jenis_user" name="jenis_user" required>
                                <option selected disabled value="">Pilih Jenis User</option>
                                <?php 
                                    if($jenis_user == "Admin") {
                                        echo"<option value='Admin' selected>Admin</option>";
                                    }else {
                                        echo "<option value='Admin'>Admin</option>";
                                    }

                                    if($jenis_user =="Peminjam di Luar UKS") {
                                        echo"<option value='Peminjam di Luar UKS' selected>Peminjam di Luar UKS</option>";
                                    }else {
                                        echo "<option value='Peminjam di Luar UKS'>Peminjam di Luar UKS</option>";
                                    }

                                    if($jenis_user =="Divisi Rumah Tangga") {
                                        echo"<option value='Divisi Rumah Tangga' selected>Divisi Rumah Tangga</option>";
                                    }else {
                                        echo "<option value='Divisi Rumah Tangga'>Divisi Rumah Tangga</option>";
                                    }

                                    if($jenis_user =="Divisi Pemasaran") {
                                        echo"<option value='Divisi Pemasaran' selected>Divisi Pemasaran</option>";
                                    }else {
                                        echo "<option value='Divisi Pemasaran''>Divisi Pemasaran</option>";
                                    }

                                    if($jenis_user =="Pengurus UKS") {
                                        echo"<option value='Pengurus UKS' selected>Pengurus UKS</option>";
                                    }else {
                                        echo "<option value='Pengurus UKS'>Pengurus UKS</option>";
                                    }
                                ?>
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
                                    <option value="<?php echo $row['id_instansi']; ?>"
                                        <?php if($id_instansi == $row['id_instansi']) {
                                            echo 'selected';
                                        }?>>
                                        <?php echo $row['nama_instansi']; ?>
                                    </option>
                                    <?php } ?>
                                </select>
							<div class="invalid-feedback">
								Masukkan Instansi!
							</div>
						</div>

						<div class="col-6">
							<label for="alamat" class="form-label">Alamat</label>
							<input type="text" name="alamat" class="form-control" value="<?php echo $alamat?>" id="alamat" required>
							<div class="invalid-feedback">Masukkan Alamat!</div>
						</div>

						<div class="col-md-12 form-group">
							<label for="gambar" class="form-label">Foto</label>
                            <img width="100px" src="img/<?php echo $gambar2?>"><br><br>
							<input type="file" class="form-control px-2 py-1" id="gambar" name="gambar" placeholder="Foto">
						</div>

						<div class="col-6">
						<a class="btn btn-warning w-100" href="user.php">Back</a>
						</div>
						<div class="col-6">
							<button class="btn btn-primary w-100" type="submit" name="simpan">Simpan Perubahan</button>
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