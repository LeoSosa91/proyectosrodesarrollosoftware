const table = document.getElementById('platos');
table.addEventListener('click',e=>{editarPlato(e)})
    
const editarPlato= e=>{
    if (e.target.classList.contains('btn-warning')) {
        añadirAForm(e.target.parentElement)
    }
}
const añadirAForm= objeto =>{
    $.ajax({
        url:baseURL+"/menu/buscarPlato",
            method: 'post',
            data: {id: objeto.querySelector('button').dataset.id},
            dataType: 'json',
            success:function(data){
                document.getElementById('idPlato').value=data.data.idPlato
                document.getElementById('inputNameFood').value=data.data.nombrePlato
                document.getElementById('inputIngredientes').value=data.data.descripcionPlato
                document.getElementById('inputPrice').value=parseInt(data.data.precioPlato);
                document.getElementById("typeFood").value = data.data.tipoPlato; 
                console.log(data.data.deleted_at)
                if (data.data.deleted_at==0) {
                    document.getElementById("stateFood").value = "0"; 
                }
                if (data.data.deleted_at==1) {
                    document.getElementById("stateFood").value = "1"; 
                }
            }
    })
    
}