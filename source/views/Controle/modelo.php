<?php $v->layout("dash::_theme"); ?>

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><?= $titulo ?></h1>
    <p class="mb-4"><?= $subTitulo ?></p>
    <form class="user" action="<?= $action; ?>" method="post">
        <div class="form-group row">
            <div class="col-sm-4 mb-3 mb-sm-0">
                <label for="id_tipomemo">Tipo Dococumento</label>
                <select class="form-control" name="id_tipoDoc" required>
                    <option></option>
                    <?php foreach ($tipoDocumento as $tipo): ?>
                        <option value="<?= $tipo->id; ?>">
                            <?= $tipo->nomeTipoDoc; ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="col-sm-4 mb-3 mb-sm-0">
                <label for="nomeTipoDoc">Assunto Dococumento</label>
                <input type="text" class="form-control" name="assuntoDoc" placeholder="assunto Dococumento" value="" required>
            </div>
            <div class="col-sm-4 mb-3 mb-sm-0">
                <label for="cargo">Data</label>
                <input type="date" class="form-control" name="dataDoc" placeholder="dataDoc" value="" required>
            </div>
            <div class="col-sm-12 mb-12 mb-sm-0">
                <label for="destinatarioDoc">Destinatario</label>
                <textarea  class="form-control" name="destinatarioDoc" placeholder="Destinatário" rows="3" required></textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-user btn-block">
            Salvar
        </button>
        <hr>
    </form>
