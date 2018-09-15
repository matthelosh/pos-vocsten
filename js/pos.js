$(document).ready(function() {

  Number.prototype.pad = function(size) {
    var sign = Math.sign(this) === -1 ? '-' : '';
    return sign + new Array(size).concat([Math.abs(this)]).join('0').slice(-size);
  }
  const ribuan = num => {
    const n = String(num),
          p = n.indexOf('.')
    return n.replace(
        /\d(?=(?:\d{3})+(?:\.|$))/g,
        (m, i) => p < 0 || i < p ? `${m}.` : m
    )
}
  // Hapus Data Barang
  $('.del_pelanggan').on('click', function(){
    var id = $(this).data("kode");
    var nama = $(this).data("nama");
    swal({
        title: "Yakin Menghapus"+id+"?",
        text: "Anda akan menghapus pelanggan: "+nama,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yakin, hapus saja!",
        cancelButtonText: "Batal",
        closeOnConfirm: false
    }, function () {
      var tipe;
      var msg;
        $.ajax({
          type: 'post',
          url: './pages/pelanggan/act_pelanggan.php',
          data: {id:id, act:'del_pelanggan'},
          success: function(res) {
            if (res === 'ok') {
              judul = "Berhasil";
              msg = nama+" Telah dihapus dari basis data";
              tipe = 'success';
              swal({title:"Info", text:msg, type:tipe}, function(){
                location.reload();
              });
            } else {
              judul = "Gagal";
              msg = nama+" Gagal dihapus dari basis data" + res;
              tipe = 'danger';
              swal({title:"Info", text:msg, type:tipe}, function(){
                location.reload();
              });
            }

          }
        })
      // swal({title:"Info", text:msg, type:tipe}, function(){
      //   location.reload();
      // });
      // setTimeout(function(){
      //   location.reload();
      // }, 1000);

    });

  });

  // Hapus Data Pelanggan
  $('.del_barang').on('click', function(){
    var kd_brg = $(this).data("kode");
    swal({
        title: "Yakin Menghapus?",
        text: "Anda akan menghapus barang dengan kode: "+kd_brg,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yakin, hapus saja!",
        closeOnConfirm: false
    }, function () {
      var judul, msg, type;
        $.ajax({
          type: 'post',
          url: './pages/barang/act_barang.php',
          data: {kd_brg:kd_brg, act:'del_barang'},
          success: function(res) {
            if (res === 'ok') {
              judul = "Berhasil";
              msg = kd_brg+" Telah dihapus dari basis data";
              type = 'success';
              swal({title:judul, text:msg, type:type}, function(){
                location.reload();
              });
            } else {
              judul = "Gagal";
              msg = kd_brg+" Gagal dihapus dari basis data" + res;
              type = 'danger';
              swal({title:judul, text:msg, type:type}, function(){
                location.reload();
              });
            }

          }
        })
      // swal("Info", "Berhasil menghapus "+kd_brg, "success");
      // location.reload();
    });

  });


  // Delete User
  $('.del_user').on('click', function(){
    var id = $(this).data("kode");
    var nama = $(this).data("nama");
    swal({
        title: "Yakin Menghapus?",
        text: "Anda akan menghapus Pengguna dengan nama: "+nama,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yakin, hapus saja!",
        closeOnConfirm: false
    }, function () {
      var judul, msg, type;
        $.ajax({
          type: 'post',
          url: './pages/user/act_user.php',
          data: {username: nama, act:'del_user'},
          success: function(res) {
            if (res === 'ok') {
              judul = "Berhasil";
              msg = nama+" Telah dihapus dari basis data";
              type = 'success';
              swal({title:judul, text:msg, type:type}, function(){
                location.reload();
              });
            } else {
              judul = "Gagal";
              msg = nama+" Gagal dihapus dari basis data" + res;
              type = 'warning';
              swal({title:judul, text:msg, type:type}, function(){
                location.reload();
              });
            }

          }
        })
      // swal("Info", "Berhasil menghapus "+kd_brg, "success");
      // location.reload();
    });

  });

  // penjualan
  // Get Stok & Harga
  $('#barcode').on('change', function(){
    var kode = $('#barcode').val();
    // var jml = $("input[name='jml']").val()
    $.ajax({
      type: 'post',
      url: './pages/penjualan/act_penjualan.php',
      data: {act: 'cek_stok', barcode: kode},
      dataType: 'json',
      success: function(res) {
        if (res.msg === 'no_stok') {
          swal('Peringatan', 'Stok barang: '+kode+' kosong.', 'warning');
          $('.stok').toggle();
        } else {
          $("input[name='stok']").val(res.msg.jml);
          $("input[name='hrg_jual']").val(res.msg.hrg_jual);
          $("input[name='jml']").focus();
        }
      }
    });
    $('.stok').show();
  });


  $('#frm_add_item').on('submit', function(e) {
    e.preventDefault();
    var user = $(".name").text();
    var stok = Number($("input[name='stok']").val());
    var jml = Number($("input[name='jml']").val());
    if (jml > stok) {
      swal("Info", "Jumlah permintaan melebihi stok yang ada.", "warning");
      return false;
    }

    var data = {
      user: user,
      act: $("input[name='act']").val(),
      kodepj: $("input[name='kodepj']").val(),
      barcode: $("select[name='kd_brg']").val(),
      jml_item: $("input[name='jml']").val()
    }

    $.ajax({
      type: 'post',
      url: './pages/penjualan/act_penjualan.php',
      data: data,
      dataType: 'json',
      success: function(res) {
        if (res.msg === 'item_exists') {
          swal("Info", "Item "+ data.barcode+ " sudah ada dlm keranjang. Untuk menambah / mengurangi, ganti jumlah pada tabel di bawah.", "warning");

          get_tmp_jual();
        } else if (res.msg === 'ok') {
          $('#barcode').val(0);
          get_tmp_jual();
        }

        // var html='';
        // var no=0;
        // var grandTot=0;
        // // <input type="number" class="jml_item" data-kode="<?php echo $data['kd_brg']; ?>" placeholder="" value="<?php echo $data['jml_item']; ?>" style="color:orange">
        // res.forEach(function(item){
        //   no++;
        //   html += "<tr><td>"+no+"</td><td>"+item.barcode+"</td><td>"+item.nama_barang+"</td><td><input type='number' class='jml_item' data-kode='"+item.barcode+"' value='"+item.jml_item+"' style='color:orange'></td><td>"+item.satuan+"</td><td>"+item.hrg_jual+"</td><td>"+item.sub_total+"</td></tr>";
        //   grandTot +=Number(item.sub_total);
        // });

        // $('#daftar_item').html(html);
        // $('#grand_tot').text(grandTot);





        // $("input[name='stok']").val("");
        // $("input[name='hrg_jual']").val("");
        // $('#barcode').prop('selectedIndex',0);
        // $(".stok").hide();
      }
    })
  });

  function get_tmp_jual(){
    $.ajax({
      type: 'post',
      url: './pages/penjualan/act_penjualan.php',
      data: {act: 'get_tmp_jual', user: $('.name').text()},
      dataType: 'json',
      success: function(res) {
        var html='';
        var no=0;
        var grandTot=0;
        // <input type="number" class="jml_item" data-kode="<?php echo $data['kd_brg']; ?>" placeholder="" value="<?php echo $data['jml_item']; ?>" style="color:orange">
        res.data.forEach(function(item){
          no++;
          html += "<tr><td>"+no+"</td><td>"+item.barcode+"</td><td>"+item.nama_barang+"</td><td><input type='number' class='jml_item' data-kode='"+item.barcode+"' value='"+item.jml_item+"' style='color:orange'></td><td>"+item.satuan+"</td><td>Rp."+item.hrg_jual+"</td><td>Rp."+item.sub_total+"</td><td class=profit>"+item.profit+"</td><td><button class='btn btn-danger del_item' data-kode='"+item.barcode+"'><i class='material-icons'>delete</i></button></td></tr>";
          grandTot +=Number(item.sub_total);
        });
        // console.log(res);
        $('#daftar_item').html(html);
        $('#grand_tot').text(grandTot);
        $('#profitpj').text(res.profits.profits);
        $("input[name='stok']").val("");
        $("input[name='hrg_jual']").val("");
        $('#barcode').val("0");
        $(".stok").hide();
        console.log(res.profits.profits);
      }
    });
  }

  $('body').on('keyup', '#uang_byr', function(){
    var grandT = Number($('#grand_tot').text());
    var bayar = Number($('#uang_byr').val());
    var sisa = bayar-grandT;
    sisa = sisa;
    $('#sisa').html(sisa);

  });
  $('body').on('click', '.del_item', function(){
    var barcode = $(this).data("kode");
    var no_struk = $("input[name='kodepj']").val();
    swal({
        title: "Yakin Menghapus?",
        text: "Anda akan membatalkan pembelian item: "+barcode,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yakin, hapus saja!",
        closeOnConfirm: false
    }, function () {
      $.ajax({
        type: 'post',
        url: './pages/penjualan/act_penjualan.php',
        data: {act: 'del_item', barcode: barcode, no_struk:no_struk},
        success: function(res) {
          if ( res !== 'Item berhasil dihapus') {
            swal("Info", res, "warning");
          } else {
            swal("Info", "Item: "+barcode+" dibatalkan.", "success");
            get_tmp_jual();
          }
        }
      });
    })
  });

  // Perubahan jumlah item
  $('body').on('change', '.jml_item', function(e){
    e.preventDefault();
    var jml = $(this).val();
    var barcode = $(this).data("kode");
    var kodepj = $('#kodepj').val();
    $.ajax({
      type: 'post',
      url: './pages/penjualan/act_penjualan.php',
      data: {act: 'upd_jml_item', barcode: barcode, kodepj:kodepj, jml:jml, user: $('.name').text()},
      dataType: 'json',
      success: function(res){
        // var mySubTot = $(this).closest('.subtot').css({"background":"red", "color": "white"});
        // alert(mySubTot.text());
        get_tmp_jual();
        // console.log(res);

      }
    });

  });

  // Proses Jual
  $('body').on('click', '#btn-proses-jual', function(){
    var data ='';
    var jmlItem = '';
    var tanggal = new Date();
    var kasir = document.getElementsByClassName('name');
    $.ajax({
      type: 'post',
      url: './pages/penjualan/act_penjualan.php',
      data: {
              act:'proses_jual',
              noFaktur: $("input[name='kodepj']").val(),
              tglJual: tanggal.getFullYear()+'-'+(tanggal.getMonth()+1)+'-'+tanggal.getDate(),
              // pelanggan: $('#pelanggan').val(),
              // keterangan: $('#keterangan').val(),
              grandTotal: $('#grand_tot').html(),
              uangByr: $('#uang_byr').val(),
              uangKembali: $('#sisa').html(),
              kasir: kasir[0].textContent
            },
      dataType: 'json',
      success: function(res) {
        jmlItem = res.length;
        res.forEach(function(item){
          data +=item.nama_barang+'<br>'+item.jml_item+' &nbsp;&nbsp;&nbsp;&nbsp;'+item.satuan+' &nbsp;&nbsp;&nbsp;&nbsp;'+item.hrg_jual+' &nbsp;&nbsp;&nbsp;&nbsp;'+item.sub_total+'<br>';
        });
        // console.log(data);
      }
    });
    
  setTimeout(function(){
      var newWin=window.open('','Print-Window');

      var logo = '';

      var content = `
                    <table style=\"font-size:8pt;\"><tr><td rowspan=\"3\">
                    <img class=\"logo\" src=\"images/logo-bpm.jpg\" width=\"50px\"
                    ></td>
                    <td><strong>BPM Vocsten</strong></td></tr>
                    <tr><td colspan=\"2\" \">Jl. Raya Tlogowaru - Kedungkandang - Malang</td></tr>
                    <tr><td colspan=\"2\">Telp. (0341)786567</td></tr></table>
                    <hr>
                    `+tanggal.getDate()+`-`+tanggal.getMonth()+`-`+tanggal.getFullYear()+`
                    No.Struk:`+document.getElementById('kodepj').value+`
                    <br>Kasir:`+kasir[0].textContent+` - Untuk Pembeli<br>
                    <hr>
                    `+data+`
                    <br><br>
                    `+tanggal.getHours()+`:`+tanggal.getMinutes()+`:`+tanggal.getSeconds()+`&nbsp;&nbsp;&nbsp;&nbsp;Jumlah: Rp.`+document.getElementById('grand_tot').innerText+`<br>
                    Item : `+jmlItem+` &nbsp;&nbsp;&nbsp;&nbsp; Jml Uang: Rp. `+document.getElementById('uang_byr').value+`<br>
                    Kembali/Kurang: Rp.`+document.getElementById('sisa').innerText+`
                    <hr>
                    Barang yang sudah dibeli tidak dapat ditukar / dikembalikan.<br>
                    \"Terima Kasih\"
      <br>`;
      var adm = `<strong>BPM Vocsten</strong>
                    <br>Jl. Raya Tlogowaru - Kedungkandang - Malang
                    <br>(0341)786567
                    <hr>
                    `+tanggal.getDate()+`-`+tanggal.getMonth()+`-`+tanggal.getFullYear()+`
                    No.Struk:`+document.getElementById('kodepj').value+`
                    <br>Kasir:`+kasir[0].textContent+` - Untuk Admin<br>
                    <hr>
                    `+data+`
                    <br><br>
                    `+tanggal.getHours()+`:`+tanggal.getMinutes()+`:`+tanggal.getSeconds()+`&nbsp;&nbsp;&nbsp;&nbsp;Jumlah: Rp.`+document.getElementById('grand_tot').innerHTML+`<br>
                    Item : `+jmlItem+` &nbsp;&nbsp;&nbsp;&nbsp; Jml Uang: Rp. `+document.getElementById('uang_byr').value+`<br>
                    Kembali/Kurang: Rp.`+document.getElementById('sisa').innerHTML+`
      <br>`;
      var style = `
          body {
            background: red;
          }
      `;
      var judul = 'Struk '+document.getElementById('kodepj').value;
      var html = `<html><head><title>`+judul+`</title><style>
      *{
        font-family: courier;
      }
      @page{
        size: 10cm auto;
        margin:20px;
      }
      @media print {
        body{
          width: 8cm;
          height: auto;
        }
        html, body {
          margin: 0;
          padding: 0;
          font-size: 8pt;
          color: #000;
        }

      }
      </style></head><body>

      `+content+`
      <br>
      ============================================================
      <br>
      `+adm+`
      </body></html>`;

      newWin.document.open();

      newWin.document.write(html);
      setTimeout(function() {
        newWin.print();
        newWin.close();
        window.location.href="index.php?page=barang";
      }, 500);
    },500);

  });
// ><b>Notice</b>:  Undefined index: kode in <b>/opt/lampp/htdocs/pos/pages/penjualan/penjualan.php</b> on line <b>7</b><br />


// Laporan
  // Laporan Penjualan
    // Filter Tanggal
    $('#filter-head').click(function(){
      $('.filter-box').slideToggle();
    })

    // Button Filter
    $('#btn-filter-jual').on('click', function(e){
      e.preventDefault();
      // var dateEnd;
      var dateStart = $('#tgl_mulai').val();
      var dateEnd = $('#tgl_akhir').val();
      // alert(dateStart+'-'+dateEnd);
      if (dateStart == null || dateStart == '') {
        swal('Perhatian', 'Pilih Tanggal Awal Dulu', 'warning');
      } else {
        $.ajax({
          type: 'post',
          url: './pages/laporan/act_laporan.php',
          data: {act: 'lap_jual_range', tgl_awal: dateStart, tglAkhir: dateEnd},
          dataType: 'json',
          success: function(res) {
            var rows;
            res.forEach(function(item) {
              rows += `
                <tr>
                  <td>`+item.tgl+`</td>
                  <td>`+item.no_struk+`</td>
                  <td>`+item.total_trx+`</td>
                  <td>`+item.lunas+`</td>
                  <td>`+item.user+`</td>
                  <td><button class="btn btn-sm bg-pink" data-toggle="modal" data-target="#modal-detil-penjualan"><i class="material-icons">search</i></td>
                </tr>
              `;
            })
            $('#dt_lap_jual').html(rows);
          }
        })
      }
    })

$('#reset').on('click', function(e) {
  e.preventDefault();
  window.location.reload();
});

$('.view-detil-jual').on('click', function(){
  // data-toggle="modal" data-target="#modal-detil-penjualan"
  var struk = $(this).closest('tr').find('td.ref').text();
  var theUser = $(this).closest('tr').find('td.theUser').text();
  var theTgl = $(this).closest('tr').find('td.theTgl').text();
  var li_detil = '';
  var grandTot;
  $.ajax({
    type: 'post',
    url: './pages/laporan/act_laporan.php',
    data: {act: 'get_detil_jual', ref: struk},
    dataType: 'json',
    success: function (res) {
      res.list.forEach(function(item) {
        li_detil += `<tr>
                    <td>`+item.kd_brg+`</td>
                    <td>`+item.nama_barang+`</td>
                    <td>`+item.jml_item+`</td>
                    <td>`+item.satuan+`</td>
                    <td>`+item.sub_tot+`</td>
        
        </tr>`;
      });
      $('#li_detil').html(li_detil);
      $('#grand_detil').html(res.total.total);
    }
  })

  $('.refModal').html(struk);
  $('.petugas').html(theUser);
  $('.tanggal').html(theTgl);
  $('#modal-detil-penjualan').modal();
})
$('.view-detil-kulak').on('click', function(){
  // data-toggle="modal" data-target="#modal-detil-penjualan"
  var struk = $(this).closest('tr').find('td.ref').text();
  var theUser = $(this).closest('tr').find('td.theUser').text();
  var theTgl = $(this).closest('tr').find('td.theTgl').text();
  var li_detil = '';
  var grandTot;
  $.ajax({
    type: 'post',
    url: './pages/laporan/act_laporan.php',
    data: {act: 'get_detil_beli', ref: struk},
    dataType: 'json',
    success: function (res) {
      res.list.forEach(function(item) {
        li_detil += `<tr>
                    <td>`+item.kd_brg+`</td>
                    <td>`+item.nama_barang+`</td>
                    <td>`+item.hrg_modal+`</td>
                    <td>`+item.jml_item+`</td>
                    <td>`+item.satuan+`</td>
                    <td style="text-align:right">`+ribuan(item.sub_tot)+`</td>
        
        </tr>`;
      });
      $('#li_detil').html(li_detil);
      $('#grand_detil').html(ribuan(res.total));
    }
  })

  $('.refModal').html(struk);
  $('.petugas').html(theUser);
  $('.tanggal').html(theTgl);
  $('#modal-detil-penjualan').modal();
});
$('body').on('click', '#btn_print_detil',function(e){
  // e.preventDefault();
  var detil = document.getElementById('detil-item-kulak').innerHTML;
  var newWin=window.open('','Print-Window');
  var ref = $('.refModal').text();
  var tgl = document.getElementsByClassName('tanggal');
  var user = $('.petugas');
  var html = `
  <html>
    <head>
      <title>Detil Pembelian Nota: `+ref+`</title>
      <style>
        table{
          border-collapse:collapse;
          font-family: sans-serif;
          width: 80%;
          margin: 0 auto;
        }
        table tbody tr:nth-child(odd) {
          background: #ccc;
        }
        table tbody tr:nth-child(even) {
          background: #efefef;
        }
        .no-space{
          margin:0;
          padding:0;
          text-align: center;
          font-family: sans-serif;
        }
        // p{
        //   margin:0;
        //   padding:0;
        //   text-align: center;
        // }
      </style>
      </head>
    <body>
      <header style="width:80%;margin: auto;">
        <tr>
          <td align=center>
          <img src=\"images/logo-bpm.jpg\" width=\"75px\" style="position: absolute;top: 25px;left: 15%;">
          </td>
          <td>
          <h4 class="no-space">Detil Pembelian</h4>
          <h3 class="no-space">BPM SMKN 10 Malang</h3>
          <p class="no-space">Tanggal Pembelian: `+tgl[0].innerText+`</p>
          <p class="no-space">Petugas: `+user[0].innerText+`</p>
          <p class="no-space">Nota: <b>`+ref+`</b></p>
          </td>
        </tr>
      </header>
      <table border=1>`+detil+`</table>
    </body>
  </html>
  
  `;
  newWin.document.open();
  newWin.document.write(html);
  setTimeout(function(){
    newWin.print();
    newWin.close();
  }, 500);
  
  // window.location.href="index.php?page=barang";
  // alert(e);
});

$('#prn_detil_jual').on('click', function(){
  var data = document.getElementById('tbl_detil_jual').outerHTML;
  var win = window.open('', 'Detil Penjualan');

  var ref = $('.refModal').text();
  var tgl = document.getElementsByClassName('tanggal');
  var user = $('.petugas');
  var html = `
  <html>
    <head>
      <title>Detil Pembelian Nota: `+ref+`</title>
      <style>
        table{
          border-collapse:collapse;
          font-family: sans-serif;
          width: 80%;
          margin: 0 auto;
        }
        table tbody tr:nth-child(odd) {
          background: #ccc;
        }
        table tbody tr:nth-child(even) {
          background: #efefef;
        }
        .no-space{
          margin:0;
          padding:0;
          text-align: center;
          font-family: sans-serif;
        }
        // p{
        //   margin:0;
        //   padding:0;
        //   text-align: center;
        // }
      </style>
      </head>
    <body>
      <header style="width:80%;margin: auto;">
        <tr>
          <td align=center>
          <img src=\"images/logo-bpm.jpg\" width=\"75px\" style="position: absolute;top: 25px;left: 15%;">
          </td>
          <td>
          <h4 class="no-space">Detil Penjualan</h4>
          <h3 class="no-space">BPM SMKN 10 Malang</h3>
          <p class="no-space">Tanggal Pemjualan: `+tgl[0].innerText+`</p>
          <p class="no-space">Petugas: `+user[0].innerText+`</p>
          <p class="no-space">Nota: <b>`+ref+`</b></p>
          </td>
        </tr>
      </header>
      <table border=1>`+data+`</table>
    </body>
  </html>`;
  win.document.open();
  win.document.write(html);
  win.print();
  win.close();
});


// DataTables
    $('.dtTable').DataTable({
      dom: '<"top"Bf><"bottom"rtlp><"clear">',
      buttons: [
          
        'copy',
        'excel',
        'csv',
        'pdf',
        'print'
          
      ],
      "ordering": false
    });

});
