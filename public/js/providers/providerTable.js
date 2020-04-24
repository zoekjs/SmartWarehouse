$(document).ready(function () {
    ajaxRequest();
});
function ajaxRequest() {
    var table = $('#providers').DataTable({
        "serverSide": true,
        "ajax": "api/products",
        "columns": [
            { data: 'id_product' },
            { data: 'name' },
            { data: 'description' },
            { data: 'quantity' },
            { data: 'quantity' },
            { data: 'quantity'},
            { "defaultContent": "<button type='button' class='btn btn-warning btn-sm edit' data-toggle='modal' data-target='#modalEdit'>Editar</button>&nbsp&nbsp<button type='button' id='formClear' class='btn  btn-sm btn-danger delete'>Eliminar</button>" },
        ],
        "language": {
            "info": "_TOTAL_ registros",
            "search": "Buscar",
            "paginate": {
                "next": "Siguiente",
                "previous": "Anterior",
            },
            "lengthMenu": 'Mostrar <select >' +
                '<option value="10">10</option>' +
                '<option value="30">30</option>' +
                '<option value="-1">Todos</option>' +
                '</select> registros',
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "emptyTable": "No hay datos",
            "zeroRecords": "No hay coincidencias",
            "infoEmpty": "",
            "infoFiltered": ""
        },
    });
}

function tableDestroy() {
    var table = $('#products').DataTable();
    table.destroy();
    ajaxRequest();
}
function closeModal() {
    var myModal = $('#modal1');
    myModal.modal('hide');
}
function closeModalEdit() {
    var myModal = $('#modalEdit');
    myModal.modal('hide');
}
