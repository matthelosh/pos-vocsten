<?php
  session_start();
  include 'konf/db.php';
  include 'konf/fungsi.php';
  include 'konf/global.php';
  if(!isset($_SESSION['user'])) {
    header('location:login.php');
  }
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo $page_title; ?>BPM SMKN 10 Malang</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css"> -->

    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />
    <!-- Sweetalert Css -->
    <link href="plugins/sweetalert/sweetalert.css" rel="stylesheet" />
    <!-- JQuery DataTable Css -->
    <link href="plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
    <!-- Bootstrap Select Css -->
    <link href="plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
    <!-- Animation Css -->
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />
    <!-- Colorpicker Css -->
     <link href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css" rel="stylesheet" />
     <!-- Dropzone Css -->
    <link href="plugins/dropzone/dropzone.css" rel="stylesheet">

    <!-- Multi Select Css -->
    <link href="plugins/multi-select/css/multi-select.css" rel="stylesheet">
    <!-- noUISlider Css -->
    <!-- <link href="plugins/nouislider/nouislider.min.css" rel="stylesheet" /> -->

    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="css/themes/all-themes.css" rel="stylesheet" />
    <link rel="stylesheet" href="plugins/material-icons/material-icons.css">
    <style>
      @font-face {
        font-family: 'Material Icons';
        font-style: normal;
        font-weight: 400;
        src: url(https://example.com/MaterialIcons-Regular.eot); /* For IE6-8 */
        src: local('Material Icons'),
          local('MaterialIcons-Regular'),
          url(plugins/material-icons/MaterialIcons-Regular.woff2) format('woff2'),
          url(plugins/material-icons/MaterialIcons-Regular.woff) format('woff'),
          url(plugins/material-icons/MaterialIcons-Regular.ttf) format('truetype');
        }
    </style>
</head>

<body class="theme-red">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="START TYPING...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="/">
                  <!-- <img src="favicon.jpg" alt="Logo" width="25px"> -->
                  <?php echo 'BPM SMKN 10 Malang'; ?>
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Call Search -->
                    <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>
                    <!-- #END# Call Search -->
                    <!-- Notifications -->
                    <?php 
                        $cek = mysqli_query($koneksi, "SELECT * FROM stok JOIN barang ON stok.id_brg=barang.kd_brg WHERE stok.jml <=10");
                        $jml_alert = mysqli_num_rows($cek);
                    ?>
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">notifications</i>
                            <span class="label-count"><?php echo $jml_alert; ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">NOTIFICATIONS</li>
                            <li class="body">
                                <ul class="menu">
                                    <?php
                                        while($r=mysqli_fetch_assoc($cek)) {
                                            echo "
                                                <li>
                                                    <a href='?page=add_stok&id=".$r['kd_brg']."'>
                                                        <div class=\"icon-circle bg-orange\">
                                                            <i class=\"material-icons\">warning</i>
                                                        </div>
                                                        <div class=\"menu-info\">
                                                            <h4>".$r['nama_barang']."</h4>
                                                            <p style=\"color:red;\">Stok tinggal ".$r['jml']." ".$r['satuan']."</p>
                                                        </div>
                                                    </a>
                                                </li>
                                            ";
                                        }
                                    ?>
                                </ul>
                            </li>
                            
                        </ul>
                    </li>
                    <!-- #END# Notifications -->
                    <li class="pull-right"><a href="?page=settings" class="js-right-sidebar" data-close="true"><i class="material-icons">settings</i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="images/<?php echo $_SESSION['foto']?>" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['user']; ?></div>
                    <div class="email"><?php echo $_SESSION['level']; ?></div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="logout.php"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MENU</li>
                    <li>
                        <a href="index.php">
                            <i class="material-icons">store</i>
                            <span>Home</span>
                        </a>
                    </li>
                    <?php
                      if ($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'kasir') { ?>
                    <li>
                      <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">local_atm</i>
                          <span>Penjualan</span>
                      </a>
                      
                      <ul class="ml-menu">
                      
                        <li>
                            <a href="?page=penjualan">
                                <i class="material-icons">shopping_cart</i>
                                <span>Barang</span>
                            </a>
                        </li>
                        <li>
                            <a href="?page=service">
                                <i class="material-icons">build</i>
                                <span>Jasa Service</span>
                            </a>
                        </li>
                             
                      </ul>  
                    </li>
                    <!--<li>
                        <a href="?page=pelanggan">
                            <i class="material-icons">supervisor_account</i>
                            <span>Pelanggan</span>
                        </a>
                    </li> -->
                    <li>
                      <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">print</i>
                          <span>Cetak Laporan</span>
                      </a>
                      <ul class="ml-menu">
                          <li>
                              <a href="?page=laporan-pembelian">
                                <i class="material-icons">book</i>
                                <span>Pembelian / Kulak</span>
                              </a>
                          </li>
                          <li>
                              <a href="?page=laporan-penjualan">
                                <i class="material-icons">book</i>
                                <span>Penjualan</span>
                              </a>
                          </li>
                          <li>
                              <a href="?page=jurnal">
                                <i class="material-icons">import_contacts</i>
                                <span>Jurnal</span>
                              </a>
                          </li>
                      </ul>
                    </li>

                <?php
                    }
                  if ($_SESSION['level'] == 'admin') { ?>
                   <li>
                      <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">dashboard</i>
                          <span>Data Master</span>
                      </a>
                      <ul class="ml-menu">
                        <li>
                            <a href="?page=barang">
                                <i class="material-icons">view_module</i>
                                <span>Barang</span>
                            </a>
                        </li>
                        <li>
                            <a href="?page=jasa">
                                <i class="material-icons">build</i>
                                <span>Jasa</span>
                            </a>
                        </li>
                        <li>
                            <a href="?page=pelanggan">
                                <i class="material-icons">supervisor_account</i>
                                <span>Pelanggan</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="?page=user">
                                <i class="material-icons">account_circle</i>
                                <span>Pengguna</span>
                            </a>
                        </li>
                        </ul>
                    </li>
                  <?php

                  }
                  if ($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'teknisi') { 
                    ?>
                    <li>
                            <a href="?page=servicing">
                                <i class="material-icons">build</i>
                                <span>Service</span>
                            </a>
                        </li>

                  <?php } ?>
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2018 <a href="mailto:matthelosh@gmail.com">Matthelosh</a> Versi: 0.0.1<br>
                    Berdasarkan <a href="https://github.com/gurayyarar/AdminBSBMaterialDesign">AdminBSB - Material Design.</a>
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.5
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <?php
                  $page = isset($_GET['page'])?$_GET['page']: null;
                  // $aksi = isset($_GET['aksi'])?$_GET['aksi']: null;

                  switch($page) {
                    default:
                      include 'pages/home.php';
                    break;

                    case "barang":
                      include 'pages/barang/barang.php';
                    break;
                    case "jasa":
                      include 'pages/jasa/jasa.php';
                    break;
                    case "add_stok":
                      include 'pages/barang/comps/form_stok.php';
                    break;
                    case "pelanggan":
                      include 'pages/pelanggan/pelanggan.php';
                    break;
                    case "user":
                      include 'pages/user/user.php';
                    break;
                    case "penjualan":
                      include 'pages/penjualan/penjualan.php';
                    break;
                    case "laporan-pembelian":
                      include 'pages/laporan/beli.php';
                    break;
                    case "laporan-penjualan":
                      include 'pages/laporan/jual.php';
                    break;
                    case "jurnal":
                      include 'pages/laporan/jurnal.php';
                    break;
                    case "servicing":
                      include 'pages/teknisi/service.php';
                    break;
                    case "settings":
                      include 'pages/settings.php';
                    break;
                  }
                ?>
            </div>
        </div>
    </section>

    <!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>

    <!-- SweetAlert Plugin Js -->
    <script src="plugins/sweetalert/sweetalert.min.js"></script>

    <!-- Jquery DataTable Plugin Js -->
   <script src="plugins/jquery-datatable/jquery.dataTables.js"></script>
   <script src="plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
   <script src="plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
   <script src="plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
   <script src="plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
   
   <script src="plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
   <script src="plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
   <script src="plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>
   <script src="plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
   <!-- Jquery Validation Plugin Css -->
    <script src="plugins/jquery-validation/jquery.validate.js"></script>
    <!-- Custom Js -->
    <script src="js/admin.js"></script>
    <script src="js/pos.js"></script>
    <script src="js/pages/tables/jquery-datatable.js"></script>
    <script src="js/pages/forms/form-validation.js"></script>
    <script src="js/pages/forms/advanced-form-elements.js"></script>
    <!-- Bootstrap Colorpicker Js -->
    <script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
    <!-- Dropzone Plugin Js -->
    <script src="plugins/dropzone/dropzone.js"></script>

    <!-- Input Mask Plugin Js -->
    <script src="plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>

    <!-- Multi Select Plugin Js -->
    <script src="plugins/multi-select/js/jquery.multi-select.js"></script>
    <!-- Select Plugin Js -->
    <script src="plugins/bootstrap-select/js/bootstrap-select.js"></script>
    <!-- Autosize Plugin Js -->
    <script src="plugins/autosize/autosize.js"></script>
    <!-- noUISlider Plugin Js -->
    <!-- <script src="plugins/nouislider/nouislider.js"></script> -->

    <!-- Demo Js -->
    <script src="js/demo.js"></script>
</body>

</html>
