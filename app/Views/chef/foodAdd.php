<main class="mt-5 pt-3">
    <div class="content p-4">
        <h1 class="display-5 font-weight-bold"><span class="fas fa-utensils"></span> SERVICIO DE RESERVAS ONLINE</h1>
        <hr class="hr-light">
        <div class="row g-0">
            <div class="col-md-11">
            <h3><strong>Plato</strong></h3>
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
                <img src="<?=base_url('/assets/image/report-plato.jpg')?>" class="img-fluid" alt="..." >
                </div>
                <div class="col-md-7">
                <div class="card-body">
                <?php if(session('msg')):?>
                  <div class="alert alert-<?=session('msg.type')?> alert-dismissible fade show" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                    <div><strong><?=session('msg.body')?></strong></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                <?php endif;?>
                        <h4><strong>Agregar plato</strong></h4>
                        <form action="<?=route_to('agregarPlato')?>" method="post">
                            <div class="mb-3">
                                <label class="form-label" for="inputNameFood">Ingrese nombre de plato</label>
                                <input type="text" class="form-control" id="inputNameFood" name="inputNameFood" placeholder="Nombres" value="<?=old('inputNameFood')?>">
                                <?php if(session('errors.inputNameFood')):?>
                                <div class="form-helper text-danger"><?=session('errors.inputNameFood')?></div>
                                <?php endif?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="typeFood">Seleccione tipo de plato</label>
                                <select class="form-select" id="typeFood" name="typeFood">
                                    <option <?php echo (old('typeFood') == "0") ? 'selected' : '';?> value="0">---</option>
                                    <option <?php echo (old('typeFood') == "1") ? 'selected' : '';?> value="1">ENSALADAS</option>
                                    <option <?php echo (old('typeFood') == "2") ? 'selected' : '';?> value="2">PIZZAS</option>
                                    <option <?php echo (old('typeFood') == "3") ? 'selected' : '';?> value="3">POSTRES</option>
                                    <option <?php echo (old('typeFood') == "4") ? 'selected' : '';?> value="3">HAMBURGUESAS</option>
                                </select>
                                <?php if(session('errors.typeFood')):?>
                                <div class="form-helper text-danger"><?=session('errors.typeFood')?></div>
                                <?php endif?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="stateFood">Estado</label>
                                <select class="form-select" id="stateFood" name="stateFood">
                                <option <?php echo (old('stateFood') == "0") ? 'selected' : '';?> value="">---</option>
                                    <option <?php echo (old('stateFood') == "0") ? 'selected' : '';?> value="1">Habilitado</option>
                                    <option <?php echo (old('stateFood') == "1") ? 'selected' : '';?> value="2">Deshabilitado</option>
                                </select>
                                <?php if(session('errors.stateFood')):?>
                                <div class="form-helper text-danger"><?=session('errors.stateFood')?></div>
                                <?php endif?>
                            </div>
                            <div class="mb-3">
                                <label for="inputIngredientes" class="form-label">Ingrese ingredientes/descripcion del plato</label>
                                <textarea class="form-control" id="inputIngredientes" name="inputIngredientes" rows="3" value="<?=old('inputIngredientes')?>"></textarea>
                                <?php if(session('errors.inputIngredientes')):?>
                                <div class="form-helper text-danger"><?=session('errors.inputIngredientes')?></div>
                                <?php endif?>
                            </div>
                            <div class="mb-3">
                                <label for="inputPrice" class="form-label">Ingrese ingredientes del plato</label>
                                <input type="number" class="form-control" name="inputPrice" id="inputPrice" placeholder="100" value="<?=old('inputPrice')?>">
                                <?php if(session('errors.inputPrice')):?>
                                <div class="form-helper text-danger"><?=session('errors.inputPrice')?></div>
                                <?php endif?>
                            </div>
                            <button type="submit" class="btn btn-dark" width="100px">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>