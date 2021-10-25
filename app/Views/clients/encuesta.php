<main class="mt-5 py-3">
    <div class="content p-4 my-4">
        <h1 class="display-5 font-weight-bold"><span class="fas fa-utensils"></span> SERVICIO DE RESERVAS ONLINE</h1>
        <hr class="hr-light">
        <div class="row g-0">
            <div class="col-md-11">
            <h3><strong>Encuesta</strong></h3>
            </div>
            <div class="col-md-1">
                <!-- Button trigger modal -->
                <button type="button" class="" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <img src="https://img.icons8.com/glyph-neue/64/000000/help.png" width="30" height="30"/> 
                </button>
            </div>
        </div>
        <div class="card mb-3" >
            <div class="container  ">
                <div class="row align-items-sm-center align-items-md-center justify-content-center ">
                    <div class="col-sm-10 col-md-6">
                        <div class="card card-body mt-5 " >
                            <h3 class="card-title text-center "> Su opinión importa </h3>
                            <hr class="hr-light">
                            <p class="text-center"><strong>¿Desea completar una encuesta?</strong></p>
                            <!-- Button trigger modal-->
                            <div class="row justify-content-center">
                                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalEncuesta">Si</button>
                                <a href="<?=base_url('/clients') ?>" type="button" class="btn btn-dark" >No</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Modal -->
<div class="modal fade" id="modalEncuesta" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-dark">
        <h5 class="modal-title text-white" id="exampleModalLabel">Encuesta</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <p ><strong>¿Como le ha parecido el servicio?</strong> </p>
      </div>
      <div class="modal-footer justify-content-center ">
                <div class="row">
                    <div class="col-4">
                        <a href="<?=base_url()?>/clients/enviarEncuesta?valor=Mala" type="button" class="bi bi-emoji-frown display-5" ></a><br>
                        <span class="font-small">MALA</span>
                    </div>
                    <div class="col-4">
                        <a href="<?=base_url()?>/clients/enviarEncuesta?valor=Buena" type="button" class="bi bi-emoji-expressionless display-5" ></a><br>        
                        <span class="font-small">BUENA</span>
                    </div>
                    <div class="col-4">
                        <a href="<?=base_url()?>/clients/enviarEncuesta?valor=Muy Buena" type="button" class="bi bi-emoji-smile display-5" ></a><br>        
                        <span class="font-small">MUY BUENA</span>
                    </div>
                </div>
            </div>
    </div>
  </div>
</div>

<?=$this->include('clients/footer');?>
<?=$this->include('clients/jsClient');?>
</body>
</html>