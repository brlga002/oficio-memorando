<?php $v->layout("dash::_theme"); ?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?= $titulo; ?></h1>
<p class="mb-4"><?= $subTitulo ?></p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="<?= url("assinaturas/novo") ?>" class="btn btn-success btn-circle btn-sm">
            <i class="fas fa-plus"></i>
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Cargo</th>
                    <th>Criado em</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Nome</th>
                    <th>Cargo</th>
                    <th>Criado em</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                <?php foreach ($assinaturas as $modelo): ?>
                    <tr>
                        <td><?= $modelo->nome ?></td>
                        <td><?= $modelo->cargo ?></td>
                        <td><?= formataDataHora($modelo->created_at) ?></td>
                        <td>
                            <a href="<?= url("assinaturas/editar/{$modelo->id}"); ?>" class="btn btn-secondary btn-circle btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" class="btn btn-danger btn-circle btn-sm"
                               data-itemNome="<?= $modelo->nomeModelo; ?>"
                               data-url="<?= url("assinaturas/deletar/{$modelo->id}") ?>">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php $v->start("modal"); ?>
<?php require __DIR__. "/../../../contents/modalDeleteItem.php"; ?>
<?php $v->end(); ?>

<?php $v->start("js"); ?>
<?php require __DIR__ . "/../../../contents/modalDeleteItem.js.php"; ?>


<!-- Page level plugins -->
<script src="<?= url("theme/dash/vendor/datatables/jquery.dataTables.js")?>"></script>
<script src="<?= url("theme/dash/vendor/datatables/dataTables.bootstrap4.min.js")?>"></script>
<!-- Page level custom scripts -->
<script src="<?= url("theme/dash/js/demo/datatables-demo.js")?>"></script>
<?php $v->end() ?>

<?php $v->start("link"); ?>
<!-- Custom styles for this page -->
<link href="<?= url("theme/dash/vendor/datatables/dataTables.bootstrap4.min.css")?>" rel="stylesheet">
<link href="<?= url("theme/dash/vendor/fontawesome-free/css/all.min.css")?>" rel="stylesheet" type="text/css">
<?php $v->end(); ?>





