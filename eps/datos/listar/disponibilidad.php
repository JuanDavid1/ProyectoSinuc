<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: <?php echo $_SESSION["urlin"] ?>/index.php');
    exit;
}

include '../../../config/conexion.php';
include '../../../config/permisos.php';

$id_usuario = $_SESSION['id_user'];

try {
    $cmd = new PDO("$bd_driver:host=$bd_servidor;dbname=$bd_base;$charset", $bd_usuario, $bd_clave);
    $cmd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $sql = "SELECT
                `personas`.`id`
                , `tipo_documento`.`codigo_ne`
                , `personas`.`identificacion`
                , CONCAT_WS(' ',`personas`.`nombre1`
                , IFNULL(`personas`.`nombre2`,'')
                , `personas`.`apellido1`
                , IFNULL(`personas`.`apellido2`, '')) AS nombre 
                , `personas`.`fecha_nacimiento`
                , `personas`.`fecha_atencion`
                , `eps`.`razon_social`
                , `personas`.`estado`
                , `personas`.`eps_id` 
                , `eps`.`nit`
                , `empresas`.`nit`
                , `empresas`.`idempresa`
                , `usuarios`.`idusuario`
            FROM
                `personas`
                INNER JOIN `tipo_documento` 
                    ON (`personas`.`tipo_identificacion_id` = `tipo_documento`.`id_doc`)
                INNER JOIN `eps` 
                    ON (`personas`.`eps_id` = `eps`.`id_eps`)
                INNER JOIN empresas 
                    ON (`eps`.`nit` = `empresas`.`nit`)
                INNER JOIN `usuarios` 
                    ON (`usuarios`.`idempresa` = `empresas`.`idempresa`)
                
          WHERE `usuarios`.`idusuario` = $id_usuario";
    $rs = $cmd->query($sql);
    $personas = $rs->fetchAll(PDO::FETCH_ASSOC);
    $cmd = null;
} catch (PDOException $e) {
    echo $e->getCode() == 2002 ? 'Sin Conexión a Mysql (Error: 2002)' : 'Error: ' . $e->getMessage();
}

$data = [];
if (!empty($personas)) {
    foreach ($personas as $o) {
        $id_person = $o['id'];
        $editar = $borrar = $detalles = $imprimir = null;
        if ((PermisosUsuario($opciones, 20, 3))) {
            $editar = '<button onclick="UpdatePecientes(' . $id_person . ')" type="button" class="btn btn-sm px-3 btn-outline-primary mb-0"> <span class="far fa-edit">  </span></button>';
        }
        if ((PermisosUsuario($opciones, 20, 4))) {
            $borrar = '<button onclick="DeletPaciente(' . $id_person . ')" type="button" class="btn btn-sm px-3 btn-outline-danger mb-0"> <span class="far fa-trash-alt">  </span></button>';
        }
        if ((PermisosUsuario($opciones, 20, 1))) {
            $detalles = '<button onclick="DetailsPaciente(' . $id_person . ')" type="button" class="btn btn-sm px-3 btn-outline-warning mb-0"> <span class="far fa-eye">  </span></button>';
        }
        $estado = $o['estado'] == 1 ? '<span class="badge rounded-pill bg-danger">DESNUTRICION</span>' : '<span class="badge rounded-pill bg-success">RECUPERADO</span>';
        $data[] = [
            'id' => $id_person,
            'tdoc' => $o['codigo_ne'],
            'doc' => $o['identificacion'],
            'nombre' => mb_strtoupper($o['nombre']),
            'fec_nac' => $o['fecha_nacimiento'],
            'fec_atencion' => $o['fecha_atencion'],
            'eps' => $o['razon_social'],
            'estado' => '<div class="text-center">' . $estado . '</div>',
            'action' => '<div class="text-center">' . $editar . ' ' . $detalles . ' ' . $borrar . ' </div>',
        ];
    }
}

$datos = [
    'data' => $data,
];
echo json_encode($datos);