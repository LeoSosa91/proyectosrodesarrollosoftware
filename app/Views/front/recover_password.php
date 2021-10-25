<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Recuperar Contraseña</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
    <link rel="stylesheet" href="<?= base_url("assets/css/styles.css")."?v=".(rand())?>">
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.5.0/mdb.min.css" rel="stylesheet"
    />
</head>
<body class="bg-light">
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


                                <?php if(session('msg')):?>
                                    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                        </symbol>
                                    </svg>
                                    <div class="alert <?=session('msg.type')?> alert-dismissible fade show" role="alert">
                                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                                        <strong><strong><?=session('msg.body') ?></strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif;?>
                                
                            <div class="card">
                                <div class="card-header bg-dark"> <h3>Restablecer la contraseña</h3> </div>
                                <div class="card-body">
                                    
                                    <form method="post" class="pt-2 row g-3 needs-validation" action="<?=base_url().'/validarPassword'?>" novalidate>
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
    
    <!-- MDB -->
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.5.0/mdb.min.js"></script>
    <!-- Custom scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <!-- <script type="text/javascript" src="<?=base_url();?>/assets/js/script.js"></script> -->
    <script type="text/javascript" src="<?=base_url();?>/assets/js/register.js"></script>
</body>
</html>