<?php
include '../../konf/db.php';
$act = isset($_POST['act'])?$_POST['act']:null;
switch($act) {
  case "add_barang":
    $kd_brg = $_POST['kode'];
    $nama_barang = $_POST['nama_barang'];
    $satuan = $_POST['satuan'];
    $jenis = $_POST['jenis'];
    $merk = $_POST['merk'];
    $spek = $_POST['spek'];

    $sql = mysqli_query($koneksi, "INSERT INTO barang(kd_brg, nama_barang, kd_jenis, kd_merk, spek, satuan) VALUES('$kd_brg', '$nama_barang', '$jenis', '$merk', '$spek', '$satuan' )");
    if (!$sql) {
      die('Query Error :' .mysqli_connect_error());
    }
    header('location: ../../index.php?page=barang');
  break;
  case "add_stok":
    $kd_brg = $_POST['kd_brg'];
    $kd_Struk_kulak = $_POST['kd_struk_kulak'];
    $supplier = $_POST['supplier'];
    $hrg_modal = $_POST['hrg_modal'];
    $hrg_jual = $_POST['hrg_jual'];
    $jml = $_POST['jml'];
    $tgl = date("Y-m-d H:i:s");
    $user = $_POST['user'];

    $cek = mysqli_query($koneksi, "SELECT * FROM stok WHERE id_brg = '$kd_brg'");
    if (mysqli_num_rows($cek) > 0) {
      $j = mysqli_fetch_assoc($cek);
      $jmlOld = $j['jml'];
      $jmlNew = $jmlOld + $jml;
      $sql = "INSERT INTO `trx_kulak` (id, kd_brg, kd_struk_kulak, kd_supplier, hrg_modal, hrg_jual, jml, tgl, user) VALUES (NULL, '$kd_brg', '$kd_Struk_kulak', '$supplier', '$hrg_modal', '$hrg_jual', '$jml', '$tgl', '$user');";
      $sql .= "UPDATE `stok` SET jml = '$jmlNew' WHERE id_brg = '$kd_brg'";
      $save = mysqli_multi_query($koneksi, $sql);
      if ($save) {
        header('location: ../../index.php?page=barang');
      } else {
        die('Query Error :' .mysqli_connect_error($koneksi));
      }
    } else {
      $sql = "INSERT INTO `trx_kulak` (id, kd_brg, kd_struk_kulak, kd_supplier, hrg_modal, hrg_jual, jml, tgl, user) VALUES (NULL, '$kd_brg', '$kd_Struk_kulak', '$supplier', '$hrg_modal', '$hrg_jual', '$jml', '$tgl', '$user');";
      $sql .= "INSERT INTO stok(id, id_brg, hrg_jual, jml) VALUES(NULL, '$kd_brg', '$hrg_jual', '$jml')";
      $save = mysqli_multi_query($koneksi, $sql);
      if ($save) {
        header('location: ../../index.php?page=barang');
      } else {
        die('Query Error :' .mysqli_connect_error($koneksi));
      }
      // echo "Query Check Gagal";
    }
  break;
  case "upd_barang":
    $sql = mysqli_query($koneksi, "UPDATE barang SET kd_brg = '$_POST[kode]',
                                                     nama_barang = '$_POST[nama_barang]',
                                                     kd_jenis = '$_POST[jenis]',
                                                     kd_merk = '$_POST[merk]',
                                                     spek = '$_POST[satuan]',
                                                     satuan = '$_POST[satuan]' WHERE urut = '$_POST[id]'");
    if (!$sql) {
      die('Query Gagal '. mysqli_error($koneksi));
    } else {
      header('location: ../../index.php?page=barang');
    }
  break;
  case "del_barang":
    $sql = mysqli_query($koneksi, "DELETE FROM barang WHERE kd_brg = '$_POST[kd_brg]'");
    if (!$sql) {
      die('Gagal Hapus: '. mysqli_error($koneksi));
    } else {
      echo 'ok';
    }
  break;
}
?>
