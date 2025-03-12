<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ' . $_SESSION['urlin'] . '/index.php');
    exit;
}
$user = $_SESSION['id_user'];
$id_usuario = $_SESSION['id_user'];
include 'conexion.php';
include 'permisos.php';
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
<style>
    /* Estilos para el menú lateral */
    .sidebar {
        width: 250px;
        background-color: #333;
        position: fixed;
        top: 0;
        left: -270px;
        height: 100%;
        transition: left 0.3s;
    }

    .show-sidebar {
        left: 0;
    }

    /* Ajustar el contenido principal */
    .main-content {
        margin-left: 270px;
        transition: margin-left 0.3s;
    }

    .hide-content {
        margin-left: 0;
    }
</style>

<body class="bg-gray-100">
    <div class="sidebar bg-gray-100" id="sidebar">
        <?php include 'menu.php'; ?>
    </div>
    <main class="main-content position-relative border-radius-lg bg-gray-100 mt-2">
        <?php include 'nave.php'; ?>
        <div style="background-color: white; padding:4px; min-height: 80vh !important">
            <div id="contenido">

            </div>
        </div>
        <?php include 'footer.php' ?>
    </main>
    <?php
    include 'scripts.php';
    include 'alerts.php';
    ?>
    <script src="<?php echo $_SESSION['urlin'] ?>/inicio/js/funciones.js?v=<?php echo date('YmdHis') ?>"></script>
    <script src="<?php echo $_SESSION['urlin'] ?>/usuarios/js/funciones.js?v=<?php echo date('YmdHis') ?>"></script>
    <script>
        function toggleSidebar(boton) {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.querySelector('.main-content');
            const menuIcon = document.getElementById('menuIco');
            sidebar.classList.toggle('show-sidebar');
            mainContent.classList.toggle('hide-content');
            if (sidebar.classList.contains('show-sidebar')) {
                menuIcon.classList.remove('fa-bars');
                menuIcon.classList.add('fa-ellipsis-v');
            } else {
                menuIcon.classList.remove('fa-ellipsis-v');
                menuIcon.classList.add('fa-bars');
            }
        }
    </script>
    <script>
        function insertHTML() {
            var data = document.getElementById('insert');
            var html = data.innerHTML;
            document.getElementById('contenido').innerHTML = html;
            data.remove();
        }
        document.addEventListener('DOMContentLoaded', function() {
            insertHTML();
        });
    </script>
</body>


</html>