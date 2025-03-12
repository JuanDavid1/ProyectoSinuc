<?php
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
    $res['msg'] = $e->getCode() == 2002 ? 'Sin Conexión a Mysql (Error: 2002)' : 'Error: ' . $e->getMessage();
}
?>
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-0 shadow-none border-radius-xl bg-primary" id="navbarBlur" data-scroll="false">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ul class="navbar-nav  justify-content-start">
                <li class="nav-item d-flex align-items-center">
                    <button onclick="toggleSidebar()" type="button" class="btn btn-outline-light m-0 px-2" style="float: left; margin-left: 10px;">
                        <i class="fas fa-bars" id="menuIco"></i>
                    </button>
                </li>
                <li class="px-2">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;"><?php echo $anio ?></a></li>
                    </ol>
                    <h6 class="font-weight-bolder text-white mb-0"><?php echo $user ?></h6>
                </li>
            </ul>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center"></div>
            <ul class="navbar-nav  justify-content-end">
                <li class="nav-item dropdown pe-2 d-flex align-items-center px-3">
                    <a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell cursor-pointer"></i>
                    </a>
                    <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <img src="#" class="avatar avatar-sm  me-3 ">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">New message</span> from Laur
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">
                                            <i class="fa fa-clock me-1"></i>
                                            13 minutes ago
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item d-flex align-items-center">
                    <div class="dropdown">
                        <a href="javascript:;" class="btn btn-outline-light dropdown-toggle mb-0 rounded-pill" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-user me-sm-0"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                            <li><a class="dropdown-item" href="<?php echo $_SESSION['urlin'] ?>/config/logout.php">Cerrar Sesión</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>