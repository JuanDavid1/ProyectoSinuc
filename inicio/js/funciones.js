(function ($) {
    //Superponer modales
    $(document).on('show.bs.modal', '.modal', function () {
        var zIndex = 1040 + (10 * $('.modal:visible').length);
        $(this).css('z-index', zIndex);
        setTimeout(function () {
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
        }, 0);
    });
})(jQuery);
// crear datatable
$(document).ready(function () {
    var setIdioma = {
        "decimal": "",
        "emptyTable": "No hay información",
        "infoPostFix": "",
        "thousands": ",",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": '<i class="fas fa-search fa-flip-horizontal" style="font-size:1.5rem; color:#2ECC71;"></i>',
        "zeroRecords": "No se encontraron registros",
        "paginate": {
            "first": "&#10096&#10096",
            "last": "&#10097&#10097",
            "next": "&#10097",
            "previous": "&#10096"
        }
    };
    var setdom;
    if ($("#peReg").val() === '1') {
        setdom = "<'row'<'col-md-5'l><'bttn-plus-dt col-md-2'B><'col-md-5'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>";
    } else {
        setdom = "<'row'<'col-md-6'l><'col-md-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>";
    }
    $('#tablePersonas').DataTable({
        language: setIdioma,
        dom: setdom,
        "ajax": {
            url: 'datos/listar/personas.php',
            type: 'POST',
            dataType: 'json',
        },
        "columns": [
            { 'data': 'id' },
            { 'data': 'tdoc' },
            { 'data': 'doc' },
            { 'data': 'nombre' },
            { 'data': 'fec_nac' },
            { 'data': 'fec_atencion' },
            { 'data': 'eps' },
            { 'data': 'estado' },
            { 'data': 'action' },
        ],
        "order": [
            [0, "asc"]
        ],
    });
    var paciente = document.getElementById("id_paciente");
    var id = paciente ? paciente.value : 0;
    $('#tableCargaFiles').DataTable({
        language: setIdioma,
        dom: setdom,
        "ajax": {
            url: '../datos/listar/archivos.php',
            type: 'POST',
            dataType: 'json',
            data: { id: id },
        },
        "columns": [
            { 'data': 'id' },
            { 'data': 'nombre' },
            { 'data': 'categoria' },
            { 'data': 'archivo' },
            { 'data': 'fecha' },
            { 'data': 'action' },
        ],
        "order": [
            [0, "asc"]
        ],
    });
    $('#tableCargarSec').DataTable({
        language: setIdioma,
        dom: setdom,
        "ajax": {
            url: '../datos/listar/datoseg.php',
            type: 'POST',
            dataType: 'json',
            data: { id: id },
        },
        "columns": [
            { 'data': 'id_seguimeinto' },
            { 'data': 'nombre' },
            { 'data': 'fechasivig' },
            { 'data': 'fechaseg' },
            { 'data': 'peso' },
            { 'data': 'talla' },
            { 'data': 'puntaje' },
            { 'data': 'ftlc' },
            { 'data': 'estado' },
            { 'data': 'action' },

        ],
        "order": [
            [0, "asc"]
        ],
    });

});
// funcion reloadtable: Realiza la recarga de la datable especificada, visualizando los cambios realizados.
function reloadtable(nom) {
    (function ($) {
        var reloadtable = function (nom) {
            $(document).ready(function () {
                var table = $('#' + nom).DataTable();
                table.ajax.reload();
            });
        };
        reloadtable(nom);
    })(jQuery);
};

function RegistrarDatosIps() {
    var id = "";
    let tamaño = "modal-xl";
    let url = 'datos/formularios/regdatosips.php';
    Formularios(tamaño, id, url);
}

function RegistrarPecientes() {
    var id = "";
    let tamaño = "modal-xl";
    let url = 'datos/formularios/regpaciente.php';
    Formularios(tamaño, id, url);
}

function hacerPost(url, datos, callback) {
    fetch(url, {
        method: "POST",
        body: datos,
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        }
    })
        .then(function (response) {
            return response.text();
        })
        .then(function (he) {
            callback(he);
        });
}

function encodeFormData(data) {
    var encodedData = [];
    for (var name in data) {
        encodedData.push(encodeURIComponent(name) + "=" + encodeURIComponent(data[name]));
    }
    return encodedData.join("&");
}

function RegPaciente(tipo) {

    var tipodocumento = document.getElementById("txtipodoc");
    var numerodocumento = document.getElementById("txnumero");
    var nombre1 = document.getElementById("txnombre1");
    var nombre2 = document.getElementById("txnombre2");
    var apellido1 = document.getElementById("txapllido1");
    var apellido2 = document.getElementById("txapllido2");
    var fechanacimiento = document.getElementById("dtfecnac");
    var telefono = document.getElementById("txtelefono");
    var municipio = document.getElementById("txmunicipio");
    var area = document.getElementById("txarea");
    var direccion = document.getElementById("txdireccion");
    var eps = document.getElementById("txteps");
    var regimen = document.getElementById("txtregimen");
    var m = document.getElementById("masculino");
    var f = document.getElementById("femenino");
    var fechaatencion = document.getElementById("txfechaatencion");
    var resultadoSemana = document.getElementById("inputresultadoSemana");

    ClearInvalid();

    if (tipodocumento.value === "0") {
        let msg = "Debe ingresar el tipo de documento";
        AlertError(msg, tipodocumento);
    } else if (numerodocumento.value === "") {
        let msg = "Debe ingresar el numero de documento";
        AlertError(msg, numerodocumento);
    } else if (nombre1.value === "") {
        let msg = "Debe ingresar el primer nombre";
        AlertError(msg, nombre1);
    } else if (apellido1.value === "") {
        let msg = "Debe ingresar el primer apellido";
        AlertError(msg, apellido1);
    } else if (apellido2.value === "") {
        let msg = "Debe ingresar el segundo apellido";
        AlertError(msg, apellido2);

    } else if (fechanacimiento.value === "") {
        let msg = "Debe ingresar la fecha de nacimiento";
        AlertError(msg, fechanacimiento);
    } else if (CalcularEdad(fechanacimiento.value) > 6000) {
        let msg = "El paciente debe ser menor de 6 años"
        AlertError(msg, fechanacimiento);
    } else if (!(f.checked || m.checked)) {
        let msg = "Debe ingresar el sexo";
        document.getElementById("genero").classList.add("is-invalid");
        AlertError(msg, m);
    } else if (telefono.value === "") {
        let msg = "Debe ingresar el telefono";
        AlertError(msg, telefono);
    } else if (municipio.value === "0") {
        let msg = "Debe ingresar el municipio";
        AlertError(msg, municipio);
    } else if (area.value === "0") {
        let msg = "Debe ingresar el area";
        AlertError(msg, area);
    } else if (direccion.value === "") {
        let msg = "Debe ingresar la direccion";
        AlertError(msg, direccion);
    } else if (eps.value === "0") {
        let msg = "Debe ingresar la eps";
        AlertError(msg, eps);
    } else if (regimen.value === "0") {
        let msg = "Debe ingresar el regimen";
        AlertError(msg, regimen);
    } else if (fechaatencion.value === "") {
        let msg = "Debe ingresar la fecha de atención";
        AlertError(msg, fechaatencion);
    } else if (resultadoSemana.value === "") {
        let msg = "Debe ingresar la fecha de atención";
        AlertError(msg, resultadoSemana);
    }
    else {
        var url = "";
        if (tipo === 'u') {
            url = "datos/actualizar/updpaciente.php";
        } else {
            url = "datos/registrar/addpaciente.php";
        }
        let form = 'formRegMarca';
        let table = 'tablePersonas';
        FetchData(url, form, table);
    }
}

function CalcularEdad(fechaNacimiento) {
    // Obtiene la fecha actual
    const fechaActual = new Date();
    fechaNacimiento = new Date(fechaNacimiento);

    // Obtiene la diferencia en milisegundos entre las dos fechas
    const diferencia = fechaActual - fechaNacimiento;

    // Divide la diferencia en milisegundos por la cantidad de milisegundos en un año
    const edad = diferencia / (31556926);

    // Devuelve la edad en años
    return Math.floor(edad);
}

function UpdatePecientes(id) {
    id = 'id=' + id;
    let tamaño = "modal-xl";
    let url = 'datos/formularios/updpaciente.php';
    Formularios(tamaño, id, url);
}

function VerArchivoP(boton) {
    var base64 = boton.value;
    var ruta = atob(base64);
    var link = document.createElement("a");
    link.href = ruta;
    link.target = "_blank";
    link.download = ruta.split("/").pop().split('_').pop();
    link.click();
}

function DeletArchivoP(id) {
    var myModal = new bootstrap.Modal(document.getElementById("divModalConfDel"), {});
    document.getElementById("divBtnsModalDel").innerHTML = '<button type="button" id="confirmation" class="btn btn-danger btn-sm mb-1" data-bs-dismiss="modal"> Aceptar</button> <a type="button" class="btn btn-secondary btn-sm mb-1" data-bs-dismiss="modal"> Cancelar</a>';
    document.getElementById("divMsgConfdel").innerHTML = "¿Esta seguro de eliminar el archivo?";
    myModal.show();
    var confirmButton = document.getElementById("confirmation");
    confirmButton.addEventListener("click", function () {

        var url = "../datos/eliminar/delarchivo.php";
        const datos = new FormData();
        datos.append('id', id);
        fetch(url, {
            method: 'POST',
            body: datos,
        })
            .then(function (response) {
                if (response.ok) {
                    return response.json();
                } else {
                    throw "Error en la llamada Ajax";
                }

            })
            .then(function (r) {
                if (r.status == 'ok') {
                    reloadtable("tableCargaFiles");
                    var myModal = new bootstrap.Modal(document.getElementById("divModalDone"), {});
                    document.getElementById("divMsgDone").innerHTML = r.msg;
                    myModal.show();
                } else {
                    var myModal = new bootstrap.Modal(document.getElementById("divModalError"), {});
                    document.getElementById("divMsgError").innerHTML = 'Error: ' + r.msg;
                    myModal.show();
                }
            })
            .catch(function (err) {
                var myModal = new bootstrap.Modal(document.getElementById("divModalError"), {});
                document.getElementById("divMsgError").innerHTML = 'Error: ' + err;
                myModal.show();
            });

    });
}

function DeletUser(id) {
    var myModal = new bootstrap.Modal(document.getElementById("divModalConfDel"), {});
    document.getElementById("divBtnsModalDel").innerHTML = '<button type="button" id="confirmation" class="btn btn-danger btn-sm mb-1" data-bs-dismiss="modal"> Aceptar</button> <a type="button" class="btn btn-secondary btn-sm mb-1" data-bs-dismiss="modal"> Cancelar</a>';
    document.getElementById("divMsgConfdel").innerHTML = "¿Esta seguro de eliminar el usuario?";
    myModal.show();
    var confirmButton = document.getElementById("confirmation");
    confirmButton.addEventListener("click", function () {

        var url = "datos/eliminar/deluser.php";
        const datos = new FormData();
        datos.append('id', id);
        fetch(url, {
            method: 'POST',
            body: datos,
        })
            .then(function (response) {
                if (response.ok) {
                    return response.json();
                } else {
                    throw "Error en la llamada Ajax";
                }

            })
            .then(function (r) {
                if (r.status == 'ok') {
                    var id = "tableUsuarios"
                    reloadtable(id);
                    var myModal = new bootstrap.Modal(document.getElementById("divModalDone"), {});
                    document.getElementById("divMsgDone").innerHTML = r.msg;
                    myModal.show();
                } else {
                    var myModal = new bootstrap.Modal(document.getElementById("divModalError"), {});
                    document.getElementById("divMsgError").innerHTML = 'Error: ' + r.msg;
                    myModal.show();
                }
            })
            .catch(function (err) {
                var myModal = new bootstrap.Modal(document.getElementById("divModalError"), {});
                document.getElementById("divMsgError").innerHTML = 'Error: ' + err;
                myModal.show();
            });
    });
}


function DeletPaciente(id) {
    var myModal = new bootstrap.Modal(document.getElementById("divModalConfDel"), {});
    document.getElementById("divBtnsModalDel").innerHTML = '<button type="button" id="confirmation" class="btn btn-danger btn-sm mb-1" data-bs-dismiss="modal"> Aceptar</button> <a type="button" class="btn btn-secondary btn-sm mb-1" data-bs-dismiss="modal"> Cancelar</a>';
    document.getElementById("divMsgConfdel").innerHTML = "¿Esta seguro de eliminar el registro?";
    myModal.show();
    var confirmButton = document.getElementById("confirmation");
    confirmButton.addEventListener("click", function () {

        var url = "datos/eliminar/delpaciente.php";
        const datos = new FormData();
        datos.append('id', id);
        fetch(url, {
            method: 'POST',
            body: datos,
        })
            .then(function (response) {
                if (response.ok) {
                    return response.json();
                } else {
                    throw "Error en la llamada Ajax";
                }

            })
            .then(function (r) {
                if (r.status == 'ok') {
                    var id = "tablePersonas"
                    reloadtable(id);
                    var myModal = new bootstrap.Modal(document.getElementById("divModalDone"), {});
                    document.getElementById("divMsgDone").innerHTML = r.msg;
                    myModal.show();
                } else {
                    var myModal = new bootstrap.Modal(document.getElementById("divModalError"), {});
                    document.getElementById("divMsgError").innerHTML = 'Error: ' + r.msg;
                    myModal.show();
                }
            })
            .catch(function (err) {
                var myModal = new bootstrap.Modal(document.getElementById("divModalError"), {});
                document.getElementById("divMsgError").innerHTML = 'Error: ' + err;
                myModal.show();
            });
    });

}
function DetailsPaciente(id) {
    const form = document.createElement("form");
    form.action = "detallepaciente/detalle.php";
    form.method = "post";

    const input = document.createElement("input");
    input.type = "hidden";
    input.name = "id";
    input.value = id;

    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
};
function SubirDocumento() {
    ClearInvalid();
    let tipos = document.querySelectorAll("select[name='slcTipo[]']");
    let archivos = document.querySelectorAll("input[name='archivo[]']");
    for (let tipo of tipos) {
        if (tipo.value === "0") {
            let msg = "Debe seleccionar un tipo de seguimiento";
            AlertError(msg, tipo);
            return false;
        }
    }
    for (let archivo of archivos) {
        if (archivo.value === "") {
            let msg = "Debe seleccionar un archivo";
            AlertError(msg, archivo);
            return false;
        }
    }
    var url = "../datos/registrar/addarchivos.php";
    var formulario = "formCargaDocs";
    var table = "tableCargaFiles";
    FetchData(url, formulario, table)
};


function addFile() {
    // Create a new row
    var lista = document.getElementById("uploadFiles");
    var newRow = document.createElement("div");
    var menu = document.getElementById("slcTipo").innerHTML; // Obtener el menu de opciones
    var fila = '<div class="row">' +
        '<div class="form-group col-md-3">' +
        '<select class="form-control form-control-sm" name="slcTipo[]">' + menu +
        '</select>' +
        '</div >' +
        '<div class="form-group col-md-8">' +
        '<input class="form-control form-control-sm" type="file" name="archivo[]">' +
        '</div>' +
        '<div class="form-group col-md-1">' +
        '<div class="form-control form-control-sm p-0 border-0">' +
        '<button type="button" class="btn btn-danger mb-0 py-2 w-100" onclick="delRow(this)"><i class="fas fa-minus"></i></button>' +
        '</div>' +
        '</div>' +
        '</div > ';
    newRow.innerHTML = fila;
    lista.insertBefore(newRow, document.getElementById("delRow"));
}
function delRow(boton) {
    var row = boton.parentNode.parentNode.parentNode;
    row.parentNode.removeChild(row);
}

//**************FUNCIONES QUE SE LLAMAN INTERNAMENTE******************//
function AlertError(msg, input) {
    var myModal = new bootstrap.Modal(document.getElementById("divModalError"), {});
    document.getElementById("divMsgError").innerHTML = msg;
    input.classList.add("is-invalid");
    input.focus();
    myModal.show();
};
function ClearInvalid() {
    document.querySelectorAll('.is-invalid').forEach(function (el) {
        el.classList.remove('is-invalid');
    });
};
function FetchData(url, formulario, table) {
    const datos = new FormData();
    const form = document.getElementById(formulario);
    const inputs = form.querySelectorAll('input, select');

    for (const input of inputs) {
        if (input.type === 'radio' && input.checked) {
            datos.append(input.name, input.value);
        } else if (input.type !== 'radio') {
            if (input.type === 'file') {
                const file = input.files[0];
                datos.append(input.name, file);
            } else {
                datos.append(input.name, input.value);
            }
        };
    }
    fetch(url, {
        method: 'POST',
        body: datos,
    })
        .then(function (response) {
            if (response.ok) {
                return response.json();
            } else {
                throw "Error en la llamada Ajax";
            }

        })
        .then(function (r) {
            if (r.status == 'ok') {
                reloadtable(table);
                document.getElementById(formulario).reset();
                var myModal = new bootstrap.Modal(document.getElementById("divModalDone"), {});
                var modalForm = document.getElementById("divModalForms");
                var modalbackdrop = document.getElementsByClassName("modal-backdrop");
                if (modalbackdrop.length > 0) {
                    modalbackdrop[0].remove();
                }
                modalForm.style.display = "none";
                document.getElementById("divMsgDone").innerHTML = r.msg;
                myModal.show();
            } else {
                var myModal = new bootstrap.Modal(document.getElementById("divModalError"), {});
                document.getElementById("divMsgError").innerHTML = 'Error: ' + r.msg;
                myModal.show();
            }
        })
        .catch(function (err) {
            var myModal = new bootstrap.Modal(document.getElementById("divModalError"), {});
            document.getElementById("divMsgError").innerHTML = 'Error: ' + err;
            myModal.show();
        });
};

function Formularios(tamaño, id, url) {
    var myModal = new bootstrap.Modal(document.getElementById("divModalForms"), {});
    document.getElementById("divTamModalForms").classList.remove("modal-fullscreen", "modal-xl", "modal-sm", "modal-2x");
    document.getElementById("divTamModalForms").classList.add(tamaño);
    hacerPost(url, id, function (he) {
        document.getElementById('divForms').innerHTML = he;
    });
    myModal.show();
};

function CargaNCatergoria() {
    var categoria = document.getElementById("txtsisben");
    var n_categorias = document.getElementById("txtnivelsisben");
    var valor = categoria.value;
    valor = 'valor=' + valor;
    var url = "datos/listar/n_categorias.php";
    hacerPost(url, valor, function (he) {
        n_categorias.innerHTML = he;
    });

};

function RegIec(tipo) {

    var niveledu = document.getElementById("txtiponivelm");
    var niveledup = document.getElementById("txtiponivelp");
    var tipofamiliar = document.getElementById("txtipofamilia");
    var personashogar = document.getElementById("txpersona");
    var nmenores = document.getElementById("txnemor");
    var nivelsisben = document.getElementById("txtsisben");
    var nnivelsisben = document.getElementById("txtnivelsisben");
    var cuidadormenor = document.getElementById("txtcuidador");
    var nacimiento = document.getElementById("txtnacimiento");
    var semana = document.getElementById("txtsemana");
    var pesonacer = document.getElementById("txtnacer");
    var tallanacer = document.getElementById("txtalla");
    var leche = document.getElementById("txtleche");
    var lechesi = document.getElementById("lechesi");
    var lecheno = document.getElementById("lecheno");
    var exclusiva = document.getElementById("txtexclusiva");
    var biberon = document.getElementById("txtbiberon");
    var biberonsi = document.getElementById("biberonsi");
    var biberonno = document.getElementById("biberonno");
    var crecimiento = document.getElementById("txtcrecimiento");
    var crecimientosi = document.getElementById("crecimientosi");
    var crecimientono = document.getElementById("crecimientono");
    var crecimientonosabe = document.getElementById("crecimientonosabe");
    var vacunacion = document.getElementById("txtvacunacion");
    var vacunacionsi = document.getElementById("vacunasi");
    var vacunacionno = document.getElementById("vacunano");
    var vacunacionnosabe = document.getElementById("vacunanosabe");
    var tflc = document.getElementById("txtftlc");
    var ftlcsi = document.getElementById("ftlcsi");
    var ftlcno = document.getElementById("ftlcno");
    var ftlcnosabe = document.getElementById("ftlcnosabe");
    var complemento = document.getElementById("txtcomplemento");
    var complementosi = document.getElementById("complementosi");
    var complementono = document.getElementById("complementono");
    var complementootro = document.getElementById("complementootro");
    var programa = document.getElementById("txtprograma");
    var programasi = document.getElementById("programasi");
    var programano = document.getElementById("programano");
    var programaotro = document.getElementById("programaotro");
    var abandono = document.getElementById("txtabandono");
    var abandonosi = document.getElementById("abandonosi");
    var abandonono = document.getElementById("abandonono");
    var abandononosabe = document.getElementById("abandononosabe");
    var eda = document.getElementById("txteda");
    var edano = document.getElementById("edano");
    var edasi = document.getElementById("edasi");
    var ira = document.getElementById("txtira");
    var irasi = document.getElementById("irasi");
    var irano = document.getElementById("irano");
    var pediatria = document.getElementById("txtpediatria");
    var pediatriasi = document.getElementById("pediatriasi");
    var pediatriano = document.getElementById("pediatriano");
    var pediatriaatencion = document.getElementById("txfechaatencionpe");
    var valornutri = document.getElementById("txtnutri");
    var nutricionsi = document.getElementById("nutricionsi");
    var nutricionno = document.getElementById("nutricionno");
    var fechaatencionnutri = document.getElementById("txtfechaatencionnutri");
    var signos = document.getElementById("txtsignos");
    var clasificacion = document.getElementById("txtclasificacion");
    var tallaedad = document.getElementById("txtallaedad");
    var pesoedad = document.getElementById("txtpesoedad");
    var educacion = document.getElementById("txteducacion");
    var ducacionsi = document.getElementById("ducacionsi");
    var ducacionno = document.getElementById("ducacionno");
    var salud = document.getElementById("txtsalud");
    var remitesi = document.getElementById("remitesi");
    var remiteno = document.getElementById("remiteno");
    var observa = document.getElementById("txtobserva");
    var fechaseguimiento = document.getElementById("fechaseguimiento");


    ClearInvalid();
    if (fechaseguimiento.value === "") {
        let msg = "Debe ingresar una fecha de seguimientos";
        AlertError(msg, fechaseguimiento);
    } else if (niveledu.value === "0") {
        let msg = "Debe ingresar el nivel educativo de la madre o cuidador";
        AlertError(msg, niveledu);
    } else if (niveledup.value === "0") {
        let msg = "Debe ingresar un nivel educativo del padre";
        AlertError(msg, niveledup);
    } else if (tipofamiliar.value === "0") {
        let msg = "Debe ingresar un nivel educativo del padre";
        AlertError(msg, tipofamiliar);
    } else if (personashogar.value === "") {
        let msg = "Debe ingresar el numero de personas en el hogar";
        AlertError(msg, personashogar);
    } else if (nmenores.value === "") {
        let msg = "Debe ingresar el numero de menores en el hogar";
        AlertError(msg, nmenores);
    } else if (nivelsisben.value === "0") {
        let msg = "Debe ingresar el nivel de sisben";
        AlertError(msg, nivelsisben);
    } else if (nnivelsisben.value === "0") {
        let msg = "Debe ingresar el numero del sisben";
        AlertError(msg, nivelsisben);
    } else if (cuidadormenor.value === "0") {
        let msg = "Debe ingresar la persona que cuida al menor";
        AlertError(msg, cuidadormenor);
    } else if (nacimiento.value === "0") {
        let msg = "Debe ingresar el nacimiento del menor";
        AlertError(msg, nacimiento);
    } else if (semana.value === "0") {
        let msg = "Debe ingresar el numero de semanas";
        AlertError(msg, semana);
    } else if (pesonacer.value === "") {
        let msg = "Debe ingresar el peso al nacer en gramos";
        AlertError(msg, pesonacer);
    } else if (tallanacer.value === "") {
        let msg = "Debe ingresar la talla en centimetros";
        AlertError(msg, tallanacer);
    } else if (!(lechesi.checked || lecheno.checked)) {
        let msg = "Debe ingresar si el menor consume leche materna";
        AlertError(msg, leche);
    } else if (exclusiva.value === "0") {
        let msg = "Debe ingresar la edad de lactancia";
        AlertError(msg, exclusiva);
    } else if (!(biberonsi.checked || biberonno.checked)) {
        let msg = "Debe ingresar si el menor utiliza biberon";
        AlertError(msg, biberon);
    } else if (!(crecimientosi.checked || crecimientono.checked || crecimientonosabe.checked)) {
        let msg = "Debe ingresar si esta en programa de crecimiento y desarrollo";
        AlertError(msg, crecimiento);
    } else if (!(vacunacionsi.checked || vacunacionno.checked || vacunacionnosabe.checked)) {
        let msg = "Debe ingresar el esquema de vacunación";
        AlertError(msg, vacunacion);
    } else if (!(ftlcsi.checked || ftlcno.checked || ftlcnosabe.checked)) {
        let msg = "Debe ingresar si recibe formula terapéutica";
        AlertError(msg, tflc);
    } else if (!(complementosi.checked || complementono.checked)) {
        let msg = "Debe ingresar un programa de apoyo nutricional";
        AlertError(msg, complemento);
    } else if (complementosi.checked && complementootro.value === "0") {
        let msg = "Debe seleccionar una opción";
        AlertError(msg, complemento);
    } else if (!(programasi.checked || programano.checked)) {
        let msg = "Debe ingresar un programa de apoyo nutricional";
        AlertError(msg, programa);
    } else if (programasi.checked && programaotro.value === "0") {
        let msg = "Debe seleccionar una opción en complemento";
        AlertError(msg, programaotro);

    } else if (!(abandonosi.checked || abandonono.checked || abandononosabe.checked)) {
        let msg = "Debe ingresar si hay negligencia o abandono";
        AlertError(msg, abandono);
    } else if (!(edasi.checked || edano.checked)) {
        let msg = "Debe ingresar si tiene EDA";
        AlertError(msg, eda);
    } else if (!(irasi.checked || irano.checked)) {
        let msg = "Debe ingresar si tiene IRA";
        AlertError(msg, ira);
    } else if (!(pediatriasi.checked || pediatriano.checked)) {
        let msg = "Debe ingresar valoracion por pediatria";
        AlertError(msg, pediatria);
    } else if (pediatriasi.checked & pediatriaatencion.value === "") {
        let msg = "Debe ingresar una fecha de valoracion";
        AlertError(msg, pediatriaatencion);
    } else if (!(nutricionsi.checked || nutricionno.checked || fechaatencionnutri.value === "")) {
        let msg = "Debe ingresar valoracion por nutricion";
        AlertError(msg, valornutri);
    } else if (signos.value === "0") {
        let msg = "Debe ingresar signos clinicos de desnutricion";
        AlertError(msg, signos);
    } else if (clasificacion.value === "0") {
        let msg = "Debe ingresar una clasificacion nutricional ";
        AlertError(msg, clasificacion);
    } else if (tallaedad.value === "0") {
        let msg = "Debe ingresar una talla para la edad";
        AlertError(msg, tallaedad);
    } else if (pesoedad.value === "0") {
        let msg = "Debe ingresar un peso para la edad";
        AlertError(msg, pesoedad)
    } else if (!(ducacionsi.checked || ducacionno.checked)) {
        let msg = "Debe ingresar si se realizo educacion alimentaria y nutricional";
        AlertError(msg, educacion);
    } else if (!(remitesi.checked || remiteno.checked)) {
        let msg = "Debe ingresar si se remite a servicio de salud";
        AlertError(msg, salud);
    } else if (observa.value === "0") {
        let msg = "Debe ingresar una observacion ";
        AlertError(msg, observa);
    } else {
        var url = "";
        if (tipo === 'u') {
            url = "datos/actualizar/updiec.php";
        } else {
            url = "../datos/registrar/addinvestigacion.php";
        }
        let form = 'formRegIEC';
        let table = 'tablePersonas';
        FetchData(url, form, table);
    }
}

function RegSeguimiento(tipo) {

    var fehcasivigila = document.getElementById("fecha_atencion");  
    var fechaseguimiento = document.getElementById("txtfechaseguimiento");    
    var pesoseguimiento = document.getElementById("txtpeso");
    var tallaseguimiento = document.getElementById("txtalla");
    var puntajez = document.getElementById("txtpuntaje");

    const decimalPattern = /^\d+(\.\d+)?$/;
    const decimalNegativePattern = /^-?\d+(\.\d+)?$/;


    ClearInvalid();
    if (fechaseguimiento.value === "") {
        let msg = "Debe ingresar una fecha de seguimientos";
        AlertError(msg, fechaseguimiento);
    } else if (!decimalPattern.test(pesoseguimiento.value)) {
        AlertError("Debe ingresar un peso de seguimiento válido (número con punto decimal Ejemplo: 12.5)", pesoseguimiento);
    } else if (!decimalPattern.test(tallaseguimiento.value)) {
        AlertError("Debe ingresar una talla de seguimiento válida (número con punto decimal)", tallaseguimiento);
    } else if (!decimalNegativePattern.test(puntajez.value)) {
        AlertError("Debe ingresar un puntaje z válido (número con punto decimal, positivo o negativo)", puntajez);
    } else {
        var url = "";
        if (tipo === 'u') {
            url = "datos/actualizar/updseguimiento.php";
        } else {
            url = "../datos/registrar/addseguimiento.php";
        }
        let form = 'formRegSeguimiento';
        let table = 'tableCargarSec';
        FetchData(url, form, table);
    }
}

function MostrarInpust(id) {
    const divamb = document.getElementById("divamb");
    const divoport = document.getElementById("divoport");
    const divadher = document.getElementById("divadher");
    const divtrata = document.getElementById("divtrata");
    const divmanejo = document.getElementById("divmanejo");
    const ambusi = document.getElementById('ambusi');
    const ambuno = document.getElementById('ambuno');
    const ftlcoportunasi = document.getElementById('ftlcoportunasi');
    const ftlcoportunano = document.getElementById('ftlcoportunano');
    const ftlcherenciasi = document.getElementById('ftlcherenciasi');
    const ftlcherenciano = document.getElementById('ftlcherenciano');
    const ftlccompletosi = document.getElementById('ftlccompletosi');
    const ftlccompletono = document.getElementById('ftlccompletono');
    const txthospitalariosi = document.getElementById('txthospitalariosi');
    const txthospitalariono = document.getElementById('txthospitalariono');
    if (id == 1) {
        divamb.classList.remove("d-none");
        divoport.classList.remove("d-none");
        ambusi.checked = false;
        ambuno.checked = false;
        ftlcoportunasi.checked = false;
        ftlcoportunano.checked = false;
        ftlcherenciasi.checked = false;
        ftlcherenciano.checked = false;
        ftlccompletosi.checked = false;
        ftlccompletono.checked = false;
        txthospitalariosi.checked = false;
        txthospitalariono.checked = false;
    } else {
        divamb.classList.add("d-none");
        divoport.classList.add("d-none");
        divadher.classList.add("d-none");
        divtrata.classList.add("d-none");
        divmanejo.classList.add("d-none");
    }
}

function MostrarInpust2(id) {
    const divadher = document.getElementById("divadher");
    const divtrata = document.getElementById("divtrata");
    const divmanejo = document.getElementById("divmanejo");
    const ftlcherenciasi = document.getElementById('ftlcherenciasi');
    const ftlcherenciano = document.getElementById('ftlcherenciano');
    const ftlccompletosi = document.getElementById('ftlccompletosi');
    const ftlccompletono = document.getElementById('ftlccompletono');
    const txthospitalariosi = document.getElementById('txthospitalariosi');
    const txthospitalariono = document.getElementById('txthospitalariono');
    if (id == 1) {
        divadher.classList.remove("d-none");
        divtrata.classList.remove("d-none");
        divmanejo.classList.remove("d-none");
        ftlcherenciasi.checked = false;
        ftlcherenciano.checked = false;
        ftlccompletosi.checked = false;
        ftlccompletono.checked = false;
        txthospitalariosi.checked = false;
        txthospitalariono.checked = false;
    } else {
        divadher.classList.add("d-none");
        divtrata.classList.add("d-none");
        divmanejo.classList.add("d-none");
    }
}



function MostrarOtro() {
    var otro = document.getElementById('programaotro');
    otro.classList.remove("d-none");
}
function OcultarOtro() {
    var otro = document.getElementById('programaotro');
    otro.classList.add("d-none");
}


function MostrarComplento() {
    var otros = document.getElementById('complementootro');
    otros.classList.remove("d-none");
}
function OcultarComplemento() {
    var otros = document.getElementById('complementootro');
    otros.classList.add("d-none");
}

function Mostrarfechapediatria() {
    var otros = document.getElementById('txfechaatencionpe');
    otros.classList.remove("d-none");
}
function Ocultarfechapediatria() {
    var otros = document.getElementById('txfechaatencionpe');
    otros.classList.add("d-none");
}

function Mostrarfechanutricion() {
    var otros = document.getElementById('fechaatencionnutri');
    otros.classList.remove("d-none");
}
function Ocultarfechanutricio() {
    var otros = document.getElementById('fechaatencionnutri');
    otros.classList.add("d-none");
}

function FormRegSec() {
    var id_paciente = document.getElementById('id_paciente');
    var id = "id=" + id_paciente.value;
    let tamaño = "modal-xl";
    let url = '../datos/formularios/regiseg.php';
    Formularios(tamaño, id, url);
}

function VerDetalle(id) {
    //var id_paciente = document.getElementById('id_paciente');
    var id = "id=" + id;
    let tamaño = "modal-xl";
    let url = '../datos/formularios/verdetalle.php';
    Formularios(tamaño, id, url);
}

function UpdateIec(id) {
    id = 'id=' + id;
    let tamaño = "modal-xl";
    let url = '../datos/formularios/updiec.php';
    Formularios(tamaño, id, url);
}

function Imprimir(nombre) {
    var ficha = document.getElementById(nombre);
    var ventimp = window.open(" ", "popimpr");
    ventimp.document.write(ficha.innerHTML);
    ventimp.document.close();
    ventimp.print();
    ventimp.close();
}
function ImprimirModal(id_iec) {
    var id = "id=" + id_iec;
    let tamaño = "modal-lg";
    let url = '../../informes/imp_iec.php';
    Formularios(tamaño, id, url);
}

function ImprimirModal2(id_person) {
    var id = "id=" + id_person;
    let tamaño = "modal-lg";
    let url = '../../informes/imp_personas.php';
    Formularios(tamaño, id, url);
}

function Exportar(nombre) {
    let xls = document.getElementById(nombre).innerHTML;

    // Codifica el contenido en base64
    var encoded = window.btoa(xls);

    // Crea un formulario dinámicamente y realiza un envío de formulario
    var form = document.createElement('form');
    form.action = '../../informes/exportar_excel.php';
    form.method = 'post';

    var input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'xls';
    input.value = encoded;

    form.appendChild(input);
    document.body.appendChild(form);

    form.submit();
}

function SeleccionMultiple() {
    const selectElement = document.querySelector('txtobserva');
    const selectedItems = Array.from(selectElement.selectedOptions).map(option => option.value);
    console.log(selectedItems);
}

function obtenerSemanaEpi(fecha) {
    Date.prototype.getWeek = function () {
        //var date = document.getElementById('txfechaatencion');
        var date = new Date(document.getElementById('txfechaatencion').value);
        // var date = new Date(this.getTime());
        var dateFirst = new Date(this.getFullYear(), 0, -1);
        var numDays = Math.floor((date - dateFirst) / (1000 * 60 * 60 * 24));
        var numWeeks = Math.floor(numDays / 7);
        var firstWeek = new Date(this.getFullYear(), 0, 1);
        var numDaysFromFirstWeek = Math.floor((firstWeek - dateFirst) / (1000 * 60 * 60 * 24));
        var numWeeksFromFirstWeek = Math.floor(numDaysFromFirstWeek / 7);
        if (numWeeks === 0 && numWeeksFromFirstWeek !== 0) {
            numWeeks++;
        }
        return numWeeks + 1;
    };

    var fecha = new Date();
    var semana = fecha.getWeek();
    var inputresultadoSemana = document.getElementById('inputresultadoSemana');
    inputresultadoSemana.value = semana;
    //console.log("Semana del año:", semana);
}


function obtenerNumeroSemana(fecha) {
Date.prototype.getWeek = function () {
    let fechaAuxiliar = new Date(document.getElementById('txfechaatencion').value);   //new Date(fecha.valueOf()); //fecha.valueOf();
    let numeroDia = (fecha.getDay() + 6) % 7;

    fechaAuxiliar.setDate(fechaAuxiliar.getDate() - numeroDia + 3);
    let primerJueves = fechaAuxiliar.valueOf();

    fechaAuxiliar.setMonth(0, 1);

    if (fechaAuxiliar.getDay() !== 5) {
        fechaAuxiliar.setMonth(0, 1 + ((5 - fechaAuxiliar.getDay()) + 7) % 7);
    }

    return 1 + Math.ceil((primerJueves - fechaAuxiliar) / 604800000);
};
    var fecha = new Date();
    var semana = fecha.getWeek();
    var inputresultadoSemana = document.getElementById('inputresultadoSemana');
    inputresultadoSemana.value = semana;
}

$(document).ready(function () {
    var setIdioma = {
        "decimal": "",
        "emptyTable": "No hay información",
        "infoPostFix": "",
        "thousands": ",",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": '<i class="fas fa-search fa-flip-horizontal" style="font-size:1.5rem; color:#2ECC71;"></i>',
        "zeroRecords": "No se encontraron registros",
        "paginate": {
            "first": "&#10096&#10096",
            "last": "&#10097&#10097",
            "next": "&#10097",
            "previous": "&#10096"
        }
    };

    var setdom = "<'row'<'col-md-6'l><'col-md-6'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>";

    // Cargar tabla con datos específicos de disponibilidad de FTLC y F74
    $('#tableDisponibilidad').DataTable({
        language: setIdioma,
        dom: setdom,
        "ajax": {
            url: '../eps/datos/listar/disponibilidad.php', // Actualiza con la ruta correspondiente
            type: 'POST',
            dataType: 'json',
        },
        "columns": [
            { 'data': 'id' },
            { 'data': 'disponibilidad_ftlc' },
            { 'data': 'disponibilidad_f74' },
            { 'data': 'profesionales_desnutricion' },
            { 'data': 'profesionales_patrones' },
            { 'data': 'fecha_entrega_farmacia' },
            { 'data': 'fecha_disponibilidad_formula' },
            { 'data': 'action' }
        ],
        "order": [
            [0, "asc"]
        ],
    });
});

