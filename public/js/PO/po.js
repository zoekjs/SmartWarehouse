function checkRefuseReason(){
    var refuseForm = document.getElementById('refuseForm');
    var refuseReason = document.getElementById('TARefuse');

    if(refuseReason == null || refuseReason == null){
        swal({
            title: "Algo malio sal :(",
            type: "error",
            text: "Debe indicar el motivo de rechazo para continuar",
            confirmButtonText: 'Aceptar',
        })
        refuseReason.focus();
        return false;
    }else{
        refuseForm.submit();
        return true;
    }
}





