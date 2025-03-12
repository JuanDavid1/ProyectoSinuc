<?php

session_start();
if (!isset($_SESSION['id_user'])) {
    exit('Acceso Denegado');
}
include '../../../config/conexion.php';
//print_r($_POST);
//exit();
$id_paciente = $_POST["id_paciente"];
$fehcasivigila = $_POST["fecha_atencion"];
$fechaseguimiento = $_POST["txtfechaseguimiento"];
$pesoseguimiento = $_POST["txtpeso"];
$tallaseguimiento = $_POST["txtalla"];
$puntajez = $_POST["txtpuntaje"];
$ftlc = isset($_POST['txtftlc']) ? $_POST['txtftlc']: 2;
$ambulatorio = isset($_POST['txtambu']) ? $_POST['txtambu']: 2;
$opotuna = isset($_POST['txtftlcoportuna']) ? $_POST['txtftlcoportuna']: 2;
$adherencia = isset($_POST['txtftlcadherencia']) ? $_POST['txtftlcadherencia']: 2;
$completo = isset($_POST['txtftlccompleto']) ? $_POST['txtftlccompleto']: 2;
$hospitalario = isset($_POST['txthospitalario']) ? $_POST['txthospitalario']: 2;
$estado = $_POST["estado"];
$s = $_POST["upgd"];

//$date = new DateTime('now', new DateTimeZone('America/Bogota'));

//$id_user_reg = $_SESSION['id_user'];
//$fecha_reg = new DateTime('now', new DateTimeZone('America/Bogota'));


try {
    $cmd = new PDO("$bd_driver:host=$bd_servidor;dbname=$bd_base;$charset", $bd_usuario, $bd_clave);
    $cmd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);

    $sql = "INSERT INTO `seguimiento`
                (`id_paciente`,`fehcasivigila`,`fechaseguimiento`,`pesoseguimiento`,`tallaseguimiento`,`puntajez`,`ftlc`,`ambulatorio`,`opotuna`,`adherencia`,`completo`,`hospitalario`,`upgd`)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $sql = $cmd->prepare($sql);
    $sql->bindParam(1, $id_paciente, PDO::PARAM_INT);
    $sql->bindParam(2, $fehcasivigila, PDO::PARAM_STR);
    $sql->bindParam(3, $fechaseguimiento, PDO::PARAM_STR);
    $sql->bindParam(4, $pesoseguimiento, PDO::PARAM_STR);
    $sql->bindParam(5, $tallaseguimiento, PDO::PARAM_STR);
    $sql->bindParam(6, $puntajez, PDO::PARAM_STR);
    $sql->bindParam(7, $ftlc, PDO::PARAM_STR);
    $sql->bindParam(8, $ambulatorio, PDO::PARAM_STR);
    $sql->bindParam(9, $opotuna, PDO::PARAM_STR);
    $sql->bindParam(10, $adherencia, PDO::PARAM_STR);
    $sql->bindParam(11, $completo, PDO::PARAM_STR);
    $sql->bindParam(12, $hospitalario, PDO::PARAM_STR);
    $sql->bindParam(13, $s, PDO::PARAM_STR);
    $sql->execute();
    if ($cmd->lastInsertId() > 0) {
        // Inserción exitosa, ahora actualizamos la tabla personas
        $sql = "UPDATE personas SET estado = ? WHERE id = ?";
        $sql = $cmd->prepare($sql);
        $sql->bindParam(1, $estado, PDO::PARAM_STR);
        $sql->bindParam(2, $id_paciente, PDO::PARAM_INT);
        
        if ($sql->execute()) {
            $res['status'] = "ok";
            $res['msg'] = 'Seguimiento Registrado Correctamente';
        } else {
            $res['msg'] = 'Registro insertado, pero falló la actualización: ' . $sql->errorInfo()[2];
        }
    } else {
        $res['msg'] = $sql->errorInfo()[2];
    }
    $cmd = null;
} catch (PDOException $e) {
    $res['msg'] = $e->getCode() == 2002 ? 'Sin Conexión a Mysql (Error: 2002)' : 'Error: ' . $e->getMessage();
}
echo json_encode($res);
