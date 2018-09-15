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
    session_start();
    $_SESSION['user'] = $user['username'];
    $_SESSION['level'] = $user['level'];
    $_SESSION['foto'] = $user['foto'];
    $_SESSION['nama'] = $user['nama'];
    echo 'ok';
  }
} else {
  echo 'User Belum terdaftar';
}
?>
