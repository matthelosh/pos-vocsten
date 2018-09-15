<div class="row clearfix">
  <h4 class="page-title">DASHBOARD</h4>
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="info-box bg-pink hover-expand-effect">
        <div class="icon">
            <i class="material-icons">attach_money</i>
        </div>
        <div class="content">
            <div class="text">
              PENJUALAN HARI INI <br>
              <?php
                $today = date('Y-m-d');
                $qry = mysqli_query($koneksi, "SELECT COUNT(*) as jml, SUM(total_trx) as total FROM trx_jual WHERE tgl = '$today'");
                // $count = mysqli_num_rows($qry);
                
                $tot = mysqli_fetch_assoc($qry);
                echo $tot['jml'].' Penjualan<br>';
                echo rupiah($tot['total']).',-';
              ?>
            </div>
            <div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20"></div>
        </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="info-box bg-teal hover-expand-effect">
        <div class="icon">
            <i class="material-icons">attach_money</i>
        </div>
        <div class="content">
            <div class="text">
              LABA HARI INI <br>
              <?php
                $today = date('Y-m-d');
                $qry = mysqli_query($koneksi, "SELECT COUNT(*) as jml, SUM(total_trx) as total FROM trx_jual WHERE tgl = '$today'");
                $qry_profit = mysqli_query($koneksi, "SELECT *,SUM(detil_jual.profit) as laba FROM trx_jual JOIN detil_jual ON detil_jual.no_struk = trx_jual.no_struk WHERE trx_jual.tgl = '$today'");
                // $count = mysqli_num_rows($qry);
                $profit = mysqli_fetch_assoc($qry_profit);
                $tot = mysqli_fetch_assoc($qry);
                echo $tot['jml'].' Penjualan<br>';
                echo rupiah($profit['laba']).',-';
              ?>
            </div>
            <div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20"></div>
        </div>
    </div>
  </div>
</div>
