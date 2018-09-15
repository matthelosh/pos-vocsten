<?php
include '../../konf/db.php';
$act = isset($_POST['act'])?$_POST['act']:null;
switch($act) {
  case "add_pelanggan":
    $nama = $_POST['nama_pelanggan'];
    $alamat = $_POST['alamat'];
    $telp = $_POST['telp'];
    $email = $_POST['email'];

    $sql = mysqli_query($koneksi, "INSERT INTO tb_pelanggan(id_pelanggan, nama, alamat, telp, email) VALUES(NULL, '$nama', '$alamat', '$telp', '$email')");
    if (!$sql) {
      die('Query Error :' .mysqli_connect_error());
    }
    header('location: ../../index.php?page=pelanggan');
  break;
  case "upd_pelanggan":
    $sql = mysqli_query($koneksi, "UPDATE tb_pelanggan SET nama = '$_POST[nama_pelanggan]',
                                                        alamat = '$_POST[alamat]',
                                                        telp = '$_POST[telp]',
                                                        email = '$_POST[email]'
                                                        WHERE id_pelanggan = '$_POST[id]'");
    if (!$sql) {
      die('Query Gagal '. mysqli_error($koneksi));
    } else {
      header('location: ../../index.php?page=pelanggan');
    }
  break;
  case "del_pelanggan":
    $sql = mysqli_query($koneksi, "DELETE FROM tb_pelanggan WHERE id_pelanggan = '$_POST[id]'");
    if (!$sql) {
      die('Gagal Hapus: '. mysqli_error($koneksi));
    } else {
      echo 'ok';
    }
  break;
}
?>
