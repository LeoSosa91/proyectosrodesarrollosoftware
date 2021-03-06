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
                    <img src="https://img.icons8.com/glyph-neue/64/000000/help.png" width="30" height="30" />
                </button>
            </div>
        </div>
        <div class="card mb-3">
            <div class="row g-0">
                <?php if (session('msg')) : ?>
                    <div class="alert alert-<?= session('msg.type') ?> alert-dismissible fade show" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                            <use xlink:href="#exclamation-triangle-fill" />
                        </svg>
                        <div><strong><?= session('msg.body') ?></strong></div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <div class="col-md-12 col-lg-3">
                    <div class="card-body">
                        <h4><strong>Editar bebida</strong></h4>
                        <form action="<?= base_url('menu/bebida/editarBebida') ?>" method="post">
                            <input type="hidden" name="idBebida" id="idBebida">
                            <div class="mb-3">
                                <label class="form-label" for="inputNameDrink">Ingrese nombre de bebida</label>
                                <input type="text" class="form-control" id="inputNameDrink" placeholder="Nombres" name="inputNameDrink" value="<?= old('inputNameDrink') ?>">
                                <?php if (session('errors.inputNameDrink')) : ?>
                                    <div class="form-helper text-danger"><?= session('errors.inputNameDrink') ?></div>
                                <?php endif ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="typeDrink">Seleccione tipo de bebida</label>
                                <select class="form-select" id="typeDrink" name="typeDrink">
                                    <option <?php echo (old('typeDrink') == "0") ? 'selected' : ''; ?> value="0">---</option>
                                    <option <?php echo (old('typeDrink') == "1") ? 'selected' : ''; ?> value="1">BEBIDAS SIN ALCOHOL</option>
                                    <option <?php echo (old('typeDrink') == "2") ? 'selected' : ''; ?> value="2">CERVEZAS</option>
                                    <option <?php echo (old('typeDrink') == "3") ? 'selected' : ''; ?> value="3">VINOS</option>
                                    <option <?php echo (old('typeDrink') == "4") ? 'selected' : ''; ?> value="4">COCTELES</option>
                                </select>
                                <?php if (session('errors.typeDrink')) : ?>
                                    <div class="form-helper text-danger"><?= session('errors.typeDrink') ?></div>
                                <?php endif ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="stateFood">Estado</label>
                                <select class="form-select" id="stateDrink" name="stateDrink">
                                    <option <?php echo (old('stateDrink') == "") ? 'selected' : ''; ?> value="">---</option>
                                    <option <?php echo (old('stateDrink') == "0") ? 'selected' : ''; ?> value="0">Habilitado</option>
                                    <option <?php echo (old('stateDrink') == "1") ? 'selected' : ''; ?> value="1">Deshabilitado</option>
                                </select>
                                <?php if (session('errors.stateDrink')) : ?>
                                    <div class="form-helper text-danger"><?= session('errors.stateDrink') ?></div>
                                <?php endif ?>
                            </div>
                            <div class="mb-3">
                                <label for="inputPrice" class="form-label">Ingrese precio de la bebida</label>
                                <input type="number" class="form-control" name="inputPrice" id="inputPrice" placeholder="100.00" value="<?= old('inputPrice') ?>">
                                <?php if (session('errors.inputPrice')) : ?>
                                    <div class="form-helper text-danger"><?= session('errors.inputPrice') ?></div>
                                <?php endif ?>
                            </div>
                            <button type="submit" class="btn btn-dark">Guardar cambios</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-12 col-lg-9">
                    <div class="card-body">
                        <table id="tablaEditarBebida" class="display nowrap" style="width:100%">
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
                                    echo '<tr>
                            <td>' . $beverage['nombreBebida'] . '</td>';

                                    foreach ($typeBeverages as $typeBeverage) {
                                        // if ($beverage['tipoBebida']==$typeBeverage['idCategoriaBebida']) {
                                        if ($beverage['idCategoriaBebida'] == $typeBeverage['idCategoriaBebida']) {
                                            echo '<td>' . $typeBeverage['nombreCategoriaBebida'] . '</td>';
                                        }
                                    }
                                    if ($beverage['deleted_at'] == null) {
                                        echo '<td>Habilitado</td>';
                                    } else {
                                        echo '<td>Deshabilitado</td>';
                                    }

                                    echo '<td>' . $beverage['precioBebida'] . '</td>
                            <td>
                            
                            <button type="button" class="btn btn-warning" data-id=' . $beverage['idBebida'] . '>
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
                <h5 class="modal-title" id="exampleModalLabel">Ayuda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ol class="list-group list-group-numbered">
                    <li class="list-group-item">Debe seleccionar el boton de modificar para poder comenzar a editar la bebida</li>
                    <li class="list-group-item">Al tenes los campos rellenos por la bebida seleccionanda, puede comenzar a editar los campos que usted desee</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<?= $this->include('front/footer'); ?>
<?= $this->include('admin/jsAdmin'); ?>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<script>
    var baseURL = "<?= base_url(); ?>";
    $(document).ready(function() {

        $('#tablaEditarBebida').DataTable({
            "scrollY": 230,
            "scrollX": true,
            "language": {
                "decimal": "",
                "emptyTable": "No hay datos disponibles en la tabla",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
                "infoFiltered": "(filtrado desde _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrando _MENU_ entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "No se encontraron registros coincidentes",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "aria": {
                    "sortAscending": ": activar para ordenar la columna ascendente",
                    "sortDescending": ": activar para ordenar la columna descendente"
                }
            }

        });
    });
</script>
<script type="text/javascript" src="<?= base_url(); ?>/assets/js/editBeverage.js"></script>

<!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>/assets/js/jquery-3.5.1.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>/assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>/assets/js/dataTables.bootstrap5.min.js"></script>

<script>
    var baseURL= "<?php echo base_url(); ?>";
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
</script> -->

</body>

</html>