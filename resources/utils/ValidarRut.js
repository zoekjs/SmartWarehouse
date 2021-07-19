export function validarRut(rut, dvForm) {
    let largo = rut.length
    let suma = 0
    let numero = null
    let constante = 2
    let dv = 0

    console.log(rut, dvForm)
    if (rut.length > 0) {
        for (let i = largo - 1; i >= 0; i--) {
            numero = Number(rut.substr(i, 1))
            console.log(numero)

            suma = suma + (numero * constante)
            constante += 1
            if (constante === 8) {
                constante = 2
            }
        }
    } else {
        return false
    }
    console.log(suma)
    console.log(11 - (suma % 11))
    dv = (11 - suma % 11)
    if (dv === 10) {
        dv = 'K'
    }
    if (dv === 11) {
        dv = '0'
    }
    if (dv === Number(dvForm)) {
        return true
    } else return dv === dvForm.toUpperCase();
}


