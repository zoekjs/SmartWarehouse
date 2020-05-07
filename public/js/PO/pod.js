document.addEventListener('DOMContentLoaded', () => {
    let delButtons = document.querySelectorAll('.delete');
    delButtons.forEach(btn =>{
        btn.addEventListener('click', () => {
            event.preventDefault();
            let idPOD = btn.parentElement.parentElement.childNodes[1].lastChild.nodeValue;
            let row = btn.parentElement.parentElement.rowIndex;
            console.log(row);
            let url = 'http://smartwarehouse.test:8080/api/pods/'
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
                        fetch(url += idPOD, {
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