<?php $v->layout("dash::_theme"); ?>
<?= $cardDocumento ?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?= $titulo ?></h1>
<p class="mb-4"><?= $subTitulo ?></p>

<form class="form-inline" action="" method="post">
    <div class="form-group">
        <label for="id_tipomemo" class="mr-sm-2">Assinatura</label>
        <select class="form-control mb-2 mr-sm-2" name="id_assinaturaDisponivel" required>
            <option></option>
            <?php foreach ($assinaturasDiponiveis as $tipo): ?>
                <option value="<?= $tipo->id; ?>">
                    <?= $tipo->cargo; ?>
                </option>
            <?php endforeach ?>
        </select>
        <label for="assuntoMemo" class="mr-sm-2">Senha</label>
        <input type="password" class="form-control mb-2 mr-sm-2" name="password" placeholder="Senha" value="">
        <button type="submit" class="btn btn-primary mb-2">
            Assinar
        </button>
    </div>
</form>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Cargo</th>
                    <th>Assinado em</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Nome</th>
                    <th>Cargo</th>
                    <th>Assinado em</th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                <?php foreach ($assinaturasNoDocumento as $assinatura): ?>
                    <tr>
                        <td><?= $assinatura->nome ?></td>
                        <td><?= $assinatura->cargo ?></td>
                        <td><?= formataDataHora($assinatura->created_at) ?></td>
                        <td>
                            <a href="#" class="btn btn-danger btn-circle btn-sm"
                               data-memo="<?= $assinatura->nome; ?> - <?= $assinatura->cargo; ?> "
                               data-url="<?= url("documento/assinatura/deletar/{$assinatura->id_documento}/{$assinatura->id}") ?>">
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
            <div class="modal-body">Selecione "Deletar" abaixo se caso queira deletar a assinatura: <p><strong id="nomeMemo"></strong></p>.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger" id="urlDeletarMemo" href="#">Deletar <i class="fas fa-trash"></i></a>
            </div>
        </div>
    </div>
</div>
<!-- Modal Delete -->
<?php $v->end(); ?>

<!-- JS Delete -->
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

<!-- Page level plugins -->
<script src="<?= url("theme/dash/vendor/datatables/jquery.dataTables.js")?>"></script>
<script src="<?= url("theme/dash/vendor/datatables/dataTables.bootstrap4.min.js")?>"></script>
<!-- Page level custom scripts -->
<script src="<?= url("theme/dash/js/demo/datatables-demo.js")?>"></script>
<?php $v->end() ?>


