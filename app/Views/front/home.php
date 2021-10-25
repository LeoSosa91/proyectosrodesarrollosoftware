<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>SRO</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
    <link rel="stylesheet" href="<?= base_url("assets/css/styles.css")."?v=".(rand())?>">
    <link rel="stylesheet" href="<?= base_url("assets/css/navBarHome.css")."?v=".(rand())?>">
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.5.0/mdb.min.css" rel="stylesheet"
    />
</head>
<body class="">
    <!--Main Navigation-->
      <header>
      <!-- Navbar -->
      <?= $this->include('front/index/navbar_index') ?>
      <!-- Navbar -->
      </header>
    <!--Main Navigation-->
  <main class="d-flex align-items-center  py-2 py-md-2 ">
    <div class="container mb-sm-5">
      <div class="card login-card">
        <div class="row g-0">
          <div class="col-md-6 bg-light">
            <img src="<?=base_url('../assets/image/imageLogin.png')?>" alt="login" class="login-card-img">
          </div>
          <div class="col-md-6">
            <div class="text-center">
                <h3 class="display-4 font-weight-bold"><span class="fas fa-utensils"></span> SERVICIO DE RESERVAS ONLINE</h3>
                <p><strong>La forma más cómoda de hacer tu reserva en sencillos pasos</strong></p>
            </div>
            <?php if(session('msg')):?>
            <div class="alert alert-<?=session('msg.type')?> alert-dismissible fade show" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div><strong><?=session('msg.body')?></strong></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif;?>
            <form action="<?=base_url(route_to('signIn'))?>" method="post" class="p-4">
                <!-- Email input -->
                <div class="form-outline mb-4">
                  <i class="fas fa-user trailing"></i>
                  <!-- <i class="fas fa-exclamation-circle trailing"></i> -->
                  <input type="email" id="email" name="email" value="<?=old('email')?>" class="form-control form-icon-trailing" />
                  <label class="form-label" for="email">Email</label>
                  <?php if(session('errors.email')):?>
                  <div class="form-helper mb-5 text-danger"><?=session('errors.email')?></div>
                  <?php endif?>
                  
                </div>
            
                <!-- Password input -->
                <div class="form-outline mt-4">
                  <i class="fas fa-lock trailing"></i>
                  <input type="password" id="password" name="password" class="form-control form-icon-trailing" />
                  <label class="form-label" for="password">Password</label>
                  <?php if(session('errors.password')):?>
                  <div class="form-helper mb-5 text-danger"><?=session('errors.password')?></div>
                  <?php endif?>
                </div>
                <div class="form-outline mt-4 mb-1">
                  <div class="d-flex justify-content-between">
                    <a href="<?= base_url()?>/auth/register" class="btn btn-outline-dark" data-mdb-ripple-color="dark">Crear cuenta</a>
                    <input type="submit" value="Iniciar sesi&oacute;n" class="btn btn-dark ">
                  </div>
                </div>
                <!--  <?// echo base_url()?>/recuperarPassword-->
                <p><a href="<?=base_url().'/recuperarPassword'?>" class="d-inline-block text-truncate align-top " style="min-width: 100px;">¿Olvido su contraseña?</a></p>
            </form>
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
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <!-- Custom scripts -->
    <!-- <script type="text/javascript" src="js/script.js"></script> -->
</body>
</html>