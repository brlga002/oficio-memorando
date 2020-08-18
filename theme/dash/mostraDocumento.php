<?php $v->layout("dash::_theme_login"); ?>

<div class="row justify-content-center">
    <div class="col-xl-6 col-lg-6 col-md-9">
        <br>
        <?php $v->insert("dash::_message"); ?>
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Verificar Autenticidade de Documento</h1>
                                <p>Preencha a chave para verificar a autenticidade</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
