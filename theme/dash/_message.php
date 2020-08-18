<?php foreach (getMessage() as $message): ?>
    <div class="alert alert-<?= $message["type"]; ?> alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?= $message["text"]; ?>
    </div>
<?php endforeach ?>



