<?php
$username = $_GET['id'];
$sqledit=mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");
$data = mysqli_fetch_assoc($sqledit);
?>

<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <h2>
            Edit Pengguna <?php echo $data['username']; ?>
        </h2>
      </div>
      <div class="body">
        <form action="" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="act" value="upd_user">
          <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
          <div class="form-group">
            <div class="form-line">
              <label for="username">Username</label>
              <input type="text" name="username" value="<?php echo $data['username']; ?>" class="form-control" required>

            </div>
          </div>

          <div class="form-group">
            <div class="form-line">
              <label for="nama">Nama Lengkap</label>
              <input type="text" name="nama" value="<?php echo $data['nama']; ?>" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <div class="form-line">
              <label for="password">Untuk mengubah kata sandi, hubungi super admin.</label>
              <!-- <input type="text" name="password" value="" class="form-control"> -->
            </div>
            <!-- <p class="col-green">*Kosongkan bila tidak ingin merubah password.</p> -->
          </div>
          <div class="form-group">
            <div class="form-line">
              <label for="hp">No.HP</label>
              <input type="text" name="hp" value="<?php echo $data['hp']; ?>" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
              <div class="form-line">
                <label for="foto">Foto</label>
                <input type="file" name="foto" value="" class="form-control">
                <img class="img" width="50px" src="images/<?php echo $data['foto'];?>" alt="Foto">
              </div>
          </div>
          <div class="form-group">
            <div class="form-line">
              <label for="level">Foto</label>
              <select name="level" id="level" class="form-control">
                <option value="">--Pilih Level--</option>
                <option value="admin" <?php echo $selected = ($data['level'] == 'admin')?'selected': '';?>>Admin</option>
                <option value="kasir" <?php echo $selected = ($data['level'] == 'kasir')?'selected': '';?>>Kasir</option>
                <option value="supervisor" <?php echo $selected = ($data['level'] == 'supervisor')?'selected': '';?>>Supervisor</option>
                <option value="teknisi" <?php echo $selected = ($data['level'] == 'teknisi')?'selected': '';?>>Teknisi</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <button class="btn btn-primary center-block" name="upd_user" type="submit">Perbarui</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
if (isset($_POST['upd_user'])) {
  $id = $_POST['id'];
  $username = $_POST['username'];
  $nama = $_POST['nama'];
  $hp = $_POST['hp'];
  $level = $_POST['level'];
  $foto = $_FILES['foto']['name'];
  $ext = end((explode(".", $foto)));
  $dir = $_FILES['foto']['tmp_name'];
  $img = $username.'.'.$ext;

  if(!empty($dir)) {
    $upload = move_uploaded_file($dir, 'images/'.$img);
    if ($upload) {
      $sql = mysqli_query($koneksi, "UPDATE user SET username = '$username',
                                                     nama = '$nama',
                                                     hp = '$hp',
                                                     level = '$level',
                                                     foto = '$img'
                                                     WHERE id = '$id'");
      if ($sql){
        ?>
          <script type="text/javascript">
          // swal({title: "Info", text: "Berhasil memperbarui data pengguna", type: "success"}, function(){
          //   window.location.href="?page=user";
          // });
          alert('Pembaruan berhasil');
          window.location.href="?page=user";
          </script>
        <?php
      } else {
        die('Error :'.mysqli_error($koneksi));
      }
    } else {
      $sql = mysqli_query($koneksi, "UPDATE user SET username = '$username',
                                                     nama = '$nama',
                                                     hp = '$hp',
                                                     level = '$level',
                                                     WHERE id = '$id'");
      if ($sql){
        ?>
          <script type="text/javascript">
          // swal({title: "Info", text: "Berhasil memperbarui data pengguna", type: "success"}, function(){
          //   window.location.href="?page=user";
          // });
          alert('Pembaruan berhasil');
          window.location.href="?page=user";
          </script>
        <?php
      } else {
        die('Error :'.mysqli_error($koneksi));
      }
    }
  }
}
?>
