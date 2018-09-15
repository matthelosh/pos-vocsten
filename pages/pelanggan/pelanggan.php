<?php
  $aksi = isset($_GET['aksi'])?$_GET['aksi']: null;

  switch ($aksi) {
    default:
?>
      <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Data Pelanggan
                    </h2>

                </div>
                <div class="body">
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable" style="font-size:small!important;">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama Pelanggan</th>
                          <!-- <th>Harga Beli</th> -->
                          <th>Alamat</th>
                          <th>Telepon</th>
                          <th>Email</th>
                          <!-- <th>Profit</th> -->
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $sql = mysqli_query($koneksi, "SELECT * FROM tb_pelanggan");
                          $no = 1;
                          while ($data = mysqli_fetch_assoc($sql)) {


                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $data['nama']; ?></td>

                            <td>
                              <?php
                                echo $data['alamat'];
                              ?>
                            </td>
                            <td><?php echo $data['telp']; ?></td>
                            <td>
                              <?php
                                echo $data['email'];

                              ?>
                            </td>
                            <td class="text-center">
                              <a href="?page=pelanggan&aksi=edit&id=<?php echo $data['id_pelanggan'];?>" class="btn btn-sm btn-warning" title="Edit <?php echo $data['nama']?>"><i class="material-icons">edit</i></a>
                              <button  data-kode="<?php echo $data['id_pelanggan'];?>" class="btn btn-danger btn-sm waves-effect del_pelanggan .js-sweetalert" data-nama="<?php echo $data['nama'];?>" data-type="confirm" title="Hapus <?php echo $data['nama']?>"><i class="material-icons">delete</i></button>
                            </td>
                        </tr>
                      <?php
                        }
                      ?>
                      </tbody>
                    </table>
                    <a href="?page=pelanggan&aksi=tambah" class="btn btn-primary">Tambah</a>
                  </div>
                </div>
            </div>
          </div>
        </div>
<?php
    break;
    case "tambah":
      include 'pages/pelanggan/comps/form-tambah.php';
    break;
    case "edit":
      include 'pages/pelanggan/comps/form-edit.php';
    break;

  }

?>
