<?php
// include '../../konf/db.php';
$id_pelanggan = isset($_GET['id'])?$_GET['id']:null;
$sql = mysqli_query($koneksi, "SELECT * FROM tb_pelanggan WHERE id_pelanggan = '$id_pelanggan'");
$data = mysqli_fetch_assoc($sql);
?>
<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="card">
          <div class="header">
            <h2>
                Edit Pelanggan: <?php echo $data['nama']; ?>
            </h2>
          </div>
          <div class="body">
            <form action="pages/pelanggan/act_pelanggan.php" method="POST">
              <input type="hidden" name="act" value="upd_pelanggan">
              <input type="hidden" name="id" value="<?php echo $data['id_pelanggan']; ?>">
              <div class="form-group">
                <div class="form-line">
                  <label for="nama_pelanggan">Nama Pelanggan</label>
                  <input type="text" name="nama_pelanggan" value="<?php echo $data['nama']; ?>" class="form-control" required>
                </div>
              </div>

              <div class="form-group">
                <div class="form-line">
                  <label for="alamat">Alamat</label>
                  <textarea rows="1" class="form-control no-resize auto-growth" name="alamat" style='max-height: 300px' required><?php echo $data['alamat'];?></textarea>
                </div>
              </div>
              <div class="form-group">
                <div class="form-line">
                  <label for="telp">No. Telepon</label>
                  <input type="text" name="telp" value="<?php echo $data['telp'];?>" class="form-control" required>
                </div>
              </div>
              <div class="form-group">
                <div class="form-line">
                  <label for="email">Email</label>
                  <input type="text" name="email" value="<?php echo $data['email'];?>" class="form-control" required>
                </div>
              </div>

              <div class="form-group">
                <button class="btn btn-primary center-block" type="submit">Perbarui</button>
              </div>
            </form>
          </div>
