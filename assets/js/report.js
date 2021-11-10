var boton = document.getElementById('btnObtenerReporte');
//var botonChef = document.getElementById('btnObtenerReporteChef');
var selectVa = document.getElementById("inputTipoReporte");
var fechaInicio = document.getElementById("inputFechaInicioReportePlatos");
var fechaFin = document.getElementById("inputFechaHastaReportePlatos");
var selectedOperation = "";
var repos = document.getElementById('resultado')

const crearTabla = (data) => {
  switch (selectedOperation) {
    case "1":
      const cabecera = ["Nombre Plato", "Cantidad"]
      // Crea las celdas
      repos.innerHTML = ''
      var title = document.createElement("h4");
      var parrafo = document.createElement("h5");
      var tabla = document.createElement("table");
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
      filaPlato.innerHTML = "";
      var cad = ""
      for (var i = 0; i < data.length; i++) {
        cad += "<tr><td>" + data[i]['nombrePlato'] + "</td><td>" + data[i]['cantidad'] + "</td>"
      }
      console.log(hilera)

      // agrega la hilera al final de la tabla (al final del elemento tblbody)
      tblHead.appendChild(hilera);
      tabla.appendChild(tblHead);
      //tblBody.appendChild(filaPlato);
      tblBody.innerHTML = cad
      tabla.appendChild(tblBody);
      repos.appendChild(title);
      repos.appendChild(parrafo);
      repos.appendChild(tabla);
      tabla.classList.add('table', 'mb-3');

      break;
    case "2":
      const cabecera2 = ["Dni Usuario", "Turno", "Horario", "Num Mesa", "Fecha Reserva"]
      // Crea las celdas
      repos.innerHTML = ''
      var title = document.createElement("h4");
      var parrafo = document.createElement("h5");
      var tabla = document.createElement("table");
      var tblHead = document.createElement("thead");
      var tblBody = document.createElement("tbody");
      var tblFoot = document.createElement("tfoot");
      var hilera = document.createElement("tr");
      var filaPlato = document.createElement("tr");
      //var hileraFooter = document.createElement("tr");
      for (var j = 0; j < cabecera2.length; j++) {
        var celda = document.createElement("th");
        var textoCelda = document.createTextNode(cabecera2[j]);
        celda.appendChild(textoCelda);
        celda.setAttribute("scope", "col");
        hilera.appendChild(celda);
      }
      filaPlato.innerHTML = "";
      var cad = ""
      for (var i = 0; i < data.length; i++) {
        cad += "<tr><td>" + data[i]['dniUsuario'] + "</td><td>" + data[i]['turnoReserva'] + "</td><td>" + data[i]['horario'] + "</td><td>" + data[i]['idMesa'] + "</td><td>" + data[i]['fechaReserva'] + "</td>"
      }
      console.log(hilera)

      // agrega la hilera al final de la tabla (al final del elemento tblbody)
      tblHead.appendChild(hilera);
      tabla.appendChild(tblHead);
      //tblBody.appendChild(filaPlato);
      tblBody.innerHTML = cad
      tabla.appendChild(tblBody);
      repos.appendChild(title);
      repos.appendChild(parrafo);
      repos.appendChild(tabla);
      tabla.classList.add('table', 'mb-3');

      break;
    case "3":
      const cabecera3 = ["Horarios", "Cantidad"]
      // Crea las celdas
      repos.innerHTML = ''
      var title = document.createElement("h4");
      var parrafo = document.createElement("h5");
      var tabla = document.createElement("table");
      var tblHead = document.createElement("thead");
      var tblBody = document.createElement("tbody");
      var tblFoot = document.createElement("tfoot");
      var hilera = document.createElement("tr");
      var filaPlato = document.createElement("tr");
      //var hileraFooter = document.createElement("tr");
      for (var j = 0; j < cabecera3.length; j++) {
        var celda = document.createElement("th");
        var textoCelda = document.createTextNode(cabecera3[j]);
        celda.appendChild(textoCelda);
        celda.setAttribute("scope", "col");
        hilera.appendChild(celda);
      }
      filaPlato.innerHTML = "";
      var cad = ""
      for (var i = 0; i < data.length; i++) {
        cad += "<tr><td>" + data[i]['horario'] + "</td><td>" + data[i]['cantidad'] + "</td>"
      }
      console.log(hilera)

      // agrega la hilera al final de la tabla (al final del elemento tblbody)
      tblHead.appendChild(hilera);
      tabla.appendChild(tblHead);
      //tblBody.appendChild(filaPlato);
      tblBody.innerHTML = cad
      tabla.appendChild(tblBody);
      repos.appendChild(title);
      repos.appendChild(parrafo);
      repos.appendChild(tabla);
      tabla.classList.add('table', 'mb-3');

      break;
    case "4":
      const cabecera4 = ["Dni Usuario", "Nombre", "Apellido", "Email", "Teleforno", "Fecha Reserva"]
      // Crea las celdas
      repos.innerHTML = ''
      var title = document.createElement("h4");
      var parrafo = document.createElement("h5");
      var tabla = document.createElement("table");
      var tblHead = document.createElement("thead");
      var tblBody = document.createElement("tbody");
      var tblFoot = document.createElement("tfoot");
      var hilera = document.createElement("tr");
      var filaPlato = document.createElement("tr");
      //var hileraFooter = document.createElement("tr");
      for (var j = 0; j < cabecera4.length; j++) {
        var celda = document.createElement("th");
        var textoCelda = document.createTextNode(cabecera4[j]);
        celda.appendChild(textoCelda);
        celda.setAttribute("scope", "col");
        hilera.appendChild(celda);
      }
      filaPlato.innerHTML = "";
      var cad = ""
      for (var i = 0; i < data.length; i++) {
        cad += "<tr><td>" + data[i]['dniUsuario'] + "</td><td>" + data[i]['username'] + "</td><td>" + data[i]['usersurname'] + "</td><td>" + data[i]['useremail'] + "</td><td>" + data[i]['usertel'] + "</td><td>" + data[i]['fechaReserva'] + "</td>"
      }
      console.log(hilera)

      // agrega la hilera al final de la tabla (al final del elemento tblbody)
      tblHead.appendChild(hilera);
      tabla.appendChild(tblHead);
      //tblBody.appendChild(filaPlato);
      tblBody.innerHTML = cad
      tabla.appendChild(tblBody);
      repos.appendChild(title);
      repos.appendChild(parrafo);
      repos.appendChild(tabla);
      tabla.classList.add('table', 'mb-3');
      break;
    case "5":
      const cabecera5 = ["Dni Usuario", "Turno", "Horario", "Num Mesa", "Fecha", "Asistencia"]
      // Crea las celdas
      repos.innerHTML = ''
      var title = document.createElement("h4");
      var parrafo = document.createElement("h5");
      var tabla = document.createElement("table");
      var tblHead = document.createElement("thead");
      var tblBody = document.createElement("tbody");
      var tblFoot = document.createElement("tfoot");
      var hilera = document.createElement("tr");
      var filaPlato = document.createElement("tr");
      //var hileraFooter = document.createElement("tr");
      for (var j = 0; j < cabecera5.length; j++) {
        var celda = document.createElement("th");
        var textoCelda = document.createTextNode(cabecera5[j]);
        celda.appendChild(textoCelda);
        celda.setAttribute("scope", "col");
        hilera.appendChild(celda);
      }
      filaPlato.innerHTML = "";
      var cad = ""
      for (var i = 0; i < data.length; i++) {
        cad += "<tr><td>" + data[i]['dniUsuario'] + "</td><td>" + data[i]['turnoReserva'] + "</td><td>" + data[i]['horario'] + "</td><td>" + data[i]['idMesa'] + "</td><td>" + data[i]['fechaReserva'] + "</td><td>" + data[i]['asistenciaReserva'] + "</td>"
      }
      console.log(hilera)

      // agrega la hilera al final de la tabla (al final del elemento tblbody)
      tblHead.appendChild(hilera);
      tabla.appendChild(tblHead);
      //tblBody.appendChild(filaPlato);
      tblBody.innerHTML = cad
      tabla.appendChild(tblBody);
      repos.appendChild(title);
      repos.appendChild(parrafo);
      repos.appendChild(tabla);
      tabla.classList.add('table', 'mb-3');
      break;

  }

}

selectVa.addEventListener('change', (event) => {
  selectedOperation = event.target.value;
})


//Muestra los reportes admin en pantalla
$("#btnObtenerReporte").click(function () {
  switch (selectedOperation) {
    case "1":
      validarreportepasad()
      break;
    case "2":
      validarreportepasad()
      break;
    case "3":
      validarreportepasad()
      break;
    case "4":
      validarreportepasad()
      break;
    case "5":
      validarreporte()
      break;
    default:
      var muestra = document.getElementById('errortipo') // Muestra error al no elegir tipo
      muestra.innerHTML = "Error, seleccione un tipo de reporte."
      break;

  }

});

const imprimirReporte = () => {
  $.ajax({
    url: urlImprimirReporte,
    type: "POST",
    data: { inputFechaInicioReportePlatos: fechaInicio.value, inputFechaHastaReportePlatos: fechaFin.value, inputTipoReporte: selectedOperation },
    dataType: 'json',
    success: function (res) {
      console.log(res)
      crearTabla(res)
    }, error: function (data) {

    }
  });
}



const pintarCarrito = () => {
  resultado.innerHTML = ''
}

const validarDatos = (data) => {
  var nodeList = document.getElementById('formReporAdmin').childNodes;
  console.log(data)
  for (var i = 0; i < nodeList.length; i++) {
    for (let j = 0; j < nodeList[i].childNodes.length; j++) {
      if (Object.keys(data).length > 0) {
        if (data.hasOwnProperty(nodeList[i].childNodes[j].name)) {
          var input1 = document.getElementById(nodeList[i].childNodes[j].name);
          input1.className = "form-select is-invalid";
          idNodoPadreContenedor = nodeList[i].childNodes[j].parentNode.id
          var valor = document.querySelector('#' + idNodoPadreContenedor + ' div.form-helper.mb-5.text-danger')
          valor.innerHTML = data[nodeList[i].childNodes[j].name]
        }
      }
    }
  }

}

const validarreporte = () => {
  $.ajax({
    url: urlValidarReporte,
    type: "POST",
    data: { inputFechaInicioReportePlatos: fechaInicio.value, inputFechaHastaReportePlatos: fechaFin.value, inputTipoReporte: selectedOperation },
    dataType: 'json',
    success: function (res) {
      if (res.status == true) {
        validarDatos(res.data)
      } else {
        imprimirReporte();
      }
    }, error: function (res) {
      console.log(res)
    }
  });
}

const validarreportepasad = () => {
  $.ajax({
    url: urlValidarReportePas,
    type: "POST",
    data: { inputFechaInicioReportePlatos: fechaInicio.value, inputFechaHastaReportePlatos: fechaFin.value, inputTipoReporte: selectedOperation },
    dataType: 'json',
    success: function (res) {
      if (res.status == true) {
        validarDatos(res.data)
      } else {
        imprimirReporte();
      }
    }, error: function (data) {

    }
  });
}
