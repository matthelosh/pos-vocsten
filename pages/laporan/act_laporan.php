<?php
    include '../../konf/db.php';
    $act = isset($_POST['act'])?$_POST['act']: null;
    switch($act) {
        // Laporan Penjualan
        case "lap_jual_range":
            $tgl_awal = $_POST['tgl_awal'];
            $tgl_akhir = isset($_POST['tgl_akhir'])?$_POST['tgl_akhir']: date('Y-m-d');
            $qry = mysqli_query($koneksi, "SELECT * FROM trx_jual WHERE tgl >= '$tgl_awal' AND tgl <= '$tgl_akhir'");
            $data = [];
            while($res = mysqli_fetch_assoc($qry)) {
                array_push($data, (["tgl"=>$res['tgl'], "no_struk"=>$res['no_struk'], "total_trx"=>$res['total_trx'], "lunas"=>$res['lunas'], "user"=>$res['user']]));
            }
            print_r(json_encode($data));
        break;
        case "get_detil_jual":
            $qry = mysqli_query($koneksi, "SELECT * FROM detil_jual JOIN barang ON detil_jual.kd_brg = barang.kd_brg WHERE no_struk = '$_POST[ref]'");
            $qry1 = mysqli_query($koneksi, "SELECT * FROM tb_pelanggan WHERE id_pelanggan = '$_POST[pelanggan]'");

            $getGrnd= mysqli_query($koneksi, "SELECT total_trx AS total FROM trx_jual WHERE no_struk = '$_POST[ref]'");
            $total = mysqli_fetch_assoc($getGrnd);
            $data = [];

            while($res = mysqli_fetch_assoc($qry)) {
                array_push($data, (["kd_brg"=>$res['kd_brg'], "nama_barang"=>$res['nama_barang'], "satuan"=>$res['satuan'], "jml_item"=>$res['jml_item'], "sub_tot"=>$res['sub_total']]));
            }

            $rPlg = mysqli_fetch_assoc($qry1);
            print_r(json_encode(["list"=>$data, "total"=>$total,"pelanggan"=>$rPlg['nama']]));
        break;
        case "get_detil_beli":
            $qli = mysqli_query($koneksi, "SELECT * FROM trx_kulak JOIN barang ON trx_kulak.kd_brg = barang.kd_brg WHERE trx_kulak.kd_struk_kulak = '$_POST[ref]'");
            $data = [];
            $tot = 0;
            while($res=mysqli_fetch_assoc($qli)) {
                array_push($data, (["kd_brg"=>$res['kd_brg'], "nama_barang"=>$res['nama_barang'], "hrg_modal"=>$res['hrg_modal'],"jml_item"=>$res['jml'], "satuan"=>$res['satuan'], "sub_tot"=>$res['jml']*$res['hrg_modal']]));
                $tot += ($res['jml']*$res['hrg_modal']);
            }
                print_r(json_encode(["list"=>$data, "total"=>$tot]));
        break;
    }
?>