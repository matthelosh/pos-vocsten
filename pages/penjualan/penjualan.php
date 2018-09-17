    <div class="row clearfix">
      <div class="body">
        <form id="frm_add_item" action="" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="act" value="add_item">
          <div class="col-md-2">
              <input type="text" name="kodepj" id="kodepj" value="<?php echo $kodepj;?>" class="form-control" required disabled>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <div class="form-line">
                <select class="form-control show-tick" data-live-search="true" name="kd_brg" id="barcode" required>
                    <option value="0"> -- Cari Barang -- </option>
                    <?php
                      $sql = mysqli_query($koneksi, "SELECT * FROM barang");
                      while($b = mysqli_fetch_assoc($sql)) {
                        echo "<option value='$b[kd_brg]'>$b[kd_brg] - $b[nama_barang]</option>";
                      }
                    ?>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <div class="form-line">
                <select class="form-control show-tick" data-live-search="true" name="pelanggan" id="pelanggan" required>
                    <option value="Umum"> -- Umum -- </option>
                    <?php
                      $sql = mysqli_query($koneksi, "SELECT * FROM tb_pelanggan");
                      while($b = mysqli_fetch_assoc($sql)) {
                        echo "<option value='$b[id_pelanggan]'>$b[nama]</option>";
                      }
                    ?>
                </select>
              </div>
            </div>
          </div>
          <div class="stok" style="display:none">
            <div class="col-md-1">
                <input type="number" name="stok" value="" placeholder="Stok" class="form-control" required disabled>
            </div>
            <div class="col-md-2">
                <input type="text" name="hrg_jual" placeholder="Harga" value="" class="form-control" required disabled>
            </div>
            <div class="col-md-2">
                <input type="number" name="jml" value="" class="form-control" required>
            </div>
          </div>
          <div class="col-md-1">
              <input type="submit" name="add_item" value="Tambahkan" class="btn btn-primary">
          </div>
        </form>
      </div>
    </div>

    <!-- <div class="row clearfix">
      <div id="meta">
        <div class="form-group">

          <div class="col-sm-3">
            <label for="pelanggan">Pelanggan</label>
            <input type="text" id="pelanggan" name="pelanggan" value="Fulan" class="form-control">
          </div>

        </div>

      </div>
    </div> -->
      <div class="card">
        <div class="header bg-red"><h2>Daftar Barang Belanjaan</h2></div>
        <div class="body" style="background:#fff">
          <div class="table-responsive">
            <table class="table table-bordered table-condensed table-hover" style="font-size:small!important;">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode Barcode</th>
                  <th>Nama Barang</th>
                  <!-- <th>Harga Beli</th> -->
                  <th>Jml</th>
                  <th>Satuan</th>
                  <th>Harga Jual</th>
                  <th>Sub Total</th>
                  <th>Laba</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="daftar_item">

              </tbody>
              <tfoot>
                <tr>
                  <th colspan="6">Grand Total</th><th id="">Rp. <span id="grand_tot"></span></th><th><span id="profitpj"></span></th>
                </tr>
                <tr>
                  <th colspan="6">Uang Bayar</th><th>Rp. <input type="number" id="uang_byr" name="uang_byr" style="color:orange"></th>
                </tr>
                <tr>
                  <th colspan="6">Sisa / Kurang</th><th>Rp. <span id="sisa"></span></th>
                </tr>
              </tfoot>
            </table>
            <div class="form-group">
              <button class="btn btn-primary right-block" id="btn-proses-jual">Proses</button>
          </div>
        </div>
      </div>
