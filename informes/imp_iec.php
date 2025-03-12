<?php

session_start();
if (!isset($_SESSION['id_user'])) {
    exit('Acceso Denegado');
}
include '../config/conexion.php';

$id = $_POST['id'];
try {
    $cmd = new PDO("$bd_driver:host=$bd_servidor;dbname=$bd_base;$charset", $bd_usuario, $bd_clave);
    $cmd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $sql ="SELECT `id_paciente` FROM `seguimiento` WHERE `id_seguimeinto` = $id limit 1";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $id_usr = $sql->fetch();
    $sql = "SELECT
                `personas`.`id`
                , `tipo_documento`.`descripcion` AS `nombre_documento`
                , `regimen`.`descripcion` AS `eapb`
                , `eps`.`razon_social`
                , `tipo_area`.`descripcion` AS `area_recidencia`
                , `personas`.`barrio_id`
                , `personas`.`grupo_etnico_id`
                , `personas`.`identificacion`
                , `personas`.`nombre1`
                , `personas`.`nombre2`
                , `personas`.`apellido1`
                , `personas`.`apellido2`
                , `personas`.`fecha_nacimiento`
                , `personas`.`direccion`
                , `personas`.`telefono`
                , `personas`.`genero`
                , `personas`.`estado`
                , `municipio`.`nombre_municipio`
                , `personas`.`fecha_atencion`
                , `personas`.`fecha_epi`
                , `seguimiento`.`id_seguimeinto`
                , `seguimiento`.`id_paciente`
                , `seguimiento`.`fehcasivigila`
                , `seguimiento`.`pesoseguimiento`
                , `seguimiento`.`tallaseguimiento`
                , `seguimiento`.`puntajez`
                , `seguimiento`.`ambulatorio`
                , `seguimiento`.`opotuna`
                , `seguimiento`.`adherencia`
                , `seguimiento`.`completo`
                , `seguimiento`.`hospitalario`
            FROM
                `seguimiento`
                INNER JOIN `personas` 
                    ON (`seguimiento`.`id_paciente` = `personas`.`id`)
                INNER JOIN `tipo_documento` 
                    ON (`personas`.`tipo_identificacion_id` = `tipo_documento`.`id_doc`)
                INNER JOIN `regimen` 
                    ON (`personas`.`regimen_id` = `regimen`.`id_reg`)
                INNER JOIN `eps` 
                    ON (`personas`.`eps_id` = `eps`.`id_eps`)
                INNER JOIN `tipo_area` 
                    ON (`personas`.`tipo_area_residencial_id` = `tipo_area`.`id_tipo`)
                INNER JOIN `municipio` 
                    ON (`personas`.`municipio_id` = `municipio`.`id_municipio`)
                    WHERE (`seguimiento`.`id_paciente` = ".$id_usr['id_paciente'] .")";
                    echo $sql;
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $usuarios = $sql->fetchAll();
    $cmd = null;
} catch (PDOException $e) {
    echo $e->getCode() == 2002 ? 'Sin Conexión a Mysql (Error: 2002)' : 'Error: ' . $e->getMessage();
}
?>


<button onclick="Exportar('divExportar')" class="btn btn-success">XLS</button>
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>



<div id="divExportar" style="display:none">
    <table style="width: 100%;">
            <thead>
                <tr>
                    <th>Id_Paciente</th>
                    <th>tipo_documento</th>
                    <th>regimen</th>
                    <th>eps</th>
                    <th>tipo_area</th>
                    <th>grupo_etnico</th>
                    <th>identificacion</th>
                    <th>nombre1</th>
                    <th>nombre1</th>
                    <th>apellido1</th>
                    <th>apellido2</th>
                    <th>fecha_nacimiento</th>
                    <th>direccion</th>
                    <th>telefono</th>
                    <th>genero</th>
                    <th>estado</th>
                    <th>nombre_municipio</th>
                    <th>fecha_atencion</th>
                    <th>fecha_epi</th>
                    <th>id_paciente</th>
                    <th>fehcasivigila</th>
                    <th>pesoseguimiento</th>
                    <th>tallaseguimiento</th>
                    <th>puntajez</th>
                    <th>ambulatorio</th>
                    <th>opotuna</th>
                    <th>adherencia</th>
                    <th>completo</th>
                    <th>hospitalario</th>   
                </tr>
            </thead>
            <tbody >
                <?php
                    foreach ($usuarios as $u){                
                ?>
                    <tr>
                        <td><?php echo $u['id'] ?></td>
                        <td><?php echo $u['nombre_documento'] ?></td>
                        <td><?php echo $u['eapb'] ?></td>
                        <td><?php echo $u['razon_social'] ?></td>
                        <td><?php echo $u['area_recidencia'] ?></td>
                        <td><?php echo $u['grupo_etnico_id'] ?></td>
                        <td><?php echo $u['identificacion'] ?></td>
                        <td><?php echo $u['nombre1'] ?></td>
                        <td><?php echo $u['nombre2'] ?></td>
                        <td><?php echo $u['apellido1'] ?></td>
                        <td><?php echo $u['apellido2'] ?></td>
                        <td><?php echo $u['fecha_nacimiento'] ?></td> 
                        <td><?php echo $u['direccion'] ?></td>
                        <td><?php echo $u['telefono'] ?></td>
                        <td><?php echo $u['genero'] ?></td>
                        <td><?php echo $u['estado'] ?></td>
                        <td><?php echo $u['nombre_municipio'] ?></td>
                        <td><?php echo $u['fecha_atencion'] ?></td>
                        <td><?php echo $u['fecha_epi'] ?></td>
                        <td><?php echo $u['id_paciente'] ?></td>
                        <td><?php echo $u['fehcasivigila'] ?></td>
                        <td><?php echo $u['pesoseguimiento'] ?></td>
                        <td><?php echo $u['tallaseguimiento'] ?></td>
                        <td><?php echo $u['puntajez'] ?></td>
                        <td><?php echo $u['ambulatorio'] ?></td>
                        <td><?php echo $u['opotuna'] ?></td>
                        <td><?php echo $u['adherencia'] ?></td>
                        <td><?php echo $u['completo'] ?></td>
                        <td><?php echo $u['hospitalario'] ?></td>

                    </tr>  
                    <?php
                    }
                    ?>             
            </tbody>
    </table>
</div>
    
    