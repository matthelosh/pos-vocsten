<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <h2>
            Tambah Pengguna
        </h2>
      </div>
      <div class="body">
        <form action="" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="act" value="add_user">
          <div class="form-group">
            <div class="form-line">
              <label for="username">Username</label>
              <input type="text" name="username" value="" class="form-control" required>
            </div>
          </div>

          <div class="form-group">
            <div class="form-line">
              <label for="nama">Nama Lengkap</label>
              <input type="text" name="nama" value="" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <div class="form-line">
              <label for="password">Kata Sandi</label>
              <input type="text" name="password" value="" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <div class="form-line">
              <label for="hp">No.HP</label>
              <input type="text" name="hp" value="" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <div class="form-line">
              <label for="foto">Foto</label>
              <input type="file" name="foto" value="" class="form-control" required>
            </div>
          </div>
          <div class="form-group">
            <div class="form-line">
              <label for="level">Foto</label>
              <select name="level" id="level" class="form-control">
                <option value="">--Pilih Level--</option>
                <option value="admin">Admin</option>
                <option value="kasir">Kasir</option>
                <option value="supervisor">Supervisor</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <button class="btn btn-primary center-block" name="add_user" type="submit">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
  if (isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $password = md5($_POST['password']);
    $hp = $_POST['hp'];
    $level = $_POST['level'];
    $foto = $_FILES['foto']['name'];
    $ext = end((explode(".", $foto)));
    $dir = $_FILES['foto']['tmp_name'];
    $upload= move_uploaded_file($dir, "images/".$username.".".$ext);

    if ($upload) {
      $sql = mysqli_query($koneksi, "INSERT INTO user (id,username, password,nama, hp, level, foto) VALUES(NULL, '$username', '$password', '$nama', '$hp', '$level', '$foto')");
      if (!$sql) {
        die('Error:'.mysqli_error($koneksi));
      } else {
        ?>
          <script type="text/javascript">
            alert('User telah ditambahkan.');
            location.href="./index.php?page=user";
          </script>
        <?php
      }
    }
  }
?>
