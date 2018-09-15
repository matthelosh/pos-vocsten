<?php
  date_default_timezone_set("Asia/Jakarta");
  $host = "localhost";
  $user = "root";
  $pass = "";
  $db = "bpm";
  $koneksi = mysqli_connect($host, $user, $pass, $db);
  if (!$koneksi) {
    die("Gagal Nyambung: " . mysqli_connect_error());
  }
  // echo "Tersambung ke DB: " . $db;
  // mysqli_close($koneksi);
?>
