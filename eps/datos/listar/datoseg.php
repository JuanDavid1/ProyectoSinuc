<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ' . $_SESSION["urlin"] . '/index.php');
    exit;
}

include '../../../config/conexion.php';
$id = $_POST['id'];
try {
    $cmd = new PDO("$bd_driver:host=$bd_servidor;dbname=$bd_base;$charset", $bd_usuario, $bd_clave);
    $cmd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $sql = "SELECT
                `seguimiento`.`id_seguimeinto`
                , `seguimiento`.`id_paciente`
                , CONCAT_WS(' ', `personas`.`nombre1`
                , `personas`.`nombre2`
                , `personas`.`apellido1`
                , `personas`.`apellido1`) AS `nombre`
                , `personas`.`estado`
                , `seguimiento`.`fehcasivigila`
                , `seguimiento`.`fechaseguimiento`
                , `seguimiento`.`pesoseguimiento`
                , `seguimiento`.`tallaseguimiento`
                , `seguimiento`.`puntajez`
                , `seguimiento`.`ambulatorio`
                , `seguimiento`.`opotuna`
                , `seguimiento`.`adherencia`
                , `seguimiento`.`completo`
                , `seguimiento`.`hospitalario`
            FROM
                `seguimiento`
                INNER JOIN `personas` 
                    ON (`seguimiento`.`id_paciente` = `personas`.`id`)"
                . "WHERE `seguimiento`.`id_paciente` = $id";            
    $rs = $cmd->query($sql);
    $iecs = $rs->fetchAll(PDO::FETCH_ASSOC);
    $cmd = null;
} catch (PDOException $e) {
    $e->getCode() == 2002 ? 'Sin Conexión a Mysql (Error: 2002)' : 'Error: ' . $e->getMessage();
}
$data = [];
if (!empty($iecs)) {
    foreach ($iecs as $o) {
        $id_iec = $o['id_seguimeinto'];
        $borrar = $editar = $imprimir = null ;
        $borrar = '<button onclick="DeletIEC(' . $id_iec . ')" type="button" class="btn btn-sm px-3 btn-outline-danger mb-0"> <span class="far fa-trash-alt">  </span></button>';
        $editar = '<button onclick="VerDetalle(' . $id_iec . ')" type="button" class="btn btn-sm px-3 btn-outline-primary mb-0"> <span class="far fa-eye">  </span></button>';
        //$imprimir = '<button onclick="ImprimirModal(' . $id_iec . ')" type="button" class="btn btn-sm px-3 btn-outline-warning mb-0"> <span class="fas fa-print">  </span></button>';
        $estado = $o['estado'] == 1 ? 'DESNUTRIDO' : 'RECUPERADO';
        $opotuna = $o['opotuna'] == 1 ? 'SI' : 'NO';
        $estado = $o['estado'] == 1 ? '<span class="badge rounded-pill bg-danger">DESNUTRICION</span>' : '<span class="badge rounded-pill bg-success">RECUPERADO</span>';
        $data[] = [
            'id_seguimeinto' => $id_iec,
            'nombre' => $o["nombre"],
            'fechasivig' => $o["fehcasivigila"],
            'fechaseg' => $o["fechaseguimiento"],
            'peso' => $o["pesoseguimiento"],
            'talla' => $o["tallaseguimiento"],
            'puntaje' => $o["puntajez"],
            'ftlc' => $opotuna,
            'estado' => '<div class="text-center">' . $estado . '</div>',
            'action' => '<div class="text-center">' . $borrar . ' ' . $editar . ' ' . $imprimir . '  </div>'
        ];
    }
}

$datos = [
    'data' => $data,
];
echo json_encode($datos);
/*
'id' => $id_person,
            'fechanacimiento' => $fechanacimiento,
            'categoria' => $o['descripcion'],
            'archivo' => $extencion,
            'fecha' => $o['fec_reg'],
            'action' => '<div class="text-center">' . $borrar . ' ' . $descargar . '</div>',*/