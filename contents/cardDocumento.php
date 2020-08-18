<div class="card border-left-primary">
    <div class="card-body">
        <a href="<?= url("documento/show/{$documento->id}") ?>" target='_blank'>
            Documento
            <strong>
                <?= $documento->tipoDoc()->nomeTipoDoc; ?>
                <?= $documento->numeroDoc ."/". $documento->anoDoc; ?>
                <?= $documento->assuntoDoc; ?>
            </strong>
            - Visualizar
        </a>
    </div>
</div>
<br>