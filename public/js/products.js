document.addEventListener('DOMContentLoaded', function () {
    var myForm = document.getElementById('productForm');

    myForm.onsubmit = function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var jsonData = {};
        for (var [k, v] of formData) {
            jsonData[k] = v;
        }

        fetch("api/products", {
            method: "POST",
            body: JSON.stringify(jsonData),
            headers: {
                "content-type": "application/json",
                "accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",

            },
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
                        .then(function () {
                            closeModal();
                        });
                    document.getElementById('productForm').reset();
                    tableDestroy();
                }
                else if (data.code == 422) {
                    swal({
                        title: "No se pudo agregar el producto :(",
                        type: "error",
                        text: data.message,
                        confirmButtonText: 'Aceptar'
                    });
                }
            })
            .catch(error => console.log(error));
    }
    editData();
    deleteProduct();
});

function editData() {
    setTimeout(() => {
        let buttons = document.querySelectorAll('.edit');
        buttons.forEach((btn) => {
            btn.addEventListener('click', () => {
                //obtener id desde la tabla antes de editar
                let idProduct = btn.parentElement.parentElement.children[0].lastChild.nodeValue;
                let url = 'api/products/';
                fetch(url += `${idProduct}`, {
                    method: 'GET'
                })
                    .then(res => res.json())
                    .then(data => {
                        if(data.code == 404){
                            swal({
                                title: "error !",
                                type: "error",
                                text: "El producto que intenta modificar no se encuentra registrado en el sistema.",
                                confirmButtonText: 'Aceptar',
                            })
                                .then(() => closeModalEdit());
                        }else{
                            let inputs = document.getElementById('productFormEdit');
                            inputs[1].setAttribute('value', data.id_product);
                            inputs[2].setAttribute('value', data.name);
                            inputs[3].value += data.description;
                            inputs[4].setAttribute('value', data.quantity);
                            inputs[5].setAttribute('value', data.unit_price);
    
                            document.getElementById('formEditClear').addEventListener('click', () => document.getElementById('productFormEdit').reset());
                            document.addEventListener('keydown', e => { if (e.key === 'Escape') { document.getElementById('productFormEdit').reset() } });
                        }
                    })
                    .catch(error => console.log(error));
            })
        });
    }, 500);
}



document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('productFormEdit').onsubmit = (e) => {
        e.preventDefault();
        let formData = new FormData(document.getElementById('productFormEdit'));
        let json = {};
        for (var [k, v] of formData) {
            json[k] = v;
        }

        let url = 'api/products/';
        fetch(url += `${json.id_product}`, {
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
                            document.getElementById('productFormEdit').reset()
                            editData();
                            deleteProduct();
                        });


                }
                else if (data.code == 404) {
                    swal({
                        title: "No se pudo actualizar el producto :(",
                        type: "error",
                        text: data.message,
                        confirmButtonText: 'FEELS BAD MAN'
                    });
                }

            })
            .catch(error => console.log(error));
    }
});

function deleteProduct() {
    setTimeout(() => {
        let delButtons = document.querySelectorAll('.delete');
        delButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                let idProduct = btn.parentElement.parentElement.childNodes[0].lastChild.nodeValue;
                let url = 'api/products/'
                swal({
                    title: "Estás seguro?",
                    text: "No podrás recuperar el producto después de borrarlo!",
                    type: "warning",
                    showCancelButton: true,
                    cancelButtonText: "cancelar",
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Sí, Eliminar!",
                })
                    .then(res => {
                        if (res.value) {
                            fetch(url += idProduct, {
                                method: 'DELETE',
                                body: String(idProduct),
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
                                                editData();
                                                deleteProduct();
                                            });
                                    }
                                    else if (data.code == 400) {
                                        swal({
                                            title: "No se pudo eliminar el producto :(",
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

