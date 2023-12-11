
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aplikasi Siakad</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= base_url()?>/plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url()?>/css/adminlte.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url()?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url()?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url()?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?= base_url()?>/plugins/daterangepicker/daterangepicker.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?= base_url()?>/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

  <!-- Select2 -->
  <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

  <!-- jQuery -->
  <script src="<?= base_url()?>/plugins/jquery/jquery.min.js"></script>

  <!-- DataTables  & Plugins -->
  <script src="<?= base_url()?>/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= base_url()?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url()?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?= base_url()?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?= base_url()?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="<?= base_url()?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="<?= base_url()?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="<?= base_url()?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="<?= base_url()?>/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <!-- InputMask -->
  <script src="<?= base_url()?>/plugins/moment/moment.min.js"></script>
  <script src="<?= base_url()?>/plugins/inputmask/jquery.inputmask.min.js"></script>
  <!-- date-range-picker -->
  <script src="<?= base_url()?>/plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Bootstrap -->
  <script src="<?= base_url()?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="<?= base_url()?>/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Select2 -->
  <script src="../../plugins/select2/js/select2.full.min.js"></script>                                

  <!-- Toastr -->
  <link rel="stylesheet" href="<?= base_url()?>/plugins/toastr/toastr.min.css">
  <script src="<?= base_url()?>/plugins/toastr/toastr.min.js"></script>

  <script>
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2()

      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })
    })
  </script>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Group: <?= session()->namagroup ?></span>
          <div class="dropdown-divider"></div>
          <a href="<?= site_url('login/keluar') ?>" class="dropdown-item has-icon text-danger">
            <i class="fas fa-sign-out-alt mr-2"></i> Log Out
          </a>
        </div>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> -->
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url()?>" class="brand-link">
      <span class="brand-text font-weight-light ml-3">Academic System</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?= base_url()?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?= session()->get('namauser') ?></a>
        </div>
      </div>

      <?= $this->include('main/menu') ?>

    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?= $this->renderSection('title') ?></h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <?= $this->renderSection('content') ?>
      </div>
    </section> 
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- AdminLTE -->
<script src="<?= base_url()?>/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="<?= base_url()?>/plugins/chart.js/Chart.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.css">
</body>
</html>
