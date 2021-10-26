$(".btnPenalidades").click(function () {
    id=$(this).parents("tr").find(".cliente").attr("data-id");
    $("#idTablaPenalidades tbody tr").remove();
    $.ajax({
        url:baseURL+"/admin/verificarPenalidades",
        method: 'post',
        data: {id: id},
        dataType: 'json',
        success: function (res) {
            console.log(res.status);  
            console.log(res.data);
            fila=''
            nro=1;
            if (res.data.length >0) {
                res.data.forEach(penalidad => {
                    fila+='<tr><td>'+nro+++"<td><td>"+penalidad['descripcionPenalidad']+'<td></tr>'
                });    
            } else {
                fila+='<tr><td colspan="2">Sin penalidades</td></tr>'
            }
            $('#idTablaPenalidades tbody').append(fila);        
        } 
      })
    
})
$(".btnModificarCliente").click(function () {
    id=$(this).parents("tr").find(".cliente").attr("data-id");
    $.ajax({
        url:baseURL+"/admin/cargarDatosCliente",
        method: 'post',
        data: {id: id},
        dataType: 'json',
        success: function (res) {
            console.log(res.status);  
            console.log(res.data);
            $("#dniUsuario").val(res.data.dniUsuario);
            $("#apellidoUsuario").val(res.data.usersurname);
            $("#nombreUsuario").val(res.data.username);
            $("#fechaNacUsuario").val(res.data.userBirthday);
            $("#correoUsuario").val(res.data.useremail);
            $("#direccionUsuario").val(res.data.useradress);
            $("#telefonoUsuario").val(res.data.usertel);
            $("#idUser").val(id);
            
        } 
      })
})
$(".btnDeshabilitarCliente").click(function () {
    console.log("btndes");
})