<main class="mt-5 py-3">
    <div class="content p-4 my-4">
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
        <div class="card mb-3" >
            <div class="row g-0">
                <?php if(session('msg')):?>
                    <div class="alert alert-<?=session('msg.type')?> alert-dismissible fade show" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                    <div><strong><?=session('msg.body')?></strong></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif;?>
                <div class="col-md-12 col-lg-3">
                    <div class="card-body">
                        <h4><strong>Editar bebida</strong></h4>
                        <form action="<?=base_url('menu/bebida/editarBebida')?>" method="post">
                            <input type="hidden" name="idBebida" id="idBebida">
                            <div class="mb-3">
                                <label class="form-label" for="inputNameDrink">Ingrese nombre de bebida</label>
                                <input type="text" class="form-control" id="inputNameDrink" placeholder="Nombres" name="inputNameDrink" value="<?=old('inputNameDrink')?>">
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
                            <button type="submit" class="btn btn-dark">Guardar cambios</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-12 col-lg-9">
                    <div class="card-body">
                        <table id="example" class="table table-striped" style="width:100%; height:100%">
                            <thead>
                                <tr>
                                    <th>Nombre de bebida</th>
                                    <th>Tipo</th>
                                    <th>Estado</th>
                                    <th>Precio</th>
                                    <th>Gestionar</th>
                                </tr>
                            </thead>
                            <tbody id="bebidas">
                        <?php
                        
                        foreach ($beverages as $beverage) {
                            echo'<tr>
                            <td>'.$beverage['nombreBebida'].'</td>';
                            
                            foreach ($typeBeverages as $typeBeverage) {
                                // if ($beverage['tipoBebida']==$typeBeverage['idCategoriaBebida']) {
                                if ($beverage['idCategoriaBebida']==$typeBeverage['idCategoriaBebida']) {
                                    echo'<td>'.$typeBeverage['nombreCategoriaBebida'].'</td>';
                                }
                            }
                            if ($beverage['deleted_at']==0) {
                                echo'<td>Habilitado</td>';
                            }else {
                                echo'<td>Deshabilitado</td>';
                            }
                            
                            echo'<td>'.$beverage['precioBebida'].'</td>
                            <td>
                            
                            <button type="button" class="btn btn-warning" data-id='.$beverage['idBebida'].'>
                                <span class="text-white">
                                    <i class="fas fa-edit mr-2"></i>
                                </span>
                            </button>
                            </td>
                            </tr>';
                        }
                        
                        
                        
                        ?>
                            </tbody>
                        </table>
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


<!--Footer-->
<footer class="fixed-bottom bg-light text-lg-start mt-3">
    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        © 2021 Copyright: SRO Version 0.0.3
    </div>
    <!-- Copyright -->
</footer>
<!--Footer-->

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>/assets/js/jquery-3.5.1.js"></script>
<script type="text/javascript" src="<?=base_url();?>/assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>/assets/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>/assets/js/editBeverage.js"></script>
<script>
    var baseURL= "<?php echo base_url();?>";
$(document).ready(function() {
    $('#example').DataTable({
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
    },
    "scrollY":        "400px",
    "scrollCollapse": true,
    "paging":         false
    });
} );
</script>

</body>
</html>