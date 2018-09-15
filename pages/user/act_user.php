<?php
  include '../../konf/db.php';
  $act = isset($_POST['act'])?$_POST['act']:null;
  switch($act) {
    default:
      echo "Aksi User";
    break;
    case "upd_user":
      $id = $_POST['id'];
      $username = $_POST['username'];
      $nama = $_POST['nama'];
      $password = md5($_POST['password']);
      $hp = $_POST['hp'];
      $level = $_POST['level'];
      $foto = $_FILES['foto']['name'];
      $ext = end((explode(".", $foto)));
      $dir = $_FILES['foto']['tmp_name'];
      $img = $username.'.'.$ext;
      if ($_FILES['foto']['name'] == 0 && $_POST['password'] == '') {
        // $upload= move_uploaded_file($dir, "../../images/".$username.".".$ext);
          $sql = mysqli_query($koneksi, "UPDATE user SET username = '$username', nama = '$nama', hp = '$hp', level='$level' WHERE id = '$id'");
          if (!$sql) {
            die('Error:'.mysqli_error($koneksi));
          } else {
            // header('location: ../../index.php?page=user');
          }
      } else if ($_POST['password'] == '' && $_FILES['foto']['name'] > 0) {
        $upload= move_uploaded_file($dir, "../../images/".$username.".".$ext);

        if ($upload) {
          $sql = mysqli_query($koneksi, "UPDATE user SET username = '$username', nama = '$nama', hp = '$hp', level='$level', foto = '$img' WHERE id = '$id'");
          if (!$sql) {
            die('Error:'.mysqli_error($koneksi));
          } else {
            header('location: ../../index.php?page=user');
          }
        }
      } else if ($_FILES['foto']['name'] == 0 && $_POST['password'] == '' ) {
        $sql = mysqli_query($koneksi, "UPDATE user SET username = '$username', nama = '$nama', password = '$password', hp = '$hp', level='$level' WHERE id = '$id'");
        if (!$sql) {
          die('Error:'.mysqli_error($koneksi));
        } else {
          // header('location: ../../index.php?page=user');
        }
      } else {
        $upload= move_uploaded_file($dir, "../../images/".$username.".".$ext);

        if ($upload) {
          $sql = mysqli_query($koneksi, "UPDATE user SET username = '$username', password = '$password',nama = '$nama', hp = '$hp', level='$level', foto = '$img' WHERE id = '$id'");
          if (!$sql) {
            die('Error:'.mysqli_error($koneksi));
          } else {
            // header('location: ../../index.php?page=user');
          }
        }
      }
    break;
    case "del_user":
      $username = $_POST['username'];
      $qry = mysqli_query($koneksi, "DELETE FROM user WHERE username = '$username'");
      if (!$qry) {
        die('Gagal '.mysqli_error($koneksi));
      } else {
        echo 'ok';
      }
    break;
  }



?>
