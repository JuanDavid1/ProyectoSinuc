<?php

session_start();
if (!isset($_SESSION['id_user'])) {
    exit('Acceso Denegado');
}
include '../../../config/conexion.php';
$id = $_POST["id"];
$tipodocumento = $_POST["txtipodoc"];
$numerodocumento = $_POST["txnumero"];
$nombre1 = mb_strtoupper($_POST["txnombre1"]);
$nombre2 = mb_strtoupper($_POST["txnombre2"]);
$apellido1 = mb_strtoupper($_POST["txapllido1"]);
$apellido2 = mb_strtoupper($_POST["txapllido2"]);
$fechanacimiento = $_POST["dtfecnac"];
$telefono = $_POST["txtelefono"];
$municipio = $_POST["txmunicipio"];
$area = $_POST["txarea"];
$direccion = mb_strtoupper($_POST["txdireccion"]);
$eps = $_POST["txteps"];
$regimen = $_POST["txtregimen"];
$mgenero = $_POST["genero"];
$res['status'] = 0;
$estado = $_POST["estado"];
$id_user_act = $_SESSION['id_user'];
$fecha_reg = new DateTime('now', new DateTimeZone('America/Bogota'));
$fecha_atencion = $_POST["txfechaatencion"];
$fecha_epi= $_POST["inputresultadoSemana"];

try {
    $cmd = new PDO("$bd_driver:host=$bd_servidor;dbname=$bd_base;$charset", $bd_usuario, $bd_clave);
    $cmd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
    $sql = "UPDATE `personas` SET 
                `tipo_identificacion_id` = ?,
                `regimen_id` = ?,
                `eps_id` = ?,
                `tipo_area_residencial_id` = ?,
                `identificacion` = ?,
                `nombre1` = ?,
                `nombre2` = ?,
                `apellido1` = ?,
                `apellido2` = ?,
                `fecha_nacimiento` = ?,
                `direccion` = ?,
                `telefono` = ?,
                `genero` = ?,
                `estado` = ?,
                `municipio_id` = ?,
                `fecha_atencion` = ?,
                `fecha_epi` = ?
            WHERE id = ? ";
    $sql = $cmd->prepare($sql);
    $sql->bindParam(1, $tipodocumento, PDO::PARAM_STR);
    $sql->bindParam(2, $regimen, PDO::PARAM_STR);
    $sql->bindParam(3, $eps, PDO::PARAM_STR);
    $sql->bindParam(4, $area, PDO::PARAM_STR);
    $sql->bindParam(5, $numerodocumento, PDO::PARAM_STR);
    $sql->bindParam(6, $nombre1, PDO::PARAM_STR);
    $sql->bindParam(7, $nombre2, PDO::PARAM_STR);
    $sql->bindParam(8, $apellido1, PDO::PARAM_STR);
    $sql->bindParam(9, $apellido2, PDO::PARAM_STR);
    $sql->bindParam(10, $fechanacimiento, PDO::PARAM_STR);
    $sql->bindParam(11, $direccion, PDO::PARAM_STR);
    $sql->bindParam(12, $telefono, PDO::PARAM_STR);
    $sql->bindParam(13, $mgenero, PDO::PARAM_STR);
    $sql->bindParam(14, $estado, PDO::PARAM_STR);
    $sql->bindParam(15, $municipio, PDO::PARAM_STR);
    $sql->bindParam(16, $fecha_atencion, PDO::PARAM_STR);
    $sql->bindParam(17, $fecha_epi,PDO::PARAM_STR);
    $sql->bindParam(18, $id, PDO::PARAM_INT);
    if (!($sql->execute())) {
        $res['msg'] = $sql->errorInfo()[2];
        echo json_encode($res);
        exit();
    } else {
        if ($sql->rowCount() > 0) {
            $cmd = new PDO("$bd_driver:host=$bd_servidor;dbname=$bd_base;$charset", $bd_usuario, $bd_clave);
            $cmd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
            $sql = "UPDATE `personas` SET  `id_user_act` = ?, `fec_act` = ?  WHERE `id` = ?";
            $sql = $cmd->prepare($sql);
            $sql->bindParam(1, $id_user_act, PDO::PARAM_INT);
            $sql->bindValue(2, $fecha_reg->format('Y-m-d H:i:s'));
            $sql->bindParam(3, $id, PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                $res['status'] = "ok";
                $res['msg'] = 'Registrado Correctamente';
            } else {
                $res['msg'] = $sql->errorInfo()[2];
            }
        } else {
            $res['msg'] = 'No se registró ningún nuevo dato';
        }
    }
    $cmd = null;
} catch (PDOException $e) {
    $res['msg'] = $e->getCode() == 2002 ? 'Sin Conexión a Mysql (Error: 2002)' : 'Error: ' . $e->getMessage();
}
echo json_encode($res);
