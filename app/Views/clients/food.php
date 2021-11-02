<main class="mt-5 pt-3">
    <div class="content p-4">
        <h1 class="display-5 font-weight-bold"><span class="fas fa-utensils"></span> SERVICIO DE RESERVAS ONLINE</h1>
        <hr class="hr-light">
        <div class="row g-0">
            <div class="col-md-11">
            <h3><strong>Platos</strong></h3>
            </div>
            <div class="col-md-1">
                <!-- Button trigger modal -->
                <button type="button" class="" data-bs-toggle="modal" data-bs-target="#helpModal">
                <img src="https://img.icons8.com/glyph-neue/64/000000/help.png" width="30" height="30"/> 
                </button>
            </div>
        </div>
        <div class="card mb-3" >
            <div class="row g-0">
                <div class="col-md-5">
                <img src="<?=base_url('/assets/image/food.png')?>" class="img-fluid" alt="..." >
                </div>
                <div class="col-md-7">
                    <div class="card-header">
                        <h3><strong>CARTA</strong></h3>
                    </div>
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                <?=$platos?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- helpModal -->
<div class="modal fade" id="helpModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ayuda</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        ...
        </div>
    </div>
  </div>
</div>
<?=$this->include('clients/footer');?>
<?=$this->include('clients/jsClient');?>