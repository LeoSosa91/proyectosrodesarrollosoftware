const table = document.getElementById('promociones');
table.addEventListener('click',e=>{editarPromocion(e)})
    
const editarPromocion= e=>{
    if (e.target.classList.contains('btn-warning')) {
        añadirAForm(e.target.parentElement)
    }
}
const añadirAForm= objeto =>{
    $.ajax({
        url:baseURL+"/menu/promocion/buscarPromocion",
            method: 'post',
            data: {id: objeto.querySelector('button').dataset.id},
            dataType: 'json',
            success:function(data){
                console.log(data)
                document.getElementById('idPromocion').value=data[0].idPromocion
                document.getElementById('inputDescripcionPromocion').value=data[0].descripcionPromocion
                document.getElementById('inputDescuentoPromocion').value=parseInt(data[0].descuentoPromocion);
                document.getElementById("inputFecIniPromocion").value = data[0].fechaPromocionInicio; 
                document.getElementById("inputFecFinPromocion").value = data[0].fechaPromocionFin; 
            }
    })
    
}