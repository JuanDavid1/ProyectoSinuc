<?php 
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ' . $_SESSION['urlin'] . '/index.php');
    exit;
}

include '../../../config/conexion.php';
$id_paciente = $_POST['id'];
$id_usuario = $_SESSION['id_user'];
 
try {
    $cmd = new PDO("$bd_driver:host=$bd_servidor;dbname=$bd_base;$charset", $bd_usuario, $bd_clave);
    $cmd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $sql = "SELECT
                `idusuario`
                , CONCAT_WS(' ', IFNULL(`nombre1`,'')
                ,  IFNULL(`nombre2`,'')
                ,  IFNULL(`apellido1`,'')
                ,  IFNULL(`apellido2`,'')) AS nombre 
            FROM
                `usuarios`
            WHERE (`idusuario` = ?)";
    $sql = $cmd->prepare($sql);
    $sql->bindParam(1, $user);
    $sql->execute();
    $resultado = $sql->fetch();
    $user = !empty($resultado) ? mb_strtoupper($resultado['nombre']) : '';
    $anio = date('Y');
} catch (PDOException $e) {
    echo  $e->getCode() == 2002 ? 'Sin Conexión a Mysql (Error: 2002)' : 'Error: ' . $e->getMessage();
}

$user = $_SESSION['id_user'];

try {
    $cmd = new PDO("$bd_driver:host=$bd_servidor;dbname=$bd_base;$charset", $bd_usuario, $bd_clave);
    $cmd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $sql = "SELECT
                `usuarios`.`idusuario`
                , `empresas`.`razonsocial`
            FROM
                `usuarios`
                INNER JOIN `empresas` 
                    ON (`usuarios`.`idempresa` = `empresas`.`idempresa`)
            WHERE (`usuarios`.`idusuario` = ?)";
    $sql = $cmd->prepare($sql);
    $sql->bindParam(1, $user);
    $sql->execute();
    $resultado = $sql->fetch();
    $s = !empty($resultado) ? mb_strtoupper($resultado['razonsocial']) : '';
} catch (PDOException $e) {
    $res['msg'] = $e->getCode() == 2002 ? 'Sin Conexión a Mysql (Error: 2002)' : 'Error: ' . $e->getMessage();
}

try {
    $cmd = new PDO("$bd_driver:host=$bd_servidor;dbname=$bd_base;$charset", $bd_usuario, $bd_clave);
    $cmd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $sql = "SELECT `id_doc`, `descripcion` FROM `tipo_seguimiento`";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $tipos = $sql->fetchAll();      
    $sql = "SELECT
                `estado`
            FROM `personas` WHERE id = $id_paciente";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $estado_persona = $sql->fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT
                `personas`.`id`
                , `personas`.`nombre1`
                , `personas`.`nombre2`
                , `personas`.`apellido1`
                , `personas`.`apellido2`
                , `personas`.`fecha_nacimiento`
                , `tipo_documento`.`descripcion`
                , `personas`.`telefono`
                , `personas`.`fecha_atencion`
            FROM
                `personas`
                INNER JOIN `tipo_documento` 
                    ON (`personas`.`tipo_identificacion_id` = `tipo_documento`.`id_doc`)
            WHERE (`personas`.`id` = $id_paciente)";
    // echo $sql; imprimir la consulta
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $persona = $sql->fetch();
    $sql = "SELECT
                `id_exclusiva`
                , `nombre`
            FROM
                `exclusiva` order by nombre asc ";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $exclusiva = $sql->fetchAll();
    $cmd = null;
} catch (PDOException $e) {
    echo $e->getCode() == 2002 ? 'Sin Conexión a Mysql (Error: 2002)' : 'Error: ' . $e->getMessage();
}
 
?>
<?php echo $s   ?>
<div class="px-0">
    <div class="shadow">
        <div class="card-header mb-3" style="background-color: #16a085 !important;">
            <h5 style="color: white;">REGISTRAR SEGUIMIENTO</h5>
        </div>
        <div class="px-2">
            <form id="formRegSeguimiento">
            <input type="hidden" value="<?php echo $_POST['id'] ?>" name="id_paciente">  
            <input type="hidden" value="<?php echo $s ?>" name="upgd">              
                <div class="row">
                <div class="form-group col-md-3">                    
                        <label for="txtMarca">Primer Nombre</label>
                        <div class="form-control form-control-sm"><?php echo $persona['nombre1'] ?></div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Segundo Nombre</label>
                        <div class="form-control form-control-sm"> <?php echo $persona['nombre2'] ?></div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Primer Apellido</label>
                        <div class="form-control form-control-sm"> <?php echo $persona['apellido1'] ?></div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Segundo Apellido</label>
                        <div class="form-control form-control-sm"> <?php echo $persona['apellido2'] ?></div>
                    </div>
                </div>
                <div class="form-group col-md-3">
                        <label for="estado">Estado</label>
                        <div id="estado" class="form-control form-control-sm" style="display: flex; justify-content: center; align-items: center;">
                            <input type="radio" name="estado" id="recuperado" value="2" <?php echo $estado_persona["estado"]  ==  2 ? "checked" : '' ?>>
                            <label for="my-radio-1" class=" mb-0 mx-2"><span class="badge rounded-pill bg-success">RECUPERADO</span></label>
                            <input type="radio" name="estado" id="desnutrido" value="1" <?php echo $estado_persona["estado"]  ==  1 ? "checked" : '' ?>>
                            <label for="my-radio-2" class=" mb-0 mx-2"><span class="badge rounded-pill bg-danger">DESNUTRICION</span></label>
                        </div>
                    </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Telefono</label>
                        <div class="form-control form-control-sm"> <?php echo $persona['telefono'] ?></div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Fecha de nacimiento</label>
                        <div class="form-control form-control-sm"> <?php echo $persona['fecha_nacimiento'] ?></div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Fecha reporte al SIVIGILA</label>
                        
                            <input type="date" class="form-control form-control-sm" name="fecha_atencion" readonly value="<?php echo htmlspecialchars($persona['fecha_atencion']); ?>">
                        
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Fecha Seguimiento</label>
                        <input type="date" class="form-control form-control-sm" id="txtfechaseguimiento" name="txtfechaseguimiento" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Peso (kg)</label>
                        <input type="text" class="form-control form-control-sm" id="txtpeso" name="txtpeso" placeholder="Peso en Kilogramos" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Talla (cm)</label>
                        <input type="text" class="form-control form-control-sm" id="txtalla" name="txtalla" placeholder="Talla en centimetros" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Puntaje Z</label>
                        <input type="text" class="form-control form-control-sm" id="txtpuntaje" name="txtpuntaje" placeholder="SISVAN" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtFTLC"> Gestion FTLC EPS</label>
                                <div id="txtfltc" class="form-control form-control-sm" style="display: flex; justify-content: center; align-items: center;">
                                    <input type="radio" name="txtftlc" id="ftlcsi" value="1" onclick="MostrarInpust(1)">
                                    <label for="my-radio-1" class=" mb-0 mx-2">Si</label>
                                    <input type="radio" name="txtftlc" id="ftlcno" value="2" onclick="MostrarInpust(2)">
                                    <label for="my-radio-2" class=" mb-0 mx-2">No</label>
                                </div>
                    </div>
                    <div class="form-group col-md-3 d-none" id="divamb">
                        <label for="txtambu">Manejo ambulatorio</label>
                                <div id="txtambu" class="form-control form-control-sm" style="display: flex; justify-content: center; align-items: center;">
                                    <input type="radio" name="txtambu" id="ambusi" value="1">
                                    <label for="ambusi" class=" mb-0 mx-2">Si</label>
                                    <input type="radio" name="txtambu" id="ambuno" value="2">
                                    <label for="ambuno" class=" mb-0 mx-2">No</label>
                                </div>
                    </div>                    
                    <div class="form-group col-md-3 d-none" id="divoport">
                        <label for="txtOportunidad"> FTLC Oportunamente</label>
                                <div id="txtoportuna" class="form-control form-control-sm" style="display: flex; justify-content: center; align-items: center;">
                                    <input type="radio" name="txtftlcoportuna" id="ftlcoportunasi" value="1" onclick="MostrarInpust2(1)">
                                    <label for="my-radio-1" class=" mb-0 mx-2">Si</label>
                                    <input type="radio" name="txtftlcoportuna" id="ftlcoportunano" value="2" onclick="MostrarInpust2(2)">
                                    <label for="my-radio-2" class=" mb-0 mx-2">No</label>
                                </div>
                    </div>    
                    <div class="form-group col-md-3 d-none" id="divadher">
                        <label for="txtherencia"> Adherencia a la FTLC</label>
                                <div id="txtherencia" class="form-control form-control-sm" style="display: flex; justify-content: center; align-items: center;">
                                    <input type="radio" name="txtftlcadherencia" id="ftlcherenciasi" value="1">
                                    <label for="my-radio-1" class=" mb-0 mx-2">Si</label>
                                    <input type="radio" name="txtftlcadherencia" id="ftlcherenciano" value="2">
                                    <label for="my-radio-2" class=" mb-0 mx-2">No</label>
                                </div>
                    </div>
                    <div class="form-group col-md-3 d-none" id="divtrata">
                        <label for="txtCompleto"> Completo Tratamiento</label>
                                <div id="txtcompleto" class="form-control form-control-sm" style="display: flex; justify-content: center; align-items: center;">
                                    <input type="radio" name="txtftlccompleto" id="ftlccompletosi" value="1">
                                    <label for="my-radio-1" class=" mb-0 mx-2">Si</label>
                                    <input type="radio" name="txtftlccompleto" id="ftlccompletono" value="2">
                                    <label for="my-radio-2" class=" mb-0 mx-2">No</label>
                                </div>
                    </div>
                    <div class="form-group col-md-3 d-none" id="divmanejo">
                        <label for="txtintrahospital"> Manejo intrahospitalario</label>
                                <div id="txtintra" class="form-control form-control-sm" style="display: flex; justify-content: center; align-items: center;">
                                    <input type="radio" name="txthospitalario" id="txthospitalariosi" value="1">
                                    <label for="my-radio-1" class=" mb-0 mx-2">Si</label>
                                    <input type="radio" name="txthospitalario" id="txthospitalariono" value="2">
                                    <label for="my-radio-2" class=" mb-0 mx-2">No</label>
                                </div>
                    </div>                
                </div>
            </form>
        </div>
    </div>
    <div class="text-center pt-3">
        <button type="button" class="btn btn-primary btn-sm" onclick="RegSeguimiento('r')">Registrar</button>
        <a type="button" class="btn btn-secondary  btn-sm" data-bs-dismiss="modal">Cancelar</a>
    </div>
</div>
<! /*aqui termina el formulario */!>