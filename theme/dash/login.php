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
                                <h1 class="h4 text-gray-900 mb-4">Bem vindo de volta!</h1>
                            </div>
                            <form class="user" action="<?= url("login") ?>" method="post">
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" name="email"
                                           aria-describedby="emailHelp"
                                           placeholder="Insira o endereço de e-mail..."
                                           value="<?= $email; ?>"
                                    >
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user" name="password" placeholder="Senha">
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Login
                                </button>
                            </form>
                            <div class="text-center">
                                <a class="small" href="<?= url("login/recupera") ?>">Perdeu a senha?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
