<main class="mt-5 py-3">
    <div class="content p-4 my-4">
        <h1 class="display-5 font-weight-bold"><span class="fas fa-utensils"></span> SERVICIO DE RESERVAS ONLINE</h1>
        <hr class="hr-light">
        <div class="row g-0">
            <div class="col-md-11">
            <h3><strong>Mis reservas realizadas</strong></h3>
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
                <table id="tablaReservaHechas" class="table table-striped" style="width:100%; height:100%">
                    <thead>
                        <tr>
                            <th>Turno</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Total a Pagar</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($reservasHechas as $reserva) {
                            echo'<tr role="row">';
                            echo'<td>'.$reserva['turnoReserva'].'</td>';
                            echo'<td>'.date_format(date_create($reserva['fechaReserva']), 'd/m/Y').'</td>';
                            echo'<td>'.$reserva['horario'].'</td>';
                            echo'<td>$'.$reserva['precioTotalReserva'].'</td>';
                            echo'<td>'.$reserva['estadoReserva'].'</td>';
                            echo'</tr>';
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

<?=$this->include('clients/footer');?>
<?=$this->include('clients/jsClient');?>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
    $('#tablaReservaHechas').DataTable( {
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
        }
    } );
} );
</script>