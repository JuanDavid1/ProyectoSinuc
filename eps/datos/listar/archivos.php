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
                `seg_archivos`.`id_file`
                , `seg_archivos`.`id_paciente`
                , `seg_archivos`.`id_tipo_seg`
                , `tipo_seguimiento`.`descripcion`
                , `seg_archivos`.`ruta_doc`
                , `seg_archivos`.`nombre_doc`
                , `seg_archivos`.`fec_reg`
            FROM
                `seg_archivos`
                INNER JOIN `tipo_seguimiento` 
                    ON (`seg_archivos`.`id_tipo_seg` = `tipo_seguimiento`.`id_doc`)
            WHERE (`seg_archivos`.`id_paciente`  = $id)";
    $rs = $cmd->query($sql);
    $archivos = $rs->fetchAll(PDO::FETCH_ASSOC);
    $cmd = null;
} catch (PDOException $e) {
    $e->getCode() == 2002 ? 'Sin Conexión a Mysql (Error: 2002)' : 'Error: ' . $e->getMessage();
}

$data = [];
if (!empty($archivos)) {
    foreach ($archivos as $o) {
        $id_person = $o['id_file'];
        $ruta = $_SESSION['urlin'] . '/' . $o['ruta_doc'] . $o['nombre_doc'];
        $borrar = $descargar = null;
        $borrar = '<button onclick="DeletArchivoP(' . $id_person . ')" type="button" class="btn btn-sm px-3 btn-outline-danger mb-0"> <span class="far fa-trash-alt">  </span></button>';
        $descargar = '<button value ="' . base64_encode($ruta) . '" onclick="VerArchivoP(this)" type="button" class="btn btn-sm px-3 btn-outline-success mb-0"> <span class="fas fa-download">  </span></button>';
        $nombre = explode('_', $o['nombre_doc']);
        $nombre = mb_strtoupper($nombre[2]);
        $extencion = explode('.', $o['nombre_doc']);
        $extencion = mb_strtoupper($extencion[1]);
        $data[] = [
            'id' => $id_person,
            'nombre' => $nombre,
            'categoria' => $o['descripcion'],
            'archivo' => $extencion,
            'fecha' => $o['fec_reg'],
            'action' => '<div class="text-center">' . $borrar . ' ' . $descargar . '</div>',
        ];
    }
}

$datos = [
    'data' => $data,
];
echo json_encode($datos);
