$(document).ready(function(){
    const itemsPlatos = document.getElementById('items-plato')
    const itemsBebidas = document.getElementById('items-bebidas')
    const items = document.getElementById('items')
    const footer = document.getElementById('footer')
    const templateFooter = document.getElementById('template-footer').content
    const templateCarrito = document.getElementById('template-carrito').content
    const fragment = document.createDocumentFragment()
    let carrito = {}
    let listado = {}
    let cantPers="";
    // Variable menu es cada tabla en donde se muestra cada plato o bebida ingresado
    // Variabla footerPedido es el pie de cada variable menu
    var menu 
    var footerPedido
    
    ///Formulario Reserva
    $("#campo2").hide();
	$(".next").click(function(){
	    $("#campo1").hide();
		$("#campo2").show();
	});
	$(".previous").click(function(){
        $("#campo2").hide();
		$("#campo1").show();
	});
    /// input Select de cantidad de personas
    $("#selectCantPers").change(function(){
        var cantMenu = parseInt(this.value)
        
        if (cantMenu>=1 && cantMenu<=4) {
            generarTablaMenus(cantMenu)
            $.ajax({
                url:baseURL+'/menu/plato/listarPlatos',
                type:'post',
                dataType: 'json',
                success:function(data){
                    generarTablaPlatos(data.data,cantMenu,data.tipo)
                }
            });
            $.ajax({
                url:baseURL+'/menu/bebida/listarBebidas',
                type:'post',
                dataType: 'json',
                success:function(data){
                    generarTablaBebidas(data.data,cantMenu,data.tipo)
                }
            });
        }
        
    })
    
    const generarTablaBebidas= (data,cantMenu,tipoBebidas) =>{
        itemsBebidas.innerHTML=''
        num=0
        Object.values(data).forEach(bebida=>{
            num=num+1
            var hilera = document.createElement("tr");
            var indice = document.createElement("td");
            var nombre = document.createElement("td");
            var tipo = document.createElement("td");
            var precio = document.createElement("td");
            var celdaGestion = document.createElement("td");
            var btnGroup = document.createElement("div");
            var button = document.createElement("button");
            var dropdownMenu = document.createElement("ul");
            
            btnGroup.classList.add('btn-group')
            button.classList.add('btn','btn-secondary','dropdown-toggle')
            button.setAttribute("type", "button");
            button.setAttribute("data-bs-toggle", "dropdown");
            button.setAttribute("aria-expanded", "false");
            button.innerText = "Agregar";

            dropdownMenu.classList.add('dropdown-menu','dropdown-menu-end')
            for (let index = 1; index <= cantMenu; index++) {
                var itemMenu = document.createElement("li");    
                var buttonLi = document.createElement("button");
                buttonLi.classList.add('dropdown-item')
                buttonLi.setAttribute("type", "button");
                buttonLi.setAttribute("data-id", bebida.idBebida);
                buttonLi.setAttribute("data-menu", index-1);
                buttonLi.setAttribute("data-type", "Bebida");
                buttonLi.innerText = "Menu "+index;
                itemMenu.appendChild(buttonLi)
                dropdownMenu.appendChild(itemMenu)    
            }
            
            btnGroup.appendChild(button)
            btnGroup.appendChild(dropdownMenu)

            indice.textContent=num
            nombre.textContent=bebida.nombreBebida
            for (let k = 0; k < tipoBebidas.length; k++) {
                if (tipoBebidas[k].idCategoriaBebida == bebida.idCategoriaBebida) {
                    tipo.textContent=tipoBebidas[k].nombreCategoriaBebida;
                }
            }
            precio.textContent="$ "+bebida.precioBebida
            celdaGestion.appendChild(btnGroup)
            hilera.appendChild(indice)
            hilera.appendChild(nombre)
            hilera.appendChild(tipo)
            hilera.appendChild(precio)
            hilera.appendChild(celdaGestion)
            itemsBebidas.appendChild(hilera)
        })
    }
    const generarTablaPlatos= (data,cantMenu,tipoPlatos) =>{
        itemsPlatos.innerHTML=''
        num=0
        Object.values(data).forEach(plato=>{
            num=num+1
            var hilera = document.createElement("tr");
            var indice = document.createElement("td");
            var nombre = document.createElement("td");
            var ingredientes = document.createElement("td");
            var tipo = document.createElement("td");
            var precio = document.createElement("td");
            var celdaGestion = document.createElement("td");
            var btnGroup = document.createElement("div");
            var button = document.createElement("button");
            var dropdownMenu = document.createElement("ul");
            
            btnGroup.classList.add('btn-group')
            button.classList.add('btn','btn-secondary','dropdown-toggle')
            button.setAttribute("type", "button");
            button.setAttribute("data-bs-toggle", "dropdown");
            button.setAttribute("aria-expanded", "false");
            button.innerText = "Agregar";

            dropdownMenu.classList.add('dropdown-menu','dropdown-menu-end')
            for (let index = 1; index <= cantMenu; index++) {
                var itemMenu = document.createElement("li");    
                var buttonLi = document.createElement("button");
                buttonLi.classList.add('dropdown-item')
                buttonLi.setAttribute("type", "button");
                buttonLi.setAttribute("data-id", plato.idPlato);
                buttonLi.setAttribute("data-menu", index-1);
                buttonLi.setAttribute("data-type", "Plato");
                buttonLi.innerText = "Menu "+index;
                itemMenu.appendChild(buttonLi)
                dropdownMenu.appendChild(itemMenu)    
            }
            
            btnGroup.appendChild(button)
            btnGroup.appendChild(dropdownMenu)

            indice.textContent=num
            nombre.textContent=plato.nombrePlato
            ingredientes.textContent=plato.descripcionPlato
            for (let k = 0; k < tipoPlatos.length; k++) {
                if (tipoPlatos[k].idCategoriaPlato == plato.idCategoriaPlato) {
                    tipo.textContent=tipoPlatos[k].nombreCategoriaPlato;
                }
            }
            precio.textContent="$ "+ plato.precioPlato
            celdaGestion.appendChild(btnGroup)
            hilera.appendChild(indice)
            hilera.appendChild(nombre)
            hilera.appendChild(ingredientes)
            hilera.appendChild(tipo)
            hilera.appendChild(precio)
            hilera.appendChild(celdaGestion)
            itemsPlatos.appendChild(hilera)
        })
    }
    const generarInputAlergia=(index)=>{
        var div   = document.createElement("div");
        var span   = document.createElement("span");
        var input   = document.createElement("input");
        div.classList.add('input-group','mb-3');
        span.classList.add('input-group-text');
        span.textContent="ALERGIA";
        input.classList.add('form-control');
        input.classList.add('inputAlergia');
        input.setAttribute("type", "text");
        input.setAttribute("name", "inputAlergia"+index);
        input.setAttribute("id", "inputAlergia"+index);
        input.setAttribute("value", "Sin Alergia");
        div.appendChild(span)
        div.appendChild(input)
        return div;
    }
    const generarTablaMenus= cantidadTablas =>{
        var menus = document.getElementById('menusPlatosBebidas')
        // const cabecera = ["Item", "Cantidad","Acción","Total"]
        const cabecera = ["Item", "Cantidad","Total"]
         // Crea las celdas
        menus.innerHTML=''
        for (let index = 1; index <= cantidadTablas; index++) {
            var title   = document.createElement("h4");
            var parrafo   = document.createElement("h5");
            var tabla   = document.createElement("table");
            var tblHead = document.createElement("thead");
            var tblBody = document.createElement("tbody");
            var tblFoot = document.createElement("tfoot");
            var hilera = document.createElement("tr");
            var hileraFooter = document.createElement("tr");

            for (var j = 0; j < 3; j++) {
            // Crea un elemento <th> y un nodo de texto, haz que el nodo de
            // texto sea el contenido de <th>, ubica el elemento <th> al final
            // de la hilera de la tabla
            var celda = document.createElement("th");
            var textoCelda = document.createTextNode(cabecera[j]);
            celda.appendChild(textoCelda);
            celda.setAttribute("scope", "col");
            if (j==0) {
                celda.setAttribute("colspan", "2");
            }
            hilera.appendChild(celda);
            }
            
            // agrega la hilera al final de la tabla (al final del elemento tblbody)
            tblHead.appendChild(hilera);
            tabla.appendChild(tblHead);
            tblBody.setAttribute("id", "idMenu"+index);
            tblBody.classList.add('menuPlatoBebida');
            tabla.appendChild(tblBody);

            var celdaFooter = document.createElement("th")
            celdaFooter.setAttribute("scope", "row");
            celdaFooter.setAttribute("colspan", "4");
            celdaFooter.innerHTML="Menu vacío - comience a agregar plato y/o bebidas!"
            hileraFooter.appendChild(celdaFooter)
            hileraFooter.classList.add('footerPedido');
            tblFoot.appendChild(hileraFooter)
            tabla.appendChild(tblFoot);
            title.textContent="Menu "+index
            parrafo.textContent="¿Posee alguna alergia?"
            menus.appendChild(title);
            menus.appendChild(parrafo);
            var div=generarInputAlergia(index)
            menus.appendChild(div);
            menus.appendChild(tabla);
            tabla.classList.add('table', 'mb-3');
        }
    }


    $("#idTurnoRes").change(function(){
        var horario = {
            Almuerzo: ["12:00", "13:00", "14:00"],
            Cena: ["20:00", "21:00", "22:00", "23:00", "00:00","01:00"]
        }
        var turno = document.getElementById('idTurnoRes')
        var hora = document.getElementById('idHora')
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
    })
    


    itemsPlatos.addEventListener('click',e=>{addCarrito(e)})
    itemsBebidas.addEventListener('click',e=>{addCarrito(e)})
    
   
    const addCarrito= e=>{
        if (e.target.classList.contains('dropdown-item')) {
            setCarrito(e.target.parentElement)
        }
    }
    const setCarrito= objeto =>{
        /// Ajax
        let menuNro=objeto.querySelector('button').dataset.menu
        let idButton=objeto.querySelector('button').dataset.id
        // console.log(objeto.querySelector('button').dataset.type)
        const list={
            menuNro:menuNro,
            platos:[],
            bebidas:[]
        }
        if (objeto.querySelector('button').dataset.type=="Plato") {
            // console.log("if con plato")
            $.ajax({
                url:baseURL+"/menu/plato/buscarPlato",
                method: 'post',
                data: {id: idButton},
                dataType: 'json',
                success:function(data){
                const producto={
                    id: data.data.idPlato,
                    nombrePlato: data.data.nombrePlato,
                    precioPlato: parseInt(data.data.precioPlato),
                    cantidad: 1
                }
                
                // if (carrito.hasOwnProperty(producto.id)) {
                //     producto.cantidad=carrito[producto.id].cantidad + 1
                // }
                // carrito[producto.id]={...producto}
    
                ///////////////////// nueva
                if (listado.hasOwnProperty(list.menuNro)) {
                    const condicion = (element) => element.id == producto.id;
                    if (listado[list.menuNro].platos.findIndex(condicion)==-1) {
                        producto.cantidad=1
                        listado[list.menuNro].platos.push(producto)    
                    }else{
                        const index = listado[list.menuNro].platos.findIndex(condicion)
                        let auxProd=listado[list.menuNro].platos[index]
                        auxProd.cantidad=auxProd.cantidad+1
                        listado[list.menuNro].platos.splice(index, 1, auxProd)
                    }
                }else{
                    producto.cantidad=1
                    listado[list.menuNro]={...list}
                    listado[list.menuNro].platos.push(producto)
                }
                    
                // pintarCarrito()
                agregarCarrito(objeto.querySelector('button').dataset.menu)
                }
            });
        }else{
            $.ajax({
            url:baseURL+"/menu/bebida/buscarBebida",
            method: 'post',
            data: {id: idButton},
            dataType: 'json',
                success:function(data){
                    const producto={
                        id: data.data.idBebida,
                        nombreBebida: data.data.nombreBebida,
                        precioBebida: parseInt(data.data.precioBebida),
                        cantidad: 1
                    }
                    if (listado.hasOwnProperty(list.menuNro)) {
                        const condicion = (element) => element.id == producto.id;
                        if (listado[list.menuNro].bebidas.findIndex(condicion)==-1) {
                            producto.cantidad=1
                            listado[list.menuNro].bebidas.push(producto)    
                        }else{
                            const index = listado[list.menuNro].bebidas.findIndex(condicion)
                            let auxProd=listado[list.menuNro].bebidas[index]
                            auxProd.cantidad=auxProd.cantidad+1
                            listado[list.menuNro].bebidas.splice(index, 1, auxProd)
                        }
                    }else{
                        producto.cantidad=1
                        listado[list.menuNro]={...list}
                        listado[list.menuNro].bebidas.push(producto)
                    }
                    agregarCarrito(objeto.querySelector('button').dataset.menu)
                }
            })
        }
    }

    const agregarCarrito =(nro)=>{
        menu = document.querySelectorAll(".menuPlatoBebida");
        menu[parseInt(nro)].innerHTML = ''
        listado[nro].platos.forEach(prod=>{
            templateCarrito.querySelectorAll('td')[0].textContent = prod.nombrePlato
            templateCarrito.querySelectorAll('td')[1].textContent = prod.cantidad
            templateCarrito.querySelector('span').textContent = prod.precioPlato * prod.cantidad
            
            const clone = templateCarrito.cloneNode(true)
            fragment.appendChild(clone)
        })
        menu[parseInt(nro)].appendChild(fragment)

        listado[nro].bebidas.forEach(prod=>{
            templateCarrito.querySelectorAll('td')[0].textContent = prod.nombreBebida
            templateCarrito.querySelectorAll('td')[1].textContent = prod.cantidad
            templateCarrito.querySelector('span').textContent = prod.precioBebida * prod.cantidad
            
            const clone = templateCarrito.cloneNode(true)
            fragment.appendChild(clone)
        })
        menu[parseInt(nro)].appendChild(fragment)
        
        menu[parseInt(nro)].addEventListener('click', e => {
            console.log(e.target)
        })
            // btnAgregarQuitar(e,nro)})
        agregarFooter(nro)
    }
    const agregarFooter = (nro) => {
        footerPedido=document.querySelectorAll('.footerPedido')
        footerPedido[parseInt(nro)].innerHTML=''

        if (listado[nro].platos.length === 0 && listado[nro].bebidas.length === 0) {
            footerPedido[parseInt(nro)].innerHTML = `<th scope="row" colspan="4">Menu vacío - comience a agregar plato y/o bebidas!</th>`
            return
        }
        var cantidadPlat = 0;
        var precioPlat = 0;
        listado[nro].platos.forEach(prod=>{
            cantidadPlat=cantidadPlat+prod.cantidad 
            precioPlat=precioPlat +(prod.cantidad*prod.precioPlato)
        })
        listado[nro].bebidas.forEach(prod=>{
            cantidadPlat=cantidadPlat+prod.cantidad 
            precioPlat=precioPlat +(prod.cantidad*prod.precioBebida)
        })
        templateFooter.querySelectorAll('td')[0].textContent = cantidadPlat
        templateFooter.querySelector('span').textContent = precioPlat
    
        const clone = templateFooter.cloneNode(true)
        fragment.appendChild(clone)
    
        footerPedido[parseInt(nro)].appendChild(fragment)

        const boton = document.querySelectorAll('#vaciar-carrito')
        boton[parseInt(nro)].addEventListener('click', () => {
            
            listado[nro].platos = []
            listado[nro].bebidas = []
            vaciarCarrito(nro)
            
        })
    }
    const vaciarCarrito =(nro)=>{
        menu = document.querySelectorAll(".menuPlatoBebida");
        menu[parseInt(nro)].innerHTML = ''
        vaciarFooter(nro)
    }
    const vaciarFooter =(nro)=>{
        footerPedido=document.querySelectorAll('.footerPedido')
        footerPedido[parseInt(nro)].innerHTML = `<th scope="row" colspan="4">Menu vacío - comience a agregar plato y/o bebidas!</th>`

    }
    /// Botones para reservar
    $("#btnConsultar").click(function() {

        cantPers = document.getElementById('selectCantPers').value;
        var fecha = $('#inputFecha').val();
        var hora = $("#idHora option:selected").val();
        
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
                    document.getElementById('idMesaRes').value = res.data.numeroMesa;
                    document.getElementById("btnSiguiente").style.visibility="visible";
                    
             }
        })
    })
    const agregarDatosAReserva =(totalAPagar,listado)=>{
        $.ajax({
            url:baseURL+'/menu/promocion/consultarPromocion',
            method: 'post',
            data: {idUser: document.getElementById('idUser').value},
            dataType: 'json',
            success: function (res) {
                var fecha = $('#inputFecha').val();
                var hora = $("#idHora option:selected").val();
                var turno = $("#idTurnoRes option:selected").val();
                if (res.data.idPromocion == 0) {
                    document.getElementById('fechaRes').value = fecha
                    document.getElementById('preciototal').value = totalAPagar
                    document.getElementById('turno').value = turno
                    document.getElementById('horario').value = hora
                    document.getElementById('idprom').value = res.data.idPromocion
                    document.getElementById('pedidos').value=JSON.stringify(listado);
                    document.getElementById('idPTotalAPagar').innerText=totalAPagar
                }else {
                    ///Se calcula precio a pagar con descuento
                    totalAPagar = totalAPagar - parseInt((totalAPagar*res.data.descuentoPromocion)/100)
                    ///
                    document.getElementById('fechaRes').value = fecha
                    document.getElementById('preciototal').value = totalAPagar
                    document.getElementById('turno').value = turno
                    document.getElementById('horario').value = hora
                    document.getElementById('idprom').value = res.data.idPromocion
                    document.getElementById('pedidos').value=JSON.stringify(listado);
                    document.getElementById('idPTotalAPagar').innerText=totalAPagar
                    
                }
            }
        })
        $("#reservaModal").modal("show");
    }
    $("#btnReservar").click(function() {
        var alergias = document.querySelectorAll(".inputAlergia");
        var indice = 0
        var totalAPagar = 0 //acumulara el importe a pagar sin aplicar el descuento/promocion
        var flagPlatos=true;
        var flagBebida=true;
        Object.values(listado).forEach(menu => {
          menu.alergia = alergias[indice].value
          if (menu.platos.length==0) {
              flagPlatos=false;
          } else {
            for (var i = 0; i < menu.platos.length; i++) {
                totalAPagar = totalAPagar+(menu.platos[i].precioPlato * menu.platos[i].cantidad)
              }    
          }
          if (menu.bebidas.length==0) {
            flagBebida=false;
          } else {
            for (var j = 0; j < menu.bebidas.length; j++) {
                totalAPagar = totalAPagar+(menu.bebidas[j].precioBebida * menu.bebidas[j].cantidad)
              }    
          }
          
          indice++
        })
        
        if (Object.values(listado).length<parseInt(cantPers,10)||flagBebida==false||flagPlatos==false) {
            $("#errorModal").modal("show");
            return false;
            
        }
        
        agregarDatosAReserva(totalAPagar,listado)

    })

})

