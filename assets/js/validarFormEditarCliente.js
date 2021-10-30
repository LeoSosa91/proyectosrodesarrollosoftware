const addCarrito= event=>{
    var ex_regular_dni; 
ex_regular_dni = /^[\d]{1,3}\.?[\d]{3,3}\.?[\d]{3,3}$/;
if(ex_regular_dni.test (event.target.value) == true){
    alert('Dni corresponde');
    return true
    
}else{
    alert('Dni erroneo, formato no válido');
    return false;
    
}
    
}
$(document).ready(function(){
    const addMjsErrorEnModal= response=>{
        $(".mjsInput").remove();
        var nodeList = document.getElementById('formModificarCliente').childNodes;
        for (var i = 0; i < nodeList.length; i++) {
            for (let j = 0; j < nodeList[i].childNodes.length; j++) {
                if (Object.keys(response).length > 0) {
                    if (response.hasOwnProperty(nodeList[i].childNodes[j].name)) {
                        var input1 = document.getElementById(nodeList[i].childNodes[j].name);
                        input1.className = "form-control is-invalid";
                        idNodoPadreContenedor=nodeList[i].childNodes[j].parentNode.id
                        $('<div/>').attr({class:'invalid-feedback mjsInput'}).text(response[nodeList[i].childNodes[j].name]).appendTo('#'+idNodoPadreContenedor);
                    }
                    else{
                        if (nodeList[i].childNodes[j].nodeType==1 && nodeList[i].childNodes[j].name!=undefined) {
                            if ( document.getElementById( nodeList[i].childNodes[j].name)) {
                                var input2 = document.getElementById(nodeList[i].childNodes[j].name);
                                input2.className = "form-control is-valid";
                                idNodoPadreContenedor=nodeList[i].childNodes[j].parentNode.id
                                $('<div/>').attr({class:'valid-feedback mjsInput'}).text("Correcto").appendTo('#'+idNodoPadreContenedor);        
                            }
                            
                        }
                    }    
                }
                
                else{
                    if (nodeList[i].childNodes[j].nodeType==1 && nodeList[i].childNodes[j].name!=undefined) {
                        if ( document.getElementById( nodeList[i].childNodes[j].name)) {
                            var input2 = document.getElementById(nodeList[i].childNodes[j].name);
                            input2.className = "form-control is-valid";
                            idNodoPadreContenedor=nodeList[i].childNodes[j].parentNode.id
                            $('<div/>').attr({class:'valid-feedback mjsInput'}).text("Correcto").appendTo('#'+idNodoPadreContenedor);        
                        }
                        
                    }
                }
            }
            
          }
    }
    $("#btnModificarCliente").click(function (e) { 
        let flag;
        $.ajax({
            type: "post",
            url:baseURL+'/admin/validarModificarCliente',
            data: {idUser: document.getElementById('idUser').value,dniUsuario: document.getElementById('dniUsuario').value,apellidoUsuario: document.getElementById('apellidoUsuario').value,nombreUsuario: document.getElementById('nombreUsuario').value,fechaNacUsuario: document.getElementById('fechaNacUsuario').value,correoUsuario: document.getElementById('correoUsuario').value,direccionUsuario: document.getElementById('direccionUsuario').value,telefonoUsuario: document.getElementById('telefonoUsuario').value},
            dataType: "json",
            success: function (response) {
                addMjsErrorEnModal(response.data)    
                var form=document.getElementById('formModificarCliente');
                var btn=document.getElementById('btnModificarCliente');
                if (response.status === true) {
                    form.removeAttribute("novalidate");
                    form.setAttribute("method", "post");
                    form.setAttribute("action", baseURL+"/admin/guardarCliente");
                    btn.setAttribute("type", "submit");
                }
                else{
                    btn.setAttribute("type", "button");
                }
                e.preventDefault();
               
            },error: function (res) {
                console.log("error");
            }
        });
        
        
        
    });
})


$("#dniUsuario").blur(addCarrito);


