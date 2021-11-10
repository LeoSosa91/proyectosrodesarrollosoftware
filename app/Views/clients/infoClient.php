<main class="mt-5 pt-3">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <h4>Home</h4>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3 col-lg-4 col-xl-4">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title mb-0">Editar mi perfil</h5>
          </div>
          <div class="list-group" id="myList" role="tablist">
            <?php if (session('errors.inputConfirmPasswordNew') || session('errors.inputPasswordNew')) {
              echo '<a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#home" role="tab" aria-selected="false">Datos Personales</a>
                  <a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#profile" role="tab" aria-selected="true">Contraseña</a> ';
            } else {
              echo '<a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#home" role="tab" aria-selected="true">Datos Personales</a>
                    <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#profile" role="tab" aria-selected="false">Contraseña</a>';
            }
            ?>
          </div>
        </div>
      </div>
      <div class="col-md-9 col-lg-8 col-xl-8">
        <?php if (session('msg')) : ?>
          <div class="alert alert-<?= session('msg.type') ?> alert-dismissible fade show" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
              <use xlink:href="#exclamation-triangle-fill" />
            </svg>
            <div><strong><?= session('msg.body') ?></strong></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>
        <div class="tab-content">
          <div class="tab-pane <?php if (session('errors.inputConfirmPasswordNew') || session('errors.inputPasswordNew')) {
                                  echo '';
                                } else {
                                  echo 'active';
                                }
                                ?>" id="home" role="tabpanel">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title mb-0">Mi información</h5>
              </div>
              <div class="card-body">
                <form action="<?= base_url(route_to('guardarInfoPersonalClient')) ?>" method="post" class="p-4">
                  <div class="row">
                    <input type="hidden" name="idUser" id="idUser" value="<?= $user['id_user']; ?>">
                    <div class="mb-3 col-sm-12 col-md-6">
                      <label class="form-label" for="inputName">Nombres</label>
                      <input type="text" class="form-control" id="inputName" name="inputName" placeholder="Nombres" value="<?php
                                                                                                                            if (old('inputName')) {
                                                                                                                              echo old('inputName');
                                                                                                                            } else {
                                                                                                                              echo $user['username'];
                                                                                                                            } ?>">
                      <?php if (session('errors.inputName')) : ?>
                        <div class="form-helper text-danger"><?= session('errors.inputName') ?></div>
                      <?php endif ?>
                    </div>
                    <div class="mb-3 col-sm-12 col-md-6">
                      <label class="form-label" for="inputSurname">Apellido</label>
                      <input type="text" class="form-control" id="inputSurname" name="inputSurname" placeholder="Apellido" value="<?php
                                                                                                                                  if (old('inputSurname')) {
                                                                                                                                    echo old('inputSurname');
                                                                                                                                  } else {
                                                                                                                                    echo $user['usersurname'];
                                                                                                                                  }
                                                                                                                                  ?>">
                      <?php if (session('errors.inputSurname')) : ?>
                        <div class="form-helper text-danger"><?= session('errors.inputSurname') ?></div>
                      <?php endif ?>
                    </div>
                    <div class="mb-3 col-sm-12 col-md-6">
                      <label class="form-label" for="inputDni">DNI</label>
                      <input type="text" class="form-control" id="inputDni" name="inputDni" placeholder="DNI" value="<?php
                                                                                                                      if (old('inputDni')) {
                                                                                                                        echo old('inputDni');
                                                                                                                      } else {
                                                                                                                        echo $user['userDni'];
                                                                                                                      } ?>">
                      <?php if (session('errors.inputDni')) : ?>
                        <div class="form-helper text-danger"><?= session('errors.inputDni') ?></div>
                      <?php endif ?>
                    </div>
                    <div class="mb-3 col-sm-12 col-md-6">
                      <label class="form-label" for="inputFecNac">Fecha de nacimiento</label>
                      <input type="date" class="form-control" id="inputFecNac" name="inputFecNac" value="<?php
                                                                                                          if (old('inputFecNac')) {
                                                                                                            echo old('inputFecNac');
                                                                                                          } else {
                                                                                                            echo $user['userBirthday'];
                                                                                                          } ?>">
                      <?php if (session('errors.inputFecNac')) : ?>
                        <div class="form-helper text-danger"><?= session('errors.inputFecNac') ?></div>
                      <?php endif ?>
                    </div>
                    <div class="mb-3 col-sm-12 col-md-6">
                      <label class="form-label" for="inputAddress">Direcci&oacute;n</label>
                      <input type="text" class="form-control" id="inputAddress" name="inputAddress" placeholder="Direcci&oacute;n" value="<?php
                                                                                                                                          if (old('inputAddress')) {
                                                                                                                                            echo old('inputAddress');
                                                                                                                                          } else {
                                                                                                                                            echo $user['useradress'];
                                                                                                                                          } ?>">
                      <?php if (session('errors.inputAddress')) : ?>
                        <div class="form-helper text-danger"><?= session('errors.inputAddress') ?></div>
                      <?php endif ?>
                    </div>
                    <div class="mb-3 col-sm-12 col-md-6">
                      <label class="form-label" for="inputTel">Tel&eacute;fono</label>
                      <input type="text" class="form-control" name="inputTel" id="inputTel" value="<?php
                                                                                                    if (old('inputTel')) {
                                                                                                      echo old('inputTel');
                                                                                                    } else {
                                                                                                      echo $user['usertel'];
                                                                                                    } ?>">
                      <?php if (session('errors.inputTel')) : ?>
                        <div class="form-helper text-danger"><?= session('errors.inputTel') ?></div>
                      <?php endif ?>
                    </div>
                    <div class="mb-3 col-sm-12 col-md-6">
                      <label class="form-label" for="inputEmail">Correo electr&oacute;nico</label>
                      <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="Apartment, studio, or floor" value="<?php
                                                                                                                                                  if (old('inputEmail')) {
                                                                                                                                                    echo old('inputEmail');
                                                                                                                                                  } else {
                                                                                                                                                    echo $user['useremail'];
                                                                                                                                                  } ?>">
                      <?php if (session('errors.inputEmail')) : ?>
                        <div class="form-helper text-danger"><?= session('errors.inputEmail') ?></div>
                      <?php endif ?>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
              </div>
            </div>
          </div>
          <div class="tab-pane <?php if (session('errors.inputConfirmPasswordNew') || session('errors.inputPasswordNew')) {
                                  echo 'active';
                                } ?>" id="profile" role="tabpanel">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Password</h5>

                <form action="<?= base_url(route_to('guardarPasswordClient')) ?>" method="post" class="p-4">
                  <input type="hidden" name="idUser" id="idUser" value="<?= $user['id_user']; ?>">
                  <div class="mb-3">
                    <label class="form-label" for="inputPasswordNew">Nueva Contrase&ntilde;a</label>
                    <input type="password" class="form-control" id="inputPasswordNew" name="inputPasswordNew">
                    <?php if (session('errors.inputPasswordNew')) : ?>
                      <div class="form-helper text-danger"><?= session('errors.inputPasswordNew') ?></div>
                    <?php endif ?>
                  </div>
                  <div class="mb-3">
                    <label class="form-label" for="inputConfirmPasswordNew">Repetir nueva contrase&ntilde;a</label>
                    <input type="password" class="form-control" id="inputConfirmPasswordNew" name="inputConfirmPasswordNew">
                    <?php if (session('errors.inputConfirmPasswordNew')) : ?>
                      <div class="form-helper text-danger"><?= session('errors.inputConfirmPasswordNew') ?></div>
                    <?php endif ?>
                  </div>
                  <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</main>
<?= $this->include('clients/footer'); ?>
<?= $this->include('clients/jsClient'); ?>
</body>

</html>