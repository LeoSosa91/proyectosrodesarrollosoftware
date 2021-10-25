<main class="mt-5 pt-3">
    <div class="content p-4">
        <h1 class="display-5 font-weight-bold"><span class="fas fa-utensils"></span> SERVICIO DE RESERVAS ONLINE</h1>
        <hr class="hr-light">
        <div class="row g-0">
            <div class="col-md-11">
            <h3><strong>REPORTE</strong></h3>
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
                <div class="col-md-5">
                <img src="<?=base_url('/assets/image/report-plato.jpg')?>" class="img-fluid" alt="..." >
                </div>
                <div class="col-md-7">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>No se encontro resultado</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <div class="card-body">
                        <form action="<?=base_URL().'/chef/reportePlato'?>" method="post">
                            <div class="mb-3 col-sm-12 col-md-6">
                                <label class="form-label" for="inputFechaInicioReportePlatos">Ingrese fecha inicio</label>
                                <input type="date" class="form-control" id="inputFechaInicioReportePlatos" name="inputFechaInicioReportePlatos" value="<?= date("Y-m-d")?>">
                            </div>
                            <div class="mb-3 col-sm-12 col-md-6">
                                <label class="form-label" for="inputFechaHastaReportePlatos">Ingrese fecha hasta</label>
                                <input type="date" class="form-control" id="inputFechaHastaReportePlatos" name="inputFechaHastaReportePlatos" value="<?= date("Y-m-d")?>">
                            </div>
                            <button type="submit" class="btn btn-outline-dark">Descargar reporte</button>
                            <button type="button" id="btnObtenerReporteChef" class="btn btn-dark">Obtener reporte</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3" >
            <div class="card-body">
                <div class="row g-0">
                    <span class="d-block">No se encontraron resultados.</span>
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
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type='text/javascript'>
    var baseURL= "<?php echo base_url();?>";
</script>
<script type="text/javascript" src="<?=base_url();?>/assets/js/reportchef.js"></script>
