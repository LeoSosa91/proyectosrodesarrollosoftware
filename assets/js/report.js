var boton = document.getElementById('btnObtenerReporte');
//var botonChef = document.getElementById('btnObtenerReporteChef');
var selectVa = document.getElementById("inputTipoReporte");
var fechaInicio = document.getElementById("inputFechaInicioReportePlatos");
var fechaFin = document.getElementById("inputFechaHastaReportePlatos");
var selectedOperation ="";
var repos = document.getElementById('resultado')

const crearTabla = (data)=>{
  switch (selectedOperation) {
    case "1":
    const cabecera = ["Nombre Plato", "Cantidad"]
     // Crea las celdas
    repos.innerHTML=''
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
        for (var i = 0; i < data.length; i++) {
          cad+="<tr><td>"+data[i]['nombrePlato']+"</td><td>"+data[i]['cantidad']+"</td>"
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
      const cabecera2 = ["Dni Usuario", "Turno", "Horario", "Num Mesa","Fecha Reserva" ]
       // Crea las celdas
      repos.innerHTML=''
          var title   = document.createElement("h4");
          var parrafo   = document.createElement("h5");
          var tabla   = document.createElement("table");
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
          filaPlato.innerHTML="";
          var cad = ""
          for (var i = 0; i < data.length; i++) {
            cad+="<tr><td>"+data[i]['dniUsuario']+"</td><td>"+data[i]['turnoReserva']+"</td><td>"+data[i]['horario']+"</td><td>"+data[i]['idMesa']+"</td><td>"+data[i]['fechaReserva']+"</td>"
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
        const cabecera3 = ["Horarios", "Cantidad" ]
         // Crea las celdas
        repos.innerHTML=''
            var title   = document.createElement("h4");
            var parrafo   = document.createElement("h5");
            var tabla   = document.createElement("table");
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
            filaPlato.innerHTML="";
            var cad = ""
            for (var i = 0; i < data.length; i++) {
              cad+="<tr><td>"+data[i]['horario']+"</td><td>"+data[i]['cantidad']+"</td>"
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
          const cabecera4 = ["Dni Usuario", "Nombre", "Apellido", "Email", "Teleforno", "Fecha Reserva" ]
           // Crea las celdas
          repos.innerHTML=''
              var title   = document.createElement("h4");
              var parrafo   = document.createElement("h5");
              var tabla   = document.createElement("table");
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
              filaPlato.innerHTML="";
              var cad = ""
              for (var i = 0; i < data.length; i++) {
                cad+="<tr><td>"+data[i]['dniUsuario']+"</td><td>"+data[i]['username']+"</td><td>"+data[i]['usersurname']+"</td><td>"+data[i]['useremail']+"</td><td>"+data[i]['usertel']+"</td><td>"+data[i]['fechaReserva']+"</td>"
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
            const cabecera5 = ["Dni Usuario", "Turno", "Horario", "Num Mesa", "Fecha", "Asistencia" ]
             // Crea las celdas
            repos.innerHTML=''
                var title   = document.createElement("h4");
                var parrafo   = document.createElement("h5");
                var tabla   = document.createElement("table");
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
                filaPlato.innerHTML="";
                var cad = ""
                for (var i = 0; i < data.length; i++) {
                  cad+="<tr><td>"+data[i]['dniUsuario']+"</td><td>"+data[i]['turnoReserva']+"</td><td>"+data[i]['horario']+"</td><td>"+data[i]['idMesa']+"</td><td>"+data[i]['fechaReserva']+"</td><td>"+data[i]['asistenciaReserva']+"</td>"
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

selectVa.addEventListener('change',(event)=>{
    selectedOperation=event.target.value;
})


//Muestra los reportes admin en pantalla
$("#btnObtenerReporte").click(function() {
  $.ajax({
    url: baseURL+"/admin/imprimirReporte",
    type: "POST",
    data:{FechaInicioReportePlatos:fechaInicio.value,FechaHastaReportePlatos:fechaFin.value,TipoReporte:selectedOperation},
    dataType: 'json',
    success: function (res) {
      console.log(res)
      crearTabla(res)
    },error: function (data) {

    }
  });

  });





const pintarCarrito = () => {
    resultado.innerHTML = ''
}
