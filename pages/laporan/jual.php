<?php
### Laporan Penjualan
?>
<div class="card">
    <div class="header bg-red">
        <h2 class="card-inside-title">Laporan Penjualan <small>BPM SMKN 10 Malang</small> </h2>
    </div>
    <div class="body">
        <div class="card">
            <div class="header" id="filter-head" style="cursor:pointer">
                <h2>Filter 
                    
                    <span class="pull-right">
                    <i class="material-icons">filter_list</i>
                </span></h2>
            </div>
            <div class="body">
                <div class="row filter-box" style="display:none; background: #999;color: #efefef;padding-top: 20px">
                
                    <form action="" method="post">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="tgl_mulai">Mulai Tanggal</label>
                                <input type="date" class="form-control" id="tgl_mulai" placeholder="YYYY-MM-DD" name="tgl_mulai" required>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="tgl_akhir">Sampai Tanggal</label>
                                <input type="date" class="form-control" id="tgl_akhir" placeholder="YYYY-MM-DD" name="tgl_akhir" required>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="petugas">Petugas</label>
                                <select data-live-search="true" name="user">
                                    <option value=""> -- Petugas -- </option>
                                    <?php
                                        $sql = mysqli_query($koneksi, "SELECT username, nama FROM user");
                                        while($b = mysqli_fetch_assoc($sql)) {
                                        echo "<option value='$b[username]'>$b[nama]</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                            <br>
                                <button class="btn btn-primary" type="submit" id="qbtn-filter-jual"><i class="material-icons">search</i></button>
                            </div>
                        </div>
                        <!-- <div class="col-sm-1">
                            <div class="form-group">
                            <br>
                                <a href="" class="btn btn-danger" id="reset"><i class="material-icons">refresh</i></a>
                            </div>
                        </div> -->
                        </form>
                        <!-- <hr> -->
                        
                </div>
                
                <?php
                if (isset($_POST['tgl_mulai'])){
                    $startDate = $_POST['tgl_mulai'];
                    $date = $_POST['tgl_akhir'];
                    // echo $_GET['tgl_mulai'];
                } else {
                    $startDate = date('Y-m-d');
                    $date = date('Y-m-d');
                }
                ?>
                <div class="row">
                    <div class="table-responsive bg-white">
                    <form action="" method="post" style="padding:0;margin:0">
                    <button class="btn btn-danger" type="submit" name="reset" style="margin:0">
                        <i class="material-icons">refresh</i>
                    </button>
                    <?php $page_title = 'Penjualan '.$startDate .'s/d'.$date; ?>
                    </form>
                        <table class="table table-condensed dtTable" style="font-size: .9em; color:#333;">
                        <caption>Rentang Waktu: <?php echo $startDate .' sampai dengan '.$date; ?></caption>
                            <thead>
                                <tr>
                                    <th>Tanggal</th><th>No. Struk</th><th>Sub Total</th><th>Keterangan</th><th>Pelanggan</th><th>Petugas</th><th>Detil</th>
                                </tr>
                            </thead>
                            <tbody id="dt_lap_jual">
                            <?php 
                                $user = isset($_POST['user'])?$_POST['user']: '';
                                if ($user !== '') {
                                    $qry = mysqli_query($koneksi, "SELECT * FROM trx_jual WHERE tgl >= '$startDate' AND tgl <='$date' AND user = '$_POST[user]'");
                                } else {
                                    $qry = mysqli_query($koneksi, "SELECT * FROM trx_jual WHERE tgl >= '$startDate' AND tgl <='$date'");
                                }
                                $i = 0;
                                
                                while($res = mysqli_fetch_assoc($qry)) {
                                    echo '<tr>
                                        <td class=theTgl>'.$res['tgl'].'</td><td class=ref>'.$res['no_struk'].'</td><td>'.$res['total_trx'].'</td><td>';
                                        echo $ket = ($res['lunas'] == '1')?'Lunas':'Kurang '.$res['sisa'];
                                    echo  '</td><td class=thePelanggan>'.$res['pelanggan'].'</td><td class=theUser>'.$res['user'].'</td><td><button class="btn btn-sm bg-pink view-detil-jual" ><i class="material-icons">search</i></button></td>
                                    </tr>';
                                }
                            ?>
                            
                            </tbody>
                            <tfoot>
                                <?php echo $_GET['tgl_akhir'];?>
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
<div class="modal fade" id="modal-detil-penjualan" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg"  role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">Detil Penjualan <span class="refModal"></span></h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <p>Petugas: <span class="petugas"></span></p>
                                </div>
                                <div class="col-sm-4">
                                    <p>Tanggal Penjualan: <span class="tanggal"></span></p>
                                </div>
                                <div class="col-sm-4">
                                    <p>Pelanggan: <span class="pelanggan"></span></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-condensed table-striped" id="tbl_detil_jual">
                                        <thead>
                                            <tr>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Qty</th>
                                                <th>Satuan</th>
                                                <th>Sub Total</th>
                                            </tr>
                                        </thead>
                                        <tbody id="li_detil">
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4" class="text-right">Grand Total</th>
                                                <th >Rp. <span id="grand_detil"></span></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link waves-effect bg-pink" id="prn_detil_jual"><i class="material-icons" style="color:#efefef">print</i></button>
                            <button type="button" class="btn btn-link waves-effect bg-light-blue" data-dismiss="modal"><i class="material-icons" style="color:#efefef">close</i></button>
                        </div>
                    </div>
                </div>
            </div>

            <?php
                if(isset($_POST['reset'])) {
                    header('location: ?page=laporan-penjualan');
                }
            ?>