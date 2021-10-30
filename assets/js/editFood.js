const table = document.getElementById('platos');
table.addEventListener('click',e=>{editarPlato(e)})
    
const editarPlato= e=>{
    if (e.target.classList.contains('btn-warning')) {
        añadirAForm(e.target.parentElement)
    }
}
const añadirAForm= objeto =>{
    $.ajax({
        url:baseURL+"/menu/plato/buscarPlato",
            method: 'post',
            data: {id: objeto.querySelector('button').dataset.id},
            dataType: 'json',
            success:function(data){
                console.log(data);
                document.getElementById('idPlato').value=data.data.idPlato
                document.getElementById('inputNameFood').value=data.data.nombrePlato
                document.getElementById('inputIngredientes').value=data.data.descripcionPlato
                document.getElementById('inputPrice').value=parseInt(data.data.precioPlato);
                document.getElementById("typeFood").value = data.data.idCategoriaPlato; 
                if (data.data.deleted_at==null) {
                    document.getElementById("stateFood").value = "0"; 
                }
                else{
                    document.getElementById("stateFood").value = "1"; 
                }
            }
    })
    
}