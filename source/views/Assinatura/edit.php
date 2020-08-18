<?php $v->layout("dash::_theme"); ?>

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><?= $titulo ?></h1>
    <p class="mb-4"><?= $subTitulo ?></p>

    <form class="user" action="<?= $action; ?>" method="post">
        <div class="form-group row">
            <div class="col-sm-5 mb-3 mb-sm-0">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" name="nome" placeholder="Nome" value="<?= $assinatura->nome ?>">
            </div>
            <div class="col-sm-4 mb-3 mb-sm-0">
                <label for="cargo">Cargo</label>
                <input type="text" class="form-control" name="cargo" placeholder="Cargo" value="<?= $assinatura->cargo ?>">
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-user btn-block">
            Salvar
        </button>
        <hr>
    </form>

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
                <div class="modal-body">Selecione "Deletar" abaixo se caso queira deletar o memo: <p><strong id="nomeDoc"></strong></p>.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger" id="urlDeletarDoc" href="#">Deletar <i class="fas fa-trash"></i></a>
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
                var urlDeletarDoc = $("#urlDeletarDoc");
                var nomeDoc = $("#nomeDoc");
                urlDeletarDoc.attr("href",data["url"]);
                nomeDoc.html(data["memo"]);
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