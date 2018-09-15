<?php
  function rupiah($angka) {
    $hasil = "Rp. ".number_format($angka,0,',','.');
    return $hasil;
  }
  function kode_random($length) {
    $data = '1234567890ABCDEF';
    $string = 'PJ-';
    for ($i=0;$i < $length; $i++) {
      $pos = rand(0, strlen($data)-1);
      $string .= $data{$pos};
    }

    return $string;
  }
  $kodepj = kode_random(10);

  function set_stok($koneksi, $kd_brg, $jml) {
    $sql = mysqli_query($koneksi, "UPDATE stok SET jml = jml+'$jml' WHERE id_brg = '$kd_brg'");
  }

  function take_stok($koneksi, $kd_brg, $jml) {
    $sql = mysqli_query($koneksi, "UPDATE stok SET jml = jml-'$jml' WHERE id_brg = '$kd_brg'");
  }

  // function cek_stok() {
  //   $qry = mysqli_query($koneksi, "SELECT * FROM stok JOIN barang ON stok.id_brg=barang.kd_brg WHERE jml <= 10");
  //   $jml = mysqli_num_rows($qry);
  //   $list = [];
  //   while($r = mysqli_fetch_assoc($qry)) {
  //     array_push($list, (["kd_brg"=>$r['kd_brg'], "nama_barang"=>$r['nama_barang']]));
  //   }
  // }
?>
