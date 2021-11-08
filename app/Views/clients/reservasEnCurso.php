<main class="mt-5 py-3">
    <div class="content p-4 my-4">
        <h1 class="display-5 font-weight-bold"><span class="fas fa-utensils"></span> SERVICIO DE RESERVAS ONLINE</h1>
        <hr class="hr-light">
        <div class="row g-0">
            <div class="col-md-11">
            <h3><strong>Mis reservas en curso</strong></h3>
            </div>
            <div class="col-md-1">
                <!-- Button trigger modal -->
                <button type="button" class="" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <img src="https://img.icons8.com/glyph-neue/64/000000/help.png" width="30" height="30"/> 
                </button>
            </div>
        </div>
        <div class="card mb-3" >
            <div class="content p-4">
            <?php if(session('msg')):?>
                <div class="alert alert-<?=session('msg.type')?> alert-dismissible fade show" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                    <div><strong><?=session('msg.body')?></strong></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif;?>
                <table id="tablaReservasEnCurso" class="display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Turno</th>
                            <th>Total a Pagar</th>
                            <th>Estado</th>
                            <th>Gestionar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $fecha_actual = new DateTime("now");
                        if (sizeof($reservasEnCurso)>0) {
                            foreach ($reservasEnCurso as $reserva) {
                                echo '<tr role="row" >';
                                echo'<td class="fecha" fecha="'.$reserva['fechaReserva'].'">'.date_format(date_create($reserva['fechaReserva']), 'd/m/Y').'</td>';
                                echo'<td class="hora" hora="'.$reserva['horario'].'">'.$reserva['horario'].'</td>';
                                echo '<td scope="row" class="reserva" id="'.$reserva['idReserva'].'">'.$reserva['turnoReserva'].'</td>';
                                echo'<td>$'.$reserva['precioTotalReserva'].'</td>';
                                $fecha_entrada = new DateTime($reserva['fechaReserva']." ".$reserva['horario'].":00");        
                                $diff = $fecha_entrada->diff($fecha_actual);        
                                echo'<td>'.$reserva['estadoReserva'].'</td>
                                    <td>';
                        ?>
                        <?php if ($diff->days>=2 && $diff->h>=48) {?>
                        <button type="button" class="btn btn-warning btnModificarReserva" data-bs-toggle="modal" data-bs-target="#modifyOrderModal">
                            <i class="fas fa-edit mr-2"></i> Modificar
                        </button>
                        <?php }?>
                            <button type="button" class="btn btn-danger btnCancelarReserva" data-bs-toggle="modal" data-bs-target="#modalCancelarReserva">
                                <i class="fas fa-trash mr-2"></i> Cancelar
                            </button>
                        <?php
                                echo '</td>
                                    </tr>';
                            }
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
<!-- modifyOrderModal modal-fullscreen-xl-down-->

<div class="modal fade" id="modifyOrderModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="modifyOrderModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tu pedido</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12">
                    <div class="list-group list-group-horizontal" id="list-tab" role="tablist">
                        <a class="list-group-item list-group-item-action list-group-item-dark active" id="list-home-list" data-bs-toggle="list" href="#list-fecha-horario" role="tab" aria-controls="list-home">Fecha - Horario</a>
                        <a class="list-group-item list-group-item-action list-group-item-dark" id="list-pedido-list" data-bs-toggle="list" href="#list-pedido" role="tab" aria-controls="list-pedido">Pedido</a>
                    </div>
                </div>
                <div class="col-12">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="list-fecha-horario" role="tabpanel" aria-labelledby="list-fecha-horario-list">
                            <form action="<?= base_url('/clients/reservar/modificarDatosReserva')?>" method="post">
                                <div class="mt-3 mb-3 col-sm-12">
                                    <label class="form-label" for="selectCantPers">Cantidad de personas</label>
                                    <select class="form-select" id="selectCantPers" disabled aria-label="Default select example">
                                        <option selected value="0">---</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-sm-12">
                                <label class="form-label" for="inputFecha">Fecha</label>
                                <input type="date" class="form-control" id="inputFecha" name="inputFecha" value="<?= date("Y-m-d")?>" min="<?= date("Y-m-d")?>">
                                </div>
                                <div class="mb-3 col-sm-12">
                                    <label class="form-label" for="idTurnoRes">Turno</label>
                                    <select class="form-select" id="idTurnoRes" name="idTurnoRes" aria-label="Default select example" >
                                        <option value="" selected="selected">Seleccione el turno</option>
                                        <option value="Almuerzo" >Almuerzo</option>
                                        <option value="Cena">Cena</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-sm-12">
                                    <label class="form-label" for="idHora">Hora</label>
                                    <select class="form-select" id="idHora" name="idHora" aria-label="Default select example">
                                        <option value="" selected="selected">Seleccione un horario...</option>
                                    </select>
                                </div>
                                <input type="hidden" name="idMesaRes" id="idMesaRes">
                                <input type="hidden" name="idReserva" id="idReserva">
                                
                                <div id="mensajeConsulta">

                                </div>
                                <div id="item">
                                    <input type="button" id="btnConsultar" name="btnConsultar" class="btn btn-outline-secondary" value="Consultar" />
                                </div>
                                
                            </form>
                        </div>
                        <div class="tab-pane fade" id="list-pedido" role="tabpanel" aria-labelledby="list-pedido-list">
                            <table class="table table-hover" id="tablaPedidoModificar">
                                <thead>
                                    <tr>
                                    <th>#</th>
                                    <th>Nro Pedido</th>
                                    <th>Nombre producto</th>
                                    <th>Cantidad</th>
                                    <th>Tipo</th>
                                    <th>Precio</th>
                                    <th>Modificar?</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="5">Sin datos para mostrar</td>
                                    </tr>
                                </tbody> 
                            </table>
                            <div class="collapse" id="collapseExample">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div> 
<!-- modifyOrderModal -->
<template id="template-footer">
    <th>
        <button class="btn btn-danger btn-sm" id="vaciar-carrito" type="button">
            Vaciar menu
        </button>
    </th>
    <th scope="row" colspan="1">Total productos</th>
    <td>10</td>
    <td class="font-weight-bold">$ <span>5000</span></td>
</template>
<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalToggleLabel">Cambiar Plato/Bebida</h5>
        </div>
        <div class="modal-body">
            <div id="contenedorFormModificar">
                
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" data-bs-target="#modifyOrderModal" data-bs-toggle="modal">Volver atras</button>
        </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalToggle2" aria-hidden="true" data-bs-backdrop="static" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel2">Modal 2</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Hide this modal and show the first with the button below.
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-bs-target="#modifyOrderModal" data-bs-toggle="modal">Back to first</button>
            </div>
        </div>
    </div>
</div>
<!--Modal: modalCancelarReserva-->
<div class="modal fade" id="modalCancelarReserva" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="msgCancelarReserva">Estas seguro de cancelar?</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            
        </div>
        <div class="modal-footer flex-center">
            <form id="formCancelarReserva" action="<?=base_url('clients/reservar/cancelarReserva')?> " method="post">
            <input type="hidden" name="tipoCancelacion" id="tipoCancelacion" value="">
            <input type="hidden" name="idReservaCancelar" id="idReservaCancelar" value=" ">
            <input type="submit" value="SI" class="btn btn-danger">
            <a type="button" class="btn btn btn-outline-danger" data-bs-dismiss="modal">NO</a>
            </form>
        </div>
    </div>
  </div>
</div>
<!--Modal: modalCancelarReserva-->
<?=$this->include('clients/footer');?>
<?=$this->include('clients/jsClient');?>

<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>


<script>
    var baseURL= "<?= base_url();?>";
    $(document).ready(function() {
    $('#tablaReservasEnCurso').DataTable( {
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
} );
</script>
<script type="text/javascript" src="<?=base_url();?>/assets/js/gestionReserva.js"></script>