<main class="mt-5 py-3">
    <div class="content p-4 my-4">
        <h1 class="display-5 font-weight-bold"><span class="fas fa-utensils"></span> SERVICIO DE RESERVAS ONLINE</h1>
        <hr class="hr-light">
        <div class="row g-0">
            <div class="col-md-11">
            <h3><strong>Agregar promocion</strong></h3>
            </div>
            <div class="col-md-1">
                <!-- Button trigger modal -->
                <button type="button" class="" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <img src="https://img.icons8.com/glyph-neue/64/000000/help.png" width="30" height="30"/> 
                </button>
            </div>
        </div>
        <div class="card mb-3 p-3" >
            <div class="row">
                <div class="col-md-5">
                <img src="<?=base_url('/assets/image/Salesman_Outline.png')?>" class="img-fluid" alt="..." >
                </div>
                <div class="col-md-7">
                <div class="card-body">
                        <?php if(session('msg')):?>
                            <div class="alert alert-<?=session('msg.type')?> alert-dismissible fade show" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                                <div>
                                    <strong><?=session('msg.body')?></strong>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif;?>    
                        <h4><strong>Agregar promoción</strong></h4>
                        <form action="<?=route_to('agregarPromocion')?>" method="POST">
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
                            <button type="submit" class="btn btn-dark" width="100px">Guardar</button>
                        </form>
                    </div>
                </div>
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
<!-- <script>
    var baseURL= "<?//base_url();?>";
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