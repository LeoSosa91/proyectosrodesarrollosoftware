
    <main class="d-flex align-items-center min-vh-100  min-vw-100">
        <div class="container justify-content-center">
            <div class="card mb-3">
                <div class="card-header bg-dark">
                    <h3>CREAR CUENTA NUEVA</h3>
                </div>
                <div class="row g-0">
                    <div class="col-md-5">
                        <img src="<?= base_url('/assets/image/undraw_Profile_data_re_v81r.svg') ?>" alt="..." class="img-fluid" />
                    </div>
                    <div class="col-md-7">
                        <div class="card-body">
                            <?php if (session('msg')) : ?>
                                <div class="alert alert-<?= session('msg.type') ?> alert-dismissible fade show" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                                        <use xlink:href="#exclamation-triangle-fill" />
                                    </svg>
                                    <div>
                                        <strong><?= session('msg.body') ?></strong>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                            <h3>REGISTRO</h3>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                    25%
                                </div>
                            </div>

                            <form id="registration_form" class="row g-3 " action="<?= base_url() ?>/auth/store" method="post" novalidate>
                                <fieldset>
                                    <div class="col-sm-12 col-md-12 mb-2">
                                        <label for="inputName" class="form-label">Nombre</label>
                                        <input type="text" class="form-control " id="inputName" name="inputName" value="<?= old('inputName') ?>" placeholder="Nombre" required>
                                        <?php if (session('errors.inputName')) : ?>
                                            <div class="form-helper text-danger"><?= session('errors.inputName') ?></div>
                                        <?php endif ?>
                                    </div>
                                    <div class="col-sm-12 col-md-12 mb-2">
                                        <label for="inputSurname" class="form-label">Apellido</label>
                                        <input type="text" class="form-control" id="inputSurname" name="inputSurname" value="<?= old('inputSurname') ?>" placeholder="Apellidos" required>
                                        <?php if (session('errors.inputSurname')) : ?>
                                            <div class="form-helper text-danger"><?= session('errors.inputSurname') ?></div>
                                        <?php endif ?>
                                    </div>
                                    <div class="col-sm-12 col-md-12 mb-4">
                                        <label for="inputDni" class="form-label">DNI</label>
                                        <input type="text" class="form-control" id="inputDni" name="inputDni" placeholder="1000000" value="<?= old('inputDni') ?>" required>
                                        <?php if (session('errors.inputDni')) : ?>
                                            <div class="form-helper text-danger"><?= session('errors.inputDni') ?></div>
                                        <?php endif ?>
                                    </div>
                                    <a class="btn btn-primary" href="<?= base_url() ?>" role="button">Volver al Login</a>
                                    <input type="button" name="" class="next btn btn-info" value="Siguiente" />
                                </fieldset>
                                <fieldset>
                                    <div class="col-sm-12 mb-2">
                                        <label for="inputFecNac" class="form-label">Fecha de nacimiento</label>
                                        <input type="date" class="form-control" id="inputFecNac" name="inputFecNac" value="<?= old('inputFecNac') ?>" max="<?= date("Y-m-d"); ?>" required>
                                        <?php if (session('errors.inputFecNac')) : ?>
                                            <div class="form-helper text-danger"><?= session('errors.inputFecNac') ?></div>
                                        <?php endif ?>
                                    </div>
                                    <div class="col-sm-12 mb-2">
                                        <label for="inputAddress" class="form-label">Direcci&oacute;n</label>
                                        <input type="text" class="form-control" id="inputAddress" name="inputAddress" value="<?= old('inputAddress') ?>" required>
                                        <?php if (session('errors.inputAddress')) : ?>
                                            <div class="form-helper text-danger"><?= session('errors.inputAddress') ?></div>
                                        <?php endif ?>
                                    </div>
                                    <div class="col-sm-12 mb-4">
                                        <label for="inputTel" class="form-label">Tel&eacute;fono</label>
                                        <input type="tel" class="form-control" id="inputTel" name="inputTel" pattern="[0-9]{9,10}" value="<?= old('inputTel') ?>" required>
                                        <div class="form-helper <?= (session('errors.inputTel')) ? 'text-danger' : 'text-muted'; ?>"><?php
                                                                                                                                    if (session('errors.inputTel')) {
                                                                                                                                        echo session('errors.inputTel');
                                                                                                                                    } else {
                                                                                                                                        echo 'Debe ingresar un telefono como ejemplo 297XXXXXXX';
                                                                                                                                    };
                                                                                                                                    ?></div>
                                    </div>
                                    <input type="button" name="previous" class="previous btn btn-default" value="Previo" />
                                    <input type="button" name="next" class="next btn btn-info" value="Siguiente" />
                                </fieldset>
                                <fieldset>
                                    <div class="col-md-12 mb-2">
                                        <label for="inputEmail" class="form-label">Correo electr&oacute;nico</label>
                                        <input type="email" class="form-control" id="inputEmail" name="inputEmail" value="<?= old('inputEmail') ?>" required>
                                        <?php if (session('errors.inputEmail')) : ?>
                                            <div class="form-helper text-danger"><?= session('errors.inputEmail') ?></div>
                                        <?php endif ?>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label for="inputPassword" class="form-label">Contrase&ntilde;a</label>
                                        <input type="password" class="form-control" id="inputPassword" name="inputPassword" required>
                                        <?php if (session('errors.inputPassword')) : ?>
                                            <div class="form-helper text-danger"><?= session('errors.inputPassword') ?></div>
                                        <?php endif ?>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label for="inputPasswordConfirm" class="form-label">Confirmar contrase&ntilde;a </label>
                                        <input type="password" class="form-control" id="inputPasswordConfirm" name="inputPasswordConfirm" required>
                                        <?php if (session('errors.inputPasswordConfirm')) : ?>
                                            <div class="form-helper text-danger"><?= session('errors.inputPasswordConfirm') ?></div>
                                        <?php endif ?>
                                    </div>
                                    <input type="button" name="previous" class="previous btn btn-default" value="Previo" />
                                    <input type="submit" name="submit" class="submit btn btn-success" value="Registrarse" id="submit_data" />
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?= $this->include('front/footer'); ?>
    <?= $this->include('auth/scripts'); ?>
</body>

</html>