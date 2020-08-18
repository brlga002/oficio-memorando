<?php $v->layout("dash::_theme"); ?>

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><?= $titulo ?></h1>
    <p class="mb-4"><?= $subTitulo ?></p>
    <form class="user" action="<?= $action; ?>" method="post">
        <div class="form-group row">
            <div class="col-sm-4 mb-3 mb-sm-0">
                <label for="nomeTipoDoc">Nome do Tipo</label>
                <input type="text" class="form-control" name="nomeTipoDoc" placeholder="Nome ex: OFÍCIO COREFI" value="">
            </div>
            <div class="col-sm-4 mb-3 mb-sm-0">
                <label for="cargo">Tipo</label>
                <input type="text" class="form-control" name="tipo" placeholder="OFÍCIO" value="">
            </div>
            <div class="col-sm-4 mb-3 mb-sm-0">
                <label for="cargo">Sigla</label>
                <input type="text" class="form-control" name="sigla" placeholder="CRTR19/COREFI" value="">
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-user btn-block">
            Salvar
        </button>
        <hr>
    </form>
