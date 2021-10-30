let listadoPlatos
// let idReservaPrevia=null
let valor = false
$(document).ready(function(){
  let horarioPrevio=null
  let idReservaPrevia=null
  // const itemsPedidos = document.getElementById('tablaPedidoModificar')
  // itemsPedidos.addEventListener('click',e=>{addCarrito(e)})
  // const addCarrito= e=>{
    
  //   if (e.target.classList.contains('btn')) {
  //       // setCarrito(e.target.parentElement)
  //       console.log(e.target.classList.contains('btn'))
  //       // console.log(e.target.parentElement);
  //   }
  // }
$(".btnCancelarReserva").click(function() {
    var fecha=$(this).parents("tr").find(".fecha").attr("fecha");
    var hora=$(this).parents("tr").find(".hora").attr("hora");
    var idReserva=$(this).parents("tr").find(".reserva").attr("id");
    var fechaActual = new Date();
    var fechaEntrada = new Date(fecha+"T"+hora+":00");
    var diffMs = (fechaEntrada - fechaActual); // milisegundos entre fecha actual y fecha entrada
    var diffDays = Math.floor(diffMs / 86400000); // dias
    var diffDaysInHrs = diffDays*24; // dias en horas
    var diffHrs = Math.floor((diffMs % 86400000) / 3600000); // horas
    var totalHrs=diffHrs+diffDaysInHrs;
    console.log(idReserva)
    $("#idReservaCancelar").val(idReserva);
    if (totalHrs>=48) {
      $("#msgCancelarReserva").text('¿Desea cancelar su reserva?');
      console.log("cancelar sin penalidad");
      $("#tipoCancelacion").val("SinPenalidad");
    }else {
      $("#msgCancelarReserva").text('¿Desea cancelar su reserva? Si lo hace tendra una penalidad');
      console.log("cancelar con penalidad");
      $("#tipoCancelacion").val("ConPenalidad");
    }
});
$(".btnModificarReserva").click(function() {
    var idReserva=$(this).parents("tr").find(".reserva").attr("id");
    idReservaPrevia=$(this).parents("tr").find(".reserva").attr("id");
    $.ajax({
      url:baseURL+"/clients/reservar/obtenerReservaCliente",
      method: 'post',
      data: {id: idReserva},
      dataType: 'json',
      success:function(data){
        $("#inputFecha").val(data['reserva'][0]['fechaReserva']);
        $("#idTurnoRes").val(data['reserva'][0]['turnoReserva']);
        $('#idTurnoRes').change();
        
        $("#idHora").val(data['reserva'][0]['horario']);
        $('#idHora').change();
        $("#selectCantPers").val(data['cantPedido'][0]['cantPedido']);

        horarioPrevio=data['reserva'][0]['horario'];
        // listadoPlatos=data['platos'];
        cargarTablaModificarPedidos(data['platos'],data['bebidas']); 
        // consultarMesa(data['cantPedido'][0]['cantPedido'],data['reserva'][0]['fechaReserva'],data['reserva'][0]['horario']);
      }
      
    })
});

  $("#idTurnoRes").change(function () {
    var horario = {
      Almuerzo: ["12:00", "13:00", "14:00"],
      Cena: ["20:00", "21:00", "22:00", "23:00", "00:00","01:00"]
    }
    var hora = document.getElementById('idHora')
    var turno = document.getElementById('idTurnoRes')
    var turnoSeleccionada = turno.value
    hora.innerHTML = '<option value="">Seleccione un horario...</option>'
    
    if(turnoSeleccionada !== ''){
      turnoSeleccionada = horario[turnoSeleccionada]
      turnoSeleccionada.forEach(function(horario){
        let opcion = document.createElement('option')
        opcion.value = horario
        opcion.text = horario
        hora.add(opcion)
      });
    }
  });
  $("#btnConsultar").click(function () {
    var cantPers = document.getElementById('selectCantPers').value;
    var fecha = $('#inputFecha').val();
    var hora = $("#idHora option:selected").val();
    console.log(cantPers)
    console.log(fecha)
    console.log(hora)
    $.ajax({
      url:baseURL+"/clients/reservar/consultarReserva",
      method: 'post',
      data: {cantPers: cantPers,fechaRes:fecha,horario:hora},
      dataType: 'json',
      success: function (res) {
        console.log(res.status)
       var mensajeConsulta=document.getElementById('mensajeConsulta');
       var mgsAlert="";
        if (res.status==false) {
            mgsAlert='<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>No puede realizar la reserva dado que ya hay registro de otra reserva para la fecha seleccionada</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
        } else {
            if (res.statusMesaEncontrada==false) {
            mgsAlert='<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>No hay mesa disponible. Intente nuevamente</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
            console.log(res.statusMesaEncontrada)
            } else {
                console.log(res.statusMesaEncontrada)
            mgsAlert='<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Hay una mesa disponible para su reserva en la fecha '+fecha+'. Puede continuar haciendo click en el boton "Siguiente" de la reserva</strong><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
        }
        }
            mensajeConsulta.innerHTML=mgsAlert;
            var something = $('<input/>').attr({ type: 'submit', id:'modificarReserva',name:'modificarReserva', value:'Modificar Reserva',class:"btn btn-success" });
             $("#item").append(something);
             document.getElementById('idMesaRes').value = res.data.numeroMesa;
             document.getElementById('idReserva').value = idReservaPrevia;
            // document.getElementById('idMesaRes').value = res.data.numeroMesa;
            // document.getElementById("btnSiguiente").style.visibility="visible";
            
     
      } 
    })
       
  })
  
})
const crearOptionsSelectPlato=(listadoPlatos)=>{
  var selectModPedPlato = document.getElementById('selectModPedPlatoBebida')
  listadoPlatos.forEach(function(plato){
    let opcion = document.createElement('option')
    opcion.value = plato.idPlato
    opcion.text = plato.nombrePlato
    selectModPedPlato.add(opcion)
  })
}
const crearOptionsSelectBebida=(listadoBebidas)=>{
  var selectModPedBebidas = document.getElementById('selectModPedPlatoBebida')
  listadoBebidas.forEach(function(bebida){
    let opcion = document.createElement('option')
    opcion.value = bebida.idBebida
    opcion.text = bebida.nombreBebida
    selectModPedBebidas.add(opcion)
  })
}
const listarBebidas =()=>{
  $.ajax({
    url:baseURL+'/menu/bebida/listarBebidas',
    type:'post',
    dataType: 'json',
    success:function(data){
      crearOptionsSelectBebida(data.data)
    }
  });
}

const listarPlatos =()=>{
  $.ajax({
    url:baseURL+'/menu/plato/listarPlatos',
    type:'post',
    dataType: 'json',
    success:function(data){
      crearOptionsSelectPlato(data.data)
    }
  });
}
const cargarFormModificarPedidoPlatoBebida =(tipo,id,nombre,nroPedido,cantidad,idReserva)=>{
  $('#contenedorFormModificar').empty()
  $('<form/>').attr({class:'mb-3',id:'formMod',method:'post',action:baseURL+'/clients/reservar/modificarPedidoPlatoBebidaCliente'}).appendTo('#contenedorFormModificar');
  $('<input/>').attr({type:'hidden',id:'inputIdAnterior',name:'inputIdAnterior',class:'form-control',value:id}).appendTo('#formMod');
  $('<input/>').attr({type:'hidden',id:'inputNroPedido',name:'inputNroPedido',class:'form-control',value:nroPedido}).appendTo('#formMod');
  $('<input/>').attr({type:'hidden',id:'inputTipo',name:'inputTipo',class:'form-control',value:tipo}).appendTo('#formMod');
  $('<input/>').attr({type:'hidden',id:'inputIdReserva',name:'inputIdReserva',class:'form-control',value:idReserva}).appendTo('#formMod');
  switch (tipo) {
    case "Plato":
      $('<div/>').attr({class:'mb-3',id:'contenedorInputModPedPlato'}).appendTo('#formMod');
      $('<label/>').attr({class:'form-label',for:'inputModPedPlato'}).appendTo('#contenedorInputModPedPlato').text('Plato anterior');
      $('<input/>').attr({id:'inputModPedPlato',name:'inputModPedPlato',class:'form-control',value:nombre,disabled:'disabled'}).appendTo('#contenedorInputModPedPlato');
      $('<div/>').attr({class:'mb-3',id:'contenedorSelectModPedPlato'}).appendTo('#formMod');
      $('<label/>').attr({class:'form-label',for:'selectModPedPlatoBebida',value:'Platos'}).appendTo('#contenedorSelectModPedPlato').text('Plato nuevo');
      $('<select/>').attr({id:'selectModPedPlatoBebida',name:'selectModPedPlatoBebida',class:'form-select'}).appendTo('#contenedorSelectModPedPlato');
      $('<div/>').attr({class:'mb-3',id:'contenedorInputModPedPlatoCantidad'}).appendTo('#formMod');
      $('<label/>').attr({class:'form-label',for:'inputModCantidad'}).appendTo('#contenedorInputModPedPlatoCantidad').text('Cantidad');
      $('<input/>').attr({type:'number',id:'inputModCantidad',name:'inputModCantidad',class:'form-control', value:cantidad}).appendTo('#contenedorInputModPedPlatoCantidad');
      listarPlatos()    
      break;
    case "Bebida":
      $('<div/>').attr({class:'mb-3',id:'contenedorInputModPedBebida'}).appendTo('#formMod');
      $('<label/>').attr({class:'form-label',for:'inputModPedBebida'}).appendTo('#contenedorInputModPedBebida').text('Bebida anterior');
      $('<input/>').attr({id:'inputModPedPlato',name:'inputModPedBebida',class:'form-control', value:nombre,disabled:'disabled'}).appendTo('#contenedorInputModPedBebida');
      $('<div/>').attr({class:'mb-3',id:'contenedorSelectModPedBebida'}).appendTo('#formMod');
      $('<label/>').attr({class:'form-label',for:'selectModPedPlatoBebida',value:'Platos'}).appendTo('#contenedorSelectModPedBebida').text('Bebida nueva');
      $('<select/>').attr({id:'selectModPedPlatoBebida',name:'selectModPedPlatoBebida',class:'form-select'}).appendTo('#contenedorSelectModPedBebida');
      $('<div/>').attr({class:'mb-3',id:'contenedorInputModPedBebidaCantidad'}).appendTo('#formMod');
      $('<label/>').attr({class:'form-label',for:'inputModCantidad'}).appendTo('#contenedorInputModPedBebidaCantidad').text('Cantidad');
      $('<input/>').attr({type:'number',id:'inputModCantidad',name:'inputModCantidad',class:'form-control', value:cantidad}).appendTo('#contenedorInputModPedBebidaCantidad');
      listarBebidas()   
      break;
  
    default:
      break;
  }

  $('<button/>').attr({class:'btn btn-success text-white',id:'btnCambiarPlatoBebidaEnPedido',type:'submit'}).appendTo('#formMod').text('Cambiar');
  //align-self-end
  // $('<div/>').attr({class:'container mb-3',id:'contenedor'}).appendTo('#formMod');
  // $('<div/>').attr({class:'row justify-content-end ',id:'contenedorRow'}).appendTo('#contenedor');
  // $('<div/>').attr({class:'col-3',id:'contenedorBtnCambiar'}).appendTo('#contenedorRow');
  // $('<button/>').attr({class:'btn btn-info text-white',id:'btnCambiarPlatoBebidaEnPedido',type:'submit'}).appendTo('#contenedorBtnCambiar').text('Cambiar');
  
  
}
  
$(document).on('click', '.btnModPedCliente', function (e) {
  let id="";
  let nombre="";
  let nroPedido="";
  let cantidad=0;
  let idReserva=0;
  switch ($(this).parents("tr").find(".tipo").attr("tipo")) {
    case 'Plato':
      id=$(this).parents("tr").find(".idPlato").attr("data-id");
      nombre=$(this).parents("tr").find(".idPlato").attr("data-nombre");
      nroPedido=$(this).parents("tr").find(".idPlato").attr("data-nro-pedido");
      cantidad=$(this).parents("tr").find(".idPlato").attr("data-cantidad");
      idReserva=$(this).parents("tr").find(".idPlato").attr("data-idReserva");
      break;
    case 'Bebida':
      id=$(this).parents("tr").find(".idBebida").attr("data-id");
      nombre=$(this).parents("tr").find(".idBebida").attr("data-nombre");
      nroPedido=$(this).parents("tr").find(".idBebida").attr("data-nro-pedido");
      cantidad=$(this).parents("tr").find(".idBebida").attr("data-cantidad");
      idReserva=$(this).parents("tr").find(".idBebida").attr("data-idReserva");
      break;
    default:
      break;
  }
  cargarFormModificarPedidoPlatoBebida($(this).parents("tr").find(".tipo").attr("tipo"),id,nombre,nroPedido,cantidad,idReserva);
})


const cargarTablaModificarPedidos =(platos,bebidas)=>{
  $("#tablaPedidoModificar tbody tr").remove();
  fila=''
  cont=0;
  platos.forEach(plato=>{
    cont++
    fila+='<tr> <td class="idPlato" data-id="'+plato['idPlato']+'" data-nombre="'+plato['nombrePlato']+'" data-nro-pedido="'+plato['nroPedido']+'" data-cantidad="'+plato['cantidad']+'" data-idReserva="'+plato['idReserva']+'">'+ cont +'</td> <td >'+plato['nroPedido']+'</td> <td>'+plato['nombrePlato']+'</td><td>'+plato['cantidad']+'</td><td class="tipo" tipo="Plato" > Plato </td> <td>$'+plato['precioPlato']+'</td> <td><a class="btn btn-warning btn-sm btnModPedCliente" data-bs-toggle="modal" href="#exampleModalToggle" role="button"><i class="fas fa-edit mr-2"></i></a></td> </tr>';
  })
  bebidas.forEach(bebida=>{
    cont++
    fila+='<tr> <td class="idBebida" data-id="'+bebida['idBebida']+'" data-nombre="'+bebida['nombreBebida']+'" data-nro-pedido="'+bebida['nroPedido']+'" data-cantidad="'+bebida['cantidad']+'" data-idReserva="'+bebida['idReserva']+'">'+ cont +'</td> <td>'+bebida['nroPedido']+'</td> <td>'+bebida['nombreBebida']+'</td><td>'+bebida['cantidad']+'</td><td class="tipo" tipo="Bebida" > Bebida </td> <td>$'+bebida['precioBebida']+'</td> <td><a class="btn btn-warning btn-sm btnModPedCliente" data-bs-toggle="modal" href="#exampleModalToggle" role="button"><i class="fas fa-edit mr-2"></i></a></td> </tr>';
  })
  $('#tablaPedidoModificar tbody').append(fila);

}
