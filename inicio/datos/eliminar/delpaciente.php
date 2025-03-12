<?php

session_start();
if (!isset($_SESSION['id_user'])) {
    exit('Acceso Denegado');
}
include '../../../config/conexion.php';

$id=isset($_POST["id"])?$_POST["id"]:exit('ACCESO DENEGADO!');

$res['status'] = 0;

try {
    $cmd = new PDO("$bd_driver:host=$bd_servidor;dbname=$bd_base;$charset", $bd_usuario, $bd_clave);
    $cmd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
    $sql = "DELETE
    FROM `desnutricion`.`personas`
    WHERE `id` = ?";
    $sql = $cmd->prepare($sql);
    $sql->bindParam(1, $id, PDO::PARAM_INT);
    $sql->execute();
    if (!($sql->rowCount() > 0)) {
        $res["msg"]=  'Paciente No Puede Ser Eliminado';
    } else {
        $res['status'] = "ok";
        $res['msg'] = 'Paciente Eliminado Correctamente';
    }
    $cmd = null;
} catch (PDOException $e) {
    echo $e->getCode() == 2002 ? 'Sin Conexión a Mysql (Error: 2002)' : 'Error: ' . $e->getMessage();
}

echo json_encode($res);
