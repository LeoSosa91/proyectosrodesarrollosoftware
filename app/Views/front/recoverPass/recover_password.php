
    <header>
        <div class="card card-intro sky-gradient">
            <div class="card-body white-text rgba-black-light text-center">
                <!--Grid row-->
                <div class="row d-flex justify-content-center">
                    <!--Grid column-->
                    <div class="col-md-6">
                        <h1 class="font-weight-bold h2">Mi cuenta</h1>
                    </div>
                    <!--Grid column-->
                </div>
                <!--Grid row-->
            </div>
        </div>
    </header>
    <!--   min-vw-100 -->
    <main class="pt-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row mb-4">
                        <div class="col-md-6 mt-4 mb-4 mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </symbol>
                        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                        </symbol>
                        </svg>

                                <?php if(session('msg')):?>
                                    <div class="alert alert-<?=session('msg.type')?> d-flex align-items-center alert-dismissible fade show" role="alert">
                                        <?=session('msg.icon')?>
                                        <strong><strong><?=session('msg.body') ?></strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>    
                                <?php endif;?>
                                
                            <div class="card">
                                <div class="card-header bg-dark"> <h3>Restablecer la contraseña</h3> </div>
                                <div class="card-body">
                                    <form method="post" class="pt-2 row g-3 needs-validation" action="<?=base_url(route_to('validarPassword'))?>" >
                                        <p>¿Perdiste tu contraseña? Ingrese su dirección de correo electrónico. Recibirá un enlace para crear una nueva contraseña por correo electrónico. Nombre de usuario o correo electrónico.</p>
                                        <div class="form-outline mb-4">
                                            <i class="fas fa-user trailing"></i>
                                            <input type="email" id="inputEmail" name="inputEmail" class="form-control form-icon-trailing" value="<?=old('inputEmail')?>"/>
                                            <label class="form-label" for="inputEmail">Correo electrónico</label>
                                            <?php if (session('errors.inputEmail')) {
                                               echo'<div class="form-helper mb-5 mt-1 text-danger">'.session('errors.inputEmail').'</div>';
                                            }
                                            ?>
                                            
                                        </div>
                                        <div class="form-outline mt-4 mb-1">
                                            <div class="d-flex justify-content-between pt-4">
                                                <a href="<?=base_url();?>" class="btn btn-outline-dark" data-mdb-ripple-color="dark">Volver</a>
                                                <input type="submit" value="Restablecer contraseña" class="btn btn-dark ">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!--Footer-->
    <?= $this->include('front/footer') ?>
    <!--Footer-->
    <!--Scripts-->
    <?= $this->include('front/recoverPass/scripts') ?>
    <!--Scripts-->
</body>
</html>