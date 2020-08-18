<?php $v->layout("dash::_theme"); ?>

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><?= $titulo ?></h1>
    <p class="mb-4"><?= $subTitulo ?></p>
    <form class="user" action="<?= $action; ?>" method="post">
        <div class="form-group row">
            <div class="col-sm-4 mb-3 mb-sm-0">
                <label for="nomeTipoDoc">Nome</label>
                <input type="text" class="form-control" name="nome" placeholder="Nome completo" value="">
            </div>
            <div class="col-sm-4 mb-3 mb-sm-0">
                <label for="cargo">Nick</label>
                <input type="text" class="form-control" name="nick" placeholder="Primeiro nome" value="">
            </div>
            <div class="col-sm-4 mb-3 mb-sm-0">
                <label for="cargo">Email</label>
                <input type="email" class="form-control" name="email" placeholder="email" value="">
            </div>
            <div class="col-sm-4 mb-3 mb-sm-0">
                <label for="cargo">Senha</label>
                <input type="password" class="form-control" name="password" placeholder="****" value="">
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-user btn-block">
            Salvar
        </button>
        <hr>
    </form>
