<?php
include '../../../config/conexion.php';
$id_seguimiento = $_POST['id'];

try {
    $cmd = new PDO("$bd_driver:host=$bd_servidor;dbname=$bd_base;$charset", $bd_usuario, $bd_clave);
    $cmd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $sql = "SELECT `id_doc`, `descripcion` FROM `tipo_seguimiento`";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $tipos = $sql->fetchAll();
    $sql = "SELECT
                `id_nivel`
                , `descripcion`
            FROM
                `educativo` order by descripcion asc";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $educativos = $sql->fetchAll();
    $sql = "SELECT
                `id_familia`
                , `descripcion`
            FROM
                `familia` order by descripcion asc";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $familiar = $sql->fetchAll();
    $sql = "SELECT
                `categoria_id`
                , `nombre`
            FROM
                `categoria` order by nombre asc";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $categorias = $sql->fetchAll();
    $sql = "SELECT
                `id`
                , `nombre`
            FROM
                `cuidador` order by nombre asc";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $cuidador = $sql->fetchAll();
    $sql = "SELECT
                `id_clasi`
                , `nombre`
            FROM
                `clasificacion` order by nombre asc";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $clasificacion = $sql->fetchAll();
    $sql = "SELECT
                `id_talla`
                , `nombre`
            FROM
                `talla` order by nombre asc";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $tallaedad = $sql->fetchAll();
    $sql = "SELECT
                `id_peso`
                , `nombre`
            FROM
                `peso` ";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $pesoedad = $sql->fetchAll();
    $sql = "SELECT
                `id_observa`
                , `nombre`
            FROM
                `observaciones` ";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $observa = $sql->fetchAll();
    $sql = "SELECT
                `id_comple`
                , `nombre`
            FROM
                `complemento` order by nombre asc ";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $complemento = $sql->fetchAll();
    $sql = "SELECT
            `id_progra`
            , `nombre`
            FROM
                `programa` order by nombre asc ";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $programa = $sql->fetchAll();
    $sql = "SELECT
                    `id_signo`
                    , `nombre`
                FROM
                    `signos` order by nombre asc ";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $signo = $sql->fetchAll();
    $sql = "SELECT
                `id_nacimiento`
                , `nombre`
            FROM
                `nacimiento` order by nombre asc ";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $nacimiento = $sql->fetchAll();
    $sql = "SELECT
                `id_semana`
                , `nombre`
            FROM
                `semanas`";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $semana = $sql->fetchAll();
    
    $sql = "SELECT
                `id_exclusiva`
                , `nombre`
            FROM
                `exclusiva` order by nombre asc ";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $exclusiva = $sql->fetchAll();
    

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
                , `id_seguimeinto`
                , `id_paciente`
                , `fehcasivigila`
                , `fechaseguimiento`
                , `pesoseguimiento`
                , `tallaseguimiento`
                , `puntajez`
                , `ftlc`
                , `ambulatorio`
                , `opotuna`
                , `adherencia`
                , `completo`
                , `hospitalario`
                , `upgd`
            FROM
                `seguimiento`
                inner join `personas` 
                    on (`seguimiento`.`id_paciente` = `personas`.`id`)
                INNER JOIN `tipo_documento` 
                    ON (`personas`.`tipo_identificacion_id` = `tipo_documento`.`id_doc`)
            WHERE (`id_seguimeinto` = $id_seguimiento)";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $seguimiento = $sql->fetch();
    $cmd = null;

    if ($seguimiento['ftlc'] == 1) {
        $ftlc1 = 'checked';
        $ftlc2 = '';
    } else if ($seguimiento['ftlc'] == 2) {
        $ftlc2 = 'checked'; 
        $ftlc1 = '';
    }
    else if ($seguimiento['ftlc'] == '') {
            $ftlc1 = '';
            $ftlc2 = '';
    }

    if ($seguimiento['ambulatorio'] == 1) {
        $ambu1 = 'checked';
        $ambu2 = '';
    } else if ($seguimiento['ambulatorio'] == 2) {
        $ambu2 = 'checked'; 
        $ambu1 = '';
    }
    else if ($seguimiento['ambulatorio'] == '') {
            $ambu1 = '';
            $ambu2 = '';
    }

    if ($seguimiento['opotuna'] == 1) {
        $opotuna1 = 'checked';
        $opotuna2 = '';
    } else if ($seguimiento['opotuna'] == 2) {
        $opotuna2 = 'checked'; 
        $opotuna1 = '';
    }
    else if ($seguimiento['opotuna'] == '') {
            $opotuna1 = '';
            $opotuna2 = '';
    }

    if ($seguimiento['adherencia'] == 1) {
        $adherencia1 = 'checked';
        $adherencia2 = '';
    } else if ($seguimiento['adherencia'] == 2) {
        $adherencia2 = 'checked'; 
        $adherencia1 = '';
    }
    else if ($seguimiento['adherencia'] == '') {
            $adherencia1 = '';
            $adherencia2 = '';
    }

    if ($seguimiento['completo'] == 1) {
        $completo1 = 'checked';
        $completo2 = '';
    } else if ($seguimiento['completo'] == 2) {
        $completo2 = 'checked'; 
        $completo1 = '';
    }
    else if ($seguimiento['completo'] == '') {
            $completo1 = '';
            $completo2 = '';
    }

    if ($seguimiento['hospitalario'] == 1) {
        $hospitalario1 = 'checked';
        $hospitalario2 = '';
    } else if ($seguimiento['hospitalario'] == 2) {
        $hospitalario2 = 'checked'; 
        $hospitalario1 = '';
    }
    else if ($seguimiento['hospitalario'] == '') {
            $hospitalario1 = '';
            $hospitalario2 = '';
    }
  
    
} catch (PDOException $e) {
    echo $e->getCode() == 2002 ? 'Sin Conexión a Mysql (Error: 2002)' : 'Error: ' . $e->getMessage();
}

?>

<div class="px-0">
    <div class="shadow">
        <div class="card-header mb-3" style="background-color: #16a085 !important;">
            <h5 style="color: white;">VER SEGUIMIENTO</h5>
        </div>
        <div class="px-2">
            <form id="formRegSeguimiento">
            <input type="hidden" value="<?php echo $_POST['id'] ?>" name="id_paciente">                
                <div class="row">
                <div class="form-group col-md-3">
                        <label for="txtMarca">Primer Nombre</label>
                        <div class="form-control form-control-sm"><?php echo $seguimiento['nombre1'] ?></div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Segundo Nombre</label>
                        <div class="form-control form-control-sm"> <?php echo $seguimiento['nombre2'] ?></div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Primer Apellido</label>
                        <div class="form-control form-control-sm"> <?php echo $seguimiento['apellido1'] ?></div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Segundo Apellido</label>
                        <div class="form-control form-control-sm"> <?php echo $seguimiento['apellido2'] ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Telefono</label>
                        <div class="form-control form-control-sm"> <?php echo $seguimiento['telefono'] ?></div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Fecha de nacimiento</label>
                        <div class="form-control form-control-sm"> <?php echo $seguimiento['fecha_nacimiento'] ?></div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Fecha reporte al SIVIGILA</label>
                        
                            <input type="date" class="form-control form-control-sm" name="fecha_atencion" readonly value="<?php echo htmlspecialchars($seguimiento['fecha_atencion']); ?>">
                        
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Fecha Seguimiento</label>
                        <div class="form-control form-control-sm"> <?php echo $seguimiento['fechaseguimiento'] ?></div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Peso (kg)</label>
                        <div class="form-control form-control-sm"> <?php echo $seguimiento['pesoseguimiento'] ?></div>                        
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Talla (cm)</label>
                        <div class="form-control form-control-sm"> <?php echo $seguimiento['tallaseguimiento'] ?></div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Puntaje Z</label>
                        <div class="form-control form-control-sm"> <?php echo $seguimiento['puntajez'] ?></div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="txtFTLC"> Gestion FTLC EPS</label>
                                <div id="txtfltc" class="form-control form-control-sm" style="display: flex; justify-content: center; align-items: center;">
                                    <input type="radio" name="txtftlc" id="ftlcsi" value="1"  <?= $ftlc1 ?> disabled>
                                    <label for="my-radio-1" class=" mb-0 mx-2">Si</label>
                                    <input type="radio" name="txtftlc" id="ftlcno" value="2"  <?= $ftlc2 ?> disabled>
                                    <label for="my-radio-2" class=" mb-0 mx-2">No</label>
                                </div>
                    </div>
                    <div class="form-group col-md-3"$seguimiento>
                        <label for="txtambu">Manejo ambulatorio</label>
                                <div id="txtambu" class="form-control form-control-sm" style="display: flex; justify-content: center; align-items: center;">
                                    <input type="radio" name="txtambu" id="ambusi" value="1" <?= $ambu1 ?> disabled >
                                    <label for="ambusi" class=" mb-0 mx-2">Si</label>       
                                    <input type="radio" name="txtambu" id="ambuno" value="2" <?= $ambu2 ?> disabled>
                                    <label for="ambuno" class=" mb-0 mx-2">No</label>
                                </div>
                    </div>                    
                    <div class="form-group col-md-3"$seguimiento>
                        <label for="txtOportunidad"> FTLC Oportunamente</label>
                                <div id="txtoportuna" class="form-control form-control-sm" style="display: flex; justify-content: center; align-items: center;">
                                    <input type="radio" name="txtftlcoportuna" id="ftlcoportunasi" value="1" <?= $opotuna1 ?> disabled>
                                    <label for="my-radio-1" class=" mb-0 mx-2">Si</label>
                                    <input type="radio" name="txtftlcoportuna" id="ftlcoportunano" value="2" <?= $opotuna2 ?> disabled>
                                    <label for="my-radio-2" class=" mb-0 mx-2">No</label>
                                </div>
                    </div>    
                    <div class="form-group col-md-3"$seguimiento>
                        <label for="txtherencia"> Adherencia a la FTLC</label>
                                <div id="txtherencia" class="form-control form-control-sm" style="display: flex; justify-content: center; align-items: center;">
                                    <input type="radio" name="txtftlcadherencia" id="ftlcherenciasi" value="1" <?= $adherencia1 ?> disabled>
                                    <label for="my-radio-1" class=" mb-0 mx-2">Si</label>
                                    <input type="radio" name="txtftlcadherencia" id="ftlcherenciano" value="2" <?= $adherencia2 ?> disabled>
                                    <label for="my-radio-2" class=" mb-0 mx-2">No</label>
                                </div>
                    </div>
                    <div class="form-group col-md-3"$seguimiento>
                        <label for="txtCompleto"> Completo Tratamiento</label>
                                <div id="txtcompleto" class="form-control form-control-sm" style="display: flex; justify-content: center; align-items: center;">
                                    <input type="radio" name="txtftlccompleto" id="ftlccompletosi" value="1" <?= $completo1 ?> disabled>
                                    <label for="my-radio-1" class=" mb-0 mx-2">Si</label>
                                    <input type="radio" name="txtftlccompleto" id="ftlccompletono" value="2" <?= $completo2 ?> disabled>
                                    <label for="my-radio-2" class=" mb-0 mx-2">No</label>
                                </div>
                    </div>
                    <div class="form-group col-md-3"$seguimiento>
                        <label for="txtintrahospital"> Manejo intrahospitalario</label>
                                <div id="txtintra" class="form-control form-control-sm" style="display: flex; justify-content: center; align-items: center;">
                                    <input type="radio" name="txthospitalario" id="txthospitalariosi" value="1" <?= $hospitalario1 ?> disabled>
                                    <label for="my-radio-1" class=" mb-0 mx-2">Si</label>
                                    <input type="radio" name="txthospitalario" id="txthospitalariono" value="2" <?= $hospitalario2 ?> disabled>
                                    <label for="my-radio-2" class=" mb-0 mx-2">No</label>
                                </div>
                    </div>    
                    <div class="form-group col-md-3">
                        <label for="txtMarca">Upgd Seguimeinto</label>
                        <div class="form-control form-control-sm"> <?php echo $seguimiento['upgd'] ?></div>
                    </div>             
                </div>
            </form>
        </div>
    </div>
    <div class="text-center pt-3">        
        <a type="button" class="btn btn-secondary  btn-sm" data-bs-dismiss="modal">Cerrar</a>
    </div>
</div>
<! /*aqui termina el formulario */!>