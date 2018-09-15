<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="card">
          <div class="header">
            <h2>
                Tambah Barang
            </h2>
          </div>
          <div class="body">
            <form action="pages/barang/act_barang.php" method="POST">
              <input type="hidden" name="act" value="add_barang">
              <div class="form-group">
                <div class="form-line">
                  <label for="kode">Kode Barcode</label>
                  <input type="text" name="kode" value="" class="form-control" required>
                </div>
              </div>
              <div class="form-group">
                <div class="form-line">
                  <label for="kode">Nama Barang</label>
                  <input type="text" name="nama_barang" value="" class="form-control" required>
                </div>
              </div>
              <div class="form-group">
                <div class="form-line">
                  <label for="satuan">Satuan</label>
                  <select class="form-control show-tick" name="satuan" required>
                      <option value="">-- Pilih Satuan --</option>
                      <option value="Pack">Pack</option>
                      <option value="Pcs">Pcs</option>
                      <option value="Kg">Kg</option>
                      <option value="Box">Box</option>
                      <option value="Dus">Dus</option>
                      <option value="Kantong">Kantong</option>
                      <option value="Btl">Btl</option>
                      <option value="Lusin">Lusin</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="form-line">
                  <label for="jenis">Jenis</label>
                  <select class="form-control show-tick" name="jenis" required>
                      <option value="">-- Pilih Jenis --</option>
                      <?php
                        $sql = mysqli_query($koneksi, "SELECT * FROM jenis");
                        while($j = mysqli_fetch_assoc($sql)) {
                          echo "<option value=$j[kd_jenis]>$j[jenis]</option>";
                        }
                      ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="form-line">
                  <label for="merk">Merk</label>
                  <select class="form-control show-tick" name="merk" required>
                      <option value="">-- Pilih Merk --</option>
                      <?php
                        $sql = mysqli_query($koneksi, "SELECT * FROM merk");
                        while($m = mysqli_fetch_assoc($sql)) {
                          echo "<option value=$m[kd_merk]>$m[merk]</option>";
                        }
                      ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="form-line">
                  <label for="spek">Spesifikasi</label>
                  <textarea rows="1" class="form-control no-resize auto-growth" name="spek" style='max-height: 300px' required></textarea>
                </div>
              </div>
              <div class="form-group">
                <button class="btn btn-primary center-block" type="submit">Simpan</button>
              </div>
            </form>
          </div>
