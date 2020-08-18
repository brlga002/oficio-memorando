<?php $v->layout("dash::_theme"); ?>

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><?= $titulo ?></h1>
    <p class="mb-4"><?= $subTitulo ?></p>

    <form class="user" action="<?= $action; ?>" method="post">
        <div class="form-group row">
            <div class="col-sm-5 mb-3 mb-sm-0">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" name="nome" placeholder="Nome" value="">
            </div>
            <div class="col-sm-4 mb-3 mb-sm-0">
                <label for="cargo">Cargo</label>
                <input type="text" class="form-control" name="cargo" placeholder="Cargo" value="">
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-user btn-block">
            Salvar
        </button>
        <hr>
    </form>
