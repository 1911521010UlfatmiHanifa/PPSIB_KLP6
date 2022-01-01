<?php
    include "session.php";
    $id_peminjaman = $_REQUEST['id_peminjaman'];

    if(isset($_POST['setuju'])){

        $status_peminjaman = "Disetujui Peminjam";
        $stmt=$conn->prepare("UPDATE peminjaman set status_harga=? where id_peminjaman=?");
        $stmt->bind_param('si', $status_peminjaman, $id_peminjaman);
        $stmt->execute();
    
        if($conn->affected_rows > 0){
            $pesan_sukses= "Data konfirmasi harga berhasil disimpan!";
        }
        else{
            $pesan_gagal= "Data konfirmasi harga gagal disimpan!";
        }
        $stmt->close();
        
    }

    if(isset($_POST['dikembalikan'])){

        $status_peminjaman2 = "Sudah Dikembalikan";
        if(!$hasil = $conn->query("SELECT * FROM peminjaman join user on user.id_user=peminjaman.id_user join instansi on
                                user.id_instansi=instansi.id_instansi where id_peminjaman='$id_peminjaman'")){
            die("gagal meminta data");
        }
        while($data = $hasil->fetch_assoc()){
            $tanggal_kembali = $data['tanggal_kembali'];
        }
        $tanggal_pengajuan = date('Y/m/d');
        if($tanggal_kembali < $tanggal_pengajuan){
            $stmt=$conn->query("UPDATE peminjaman set status_peminjaman='$status_peminjaman2' where id_peminjaman='$id_peminjaman'");
            $pesan_peringatan = "Data Berhasil Disimpan dan Peminjam Dikenakan Denda";
        }else{
            $stmt=$conn->prepare("UPDATE peminjaman set status_peminjaman=? where id_peminjaman=?");
            $stmt->bind_param('si', $status_peminjaman, $id_peminjaman);
            $stmt->execute();
        
            if($conn->affected_rows > 0){
                $pesan_sukses= "Data pengembalian peminjaman berhasil disimpan!";
            }
            else{
                $pesan_gagal= "Data pengembalian peminjaman konfirmasi harga gagal disimpan!";
            }
            $stmt->close();
        }
        
    }
    
    if(isset($_POST['tolakan'])){

        $status_peminjaman = "Ditolak Peminjam";
        $stmt=$conn->prepare("UPDATE peminjaman set status_harga=? where id_peminjaman=?");
        $stmt->bind_param('si', $status_peminjaman, $id_peminjaman);
        $stmt->execute();
    
        if($conn->affected_rows > 0){
            $pesan_sukses= "Data konfirmasi harga berhasil disimpan!";
        }
        else{
            $pesan_gagal= "Data konfirmasi harga gagal disimpan!";
        }
        $stmt->close();
        
    }
    
    if(!$hasil = $conn->query("SELECT * FROM peminjaman join user on user.id_user=peminjaman.id_user join instansi on
                            user.id_instansi=instansi.id_instansi where id_peminjaman=$id_peminjaman")){
        die("gagal meminta data");
    }
    $no = 1;

    while($data = $hasil->fetch_assoc()){
        $nama_lengkap= $data['nama_lengkap'];
        $tanggal_pinjam = $data['tanggal_pinjam'];
        $tanggal_kembali = $data['tanggal_kembali'];
        $nama_instansi = $data['nama_instansi'];
        $no_hp = $data['no_hp'];
        $status_peminjaman = $data['status_peminjaman'];
        $status_harga =  $data['status_harga'];
        $surat_peminjaman = $data['surat_peminjaman'];
    }
    $tgl1 = new DateTime($tanggal_pinjam);
    $tgl2 = new DateTime($tanggal_kembali);
    $jarak = $tgl2->diff($tgl1);
    $diff = $jarak->d;

    if(!$que = $conn->query("SELECT * FROM peminjaman join detail_pinjaman on peminjaman.id_peminjaman=detail_pinjaman.id_peminjaman
                            join inventaris on inventaris.id_inventaris=detail_pinjaman.id_inventaris where 
                            peminjaman.id_peminjaman=$id_peminjaman")){
        die("gagal meminta data");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Detail Data Peminjaman Inventaris</title>
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
            <li class="breadcrumb-item">Detail Data Peminjaman Inventaris</li>
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
            else if(isset($pesan_peringatan)){
            ?>
                <div class="alert alert-warning" role="alert">
                <?php echo '<img src="logo/warning.png" width="18" class="me-2">'.$pesan_peringatan; ?>
                </div>
            <?php
            }
            ?>

            <div class="card">
                <div class="card-body">
                <h5 class="card-title">Form Tambah Data Pengajuan Peminjaman</h5>

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                    <div class="row">
                        <div class="col-lg-8 col-md-4 label ">Nama Lengkap</div>
                        <div class="col-lg-4 col-md-8"><?php echo $nama_lengkap?></div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8 col-md-4 label">Nama Instansi</div>
                        <div class="col-lg-4 col-md-8"><?php echo $nama_instansi?></div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8 col-md-4 label">Tanggal Pinjam</div>
                        <div class="col-lg-4 col-md-8"><?php echo date('d F Y', strtotime($tanggal_pinjam))?></div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8 col-md-4 label">Tanggal Kembali</div>
                        <div class="col-lg-4 col-md-8"><?php echo date('d F Y', strtotime($tanggal_kembali))?></div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8 col-md-4 label">Nomor HP</div>
                        <div class="col-lg-4 col-md-8"><?php echo $no_hp?></div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8 col-md-4 label">Status Peminjaman</div>
                        <div class="col-lg-4 col-md-8"><?php echo $status_peminjaman?></div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8 col-md-4 label">Status Konfirmasi</div>
                        <div class="col-lg-4 col-md-8">
                            <?php if($status_harga == null){
                                echo "-";
                            }else{
                                echo $status_harga;
                            }
                            ?>
                        </div>
                    </div>

                    <?php if($_SESSION['jenis_user'] == 'Peminjam di Luar UKS'){?>
                        <div class="row">
                            <div class="col-lg-8 col-md-4 label">Surat Peminjaman</div>
                            <div class="col-lg-4 col-md-8">
                                <a href="surat/<?php echo $surat_peminjaman; ?>"/><?php echo $surat_peminjaman; ?></a>
                            </div>
                        </div>
                    <?php } ?>

                </div>
                <hr>
                    <table class="table datatable table-hover">
                        <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Nama Inventaris</th>
                            <th scope="col">Gambar</th>
                            <?php if($nama_instansi=='Universitas Andalas'){?>
                            <th scope="col">Harga Mahasiswa</th>
                            <?php } else{ ?>
                            <th scope="col">Harga Non Mahasiswa</th>
                            <?php } ?>
                            <th scope="col">Jumlah Hari</th>
                            <th scope="col">Jumlah Inventaris</th>
                            <th scope="col">Total Harga</th>
                            <th scope="col">Keterangan</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                            $total = 0; $tot[]=0;
                            while($row = $que->fetch_assoc()){
                        ?>
                        <tr>
                            <th scope="row"><?php echo $no++;?></th>
                            <td><?php echo $row['nama_inventaris']; ?></td>
                            <td><img width="100px" src="img/<?php echo $row['gambar'];?>"></td>
                            <?php if($nama_instansi=='Universitas Andalas'){ $total= $row['harga_mahasiswa']*$row['jumlah']*$diff;?>
                            <td><?php echo "Rp " . number_format($row['harga_mahasiswa'],2,',','.');?></td>
                            <?php } else{ $total= $row['harga_nonmahasiswa']*$row['jumlah']*$diff;?>
                            <td><?php echo "Rp " . number_format($row['harga_nonmahasiswa'],2,',','.'); ?></td>
                            <?php } ?>
                            <td><?php echo $diff; ?></td>
                            <td><?php echo $row['jumlah']; ?></td>
                            <td><?php echo "Rp " . number_format($tot[]=$total,2,',','.');  ?></td>
                            <td><?php echo $row['keterangan']; ?></td>
                        </tr>
                        <?php } ?>
                        <tr class="text-center">
                        <td colspan="8">Total Pembayaran : <?php echo "Rp " . number_format(array_sum($tot),2,',','.');?></td>
                        </tr>
                        </tbody>
                    </table>
                    
                    <!-- ADMIN -->
                    <?php if($_SESSION['jenis_user']=='Admin' && $status_harga == "Disetujui Peminjam" && $status_peminjaman == "Disetujui Divisi Rumah Tangga") {?>
                        <a class="btn btn-warning w-100" href="peminjaman_sedang.php">Back</a>
                    <?php } else if($_SESSION['jenis_user']=='Admin' && $status_harga == null && $status_peminjaman == "Diajukan") {?>
                        <a class="btn btn-warning w-100" href="peminjaman_pengajuan_daftar.php">Back</a>
                    <?php } else if(($_SESSION['jenis_user']=='Admin') && ($status_harga == "Ditolak Peminjam" || $status_harga == "Ditolak Divisi Pemasaran" || $status_peminjaman == "Ditolak Divisi Rumah Tangga")) {?>
                        <a class="btn btn-warning w-100" href="peminjaman_ditolak.php">Back</a>
                    <?php } ?>

                    <!-- DIVISI RUMAH TANGGA -->
                    <?php if($_SESSION['jenis_user']=='Divisi Rumah Tangga' && $status_harga == "Disetujui Divisi Pemasaran" && $status_peminjaman == "Disetujui Divisi Rumah Tangga") {?>
                        <div class="col-12 text-center">
                            <form method="POST" action="">
                                <button class="btn btn-primary w-30" type="submit" name="setuju" onclick="return confirm('Anda yakin akan memenyetujui harga peminjaman inventaris ini?')">Setujui Harga</button>
                                <button class="btn btn-danger w-30" type="submit" name="tolakan" onclick="return confirm('Anda yakin akan menolak harga peminjaman inventaris ini?')">Tolak Harga</button>
                                <button class="btn btn-warning w-30" href="peminjaman_pengajuan_daftar.php">Back</button>
                            </form> 
                        </div>
                    <?php }else if($_SESSION['jenis_user']=='Divisi Rumah Tangga' && $status_harga == "Disetujui Peminjam" && $status_peminjaman == "Disetujui Divisi Rumah Tangga") {?>
                        <div class="col-12 text-center">
                            <form method="POST" action="">
                                <button class="btn btn-danger w-30" type="submit" name="dikembalikan" onclick="return confirm('Anda yakin semua inventaris sudah dikembalikan?')">Sudah Dikembalikan</button>
                                <a class="btn btn-warning w-30" href="pengembalian_daftar.php">Back</a>
                            </form> 
                        </div>
                    <?php } else if(($_SESSION['jenis_user']=='Divisi Rumah Tangga') && (($status_harga == "Disetujui Peminjam" || $status_harga == "Diterima Peminjam" ) && $status_peminjaman == "Sudah Dikembalikan")) {?>
                        <a class="btn btn-warning w-100" href="pengembalian_daftar.php">Back</a>
                    <?php } else if(($_SESSION['jenis_user']=='Divisi Rumah Tangga')){ ?>
                        <a class="btn btn-warning w-100" href="peminjaman_daftar.php">Back</a>
                    <?php } ?>

                    <!-- DIVISI PEMASARAN -->
                    <?php if($_SESSION['jenis_user']=='Divisi Pemasaran' && $status_harga == "Disetujui Divisi Pemasaran" && $status_peminjaman == "Disetujui Divisi Rumah Tangga") {?>
                        <div class="col-12 text-center">
                            <form method="POST" action="">
                                <button class="btn btn-primary w-30" type="submit" name="setuju" onclick="return confirm('Anda yakin akan memenyetujui harga peminjaman inventaris ini?')">Setujui Harga</button>
                                <button class="btn btn-danger w-30" type="submit" name="tolakan" onclick="return confirm('Anda yakin akan menolak harga peminjaman inventaris ini?')">Tolak Harga</button>
                                <button class="btn btn-warning w-30" href="peminjaman_pengajuan_daftar.php">Back</button>
                            </form> 
                        </div>
                    <?php } else if(($_SESSION['jenis_user']=='Divisi Pemasaran')) {?>
                        <a class="btn btn-warning w-100" href="peminjaman_daftar.php">Back</a>
                    <?php } ?>

                    <!-- PEMINJAM DI LUAR UKS -->
                    <?php if($_SESSION['jenis_user']=='Peminjam di Luar UKS' && $status_harga == "Disetujui Divisi Pemasaran" && $status_peminjaman == "Disetujui Divisi Rumah Tangga") {?>
                        <div class="col-12 text-center">
                            <form method="POST" action="">
                                <button class="btn btn-primary w-30" type="submit" name="setuju" onclick="return confirm('Anda yakin akan memenyetujui harga peminjaman inventaris ini?')">Setujui Harga</button>
                                <button class="btn btn-danger w-30" type="submit" name="tolakan" onclick="return confirm('Anda yakin akan menolak harga peminjaman inventaris ini?')">Tolak Harga</button>
                                <button class="btn btn-warning w-30" href="peminjaman_pengajuan_daftar.php">Back</button>
                            </form> 
                        </div>
                    <?php } else if($_SESSION['jenis_user']=='Peminjam di Luar UKS'){ ?>
                        <a class="btn btn-warning w-100" href="peminjaman_daftar.php">Back</a>
                    <?php } ?>
                    
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