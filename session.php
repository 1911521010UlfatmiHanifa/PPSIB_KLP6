<?php
    include "koneksi.php";
    if (!isset($_SESSION)) {
      session_start();
      if (!isset($_SESSION["id_user"]) && !isset($_SESSION["nama_lengkap"]) && !isset($_SESSION["foto"]) && ($_SESSION["jenis_user"] == null)) {
        header("Location: login.php");
        exit;
      }
    }
?>