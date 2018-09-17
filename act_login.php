<?php
// session_start();
include 'konf/db.php';

$username = $_POST['username'];
$password = md5($_POST['password']);

$sql = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");
if (mysqli_num_rows($sql) > 0) {
  $user = mysqli_fetch_assoc($sql);
  if($user['password'] !== $password) {
    echo 'Password, tidak sesuai. Coba lagi.';
  } else {
    $cek_log = mysqli_query($koneksi, "SELECT * FROM access_log WHERE user = '$username' AND isActive = '1'");
    if (mysqli_num_rows($cek_log) > 0) {
      echo 'Maaf! Anda tidak boleh masuk. User: '. $username .' sedang aktif.';
    } else {
      session_start();
      // $qry = mysqli_query($koneksi, "UPDATE access_log SET isActive = '1' WHERE user = '$username'");
      $_SESSION['user'] = $user['username'];
      $_SESSION['level'] = $user['level'];
      $_SESSION['foto'] = $user['foto'];
      $_SESSION['nama'] = $user['nama'];
      echo 'ok';
    }
  }
} else {
  echo 'User Belum terdaftar';
}
?>
