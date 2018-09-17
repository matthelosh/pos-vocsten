<?php
include '../../konf/db.php';
include '../../konf/fungsi.php';
$act = isset($_POST['act'])?$_POST['act']:null;

switch ($act) {
  case 'add_item':
    $kode = $_POST['barcode'];
    $cektrx = mysqli_query($koneksi, "SELECT * FROM tmp_jual WHERE kd_brg='$kode' AND user='$_POST[user]'");
    if(mysqli_num_rows($cektrx) > 0){
      $item = mysqli_fetch_assoc($cektrx);
      print_r(json_encode(["msg"=>"item_exists", "ref"=>$item['no_struk']]));
    } else {
      $cek = mysqli_query($koneksi, "SELECT * FROM barang JOIN stok ON barang.kd_brg = stok.id_brg WHERE stok.id_brg = '$kode'");

      $item = mysqli_fetch_assoc($cek);
      $profit = $_POST['jml_item']*($item['hrg_jual'] - $item['hrg_modal']);
      $subtotal = $_POST['jml_item'] * $item['hrg_jual'];


      $sql_insert_tmp = mysqli_query($koneksi, "INSERT INTO tmp_jual (id, no_struk, kd_brg, nama_barang, hrg_modal,hrg_jual, jml_item, satuan, sub_total, profit,user) VALUES(NULL, '$_POST[kodepj]', '$kode', '$item[nama_barang]', '$item[hrg_modal]','$item[hrg_jual]', '$_POST[jml_item]', '$item[satuan]', '$subtotal', '$profit','$_POST[user]' )");
      if(!$sql_insert_tmp){
        die('Error: '. mysqli_error($koneksi));
      } else {
        // take_stok($koneksi, $kode, $_POST['jml_item']);

//         <!-- No	Kode Barcode	Nama Barang	Jml	Satuan	Harga Jual	Sub Total	Aksi
//  -->


                //   $sql = mysqli_query($koneksi, "SELECT * FROM tmp_jual WHERE user='$_POST[user]'");
                //   $no = 1;
                //   $grandTot=0;
                //   $data = [];
                //   while ($res = mysqli_fetch_assoc($sql)) {

                //     $grandTot += $res['sub_total'];
                //     array_push($data, (["kodepj"=>$res['no_struk'], "barcode"=>$res['kd_brg'], "nama_barang"=>$res['nama_barang'], "hrg_jual"=>$res['hrg_jual'], "jml_item"=>$res['jml_item'], "satuan"=>$res['satuan'], "sub_total"=>$res['sub_total']]));
                // }
                // print_r(json_encode($data));

              print_r(json_encode(["msg"=>'ok']));


      }
    }

    break;
  case "cek_stok":
    $kode = $_POST['barcode'];
    // $jml = $_POST['jml'];
    // $item = [];
    $cek = mysqli_query($koneksi, "SELECT * FROM stok WHERE id_brg = '$kode'");
    if (mysqli_num_rows($cek) < 1) {
      print_r(json_encode(["msg"=>'no_stok']));
    } else {
      $brg = mysqli_fetch_assoc($cek);
      print_r(json_encode(["msg"=>$brg]));
    }
    break;
  case "upd_stok_tmp":
      $kd_brg = $_POST['kode'];
      $jml = $_POST['jml'];
      $upd = mysqli_query($koneksi, "UPDATE stok SET jml = jml- '$jml' WHERE id_brg = '$kd_brg'");
      if (!$upd) {
        die('Error: '.mysqli_error($koneksi));
      } else {
        echo 'Stok diubah sementara.';
      }
    break;
  case "get_tmp_jual":


      $sql = mysqli_query($koneksi, "SELECT * FROM tmp_jual WHERE user='$_POST[user]'");
      $qry_profit = mysqli_query($koneksi, "SELECT SUM(profit) AS profits FROM tmp_jual WHERE user='$_POST[user]'");
      $laba = mysqli_fetch_assoc($qry_profit);
      $no = 1;
      $grandTot=0;
      $data = [];
      while ($res = mysqli_fetch_assoc($sql)) {

        $grandTot += $res['sub_total'];
        array_push($data, (["kodepj"=>$res['no_struk'], "barcode"=>$res['kd_brg'], "nama_barang"=>$res['nama_barang'], "hrg_jual"=>$res['hrg_jual'], "jml_item"=>$res['jml_item'], "satuan"=>$res['satuan'], "sub_total"=>$res['sub_total'],"profit"=>$res['profit']]));
    }
    print_r(json_encode(["data"=>$data, "profits"=>$laba]));
    break;
// act: 'del_item', barcode: barcode, no_struk:no_struk
    case "del_item":
        $kd_brg = $_POST['barcode'];
        $no_struk = $_POST['no_struk'];

        $qry = mysqli_query($koneksi, "DELETE FROM tmp_jual WHERE no_struk = '$no_struk' AND kd_brg = '$kd_brg'");
        if (!$qry){
          die('Error :'.mysqli_error($koneksi));
        } else {
          echo 'Item berhasil dihapus';
        }
      break;
  case "proses_jual":
      $qry = mysqli_query($koneksi, "SELECT * FROM tmp_jual JOIN barang ON tmp_jual.kd_brg=barang.kd_brg");
      if (mysqli_num_rows($qry)<1 ) {
        print_r(json_encode(["msg"=>"zonk"]));
      } else {
        // Save to DB
        $no_faktur = filter_input(INPUT_POST, 'noFaktur');
        $tgl_jual = filter_input(INPUT_POST, 'tglJual');
        $pelanggan = filter_input(INPUT_POST, 'pelanggan');
        // $keterangan = filter_input(INPUT_POST, 'keterangan');
        $grand_total = filter_input(INPUT_POST, 'grandTotal');
        $uang_bayar = filter_input(INPUT_POST, 'uangByr');
        $uang_kembali = filter_input(INPUT_POST, 'uangKembali');
        $kasir = filter_input(INPUT_POST, 'kasir');
        $lunas = ($uang_bayar >= $grand_total)?'1':'0';

        $sql = "INSERT INTO trx_jual(id, tgl, no_struk, total_trx, total_byr, sisa, lunas, pelanggan, user) VALUES (NULL, '$tgl_jual', '$no_faktur', '$grand_total', '$uang_bayar', '$uang_kembali', '$lunas', '$pelanggan','$kasir');";
        $sql .= "INSERT INTO detil_jual(no_struk, kd_brg, jml_item, sub_total, profit) SELECT no_struk, kd_brg, jml_item, sub_total, profit FROM tmp_jual;";
        $sql .= "UPDATE stok dest, (SELECT * FROM tmp_jual) src
                  SET dest.jml = dest.jml - src.jml_item WHERE dest.id_brg = src.kd_brg;";
        $sql .= "TRUNCATE TABLE tmp_jual";
        if (mysqli_multi_query($koneksi, $sql)) {
          // Print Struk
          $items = [];
          while($r=mysqli_fetch_assoc($qry)) {
            array_push($items, $r);
          }
          print_r(json_encode($items));
        } else {
          print_r(json_encode(["kode"=>mysqli_errno($koneksi), "msg"=>mysqli_error($koneksi)]));
        }
      }

    break;
  case "upd_jml_item":
      // $profit = $_POST['jml_item']*($item['hrg_jual'] - $item['hrg_modal']);
      $sql = mysqli_query($koneksi, "UPDATE tmp_jual SET jml_item = '$_POST[jml]', sub_total='$_POST[jml]'*hrg_jual,
                                                         profit = '$_POST[jml]' * (hrg_jual - hrg_modal) WHERE no_struk = '$_POST[kodepj]' AND kd_brg = '$_POST[barcode]'");
      if(!$sql){
        print_r(json_encode(["msg"=>mysqli_connect_error($koneksi)]));
        // die('Error: '.mysqli_connect_error($koneksi));
      } else {
        $user = $_POST['user'];
        $sql = mysqli_query($koneksi, "SELECT * FROM tmp_jual WHERE user='$user'");
        $no = 1;
        
        $grandTot=0;
        $data = [];
        while ($res = mysqli_fetch_assoc($sql)) {

          $grandTot += $res['sub_total'];
          array_push($data, (["kodepj"=>$res['no_struk'], "barcode"=>$res['kd_brg'], "nama_barang"=>$res['nama_barang'], "hrg_jual"=>$res['hrg_jual'], "jml_item"=>$res['jml_item'], "satuan"=>$res['satuan'], "sub_total"=>$res['sub_total'], "profit"=>$res['profit']]));
      }
      print_r(json_encode(["data"=>$data]));
      }
    break;
  default:
    echo 'Aksi Penjualan';
    break;
}

function get_tmp_jual($user){
  $sql = mysqli_query($koneksi, "SELECT * FROM tmp_jual WHERE user='$user'");
  $no = 1;
  $grandTot=0;
  $data = [];
  while ($res = mysqli_fetch_assoc($sql)) {

    $grandTot += $res['sub_total'];
    array_push($data, (["kodepj"=>$res['no_struk'], "barcode"=>$res['kd_brg'], "nama_barang"=>$res['nama_barang'], "hrg_jual"=>$res['hrg_jual'], "jml_item"=>$res['jml_item'], "satuan"=>$res['satuan'], "sub_total"=>$res['sub_total']]));
}
print_r(json_encode(["data"=>$data]));
}
?>
