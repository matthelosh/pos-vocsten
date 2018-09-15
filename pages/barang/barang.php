<?php
  $aksi = isset($_GET['aksi'])?$_GET['aksi']: null;

  switch ($aksi) {
    default:
?>
      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header bg-red">
                    <h2>
                        Data Barang
                    </h2>

                </div>
                <div class="body">
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable" style="font-size:small!important;">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Kode Barcode</th>
                          <th>Nama Barang</th>
                          <!-- <th>Harga Beli</th> -->
                          <th>Stok</th>
                          <th>Satuan</th>
                          <th>Harga Jual</th>
                          <!-- <th>Profit</th> -->
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $sql = mysqli_query($koneksi, "SELECT * FROM barang LEFT JOIN stok ON barang.kd_brg = stok.id_brg");
                          $no = 1;
                          while ($data = mysqli_fetch_assoc($sql)) {


                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $data['kd_brg']; ?></td>
                            <td><?php echo $data['nama_barang']; ?></td>

                            <td>
                              <?php
                                echo $stok = isset($data['jml'])?$data['jml']: '0';
                                echo '&nbsp;<a href="?page=add_stok&id='.$data['kd_brg'].'" class="btn btn-sm btn-warning" title="Tambah Stok">+</a>';
                              ?>
                            </td>
                            <td><?php echo $data['satuan']; ?></td>
                            <td>
                              <?php
                                echo $hrg_jual = isset($data['hrg_jual'])?rupiah($data['hrg_jual']):'-';

                              ?>
                            </td>
                            <td class="text-center">
                              <a href="?page=barang&aksi=edit&id=<?php echo $data['kd_brg'];?>" class="btn btn-sm btn-warning" title="Edit <?php echo $data['nama_barang']?>"><i class="material-icons">edit</i></a>
                              <button  data-kode="<?php echo $data['kd_brg'];?>" class="btn btn-danger btn-sm waves-effect del_barang .js-sweetalert" data-type="confirm" title="Hapus <?php echo $data['nama_barang']?>"><i class="material-icons">delete</i></button>
                            </td>
                        </tr>
                      <?php
                        }
                      ?>
                      </tbody>
                    </table>
                    <a href="?page=barang&aksi=tambah" class="btn btn-primary">Tambah</a>
                  </div>
                </div>
            </div>
          </div>
        </div>
<?php
    break;
    case "tambah":
      include 'pages/barang/comps/form-tambah.php';
    break;
    case "edit":
      include 'pages/barang/comps/form-edit.php';
    break;
    case 'del_barang':
      ?>

      <?php
      break;
  }

?>
