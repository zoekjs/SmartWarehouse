document.addEventListener('DOMContentLoaded', function () {
    var myForm = document.getElementById('categoryForm');

    myForm.onsubmit = function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var jsonData = {};
        for (var [k, v] of formData) {
            jsonData[k] = v;
        }

        fetch('api/categories', {
            method: 'POST',
            body: JSON.stringify(jsonData),
            headers: {
                "content-type": "application/json",
                "accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
            }
        })
            .then(res => res.json())
            .then(data => {
                if(data.code == 201){
                    swal({
                        title: "Todo listo !",
                        type: "success",
                        text: data.message,
                        confirmButtonText: 'Aceptar',
                    })
                    .then(function () {
                        closeModal();
                        deleteProvider();
                        editData();
                        tableDestroy();
                    });
                document.getElementById('providerFormEdit').reset();
                }else if(data.code == 422 || data.code == 400){
                    swal({
                        title: 'Algo malio sal :(',
                        type: 'error',
                        text: data.message,
                        confirmButtonText: 'Aceptar',
                    })
                }
            })
            .catch(error => console.log(error));

    }

    deleteProvider();
    editData();
});


function editData() {
    setTimeout(() => {
        let buttons = document.querySelectorAll('.edit');
        buttons.forEach((btn) => {
            btn.addEventListener('click', () => {
                //obtener id desde la tabla antes de editar
                let categoryName = btn.parentElement.parentElement.children[0].lastChild.nodeValue;

                console.log(categoryName);
                let url = 'api/categories/';
                fetch(url += `${categoryName}`, {
                    method: 'GET'
                })
                    .then(res => res.json())
                    .then(data => {
                        console.log(data);
                        if(data.code == 404){
                            swal({
                                title: "error !",
                                type: "error",
                                text: "El proveedor que intenta modificar no se encuentra registrado en el sistema.",
                                confirmButtonText: 'Aceptar',
                            })
                                .then(() => closeModalEdit());
                        }else{
                            let name = document.getElementById('nameEdit');
                            let id = document.getElementById('idEdit');
                            name.setAttribute('value', `${data.name}`);
                            id.setAttribute('value', `${data.id_category}`);
                            
    
                            document.getElementById('formEditClear').addEventListener('click', () => document.getElementById('categoryFormEdit').reset());
                            document.addEventListener('keydown', e => { if (e.key === 'Escape') { document.getElementById('categoryFormEdit').reset() } });
                        }
                    })
                    .catch(error => console.log(error));
            })
        });
    }, 500);
}



document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('categoryFormEdit').onsubmit = (e) => {
        e.preventDefault();
        let formData = new FormData(document.getElementById('categoryFormEdit'));
        console.log(formData);
        let json = {};
        for (var [k, v] of formData) {
            json[k] = v;
        }

        console.log(json);
        let url = 'api/categories/';
        fetch(url += `${json.id_category}`, {
            method: 'PUT',
            body: JSON.stringify(json),
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
            }
        })
            .then(res => res.json())
            .then(data => {
                if (data.code == 201) {
                    swal({
                        title: "Todo listo !",
                        type: "success",
                        text: data.message,
                        confirmButtonText: 'Aceptar',
                    })
                        .then(() => {
                            closeModalEdit();
                            tableDestroy();
                            document.getElementById('providerFormEdit').reset()
                            editData();
                            deleteProvider();
                        });


                }
                else if (data.code == 404) {
                    swal({
                        title: "No se pudo actualizar el proveedor :(",
                        type: "error",
                        text: data.message,
                        confirmButtonText: 'Aceptar'
                    });
                }
                else if (data.code == 400) {
                    swal({
                        title: "No se pudo actualizar el proveedor :(",
                        type: "error",
                        text: data.message,
                        confirmButtonText: 'Aceptar'
                    });
                }

            })
            .catch(error => console.log(error));
    }
});

function deleteProvider() {
    setTimeout(() => {
        let delButtons = document.querySelectorAll('.delete');
        delButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                let name = btn.parentElement.parentElement.childNodes[0].lastChild.nodeValue;
                let url = 'api/categories/'
                swal({
                    title: "Estás seguro?",
                    text: "No podrás recuperar la categoría después de borrarla!",
                    type: "warning",
                    showCancelButton: true,
                    cancelButtonText: "cancelar",
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Sí, Eliminar!",
                })
                    .then(res => {
                        if (res.value) {
                            fetch(url += name, {
                                method: 'DELETE',
                                body: String(name),
                                headers: {
                                    "Content-Type": "application/json",
                                    "Accept": "application/json",
                                    "X-Requested-With": "XMLHttpRequest",
                                }
                            })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.code == 200) {
                                        swal({
                                            title: "Todo listo !",
                                            type: "success",
                                            text: data.message,
                                            confirmButtonText: 'Aceptar',
                                        })
                                            .then(() => {
                                                tableDestroy();
                                                deleteProvider();
                                                editData();
                                            });
                                    }
                                    else if (data.code == 400) {
                                        swal({
                                            title: "No se pudo eliminar la categoría :(",
                                            type: "error",
                                            text: data.message,
                                            confirmButtonText: 'Aceptar'
                                        });
                                    }
                                })
                        }
                    });
            })
        }
        )
    }, 500);
}

