<nav class="navbar navbar-expand-sm btn-primary  navbar-dark">
    <ul class="navbar-nav">
    <li class="nav-item">
        <a href="<?= url("documento/editar/{$documento->id}"); ?>" class="nav-link">
            <i class="fas fa-pencil-alt"></i>
            <span class="text">Editar</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= url("documento/assinatura/{$documento->id}"); ?>" class="nav-link">
            <i class="fas fa-signature"></i>
            <span class="text">Assinatura</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= url("documento/historico/{$documento->id}"); ?>" class="nav-link">
            <i class="fas fa-landmark"></i>
            <span class="text">Histórico</span>
        </a>
    </li>
        <li class="nav-item">
            <a href="" class="nav-link"
               data-memo="<?= $documento->tipoDoc()->nomeTipoDoc ?> <?= $documento->numeroDoc ."/".  $documento->anoDoc ?> <?= $documento->assuntoDoc ?>"
               data-url="<?= url("documento/deletar/{$documento->id}") ?>">
                <i class="fas fa-trash"></i>
                <span class="text">Deletar</span>
            </a>
    </li>
</ul>
</nav>
<br>
