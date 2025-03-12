document.getElementById("btnEntrarLogin").onclick = validarLogin;

function validarLogin() {
    var usuario = document.getElementById("usuario").value;
    var clave = document.getElementById("clave").value;
    var isVisible = "show";    
    if (usuario == "") {
        var myModal = new bootstrap.Modal(document.getElementById("divModalError"), {});
        document.getElementById("divMsgError").innerHTML = "Debe ingresar usuario";
        myModal.show();
        return false;
    } else if (clave == "") {
        var myModal = new bootstrap.Modal(document.getElementById("divModalError"), {});
        document.getElementById("divMsgError").innerHTML = "Debe ingresar clave";
        myModal.show();
        return false;
    } else {
        var url = 'config/login.php';
        let user = document.getElementById("usuario").value;
        const data = new FormData();
        data.append('usuario', user);
        data.append('password', clave);
        fetch(url, {
            method: 'POST',
            body: data,
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
                    window.location.href = "inicio/panel_control.php";
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
    }
    return true;
}