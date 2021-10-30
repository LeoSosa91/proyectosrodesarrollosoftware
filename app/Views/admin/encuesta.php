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
        <div class="card mb-5" >
            <div class="row g-0">
                <div class="col-md-5">
                <img src="<?=base_url('/assets/image/encuesta.jpg')?>" class="img-fluid" alt="..." >
                </div>
                <div class="col-md-7">
                    <div class="card text-center">
                        <div class="card-header bg-dark text-white text-center mb-3">
                            <h4>MODIFICAR ENCUESTA</h4>
                        </div>
                        <div class="card-body">
                            <?php if(session('msg')):?>
                                <div class="alert alert-<?=session('msg.type')?> alert-dismissible fade show" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                                    <div><strong><?=session('msg.body')?></strong></div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif;?>
                            <form action="<?=base_url('admin/modificarEncuesta')?>" method="post" novalidate>
                            <div class="form-floating mb-3">
                                <select class="form-select" id="preguntaAnterior" name="preguntaAnterior" aria-label="Floating label select example">
                                    <option value="0" selected>---</option>
                                    <?php
                                        foreach ($listadoPreguntaEncuesta as $preg) {
                                            echo'<option value="'.$preg['idPregunta'].'">'.$preg['preguntaEncuesta'].'</option>';
                                        }
                                    ?>
                                </select>
                                <label for="preguntaAnterior">Pregunta</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="preguntaNueva" name="preguntaNueva" placeholder="">
                                <label for="preguntaNueva">Nueva pregunta</label>
                            </div>
                            <input type="submit" value="Modificar" class="btn btn-dark">
                            </form>
                        </div>
                    </div>         
                </div>
            </div>                      
        </div>           
    </div>
</main>        
<!-- helpModal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
<?=$this->include('front/footer');?>
<?=$this->include('admin/jsAdmin');?>