var fechaInicioChef = document.getElementById("inputFechaInicioReportePlatosChef");
var fechaFinChef = document.getElementById("inputFechaHastaReportePlatosChef");
var menus = document.getElementById('contenedorRepo')
const crearTabla = (data)=>{
// const cabecera = ["Item", "Cantidad","Acción","Total"]
const cabecera = ["Nombre Plato","Cantidad", "Alergia","Fecha Reserva", "Num Mesa", "Turno", "Horario"]
 // Crea las celdas
menus.innerHTML=''
    var title   = document.createElement("h4");
    var parrafo   = document.createElement("h5");
    var tabla   = document.createElement("table");
    var tblHead = document.createElement("thead");
    var tblBody = document.createElement("tbody");
    var tblFoot = document.createElement("tfoot");
    var hilera = document.createElement("tr");
    var filaPlato = document.createElement("tr");
    //var hileraFooter = document.createElement("tr");
for (var j = 0; j < cabecera.length; j++) {
    var celda = document.createElement("th");
    var textoCelda = document.createTextNode(cabecera[j]);
    celda.appendChild(textoCelda);
    celda.setAttribute("scope", "col");
    hilera.appendChild(celda);
    }
    filaPlato.innerHTML="";
    var cad = ""
    var cadFoot = ''
    if (data.length>=1) {
      for (var i = 0; i < data.length; i++) {
        cad+="<tr><td>"+data[i]['nombrePlato']+"</td><td>"+data[i]['cantidad']+"</td><td>"+data[i]['detallePlatoAlergia']+"</td><td>"+data[i]['fechaReserva'].split('-').reverse().join('/')+"</td><td>"+data[i]['idMesa']+"</td><td>"+data[i]['turnoReserva']+"</td><td>"+data[i]['horario']+"</td></tr>"
      }  
    } else {
      cadFoot=  '<tr><td colspan="7">Sin datos para mostrar</td></tr>'
    }
    tblFoot.innerHTML = cadFoot
    console.log(hilera)

    // agrega la hilera al final de la tabla (al final del elemento tblbody)
    tblHead.appendChild(hilera);
    tabla.appendChild(tblHead);
    //tblBody.appendChild(filaPlato);
    tblBody.innerHTML = cad
    tabla.appendChild(tblBody);
    tabla.appendChild(tblFoot);
    menus.appendChild(title);
    menus.appendChild(parrafo);
    menus.appendChild(tabla);
    tabla.classList.add('table', 'mb-3');
}

//Muestra reporte chef en pantalla

$("#btnObtenerReporteChef").click(function() {
  //crearTabla()
  $.ajax({
    url: baseURL+"/chef/imprimirReporteChef",
    type: "POST",
    data:{inputFechaInicioReportePlatosChef:fechaInicioChef.value,inputFechaHastaReportePlatosChef:fechaFinChef.value},
    dataType: 'json',
    success: function (res) {
      console.log(res.status)
      //crearTabla(res)
      if (res.status == true ) {
        console.log(res.data)
        crearTabla(res.data)
      }else {
        document.getElementById('nores').innerHTML = "No se encontraron resultados.";
      }
    },error: function (data) {
      document.getElementById('nores').innerHTML = "No se encontraron resultados.";
    }
  });

  });
