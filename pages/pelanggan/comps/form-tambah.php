<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="card">
          <div class="header">
            <h2>
                Tambah Pelanggan
            </h2>
          </div>
          <div class="body">
            <form action="pages/pelanggan/act_pelanggan.php" method="POST">
              <input type="hidden" name="act" value="add_pelanggan">
              <div class="form-group">
                <div class="form-line">
                  <label for="nama_pelanggan">Nama Pelanggan</label>
                  <input type="text" name="nama_pelanggan" value="" class="form-control" required>
                </div>
              </div>

              <div class="form-group">
                <div class="form-line">
                  <label for="alamat">Alamat</label>
                  <textarea rows="1" class="form-control no-resize auto-growth" name="alamat" style='max-height: 300px' required></textarea>
                </div>
              </div>
              <div class="form-group">
                <div class="form-line">
                  <label for="telp">No. Telepon</label>
                  <input type="text" name="telp" value="" class="form-control" required>
                </div>
              </div>
              <div class="form-group">
                <div class="form-line">
                  <label for="email">Email</label>
                  <input type="text" name="email" value="" class="form-control" required>
                </div>
              </div>

              <div class="form-group">
                <button class="btn btn-primary center-block" type="submit">Simpan</button>
              </div>
            </form>
          </div>
