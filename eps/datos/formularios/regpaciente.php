<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: <?php echo $_SESSION["urlin"] ?>/index.php');
    exit;
}

include '../../../config/conexion.php';

try {
    $cmd = new PDO("$bd_driver:host=$bd_servidor;dbname=$bd_base;$charset", $bd_usuario, $bd_clave);
    $cmd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $sql = "SELECT
                `id_doc`
                , `descripcion`
            FROM
                `tipo_documento` order by descripcion asc";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $documentos = $sql->fetchAll();
    $cmd = null;
} catch (PDOException $e) {
    echo $e->getCode() == 2002 ? 'Sin Conexión a Mysql (Error: 2002)' : 'Error: ' . $e->getMessage();
}


try {
    $cmd = new PDO("$bd_driver:host=$bd_servidor;dbname=$bd_base;$charset", $bd_usuario, $bd_clave);
    $cmd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $sql = "SELECT
                `id_municipio`
                , `nombre_municipio`
            FROM
                `municipio` order by nombre_municipio asc";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $municipios = $sql->fetchAll();
    $cmd = null;
} catch (PDOException $e) {
    echo $e->getCode() == 2002 ? 'Sin Conexión a Mysql (Error: 2002)' : 'Error: ' . $e->getMessage();
}

try {
    $cmd = new PDO("$bd_driver:host=$bd_servidor;dbname=$bd_base;$charset", $bd_usuario, $bd_clave);
    $cmd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $sql = "SELECT
                `id_eps`
                , `razon_social`
            FROM
                `eps` order by razon_social asc";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $epes = $sql->fetchAll();
    $cmd = null;
} catch (PDOException $e) {
    echo $e->getCode() == 2002 ? 'Sin Conexión a Mysql (Error: 2002)' : 'Error: ' . $e->getMessage();
}

try {
    $cmd = new PDO("$bd_driver:host=$bd_servidor;dbname=$bd_base;$charset", $bd_usuario, $bd_clave);
    $cmd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $sql = "SELECT
                `id_tipo`
                , `descripcion`
            FROM
                `tipo_area` order by descripcion asc";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $areas = $sql->fetchAll();
    $cmd = null;
} catch (PDOException $e) {
    echo $e->getCode() == 2002 ? 'Sin Conexión a Mysql (Error: 2002)' : 'Error: ' . $e->getMessage();
}

try {
    $cmd = new PDO("$bd_driver:host=$bd_servidor;dbname=$bd_base;$charset", $bd_usuario, $bd_clave);
    $cmd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
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
            <h5 style="color: white;">REGISTRAR PACIENTE</h5>
        </div>
        <div class="px-2">
            <form id="formRegMarca">
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Tipo Documento</label>
                        <select class="form-control form-control-sm" id="txtipodoc" name="txtipodoc" required>
                            <option value="0">--Seleccione--</option>
                            <?php
                            foreach ($documentos as $key => $value) {
                                echo '<option value="' . $value['id_doc'] . '">' . $value['descripcion'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Numero Documento</label>
                        <input type="text" class="form-control form-control-sm" id="txnumero" name="txnumero" placeholder="Nombre de marca" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Primer Nombre</label>
                        <input type="text" class="form-control form-control-sm" id="txnombre1" name="txnombre1" placeholder="Nombre de marca" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Segundo Nombre</label>
                        <input type="text" class="form-control form-control-sm" id="txnombre2" name="txnombre2" placeholder="Nombre de marca" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Primer Apellido</label>
                        <input type="text" class="form-control form-control-sm" id="txapllido1" name="txapllido1" placeholder="Nombre de marca" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Segundo Apellido</label>
                        <input type="text" class="form-control form-control-sm" id="txapllido2" name="txapllido2" placeholder="Nombre de marca" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Fecha de Nacimiento</label>
                        <input type="date" class="form-control form-control-sm" id="dtfecnac" name="dtfecnac" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="genero">Sexo</label>
                        <div id="genero" class="form-control form-control-sm" style="display: flex; justify-content: center; align-items: center;">
                            <input type="radio" name="genero" id="masculino" value="1">
                            <label for="my-radio-1" class=" mb-0 mx-2">Masculino</label>
                            <input type="radio" name="genero" id="femenino" value="2">
                            <label for="my-radio-2" class=" mb-0 mx-2">Femenino</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Telefono</label>
                        <input type="text" class="form-control form-control-sm" id="txtelefono" name="txtelefono" placeholder="Nombre de marca" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Municipio</label>
                        <select class="form-control form-control-sm" id="txmunicipio" name="txmunicipio" required>
                            <option value="0">--Seleccione--</option>
                            <?php
                            foreach ($municipios as $mun) {
                                echo '<option value="' . $mun['id_municipio'] . '">' . $mun['nombre_municipio'] . '</option>';
                            }
                            ?>

                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Area de Residencia</label>
                        <select class="form-control form-control-sm" id="txarea" name="txarea" required>
                            <option value="0">--Seleccione--</option>
                            <?php
                            foreach ($areas as $key => $value) {
                                echo '<option value="' . $value['id_tipo'] . '">' . $value['descripcion'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Direccion</label>
                        <input type="text" class="form-control form-control-sm" id="txdireccion" name="txdireccion" placeholder="Nombre de marca" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="txtMarca">EPS</label>
                        <select class="form-control form-control-sm" id="txteps" name="txteps" required>
                            <option value="0">--Seleccione--</option>
                            <?php
                            foreach ($epes as $key => $value) {
                                echo '<option value="' . $value['id_eps'] . '">' . $value['razon_social'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Regimen</label>
                        <select class="form-control form-control-sm" id="txtregimen" name="txtregimen" required>
                            <option value="0">--Seleccione--</option>
                            <?php
                            foreach ($regimen as $key => $value) {
                                echo '<option value="' . $value['id_reg'] . '">' . $value['descripcion'] . '</option>';
                            }
                            ?>
                        </select>

                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Fecha de Atención </label>
                        <input type="date" class="form-control form-control-sm" id="txfechaatencion" name="txfechaatencion"  onchange="obtenerNumeroSemana()"> 

                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Semana Epidemiologica </label>                          
                        <input type="text" class="form-control form-control-sm" id="inputresultadoSemana" name="inputresultadoSemana"  readonly>        
                    </div>                    
                </div>
            </form>
        </div>
    </div>
    <div class="text-center pt-3">
        <button type="button" class="btn btn-primary btn-sm" onclick="RegPaciente('r')">Registrar</button>
        <a type="button" class="btn btn-secondary  btn-sm" data-bs-dismiss="modal">Cancelar</a>
    </div>
</div>