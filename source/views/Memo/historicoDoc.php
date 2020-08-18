<?php $v->layout("dash::_theme"); ?>
<?= $cardDocumento ?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?= $titulo ?></h1>
<p class="mb-4"><?= $subTitulo ?></p>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Ação</th>
                    <th>Data</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Nome</th>
                    <th>Ação</th>
                    <th>Data</th>
                </tr>
                </tfoot>
                <tbody>
                <?php foreach ($historicos as $historico): ?>
                    <tr>
                        <td><?= $historico->getNome() ?></td>
                        <td><?= $historico->acao ?></td>
                        <td><?= formataDataHora($historico->created_at) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php $v->start("modal"); ?>
<!-- Modal Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Deseja deletar?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Selecione "Deletar" abaixo se caso queira deletar o memo: <p><strong id="nomeMemo"></strong></p>.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger" id="urlDeletarMemo" href="#">Deletar <i class="fas fa-trash"></i></a>
            </div>
        </div>
    </div>
</div>
<!-- Modal Delete -->
<?php $v->end(); ?>

<?php $v->start("js"); ?>
<!-- JS Delete -->
<script>
    $(function () {
        $("body").on("click", "[data-memo]", function (e) {
            e.preventDefault();
            var data = $(this).data();
            var urlDeletarMemo = $("#urlDeletarMemo");
            var nomeMemo = $("#nomeMemo");
            urlDeletarMemo.attr("href",data["url"]);
            nomeMemo.html(data["memo"]);
            $("#deleteModal").modal()
        });
    });
</script>
<!-- JS Delete -->

<!-- Page level plugins -->
<script src="<?= url("theme/dash/vendor/datatables/jquery.dataTables.js")?>"></script>
<script src="<?= url("theme/dash/vendor/datatables/dataTables.bootstrap4.min.js")?>"></script>
<!-- Page level custom scripts -->
<script src="<?= url("theme/dash/js/demo/datatables-demo.js")?>"></script>
<?php $v->end() ?>
