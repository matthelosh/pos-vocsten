<?php $id_brg = isset($_GET['id'])?$_GET['id']:null; ?>
<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="card">
          <div class="header">
            <h2>
                Tambah Stok Barang <?php echo $id_brg; ?>
            </h2>
          </div>
          <div class="body">
            <form action="pages/barang/act_barang.php" method="POST">
              <input type="hidden" name="act" value="add_stok">
              <input type="hidden" name="user" value="<?php echo $_SESSION['user']; ?>">
              <div class="form-group">
                <div class="form-line">
                  <label for="kd_brg">Barang</label>
                  <select class="form-control show-tick" data-live-search="true" name="kd_brg" required>
                      <option value=""> -- Cari Barang -- </option>
                      <?php
                        $sql = mysqli_query($koneksi, "SELECT * FROM barang WHERE kd_brg = '$id_brg'");
                        while($b = mysqli_fetch_assoc($sql)) {
                          echo "<option value='$b[kd_brg]'>$b[kd_brg] - $b[nama_barang]</option>";
                        }
                      ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="form-line">
                  <label for="struk_kulak">Nota Pembelian / Kulak</label>
                  <input type="text" name="kd_struk_kulak" value="" class="form-control" required>
                </div>
              </div>
              <div class="form-group">
                <div class="form-line">
                  <label for="supplier">Supplier</label>
                  <select class="form-control show-tick" data-live-search="true" name="supplier" required>
                      <option value="">-- Pilih Suppplier --</option>
                      <?php
                        $sqls = mysqli_query($koneksi, "SELECT * FROM supplier");
                        while($s = mysqli_fetch_assoc($sqls)) {
                          echo "<option value='$s[kd_supplier]'>$s[nama]</option>";
                        }
                      ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="form-line">
                  <label for="hrg_modal">Harga Modal</label>
                  <input type="number" name="hrg_modal" value="" class="form-control" required>
                </div>
              </div>
              <div class="form-group">
                <div class="form-line">
                  <label for="hrg_jual">Harga Jual</label>
                  <input type="number" name="hrg_jual" value="" class="form-control" required>
                </div>
              </div>
              <div class="form-group">
                <div class="form-line">
                  <label for="jml">Jumlah</label>
                  <input type="number" name="jml" value="" class="form-control" required>
                </div>
              </div>
              <div class="form-group">
                <button class="btn btn-primary center-block" type="submit">Tambah</button>
              </div>
            </form>
          </div>
