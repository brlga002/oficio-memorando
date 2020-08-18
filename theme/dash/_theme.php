<!DOCTYPE html>
<html lang="pt-br">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?= $title ?></title>

  <!-- Custom fonts for this template-->
  <link href="<?= url("theme/dash/vendor/fontawesome-free/css/all.min.css")?>" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?= url("theme/dash/css/sb-admin-2.min.css")?>" rel="stylesheet">
  <?= $v->section("link") ?>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

      <!-- Sidebar -->
      <?php $v->insert("dash::_sidebar"); ?>
      <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
          <?php $v->insert("dash::_topbar"); ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
            <?php $v->insert("dash::_message"); ?>
          <?= $v->section("content") ?>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy;  2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Pronto para partir?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Selecione "Logout" abaixo se você estiver pronto para terminar sua sessão atual.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
          <a class="btn btn-primary" href="<?= url("login/logout"); ?>">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <?= $v->section("modal") ?>
  <!-- Jquery-->
  <script src="<?= url("theme/dash/js/jquery.js")?>"></script>

  <!-- Bootstrap core JavaScript-->
  <script src="<?= url("theme/dash/vendor/jquery/jquery.min.js")?>"></script>
  <script src="<?= url("theme/dash/vendor/bootstrap/js/bootstrap.bundle.min.js")?>"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?= url("theme/dash/vendor/jquery-easing/jquery.easing.min.js")?>"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= url("theme/dash/js/sb-admin-2.min.js")?>"></script>

  <?= $v->section("js") ?>

</body>

</html>
