<main class="mt-5 pt-3">
    <div class="content p-4">
        <h1 class="display-5 font-weight-bold"><span class="fas fa-utensils"></span> SERVICIO DE RESERVAS ONLINE</h1>
        <hr class="hr-light">
        <div class="row g-0">
            <div class="col-md-11">
            <h3><strong>RESERVA DE MESA</strong></h3>
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
                        <form action="" method="post">
                            <fieldset id="campo1">
                                <div class="mb-3 col-sm-12 col-md-6">
                                    <label class="form-label" for="selectCantPers">Cantidad de personas</label>
                                    <select class="form-select" id="selectCantPers" aria-label="Default select example">
                                        <option selected value="0">---</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-sm-12 col-md-6">
                                <label class="form-label" for="inputFecha">Fecha</label>
                                <input type="date" class="form-control" id="inputFecha" name="inputFecha" value="<?= date("Y-m-d")?>" min="<?= date("Y-m-d")?>">
                                </div>
                                <div class="mb-3 col-sm-12 col-md-6">
                                    <label class="form-label" for="idTurnoRes">Turno</label>
                                    <select class="form-select" id="idTurnoRes" aria-label="Default select example" >
                                        <option value="" selected="selected">Seleccione el turno</option>
                                        <option value="Almuerzo" >Almuerzo</option>
                                        <option value="Cena">Cena</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-sm-12 col-md-6">
                                    <label class="form-label" for="idHora">Hora</label>
                                    <select class="form-select" id="idHora" aria-label="Default select example">
                                        <option value="" selected="selected">Seleccione un horario...</option>
                                    </select>
                                </div>
                                <div id="mensajeConsulta">

                                </div>
                                <input type="button" id="btnConsultar" name="btnConsultar" class="btn btn-outline-secondary" value="Consultar" />
                                <input type="button" style="visibility: hidden" name="next" id="btnSiguiente" class="next btn btn-info" value="Siguiente"/>
                            </fieldset>    
                            <fieldset id="campo2">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                 
                                  <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#foodModal"><i class="fas fa-plus"></i> Plato</button>
                                  <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#beverageModal"><i class="fas fa-plus"></i>Bebida</button>
                                </div>
                                <div class="container mb-3" id="menusPlatosBebidas"></div>
                           
                                <input type="button" name="previous" class="previous btn btn-default" value="Previo" />
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" id="btnReservar" >Reservar</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

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

<template id="template-carrito">
  <tr>
    <td colspan="2">Café</td>
    <td>1</td>
    <td>$ <span>500</span></td>
  </tr>
</template>
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
<!-- beverageModal -->
<div class="modal fade" id="beverageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Bebidas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Bebida</th>
                <th scope="col">Tipo</th>
                <th scope="col">Precio</th>
                <th scope="col">Gestionar</th>
                </tr>
            </thead>
            <tbody id="items-bebidas"></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- foodModal -->
<div class="modal fade" id="foodModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Platos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre Plato</th>
                <th scope="col">Ingredientes</th>
                <th scope="col">Tipo</th>
                <th scope="col">Precio</th>
                <th scope="col">Gestionar</th>
                </tr>
            </thead>
            <tbody id="items-plato"></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- errorModal -->
<div class="modal fade" id="errorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger bg-gradient">
        <p class="display-6 text-white">ERROR</p>
      </div>
      <div class="modal-body">
        <p class="text-danger">Se encontró al menos un pedido sin completar. Por favor que recuerde los pedidos deben tener al menos una bebida y un plato.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Entendido</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="reservaModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="exampleModalLabel">Mi reserva</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="contenedorTexto"></div>
        <h4>TOTAL A PAGAR: $ <span id="idPTotalAPagar"></span></h4>
        <h5>¿Desea registrar la reserva con los datos solicitados</h5>
      </div>
      <form class="" action="<?= base_url().'/clients/reservar/guardarReserva'  ?>" method="post">
          <input type="hidden" id="idUser" name="idUser" value="<?=session('id_user')  ?>">
          <input type="hidden" id="idMesaRes" name="idMesaRes" value="">
          <input type="hidden" id="fechaRes" name="fechaRes" value="">
          <input type="hidden" id="preciototal" name="preciototal" value="">
          <input type="hidden" id="turno" name="turno" value="">
          <input type="hidden" id="horario" name="horario" value="">
          <input type="hidden" id="idprom" name="idprom" value="">
          <input type="hidden" id="pedidos" name="pedidos" value="pedidos xxxxxx">
          <div class="modal-footer">
            <input type="submit" class="btn btn-primary" name="" value="SI">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Salir</button>
          </div>
          
      </form>
    </div>
  </div>
</div>

<script type='text/javascript'>
    var baseURL= "<?= base_url();?>";
</script>