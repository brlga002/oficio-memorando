<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= url(); ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Docs <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="<?= url(); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            <i class="far fa-sticky-note"></i>
            <span>Documentos</span>
        </a>
        <div id="collapseOne" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= url("documento/novo"); ?>">Novo</a>
                <h6 class="collapse-header">Tipo:</h6>
                <?php foreach (tipoDocumentos() as $modelo): ?>
                    <a class="collapse-item"
                       href="<?= url("documento/tipo/{$modelo->id}"); ?>">
                        <?= $modelo->nomeTipoDoc; ?>
                    </a>
                <?php endforeach ?>
                <h6 class="collapse-header">Situação:</h6>
                <a class="collapse-item" href="<?= url("documento/situacao/1"); ?>">Não Assinados</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseOne">
            <i class="far fa-sticky-note"></i>
            <span>Modelos de Documento</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= url("modelos/modelo/novo"); ?>">Novo</a>
                <a class="collapse-item" href="<?= url("modelos"); ?>">Todos</a>
                <h6 class="collapse-header">Tipo:</h6>
                <?php foreach (modeloDocumentos() as $modelo): ?>
                    <a class="collapse-item"
                       href="<?= url("modelos/{$modelo->id_tipoDoc}"); ?>">
                        <?= $modelo->tipoDoc(); ?>
                    </a>
                <?php endforeach ?>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseOne">
            <i class="far fa-sticky-note"></i>
            <span>Tabelas</span>
        </a>
        <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Tipo:</h6>
                <a class="collapse-item" href="<?= url("assinaturas"); ?>">
                    Assinatura Disponível
                </a>
                <a class="collapse-item" href="<?= url("tipoDocumento"); ?>">
                    Tipo Documento
                </a>
            </div>
        </div>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <li class="nav-item">
        <a class="nav-link" href="<?= url("controle"); ?>">
            <i class="fas fa-pager"></i>
            <span>Numeração Documento</span></a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
