<?php
    include "session.php";
    $id_peminjaman = $_REQUEST['id_peminjaman'];

    if(isset($_POST['delete'])){
        if(isset($_POST['aksi']) && $_POST['aksi'] == 'hapus'){
            $id_inventaris = $_POST['id_inventaris'];
 
            $stmt=$conn->prepare("DELETE FROM detail_pinjaman WHERE id_inventaris= ? AND id_peminjaman=?");
            $stmt->bind_param('ss', $id_inventaris, $id_peminjaman);
            $stmt->execute();
        
            if($conn->affected_rows > 0){
                $pesan_sukses= "Data inventaris berhasil dihapus!";
            }
            else{
                $pesan_gagal= "Data inventaris gagal dihapus!";
            }
            $stmt->close();
        }
    }

    if(isset($_POST['simpan'])){
        $data = $conn->query("SELECT count(id_inventaris) as id from detail_pinjaman where id_peminjaman=$id_peminjaman");
        while($row1 = $data->fetch_assoc()){
            $brag = $row1['id'];
        }

        if($brag == 0 ){
            $pesan_gagal= "Data inventaris belum ditambahkan!";
        }else{
            header("Location:peminjaman_daftar.php");
        }
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

    <title>Form Tambah Inventaris Pengajuan Peminjaman</title>
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
            <li class="breadcrumb-item">Form Tambah Inventaris Pengajuan Peminjaman</li>
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
                <a href="peminjaman_tambah_ive.php?id_peminjaman=<?php echo $id_peminjaman?>" class="btn btn-outline-info btn-mt">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-plus-circle" viewBox="1 1 15 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                        </svg> Tambah Data Inventaris
                </a><br><br>
                <form class="row g-3 needs-validation" method="post" novalidate enctype="multipart/form-data">
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
                            <th scope="col">Jumlah Inventaris</th>
                            <th scope="col">Jumlah Hari</th>
                            <th scope="col">Total Harga</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Aksi</th>
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
                            <td width="105px" class="text-center">
                            <form method="POST" action="">
                                <input type="hidden" name="aksi" value="hapus">
                                <input type="hidden" name="id_inventaris" value="<?php echo $row['id_inventaris'];?>">
                                <button class="btn btn-outline-danger btn-sm" type="submit" name="delete" onclick="return confirm('Anda yakin akan menghapus data inventaris ini?')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 14 15">
                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                    </svg>
                                </button> 
                            </td>
                            </form>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr class="text-center">
                        <td colspan="8">Total Pembayaran : <?php echo "Rp " . number_format(array_sum($tot),2,',','.');?></td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="col-12">
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