<?php
$user = $_SESSION['id_user'];
include 'conexion.php';
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
    $empresa = !empty($resultado) ? mb_strtoupper($resultado['razonsocial']) : '';
} catch (PDOException $e) {
    $res['msg'] = $e->getCode() == 2002 ? 'Sin Conexión a Mysql (Error: 2002)' : 'Error: ' . $e->getMessage();
}

?>
<div class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-2 fixed-start mx-2 sidebar" id="sidebar">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="<?php echo $_SESSION['urlin'] ?>/inicio/panel_control.php">
            <span class="ms-1 font-weight-bold"><?php echo $empresa ?></span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <?php
            $key = array_search(1, array_column($modulos, 'id_modulo'));
            if ($key !== false) {
            ?>
                <li class="nav-item">
                    <a class="nav-link active" href="<?php echo $_SESSION["urlin"] ?>/inicio/panel_control.php">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-stethoscope text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">IPS</span>
                    </a>
                </li>
            <?php
            }
            $key = array_search(2, array_column($modulos, 'id_modulo'));
            if ($key !== false) {
            ?>
                <li class="nav-item">
                    <a class="nav-link " href="<?php echo $_SESSION["urlin"] ?>/eps/panel_control.php">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-file-text-o text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">EPS</span>                        
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="<?php echo $_SESSION["urlin"] ?>/eps/datosips.php">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-user-md text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">DATOS</span>
                    </a>
                </li>
            <?php
            }
            ?>
        </ul>
    </div>
</div>