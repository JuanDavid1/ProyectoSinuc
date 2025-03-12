<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ' . $_SESSION['urlin'] . '/index.php');
    exit;
}

$user = $_SESSION['id_user'];
include 'conexion.php';
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
            WHERE (`usuarios`.`idusuario` = ?);";
    $sql = $cmd->prepare($sql);
    $sql->bindParam(1, $user);
    $sql->execute();
    $resultado = $sql->fetch();
    $empresa = !empty($resultado) ? mb_strtoupper($resultado['razonsocial']) : '';
} catch (PDOException $e) {
    echo  $e->getCode() == 2002 ? 'Sin Conexión a Mysql (Error: 2002)' : 'Error: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<?php include 'header.php'; ?>
<?php include 'footer.php' ?>
</html>