document.addEventListener('DOMContentLoaded', () => {
    let delButtons = document.querySelectorAll('.delete');
    delButtons.forEach(btn =>{
        btn.addEventListener('click', () => {
            event.preventDefault();
            let idPOD = btn.parentElement.parentElement.childNodes[1].lastChild.nodeValue;
            let row = btn.parentElement.parentElement.rowIndex;
            let rutUser = document.getElementById('rut_user').value;
            let url = 'https://smartwarehouse.brazilsouth.cloudapp.azure.com/api/pods/'
            swal({
                title: "Estás seguro?",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "cancelar",
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Sí, quitar!",
            })
                .then(res => {
                    if(res.value){
                        fetch(url += idPOD += `/${rutUser}`, {
                            method: 'DELETE',
                            body: String(idPOD),
                            headers: {
                                "Content-Type": "application/json",
                                "Accept": "application/json",
                                "X-Requested-With": "XMLHttpRequest",
                            }
                        })
                            .then(res => res.json())
                            .then(data => {
                                if(data.code == 200){
                                    document.getElementById('table_details').deleteRow(row);
                                }
                            })
                            .catch(error => console.log(error));
                    }
                })

        })
    })
});

function getPrice(){
    let idProduct = document.getElementById('id_product').value;
    let url = 'https://smartwarehouse.brazilsouth.cloudapp.azure.com/api/products/';
    fetch(url+=`${idProduct }`, {
        method: 'GET'
    })
        .then(res => res.json())
        .then(data => {
            let precio = document.getElementById('price');
            precio.setAttribute('value', data.unit_price);
        })
}
