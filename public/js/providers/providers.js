document.addEventListener('DOMContentLoaded', function () {
    var myForm = document.getElementById('providerForm');

    myForm.onsubmit = function (e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        var jsonData = {};
        for (var [k, v] of formData) {
            jsonData[k] = v;
        }

        jsonData['id_pais'] = document.getElementById('id_pais').value;

        fetch('api/providers', {
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
                    });
                document.getElementById('providerFormEdit').reset();
                tableDestroy();
                }else if(data.code == 422 || data.code == 400){
                    swal({
                        title: 'Algo malio sal :(',
                        type: 'error',
                        text: data.message,
                        confirmButtonText: 'Aceptar',
                    })
                }else if(data.code == 409){
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


function editData(){
    setTimeout(() => {
        let buttons = document.querySelectorAll('.edit');
        console.log(buttons);
        buttons.forEach((btn) => {
            btn.addEventListener('click', () => {
                deleteProvider();
                //obtener id desde la tabla antes de editar
                let idProvider = btn.parentElement.parentElement.children[0].lastChild.nodeValue;
                console.log(idProvider);
                let url = 'api/providers/';
                fetch(url += `${idProvider}`, {
                    method: 'GET'
                })
                    .then(res => res.json())
                    .then(data => {
                        console.log(data);
                        let json = data[0];
                        console.log(json);
                        if(data.code == 404){
                            swal({
                                title: "error !",
                                type: "error",
                                text: "El proveedor que intenta modificar no se encuentra registrado en el sistema.",
                                confirmButtonText: 'Aceptar',
                            })
                                .then(() => closeModalEdit());
                        }else{
                            let inputs = document.getElementById('providerFormEdit');
                            let select = document.getElementById('id_select');
                            select.setAttribute('value', `${json.id_country}`)
                            select.innerText = `${json.country_name}` 
                            inputs[2].setAttribute('value', json.rut_provider);
                            inputs[4].setAttribute('value', json.name);
                            inputs[5].setAttribute('value', json.telephone);
                            inputs[6].setAttribute('value', json.address);
                            inputs[7].setAttribute('value', json.email);
    
                            document.getElementById('formEditClear').addEventListener('click', () => document.getElementById('providerFormEdit').reset());
                            document.addEventListener('keydown', e => { if (e.key === 'Escape') { document.getElementById('providerFormEdit').reset() } });
                        }
                    })
                    .catch(error => console.log(error));
            })
        });
    }, 500);
};





document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('providerFormEdit').onsubmit = (e) => {
        e.preventDefault();
        let formData = new FormData(document.getElementById('providerFormEdit'));
        let json = {};
        for (var [k, v] of formData) {
            json[k] = v;
        }
        json['id_country'] = document.getElementById('id_countryEdit').value;

        console.log(json);
        let url = 'api/providers/';
        fetch(url += `${json.rut_provider}`, {
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
                let idProvider = btn.parentElement.parentElement.childNodes[0].lastChild.nodeValue;
                console.log(idProvider);
                let url = 'api/providers/'
                swal({
                    title: "Estás seguro?",
                    text: "No podrás recuperar el proveedor después de borrarlo!",
                    type: "warning",
                    showCancelButton: true,
                    cancelButtonText: "cancelar",
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Sí, Eliminar!",
                })
                    .then(res => {
                        if (res.value) {
                            fetch(url += idProvider, {
                                method: 'DELETE',
                                body: String(idProvider),
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
                                            title: "No se pudo eliminar el proveedor :(",
                                            type: "error",
                                            text: data.message,
                                            confirmButtonText: 'Aceptar'
                                        });
                                    }
                                })
                                .catch(error => console.log(error));
                        }
                    });
            })
        }
        )
    }, 500);
}

