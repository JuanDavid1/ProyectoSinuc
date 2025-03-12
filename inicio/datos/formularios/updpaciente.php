<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: <?php echo $_SESSION["urlin"] ?>/index.php');
    exit;
}

include '../../../config/conexion.php';
$id = isset($_POST["id"]) ? $_POST["id"] : exit('ACCESO DENEGADO!');

try {
    $cmd = new PDO("$bd_driver:host=$bd_servidor;dbname=$bd_base;$charset", $bd_usuario, $bd_clave);
    $cmd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $sql = "SELECT
                `tipo_identificacion_id`, `regimen_id`, `eps_id`, `tipo_area_residencial_id`, `barrio_id`, `grupo_etnico_id`, `identificacion`
                , `nombre1`, `nombre2`, `apellido1`, `apellido2`, `fecha_nacimiento`, `direccion`, `telefono`, `genero`, `estado`, `municipio_id`
                , `fecha_atencion`, `id_user_reg`, `fecha_reg` , `fecha_epi`
            FROM `personas` WHERE id = $id";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $paciente = $sql->fetch(PDO::FETCH_ASSOC);
    $sql = "SELECT
                `id_doc`
                , `descripcion`
            FROM
                `tipo_documento` order by descripcion asc";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $documentos = $sql->fetchAll();
    $sql = "SELECT
                `id_municipio`
                , `nombre_municipio`
            FROM
                `municipio` order by nombre_municipio asc";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $municipios = $sql->fetchAll();
    $sql = "SELECT
                `id_eps`
                , `razon_social`
            FROM
                `eps` order by razon_social asc";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $epes = $sql->fetchAll();
    $sql = "SELECT
                `id_tipo`
                , `descripcion`
            FROM
                `tipo_area` order by descripcion asc";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $areas = $sql->fetchAll();
    $sql = "SELECT
                `id_reg`
                , `descripcion`
            FROM
                `regimen` order by descripcion asc";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $regimen = $sql->fetchAll();
    $cmd = null;
} catch (PDOException $e) {
    echo $e->getCode() == 2002 ? 'Sin Conexión a Mysql (Error: 2002)' : 'Error: ' . $e->getMessage();
}

?>

<div class="px-0">
    <div class="shadow">
        <div class="card-header mb-3" style="background-color: #16a085 !important;">
            <h5 style="color: white;">ACTUALIZAR PACIENTE</h5>
        </div>
        <div class="px-2">
            <form id="formRegMarca">
                <input type="hidden" id="id" name="id" value="<?php echo $id ?>">
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Tipo Documento</label>
                        <select class="form-control form-control-sm" id="txtipodoc" name="txtipodoc" required>
                            <?php
                            foreach ($documentos as $key => $value) {
                                $selected = $paciente['tipo_identificacion_id'] == $value['id_doc'] ? 'selected' : '';
                                echo '<option value="' . $value['id_doc'] . '" ' . $selected . '>' . $value['descripcion'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Numero Documento</label>
                        <input type="text" class="form-control form-control-sm" id="txnumero" name="txnumero" placeholder="Nombre de marca" value="<?php echo $paciente['identificacion'] ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Primer Nombre</label>
                        <input type="text" class="form-control form-control-sm" id="txnombre1" name="txnombre1" value="<?php echo $paciente['nombre1'] ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Segundo Nombre</label>
                        <input type="text" class="form-control form-control-sm" id="txnombre2" name="txnombre2" value="<?php echo $paciente['nombre2'] ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Primer Apellido</label>
                        <input type="text" class="form-control form-control-sm" id="txapllido1" name="txapllido1" value="<?php echo $paciente['apellido1'] ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Segundo Apellido</label>
                        <input type="text" class="form-control form-control-sm" id="txapllido2" name="txapllido2" value="<?php echo $paciente['apellido2'] ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Fecha de Nacimiento</label>
                        <input type="date" class="form-control form-control-sm" id="dtfecnac" name="dtfecnac" value="<?php echo $paciente['fecha_nacimiento'] ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="genero">Sexo</label>
                        <div id="genero" class="form-control form-control-sm" style="display: flex; justify-content: center; align-items: center;">
                            <input type="radio" name="genero" id="masculino" value="1" <?php echo $paciente["genero"]  ==  1 ? "checked" : '' ?>>
                            <label for="my-radio-1" class=" mb-0 mx-2">Masculino</label>
                            <input type="radio" name="genero" id="femenino" value="2" <?php echo $paciente["genero"]  ==  2 ? "checked" : '' ?>>
                            <label for="my-radio-2" class=" mb-0 mx-2">Femenino</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Telefono</label>
                        <input type="text" class="form-control form-control-sm" id="txtelefono" name="txtelefono" value="<?php echo $paciente['telefono'] ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Municipio</label>
                        <select class="form-control form-control-sm" id="txmunicipio" name="txmunicipio" required>
                            <?php
                            foreach ($municipios as $mun) {
                                $selected = ($paciente['municipio_id'] == $mun['id_municipio']) ? 'selected' : '';
                                echo '<option value="' . $mun['id_municipio'] . '" ' . $selected . '>' . $mun['nombre_municipio'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="txtMarca">Area de Residencia</label>
                        <select class="form-control form-control-sm" id="txarea" name="txarea" required>
                            <?php
                            foreach ($areas as $key => $value) {
                                $selected = $paciente['tipo_area_residencial_id'] == $value['id_tipo'] ? 'selected' : '';
                                echo '<option value="' . $value['id_tipo'] . '" '.$selected . '>' . $value['descripcion'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Direccion</label>
                        <input type="text" class="form-control form-control-sm" id="txdireccion" name="txdireccion" value="<?php echo $paciente['direccion'] ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="txtMarca">EPS</label>
                        <select class="form-control form-control-sm" id="txteps" name="txteps" required>
                            <?php
                            foreach ($epes as $key => $value) {
                                $selected = $paciente['eps_id'] == $value['id_eps'] ? 'selected' : '';
                                echo '<option value="' . $value['id_eps'] . '" '.$selected. '>' . $value['razon_social'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Regimen</label>
                        <select class="form-control form-control-sm" id="txtregimen" name="txtregimen" required>
                            <?php
                            foreach ($regimen as $key => $value) {
                                $selected = $paciente['regimen_id'] == $value['id_reg'] ? 'selected' : '';
                                echo '<option value="' . $value['id_reg'] . '" '.$selected.'>' . $value['descripcion'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Fecha de Atención </label>
                        <input type="date" class="form-control form-control-sm" id="txfechaatencion" name="txfechaatencion" value="<?php echo $paciente['fecha_atencion'] ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Semana Epidemiologica</label>
                        <input type="text" class="form-control form-control-sm" id="inputresultadoSemana" name="inputresultadoSemana" value="<?php echo $paciente['fecha_epi'] ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="estado">Estado</label>
                        <div id="estado" class="form-control form-control-sm" style="display: flex; justify-content: center; align-items: center;">
                            <input type="radio" name="estado" id="recuperado" value="2" <?php echo $paciente["estado"]  ==  2 ? "checked" : '' ?>>
                            <label for="my-radio-1" class=" mb-0 mx-2"><span class="badge rounded-pill bg-success">RECUPERADO</span></label>
                            <input type="radio" name="estado" id="desnutrido" value="1" <?php echo $paciente["estado"]  ==  1 ? "checked" : '' ?>>
                            <label for="my-radio-2" class=" mb-0 mx-2"><span class="badge rounded-pill bg-danger">DESNUTRICION</span></label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="text-center pt-3">
        <button type="button" class="btn btn-primary btn-sm" onclick="RegPaciente('u')">Actualizar</button>
        <a type="button" class="btn btn-secondary  btn-sm" data-bs-dismiss="modal">Cancelar</a>
    </div>
</div>