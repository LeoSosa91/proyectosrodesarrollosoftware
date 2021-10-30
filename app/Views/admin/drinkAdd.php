<main class="mt-5 pt-3">
    <div class="content p-4">
        <h1 class="display-5 font-weight-bold"><span class="fas fa-utensils"></span> SERVICIO DE RESERVAS ONLINE</h1>
        <hr class="hr-light">
        <div class="row g-0">
            <div class="col-md-11">
            <h3><strong>Bebida</strong></h3>
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
                <img src="<?=base_url('/assets/image/drinkManager.png')?>" class="img-fluid" alt="..." >
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
                        <h4><strong>Agregar bebida</strong></h4>
                        <form action="<?=base_url('menu/bebida/agregarBebida')?>" method="post">
                            <div class="mb-3">
                                <label class="form-label" for="inputNameDrink">Ingrese nombre de bebida</label>
                                <input type="text" class="form-control" id="inputNameDrink" name="inputNameDrink" placeholder="Nombres" value="<?=old('inputNameDrink')?>">
                                <?php if(session('errors.inputNameDrink')):?>
                                <div class="form-helper text-danger"><?=session('errors.inputNameDrink')?></div>
                                <?php endif?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="typeDrink">Seleccione tipo de bebida</label>
                                <select class="form-select" id="typeDrink" name="typeDrink">
                                    <option <?php echo (old('typeDrink') == "0") ? 'selected' : '';?> value="0">---</option>
                                    <option <?php echo (old('typeDrink') == "1") ? 'selected' : '';?> value="1">BEBIDAS SIN ALCOHOL</option>
                                    <option <?php echo (old('typeDrink') == "2") ? 'selected' : '';?> value="2">CERVEZAS</option>
                                    <option <?php echo (old('typeDrink') == "3") ? 'selected' : '';?> value="3">VINOS</option>
                                    <option <?php echo (old('typeDrink') == "4") ? 'selected' : '';?> value="4">COCTELES</option>
                                </select>
                                <?php if(session('errors.typeDrink')):?>
                                <div class="form-helper text-danger"><?=session('errors.typeDrink')?></div>
                                <?php endif?> 
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="stateFood">Estado</label>
                                <select class="form-select" id="stateDrink" name="stateDrink">
                                    <option <?php echo (old('stateDrink') == "") ? 'selected' : '';?> value="">---</option>
                                    <option <?php echo (old('stateDrink') == "0") ? 'selected' : '';?> value="0">Habilitado</option>
                                    <option <?php echo (old('stateDrink') == "1") ? 'selected' : '';?> value="1">Deshabilitado</option>
                                </select>
                                <?php if(session('errors.stateDrink')):?>
                                <div class="form-helper text-danger"><?=session('errors.stateDrink')?></div>
                                <?php endif?>
                            </div>
                            <div class="mb-3">
                                <label for="inputPrice" class="form-label">Ingrese precio de la bebida</label>
                                <input type="number" class="form-control" name="inputPrice" id="inputPrice" placeholder="100.00" value="<?=old('inputPrice')?>">
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