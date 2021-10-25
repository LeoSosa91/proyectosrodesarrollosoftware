<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Material Design for Bootstrap</title>
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
    <main class="pt-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row mb-4">
                        <div class="col-sm-12 col-md-8 col-lg-5 mt-4 mb-4 mx-auto">
                            <div class="card">
                                <div class="card-header bg-dark"> 
                                    <h3>Crear nueva contraseña</h3> 
                                </div>
                                <div class="card-body">
                                    <?php if(session('msg')):?>
                                    <div class="alert alert-<?=session('msg.type')?> alert-dismissible fade show" role="alert">
                                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                                        <div><strong><?=session('msg.body')?></strong></div>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    <?php endif;?>
                                    <form action="<?=base_url();?>/newPassword" method="post" class="row g-3 needs-validation <?php 
                                    echo (session('errors.passwordConfirm')||session('errors.password')) ? 'was-validated' : '' ;?>" >
                                    <!-- novalidate -->
                                        <input type="hidden" name="id_user" id="id_user" value="<?=$id_user?>">
                                        <div class="col-md-12 position-relative mb-2 pt-2">
                                            <div class="form-outline">
                                                <input type="password" class="form-control"
                                                    id="password" name="password" required/>
                                                <label for="password" class="form-label">Nueva contrase&ntilde;a</label>
                                                <div class="valid-tooltip">Looks good!</div>
                                                <?php if (session('errors.password')):?>
                                                    <div class="invalid-tooltip">
                                                    <?=session('errors.password');?>
                                                    </div>
                                                <?php endif;?>
                                                <!-- <div class="invalid-tooltip">Por favor, ingrese contraseña</div> -->
                                            </div>
                                        </div>
                                        <div class="col-md-12 position-relative mb-3">
                                            <div class="form-outline">
                                                <input type="password" class="form-control"
                                                    id="passwordConfirm" name="passwordConfirm"
                                                    required/>
                                                <label for="passwordConfirm" class="form-label">Confirmaci&oacute;n contrase&ntilde;a</label>
                                                <div class="valid-tooltip">Looks good!</div>
                                                <?php if (session('errors.passwordConfirm')):?>
                                                    <div class="invalid-tooltip">
                                                    <?=session('errors.passwordConfirm');?>
                                                    </div>
                                                <?php endif;?>
                                                <!-- <div class="invalid-tooltip">La contraseña ingresada no es la misma</div> -->
                                            </div>
                                        </div>
                                        <div class="col-12 mt-4">
                                            <button class="btn btn-primary" type="submit">Resetear Password</button>
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
    <footer class="fixed-bottom bg-light text-lg-start">
        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">© 2021 Copyright:
        <a class="text-dark" href="https://mdbootstrap.com/">MDBootstrap.com</a></div>
        <!-- Copyright -->
    </footer>
    <!--Footer-->
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.5.0/mdb.min.js"></script>
    <!-- Custom scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <!-- <script type="text/javascript" src="<?=base_url();?>/assets/js/script.js"></script> -->
    <script type="text/javascript" src="<?=base_url();?>/assets/js/register.js"></script>
    <script type="text/javascript" src="<?=base_url();?>/assets/js/resetPass.js"></script>
</body>
</html>