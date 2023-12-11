<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in (v2)</title> 
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url()?>/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= base_url()?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url()?>/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
  <?php 
      $session = \Config\Services::session();
  ?>
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="../../index2.html" class="h1"><b>Admin</b>LTE</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <?= form_open('login/validateuser') ?>
          <div class="input-group mb-3">
            <input type="email" name="email" id="email" class="form-control <?= $session->getFlashdata('error_email') ? 'is-invalid' : ''; ?>" placeholder="Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user-circle"></span>
              </div>
            </div>
            <?= $session->getFlashdata('error_email') ? "<span class='error invalid-feedback'>".$session->getFlashdata('error_email')."</span>" : ''; ?>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" id="password" class="form-control <?= $session->getFlashdata('error_password') ? 'is-invalid' : ''; ?>" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            <?= $session->getFlashdata('error_password') ? "<span class='error invalid-feedback'>".$session->getFlashdata('error_password')."</span>" : ''; ?>
          </div>
          <div class="text-center mt-2 mb-3">
              <button type="submit" class="btn btn-primary btn-block">Login</button>
          </div>
        <?= form_close() ?>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="<?= base_url()?>/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url()?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url()?>/js/adminlte.min.js"></script>
  </body>
</html>
