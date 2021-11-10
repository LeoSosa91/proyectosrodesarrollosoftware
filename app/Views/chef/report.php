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
                    <img src="https://img.icons8.com/glyph-neue/64/000000/help.png" width="30" height="30" />
                </button>
            </div>
        </div>
        <div class="card mb-3">
            <div class="row g-0">
                <div class="col-md-5">
                    <img src="<?= base_url('/assets/image/report-plato.jpg') ?>" class="img-fluid" alt="...">
                </div>
                <div class="col-md-7">
                    <div class="card-body">
                        <?php if (session('msg')) : ?>
                            <div class="alert alert-<?= session('msg.type') ?> alert-dismissible fade show" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                                    <use xlink:href="#exclamation-triangle-fill" />
                                </svg>
                                <div><strong><?= session('msg.body') ?></strong></div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        <form action="<?= base_URL() . '/chef/reportePlato' ?>" method="post">
                            <div class="mb-3 col-sm-12 col-md-6">
                                <label class="form-label" for="inputFechaInicioReportePlatos">Ingrese fecha inicio</label>
                                <input type="date" class="form-control" min="<?php echo date("Y-m-d") ?>" id="inputFechaInicioReportePlatosChef" name="inputFechaInicioReportePlatosChef" value="<?= date("Y-m-d") ?>">
                            </div>
                            <div class="mb-3 col-sm-12 col-md-6">
                                <label class="form-label" for="inputFechaHastaReportePlatos">Ingrese fecha hasta</label>
                                <input type="date" class="form-control" min="<?php echo date("Y-m-d") ?>" id="inputFechaHastaReportePlatosChef" name="inputFechaHastaReportePlatosChef" value="<?= date("Y-m-d") ?>">
                            </div>
                            <button type="submit" class="btn btn-outline-dark">Descargar reporte</button>
                            <button type="button" id="btnObtenerReporteChef" class="btn btn-dark">Obtener reporte</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div id="contenedorRepo" class="row g-0">
                    <span id="nores" class="d-block"></span>
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
                ...
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
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type='text/javascript'>
    var baseURL = "<?php echo base_url(); ?>";
</script>
<script type="text/javascript" src="<?= base_url(); ?>/assets/js/reportchef.js"></script>
</body>

</html>