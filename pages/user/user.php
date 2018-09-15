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
                        Data Pengguna
                    </h2>

                </div>
                <div class="body">
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable" style="font-size:small!important;">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Username</th>
                          <!-- <th>Harga Beli</th> -->
                          <th>Nama</th>
                          <th>HP</th>
                          <th>Foto</th>
                          <!-- <th>Profit</th> -->
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $sql = mysqli_query($koneksi, "SELECT * FROM user");
                          $no = 1;
                          while ($data = mysqli_fetch_assoc($sql)) {


                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $data['username']; ?></td>

                            <td>
                              <?php
                                echo $data['nama'];
                              ?>
                            </td>
                            <td><?php echo $data['hp']; ?></td>
                            <td>
                              <img class="img-circle" src="images/<?php echo $data['foto'];?>" alt="Foto" height="50px">
                            </td>
                            <td class="text-center">
                              <a href="?page=user&aksi=edit&id=<?php echo $data['username'];?>" class="btn btn-sm btn-warning" title="Edit <?php echo $data['username']?>"><i class="material-icons">edit</i></a>
                              <button  data-kode="<?php echo $data['username'];?>" class="btn btn-danger btn-sm waves-effect del_user .js-sweetalert" data-nama="<?php echo $data['username'];?>" data-type="confirm" title="Hapus <?php echo $data['username']?>"><i class="material-icons">delete</i></button>
                            </td>
                        </tr>
                      <?php
                        }
                      ?>
                      </tbody>
                    </table>
                    <a href="?page=user&aksi=tambah" class="btn btn-primary">Tambah</a>
                  </div>
                </div>
            </div>
          </div>
        </div>
<?php
    break;
    case "tambah":
      include 'pages/user/comps/form-tambah.php';
    break;
    case "edit":
      include 'pages/user/comps/form-edit.php';
    break;

  }

?>
