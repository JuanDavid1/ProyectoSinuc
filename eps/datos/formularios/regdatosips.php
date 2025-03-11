<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: <?php echo $_SESSION["urlin"] ?>/index.php');
    exit;
}

include '../../../config/conexion.php';
include '../../../config/permisos.php';
?>


<div class="px-0">
    <div class="shadow">
        <div class="card-header mb-3" style="background-color: #16a085 !important;">
            <h5 style="color: white;">REGISTRAR DATOS DE LA EPS</h5>
        </div>
        <div class="px-2">
            <form id="formRegMarca">
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Profesionales capacitados en resolución 2350 desnutrición aguda</label>
                        <input type="text" class="form-control form-control-sm" id="txnumerodes" name="txnumerodes" placeholder="Numero de profesionales" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Profesionales capacitados en patrones antropometrico</label>
                        <input type="text" class="form-control form-control-sm" id="txnumeropatron" name="txnumeropatron" placeholder="Numero de profesionales" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Profesionales en atención a menores de 5 años</label>
                        <input type="text" class="form-control form-control-sm" id="txnumeropatron" name="txnumeropatron" placeholder="Numero de profesionales" required>
                    </div>
                </div>                
                <div class="row">
                <div class="form-group col-md-3">
                        <label for="txtformula">Disponibilidad de formula FTLC</label>
                                    <div id="txtambu" class="form-control form-control-sm" style="display: flex; justify-content: center; align-items: center;">
                                        <input type="radio" name="txtaftlc" id="ftlcsi" value="1">
                                        <label for="ftlcsi" class=" mb-0 mx-2">Si</label>
                                        <input type="radio" name="txtaftlc" id="ftlcno" value="2">
                                        <label for="ftlcno" class=" mb-0 mx-2">No</label>
                                    </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtformula">Disponibilidad de formula F75</label>
                                    <div id="txtambu" class="form-control form-control-sm" style="display: flex; justify-content: center; align-items: center;">
                                        <input type="radio" name="txtf75" id="f75si" value="1">
                                        <label for="f75si" class=" mb-0 mx-2">Si</label>
                                        <input type="radio" name="txtf75" id="f75no" value="2">
                                        <label for="f75no" class=" mb-0 mx-2">No</label>
                                    </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Fecha de Entrega de Farmacia</label>
                        <input type="date" class="form-control form-control-sm" id="txfechafarmacia" name="txfechafarmacia" required>                        
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Fecha de Disponibilidad de Formula</label>
                        <input type="date" class="form-control form-control-sm" id="txfechaformula" name="txfechaformula" required>
                    </div>                    
            </form>
        </div>
    </div>
    <div class="text-center pt-3">
        <button type="button" class="btn btn-primary btn-sm" onclick="RegDatosIps('r')">Registrar</button>
        <a type="button" class="btn btn-secondary  btn-sm" data-bs-dismiss="modal">Cancelar</a>
    </div>
</div>