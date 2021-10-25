const table = document.getElementById('bebidas');
table.addEventListener('click',e=>{editarBebida(e)})
    
const editarBebida= e=>{
    if (e.target.classList.contains('btn-warning')) {
        añadirAForm(e.target.parentElement)
    }
}
const añadirAForm= objeto =>{
    $.ajax({
        url:baseURL+"/menu/buscarBebida",
            method: 'post',
            data: {id: objeto.querySelector('button').dataset.id},
            dataType: 'json',
            success:function(data){
                
                document.getElementById('idBebida').value=data.data.idBebida
                document.getElementById('inputNameDrink').value=data.data.nombreBebida
                document.getElementById('inputPrice').value=parseInt(data.data.precioBebida);
                document.getElementById("typeDrink").value = data.data.tipoBebida; 
                
                if (data.data.deleted_at==0) {
                    document.getElementById("stateDrink").value = "0"; 
                }
                if (data.data.deleted_at==1) {
                    document.getElementById("stateDrink").value = "1"; 
                }
            }
    })
    
}