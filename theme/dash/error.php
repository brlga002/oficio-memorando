<?php $v->layout("dash::_theme"); ?>


<div class="text-center">
    <div class="error mx-auto" data-text="<?= $error; ?><"><?= $error; ?></div>
    <p class="lead text-gray-800 mb-5">Error Found</p>
    <p class="text-gray-500 mb-0">Parece que você encontrou uma falha na matriz ...</p>
    <a href="<?= url() ?>">Voltar ao Início</a>
</div>
