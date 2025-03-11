<?php

session_start();
if (!isset($_SESSION['id_user'])) {
    exit('Acceso Denegado');
}
include '../../../config/conexion.php';
$tipos = $_POST['slcTipo'];
$files = $_FILES['archivo'];
$idt = $_POST['id'];
$res = [];
$res['status'] = 'fail';
$iduser = $_SESSION['id_user'];
$date = new DateTime('now', new DateTimeZone('America/Bogota'));
$total = 0;
try {
    $cmd = new PDO("$bd_driver:host=$bd_servidor;dbname=$bd_base;$charset", $bd_usuario, $bd_clave);
    $cmd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
    $sql = "INSERT INTO `seg_archivos`(`id_paciente`, `id_tipo_seg`, `ruta_doc`, `nombre_doc`, `id_user_reg`, `fec_reg`)
            VALUES(?, ?, ?, ?, ?, ?)";
    $sql = $cmd->prepare($sql);
    $sql->bindParam(1, $idt, PDO::PARAM_INT);
    $sql->bindParam(2, $id_tipo, PDO::PARAM_INT);
    $sql->bindParam(3, $ruta, PDO::PARAM_STR);
    $sql->bindParam(4, $nom_archivo, PDO::PARAM_STR);
    $sql->bindParam(5, $iduser, PDO::PARAM_INT);
    $sql->bindValue(6, $date->format('Y-m-d H:i:s'));
    foreach ($files['name'] as $key => $name) {
        $id_tipo = $tipos[$key];
        $nom_archivo = $id_tipo . '_' . date('YmdGis') . $total . '_' . $name;
        $nom_archivo = strlen($nom_archivo) >= 101 ? substr($nom_archivo, 0, 100) : $nom_archivo;
        $temporal = file_get_contents($files['tmp_name'][$key]);
        $ruta = '../../../uploads/' . $idt . '/';
        if (!file_exists($ruta)) {
            $ruta = mkdir('../../../uploads/' . $idt . '/', 0777, true);
            $ruta = '../../../uploads/' . $idt . '/';
        }
        $estado = file_put_contents("$ruta/$nom_archivo", $temporal);
        if (false !== $estado) {
            $ruta = '/uploads/' . $idt . '/';
            $sql->execute();
            if ($cmd->lastInsertId() > 0) {
                $total++;
            } else {
                $res['msg'] = $cmd->errorInfo()[2];
            }
        }
    }
    $cmd = null;
} catch (PDOException $e) {
    $res['msg'] = $e->getCode() == 2002 ? 'Sin Conexión a Mysql (Error: 2002)' : 'Error: ' . $e->getMessage();
}
if ($total > 0) {
    $res['status'] = 'ok';
    $res['msg'] = 'Se han cargado ' . $total . ' archivos';
}
echo json_encode($res);
