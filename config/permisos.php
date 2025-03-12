<?php
$id_usuario = $_SESSION['id_user'];
try {
    // consultar rol de usuario de la tabla seg_usuarios_sistema
    $cmd = new PDO("$bd_driver:host=$bd_servidor;dbname=$bd_base;$charset", $bd_usuario, $bd_clave);
    $cmd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $sql = "SELECT
                `id_modulo`
            FROM
                `permisos_modulos`
            WHERE (`id_usuario` = $id_usuario)";
    $rs = $cmd->query($sql);
    $modulos = $rs->fetchAll();
    $cmd = null;
} catch (PDOException $e) {
    echo $e->getCode() == 2002 ? 'Sin Conexión a Mysql (Error: 2002)' : 'Error: ' . $e->getCode();
}
try {
    // consultar rol de usuario de la tabla seg_usuarios_sistema
    $cmd = new PDO("$bd_driver:host=$bd_servidor;dbname=$bd_base;$charset", $bd_usuario, $bd_clave);
    $cmd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $sql = "SELECT
                `id_opcion`,`p_listar`,`p_registrar`,`p_modificar`,`p_eliminiar`,`p_anular`,`p_imprimir`
            FROM
                `permisos_opciones`
            WHERE (`id_usuaio` = $id_usuario)";
    $rs = $cmd->query($sql);
    $opciones = $rs->fetchAll();
    $cmd = null;
} catch (PDOException $e) {
    echo $e->getCode() == 2002 ? 'Sin Conexión a Mysql (Error: 2002)' : 'Error: ' . $e->getCode();
}
function PermisosUsuario($array, $opcion, $tipo)
{
    $comp = false;

    $key = array_search($opcion, array_column($array, 'id_opcion'));

    if ($key !== false) {
        if ($tipo == 0) {
            $comp = true;
        } else {
            $permiso = 'p_' . obtenerNombrePermiso($tipo);
            $comp = $array[$key][$permiso] == 1;
        }
    }

    return $comp;
}

function obtenerNombrePermiso($tipo)
{
    $permisos = [
        1 => 'listar',
        2 => 'registrar',
        3 => 'modificar',
        4 => 'eliminiar',
        5 => 'anular',
        6 => 'imprimir',
    ];

    return $permisos[$tipo] ?? '';
}
