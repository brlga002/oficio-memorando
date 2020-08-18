<?php $v->layout("dash::_theme"); ?>
<h1 class="h3 mb-4 text-gray-800">Home</h1>
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">N° Documentos</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $numedoDocumentos ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-pdf fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">N° Modelos</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $numedoModelos ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-copy fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Ducumentos Assinados</div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $porcentagemAssinados ?>%</div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: <?= $porcentagemAssinados ?>%" aria-valuenow="<?= $porcentagemAssinados ?>" aria-valuemin="0" aria-valuemax="<?= $numedoDocumentos ?>"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Assinatura Pedente</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $numedoAssinaturaPedente ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-info-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <?php if($assinaturas): ?>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Assinaturas Disponíveis</h6>
            </div>
            <div class="card-body">
                <?php foreach ($assinaturas as $modelo): ?>
                      <?= $modelo->nome ?> - <?= $modelo->cargo ?><br>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if($tipoDocumento): ?>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tipos Disponíveis</h6>
            </div>
            <div class="card-body">
                <?php foreach ($tipoDocumento as $modelo): ?>
                      Nome: <?= $modelo->nomeTipoDoc ?> - Tipo: <?= $modelo->tipo ?> - Sigla: <?= $modelo->sigla ?><br>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if($linkADM): ?>
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tipos Disponíveis</h6>
                </div>
                <div class="card-body">
                    <?= $linkADM ?>
                </div>
            </div>
        </div>
   <?php endif; ?>
</div>

<?php $v->start("link"); ?>
<!-- Custom styles for this page -->
<link href="<?= url("theme/dash/vendor/fontawesome-free/css/all.min.css")?>" rel="stylesheet" type="text/css">
<?php $v->end(); ?>








