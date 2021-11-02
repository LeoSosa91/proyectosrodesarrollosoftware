<main class="mt-5 py-3">
    <div class="content p-4 my-4">
        <h1 class="display-5 font-weight-bold"><span class="fas fa-utensils"></span> SERVICIO DE RESERVAS ONLINE</h1>
        <hr class="hr-light">
        <div class="row g-0">
            <div class="col-md-11">
            <h3><strong>Clientes</strong></h3>
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
                <table id="tablaClientes" class="display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>DNI</th>
                            <th>Apellido</th>
                            <th>Nombre</th>
                            <th>Fecha de Nacimiento</th>
                            <th>Email</th>
                            <th>Estado</th>
                            <th>Gestionar</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                        foreach ($listadoClientes as $cliente) {
                          echo '<tr role="row">';
                          echo '<td scope="row" class="cliente" data-id="'.$cliente['id_user'].'">'.$cliente['dniUsuario'].'</td>';
                          echo '<td role="row">'.$cliente['usersurname'].'</td>';
                          echo '<td role="row">'.$cliente['username'].'</td>';
                          echo '<td role="row">'.date("d/m/Y", strtotime($cliente['userBirthday'])).'</td>';
                          echo '<td role="row">'.$cliente['useremail'].'</td>';
                          if ($cliente['deleted_at']!=null) {
                            echo'<td role="row">Deshabilitado</td>';
                            echo '<td role="row">
                            <button type="button" class="btn btn-outline-info btnPenalidades" data-bs-toggle="modal" data-bs-target="#modalPenalidad" title="Ver Penalidades">
                              <i class="far fa-id-badge"></i> 
                            </button>
                            <button type="button" class="btn btn-outline-warning btnModificarCliente" data-bs-toggle="modal" data-bs-target="#modalClients" title="Modificar">
                              <i class="fas fa-edit mr-2"></i> 
                            </button>
                            <button type="button" class="btn btn-outline-success btnHabilitarCliente" data-bs-toggle="modal" data-bs-target="#modalConfirmarHabilitacion" title="Habilitar">
                              <i class="fas fa-user-plus"></i>
                            </button>
                            </td>';
                          }else{
                            echo'<td role="row">Habilitado</td>';
                            echo '<td role="row">
                              <button type="button" class="btn btn-outline-info btnPenalidades" data-bs-toggle="modal" data-bs-target="#modalPenalidad" title="Ver Penalidades">
                                <i class="far fa-id-badge"></i> 
                              </button>
                              <button type="button" class="btn btn-outline-warning btnModificarCliente" data-bs-toggle="modal" data-bs-target="#modalClients" title="Modificar">
                                <i class="fas fa-edit mr-2"></i> 
                              </button>
                              <button type="button" class="btn btn-outline-danger btnDeshabilitarCliente" data-bs-toggle="modal" data-bs-target="#modalConfirmDelete" title="Deshabilitar">
                                <i class="fas fa-trash mr-2"></i>
                              </button>
                            </td>';
                          }
                          echo '</tr>';
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
<!-- modalPenalidad -->
<div class="modal fade" id="modalPenalidad" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Penalidades</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <table class="table table-hover idTablaPenalidades" id="idTablaPenalidades">
                <thead>
                    <th>#</th>
                    <th>Penalidades</th>
                </thead>
                <tbody>
                  <tr>
                    <td colspan="2">Sin datos</td>
                  </tr>
                </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- modalPenalidad -->
<!-- modalClients -->
<div class="modal fade" id="modalClients" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Datos personales</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3 needs-validation" novalidate id="formModificarCliente">
          <div class="input-group mb-3 has-validation" id="contenedorDniUsuario">
            <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock prefix"></i></span>
            <input type="text" id="dniUsuario" name="dniUsuario" class="form-control" placeholder="DNI" aria-label="DNI" aria-describedby="basic-addon1" value="<?= old('dniUsuario') ?>" required>
          </div>
          <div class="input-group mb-3 has-validation" id="contenedorApellidoUsuario">
            <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock prefix"></i></span>
            <input type="text" id="apellidoUsuario" name="apellidoUsuario" class="form-control" placeholder="Apellido" aria-label="Apellido" aria-describedby="basic-addon1" value="<?= old('apellidoUsuario') ?>" required>
          </div>
          <div class="input-group mb-3 has-validation" id="contenedorNombreUsuario">
            <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock prefix"></i></span>
            <input type="text" id="nombreUsuario" name="nombreUsuario" class="form-control" placeholder="Nombre" aria-label="Nombre" aria-describedby="basic-addon1" value="<?= old('nombreUsuario') ?>" required>
          </div>
          <div class="input-group mb-3 has-validation" id="contenedorFechaNacUsuario">
            <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock prefix"></i></span>
            <input type="date" id="fechaNacUsuario" name="fechaNacUsuario" class="form-control" placeholder="Fecha de nacimiento" aria-label="Fecha de nacimiento" aria-describedby="basic-addon1" value="<?= old('fechaNacUsuario') ?>" required>
          </div>
          <div class="input-group mb-3 has-validation" id="contenedorCorreoUsuario">
            <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock prefix"></i></span>
            <input type="email" id="correoUsuario" name="correoUsuario" class="form-control" placeholder="Correo electronico" aria-label="Correo electronico" aria-describedby="basic-addon1" value="<?= old('correoUsuario') ?>" required>
          </div>
          <div class="input-group mb-3 has-validation" id="contenedorDireccionUsuario">
            <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock prefix"></i></span>
            <input type="text" id="direccionUsuario" name="direccionUsuario" class="form-control" placeholder="Direccion" aria-label="Direccion" aria-describedby="basic-addon1" value="<?= old('direccionUsuario') ?>" required>
          </div>
          <div class="input-group mb-3 has-validation" id="contenedorTelefonoUsuario">
            <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock prefix"></i></span>
            <input type="tel" id="telefonoUsuario" name="telefonoUsuario" class="form-control" placeholder="Telefono/Celular" aria-label="Telefono/Celular" aria-describedby="basic-addon1" value="<?= old('telefonoUsuario') ?>" pattern="[0-9]{4}[0-9]{3}[0-9]{3}" required>
          </div>
          <input type="hidden" name="idUser" id="idUser">
          <div class="col-12">
            <button class="btn btn-success" type="button" id="btnModificarCliente">Modificar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- modalClients -->
<!-- modalConfirmarHabilitacion -->
<div class="modal fade" id="modalConfirmarHabilitacion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Estas seguro de Habilitar?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-footer">
        <form action="<?=base_url('/admin/habilitarCliente')?>" method="post">
        <input type="hidden" name="idUserHabilitar" id="idUserHabilitar">
        <button type="submit" class="btn btn-success">SI</button>
        <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">NO</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- modalConfirmarHabilitacion -->
<!-- modalConfirmDelete -->
<div class="modal fade" id="modalConfirmDelete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Estas seguro de eliminar?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-footer">
        <form action="<?=base_url('/admin/borrarCliente')?>" method="post">
        <input type="hidden" name="idUserDelete" id="idUserDelete">
        <button type="submit" class="btn btn-danger">SI</button>
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">NO</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- modalConfirmDelete -->
<?=$this->include('front/footer');?>
<?=$this->include('admin/jsAdmin');?>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="<?=base_url();?>/assets/js/gestionCliente.js"></script>
<script type="text/javascript" src="<?=base_url();?>/assets/js/validarFormEditarCliente.js"></script>
<script>
    var baseURL= "<?= base_url();?>";
    $(document).ready(function() {
      $('#tablaClientes').DataTable({
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
        
      });
    } );
</script>