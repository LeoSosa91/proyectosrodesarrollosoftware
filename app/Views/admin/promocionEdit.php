<main class="mt-5 py-3">
    <div class="content p-4 my-4">
        <h1 class="display-5 font-weight-bold"><span class="fas fa-utensils"></span> SERVICIO DE RESERVAS ONLINE</h1>
        <hr class="hr-light">
        <div class="row g-0">
            <div class="col-md-11">
            <h3><strong>Promociones</strong></h3>
            </div>
            <div class="col-md-1">
                <!-- Button trigger modal -->
                <button type="button" class="" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <img src="https://img.icons8.com/glyph-neue/64/000000/help.png" width="30" height="30"/> 
                </button>
            </div>
        </div>
        <div class="card mb-3 p-3" >
            <div class="card-header">
                <h3><strong>Listado de promociones</strong></h3>
            </div>
            
            <div class="card-body p-3">
                <?php if(session('error')):?>
                    <div class="alert alert-<?=session('error.type')?> alert-dismissible fade show" role="alert">
                    <ul>
                    <?php foreach (session('error.body') as $error) : ?>
                        <li><strong><?= esc($error) ?></strong></li>
                    <?php endforeach ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif;?>
                <?php if(session('msg')):?>
                    <div class="alert alert-<?=session('msg.type')?> alert-dismissible fade show" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                        <div>
                            <strong><?=session('msg.body')?></strong>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif;?>    
                <table id="tablaPromociones" class="display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Descripción de promoción</th>
                            <th>Descuento</th>
                            <th>Estado</th>
                            <th>Fecha inicio de prom.</th>
                            <th>Fecha fin de prom.</th>
                            <th>Gestionar</th>
                        </tr>
                    </thead>
                    <tbody id="promociones">
                    <?php
                    $num=0;
                    $fecha_actual = strtotime(date("d-m-Y H:i:00",time()));
                    foreach ($promociones as $promocion) {
                        $num++;
                        $cad='<tr>
                            <td>'.$num.'</td>
                            <td>'.$promocion['descripcionPromocion'].'</td>
                            <td>'.$promocion['descuentoPromocion'].'</td>';
                        $cad.= ($fecha_actual<= $promocion['fechaPromocionFin'] ||$fecha_actual> $promocion['fechaPromocionInicio']) ? "<td>Habilitado</td>" : "<td>Deshabilitado</td>" ;
                        $cad.='<td>'.date_format(date_create($promocion['fechaPromocionInicio']), 'd/m/Y').'</td>
                            <td>'.date_format(date_create($promocion['fechaPromocionFin']), 'd/m/Y').'</td>
                            <td>
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#promocionModal" data-id="'.$promocion['idPromocion'].'">
                                    <span class="text-white">
                                        <i class="fas fa-edit mr-2"></i>
                                    </span>
                                </button>
                            </td>   
                        </tr>                            
                        ';
                        echo $cad;
                    }
                    
                    ?>
                   </tbody>
                </table>
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
<!-- helpModal -->
<!-- promocionModal -->
<div class="modal fade" id="promocionModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="promocionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <img src="<?=base_url('/assets/image/promotion.svg')?>" class="img-fluid" alt="..." >
      </div>
      <div class="modal-body">
        <h5 class="modal-title" id="staticBackdropLabel">Modificar</h5>
            <form action="<?=base_url('menu/promocion/editarPromocion')?>" method="POST">
                <input type="hidden" name="idPromocion" id="idPromocion">
                <div class="mb-3">
                    <label for="inputDescripcionPromocion" class="form-label">Descripción de promoción</label>
                    <input type="text" class="form-control" id="inputDescripcionPromocion" name="inputDescripcionPromocion" value="<?=old('inputDescripcionPromocion')?>">
                    <?php if(session('errors.inputDescripcionPromocion')):?>
                    <div class="form-helper text-danger"><?=session('errors.inputDescripcionPromocion')?></div>
                    <?php endif?>
                </div>
                <div class="mb-3">
                    <label for="inputDescuentoPromocion" class="form-label">Descuento</label>
                    <input type="number" min="1" max="100" class="form-control" id="inputDescuentoPromocion" name="inputDescuentoPromocion" value="<?=old('inputDescuentoPromocion')?>">
                    <?php if(session('errors.inputDescuentoPromocion')):?>
                    <div class="form-helper text-danger"><?=session('errors.inputDescuentoPromocion')?></div>
                    <?php endif?>
                </div>
                <div class="mb-3">
                    <label for="inputFecIniPromocion" class="form-label">Fecha inicio promoción</label>
                    <input type="date" class="form-control" name="inputFecIniPromocion" id="inputFecIniPromocion" value="<?=old('inputFecIniPromocion')?>">
                    <?php if(session('errors.inputFecIniPromocion')):?>
                    <div class="form-helper text-danger"><?=session('errors.inputFecIniPromocion')?></div>
                    <?php endif?>
                </div>
                <div class="mb-3">
                    <label for="inputFecFinPromocion" class="form-label">Fecha fin promoción</label>
                    <input type="date" class="form-control" name="inputFecFinPromocion" id="inputFecFinPromocion" value="<?=old('inputFecFinPromocion')?>">
                    <?php if(session('errors.inputFecFinPromocion')):?>
                    <div class="form-helper text-danger"><?=session('errors.inputFecFinPromocion')?></div>
                    <?php endif?>
                </div>
                <input type="submit" value="Guardar" class="btn btn-success">
            </form>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-success">Guardar</button> -->
        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- promocionModal -->
<?=$this->include('front/footer');?>
<?=$this->include('admin/jsAdmin');?>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>/assets/js/jquery-3.5.1.js"></script>
<script type="text/javascript" src="<?=base_url();?>/assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>/assets/js/dataTables.bootstrap5.min.js"></script> -->
<script type="text/javascript" src="<?=base_url();?>/assets/js/editPromocion.js"></script>
<script>
    var baseURL= "<?=base_url();?>";
$(document).ready(function() {
    $('#tablaPromociones').DataTable({
        "scrollY": 230,
        "scrollX": true,
        "language": {
            "decimal":        "",
        "emptyTable":     "No hay datos disponibles en la tabla",
        "info":           "Mostrando _START_ a _END_ de _TOTAL_ entradas",
        "infoEmpty":      "Mostrando 0 a 0 de 0 entradas",
        "infoFiltered":   "(filtrado desde _MAX_ total entradas)",
        "infoPostFix":    "",
        "thousands":      ",",
        "lengthMenu":     "Mostrando _MENU_ entradas",
        "loadingRecords": "Cargando...",
        "processing":     "Procesando...",
        "search":         "Buscar:",
        "zeroRecords":    "No se encontraron registros coincidentes",
        "paginate": {
            "first":      "Primero",
            "last":       "Ultimo",
            "next":       "Siguiente",
            "previous":   "Anterior"
        },
        "aria": {
            "sortAscending":  ": activar para ordenar la columna ascendente",
            "sortDescending": ": activar para ordenar la columna descendente"
        }
        }
    } );
});
</script>

</body>
</html>