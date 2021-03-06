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

                    <div class="card-body">
                      <?php if(session('msg')):?>
                <div class="alert alert-<?=session('msg.type')?> alert-dismissible fade show" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                    <div><strong><?=session('msg.body')?></strong></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif;?>
                        <form action="<?=base_URL().'/admin/reporteRanking'?>" method="post" id="formReporAdmin">
                            <div class="mb-3 col-sm-12 col-md-6" id="contRepo1">
                                <label class="form-label" for="inputTipoReporte">Ingrese tipo de reporte</label>
                                <select name="inputTipoReporte" id="inputTipoReporte" class="form-select" aria-label="Default select example">
                                    <option value="0">---</option>
                                    <option value="1">Ranking platos</option>
                                    <option value="2">Reservas canceladas</option>
                                    <option value="3">Horarios m??s demandados</option>
                                    <option value="4">Clientes que no asistieron</option>
                                    <option value="5">Reservas del dia</option>
                                </select>
                                <div class="form-helper mb-5 text-danger" id="errortipo"><?=session('errors.inputTipoReporte')?></div>
                            </div>
                            <div class="mb-3 col-sm-12 col-md-6" id="contRepo2">
                                <label class="form-label" for="inputFechaInicioReportePlatos">Ingrese fecha inicio</label>
                                <input type="date" class="form-control"  id="inputFechaInicioReportePlatos" name="inputFechaInicioReportePlatos" value="<?=(old('inputFechaInicioReportePlatos')) ? old('inputFechaInicioReportePlatos') : date("Y-m-d") ;?>">
                                <div class="form-helper mb-5 text-danger" id="errorini"><?=session('errors.inputFechaInicioReportePlatos')?></div>
                            </div>
                            <div class="mb-3 col-sm-12 col-md-6" id="contRepo3">
                                <label class="form-label" for="inputFechaHastaReportePlatos">Ingrese fecha hasta</label>
                                <input type="date" class="form-control"  id="inputFechaHastaReportePlatos" name="inputFechaHastaReportePlatos" value="<?= date("Y-m-d")?>">
                                <div class="form-helper mb-5 text-danger" id="errorfin"><?=session('errors.inputFechaHastaReportePlatos')?></div>
                            </div>
                            <button type="submit" class="btn btn-outline-dark">Descargar reporte</button>
                            <button type="button" class="btn btn-dark" id="btnObtenerReporte">Obtener reporte</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3" >
            <div class="card-body p-4" id="resultado">
                <span id="noresadm" class="d-block">No se encontraron resultados.</span>
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
        ...
      </div>
    </div>
  </div>
</div>
<?//$this->include('admin/footer');?>

<!--Footer-->
<footer class="fixed-bottom bg-light text-lg-start mt-3">
    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        ?? 2021 Copyright: SRO Version 0.0.3
    </div>
    <!-- Copyright -->
</footer>
<!--Footer-->

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>/assets/js/script.js"></script>
<script type="text/javascript" src="<?=base_url();?>/assets/js/report.js"></script>
<script type='text/javascript'>
    var baseURL= "<?php echo base_url();?>";
    var urlValidarReporte= "<?=base_url(route_to('validarReporte'));?>";
    var urlValidarReportePas= "<?=base_url(route_to('validarReportepas'));?>";
    var urlImprimirReporte= "<?=base_url(route_to('imprimirReporte'));?>";
    
    
</script>
</body>
</html>