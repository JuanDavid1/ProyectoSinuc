<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: <?php echo $_SESSION["urlin"] ?>/index.php');
    exit;
}

include '../../../../config/conexion.php';
$id = $_POST['valor'];
try {
    $cmd = new PDO("$bd_driver:host=$bd_servidor;dbname=$bd_base;$charset", $bd_usuario, $bd_clave);
    $cmd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $sql = "SELECT
                `id`
                , `nombre`
            FROM
                `ncategoria` 
            WHERE categoria_id =  $id";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $ncategorias = $sql->fetchAll();
    $cmd = null;
} catch (PDOException $e) {
    echo $e->getCode() == 2002 ? 'Sin Conexión a Mysql (Error: 2002)' : 'Error: ' . $e->getMessage();
}
$lista = '<option value="0">--Seleccione--</option>';
foreach ($ncategorias as $ncategoria) {
    $lista .= '<option value="' . $ncategoria['id'] . '">' . $ncategoria['nombre'] . '</option>';
}
echo $lista;
