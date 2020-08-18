<?php $v->layout("dash::_theme"); ?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Documentos</h1>
<p class="mb-4">Listagem de documentos emitidos pelo sistema</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="<?= url("documento/novo") ?>" class="btn btn-success btn-circle btn-sm">
            <i class="fas fa-plus"></i>
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Número</th>
                    <th>Tipo</th>
                    <th>Assunto</th>
                    <th>Data</th>
                    <th>Situação</th>
                    <th>Criado em</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Número</th>
                    <th>Tipo</th>
                    <th>Assunto</th>
                    <th>Data</th>
                    <th>Situação</th>
                    <th>Criado em</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                <?php foreach ($documentos as $documento): ?>
                    <tr>
                        <?php $numeroDoc = ($documento->numeroDoc !== "xxxx") ? zeroEsquerda($documento->numeroDoc) : $documento->numeroDoc; ?>
                        <td><a href="<?= url("documento/show/{$documento->id}") ?>" target="_blank" ><?= $numeroDoc ."/".  $documento->anoDoc ?></a></td>
                        <td><a href="<?= url("documento/tipo/{$documento->id_tipoDoc}") ?>"><?= $documento->tipoDoc()->nomeTipoDoc ?></a></td>
                        <td><?= $documento->assuntoDoc ?></td>
                        <td><?= formataData($documento->dataDoc) ?></td>
                        <td><?= $documento->SituacaoDoc()->nomeSituacao ?></td>
                        <td><?= formataDataHora($documento->created_at) ?></td>
                        <td>
                            <a href="#" class="btn btn-secondary btn-circle btn-sm"
                               data-acao="<?= $documento->tipoDoc()->nomeTipoDoc ?> <?= $documento->numeroDoc ."/".  $documento->anoDoc ?> <?= $documento->assuntoDoc ?>"
                               data-urlEditar="<?= url("documento/editar/{$documento->id}") ?>"
                               data-urlAssinar="<?= url("documento/assinatura/{$documento->id}") ?>"
                               data-urlHistoricoDoc="<?= url("documento/historico/{$documento->id}") ?>">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" class="btn btn-danger btn-circle btn-sm"
                               data-itemNome="<?= $documento->tipoDoc()->nomeTipoDoc ?> <?= $documento->numeroDoc ."/".  $documento->anoDoc ?> <?= $documento->assuntoDoc ?>"
                               data-url="<?= url("documento/deletar/{$documento->id}") ?>">
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

    <!-- Modal Ação -->
    <div class="modal fade" id="acaoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Selecione uma ação</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Selecione uma opção para o Doc: <p><strong id="nomeDocAcao"></strong></p>.</div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" id="urlHistoricoDoc" href="#">Histórico</a>
                    <a class="btn btn-primary" id="urlEditarDoc" href="#">Editar</a>
                    <a class="btn btn-primary" id="urlAssinarDoc" href="#">Assinar</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Ação -->
<?php $v->end(); ?>



<?php $v->start("js"); ?>
<?php require __DIR__ . "/../../../contents/modalDeleteItem.js.php"; ?>

<!-- JS Ação -->
<script>
    $(function () {
        $("body").on("click", "[data-acao]", function (e) {
            e.preventDefault();
            var data = $(this).data();
            console.log(data);
            console.log(data["urlhistoricomemo"]);
            var urlEditarDoc = $("#urlEditarDoc");
            var urlAssinarDoc = $("#urlAssinarDoc");
            var urlHistoricoDoc = $("#urlHistoricoDoc");
            var nomeDocAcao = $("#nomeDocAcao");
            urlEditarDoc.attr("href",data["urleditar"]);
            urlAssinarDoc.attr("href",data["urlassinar"]);
            urlHistoricoDoc.attr("href",data["urlhistoricomemo"]);
            nomeDocAcao.html(data["acao"]);
            $("#acaoModal").modal()
        });
    });
</script>

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





