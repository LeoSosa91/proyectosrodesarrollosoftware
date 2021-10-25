<main class="mt-5 pt-3">
    <div class="content p-4">
        <?php if(session('msg')):?>
        <div class="alert alert-<?=session('msg.type')?> alert-dismissible fade show" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
            <div><strong><?=session('msg.body')?></strong></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif;?>
        <h1 class="display-5 font-weight-bold"><span class="fas fa-utensils"></span> SERVICIO DE RESERVAS ONLINE</h1>
        <hr class="hr-light">
        <h3><strong>La forma más cómoda de hacer tu reserva en sencillos pasos</strong></h3>
        <p>CHEF</p>
        <p class="mb-4 ">
            <strong>
            SERVICIO DE RESERVAS ONLINE es un programa alojado en internet, que permite al cliente disponga entre varias opciones, el listado de los diferentes platos y bebidas que posea en stock el negocio, poder realizar reservas de mesas(con los respectivos protocolos por el COVID), ver sus reservas..</strong>
        </p>
    </div>
</main>