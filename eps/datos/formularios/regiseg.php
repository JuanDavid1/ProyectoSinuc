<?php
// Incluir el archivo de configuración
include '../../../config/conexion.php';

// Obtener el ID del paciente desde POST
$id_paciente = $_POST['id'];

try {
    // Establecer conexión a la base de datos
    $cmd = new PDO("$bd_driver:host=$bd_servidor;dbname=$bd_base;$charset", $bd_usuario, $bd_clave);
    $cmd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Función para ejecutar consultas y obtener resultados
    function executeQuery($cmd, $sql) {
        $stmt = $cmd->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener datos de diferentes tablas
    $tipos = executeQuery($cmd, "SELECT `id_doc`, `descripcion` FROM `tipo_seguimiento`");
    $educativos = executeQuery($cmd, "SELECT `id_nivel`, `descripcion` FROM `educativo` ORDER BY descripcion ASC");
    $familiar = executeQuery($cmd, "SELECT `id_familia`, `descripcion` FROM `familia` ORDER BY descripcion ASC");
    $categorias = executeQuery($cmd, "SELECT `categoria_id`, `nombre` FROM `categoria` ORDER BY nombre ASC");
    $cuidador = executeQuery($cmd, "SELECT `id`, `nombre` FROM `cuidador` ORDER BY nombre ASC");
    $clasificacion = executeQuery($cmd, "SELECT `id_clasi`, `nombre` FROM `clasificacion` ORDER BY nombre ASC");
    $tallaedad = executeQuery($cmd, "SELECT `id_talla`, `nombre` FROM `talla` ORDER BY nombre ASC");
    $pesoedad = executeQuery($cmd, "SELECT `id_peso`, `nombre` FROM `peso`");
    $observa = executeQuery($cmd, "SELECT `id_observa`, `nombre` FROM `observaciones`");
    $complemento = executeQuery($cmd, "SELECT `id_comple`, `nombre` FROM `complemento` ORDER BY nombre ASC");
    $programa = executeQuery($cmd, "SELECT `id_progra`, `nombre` FROM `programa` ORDER BY nombre ASC");
    $signo = executeQuery($cmd, "SELECT `id_signo`, `nombre` FROM `signos` ORDER BY nombre ASC");
    $nacimiento = executeQuery($cmd, "SELECT `id_nacimiento`, `nombre` FROM `nacimiento` ORDER BY nombre ASC");
    $semana = executeQuery($cmd, "SELECT `id_semana`, `nombre` FROM `semanas`");
    $exclusiva = executeQuery($cmd, "SELECT `id_exclusiva`, `nombre` FROM `exclusiva` ORDER BY nombre ASC");

    // Obtener datos del paciente
    $sql = "SELECT p.id, p.nombre1, p.nombre2, p.apellido1, p.apellido2, p.fecha_nacimiento, 
                   td.descripcion, p.telefono, p.fecha_atencion 
            FROM personas p 
            INNER JOIN tipo_documento td ON p.tipo_identificacion_id = td.id_doc 
            WHERE p.id = :id_paciente";
    $stmt = $cmd->prepare($sql);
    $stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
    $stmt->execute();
    $persona = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo $e->getCode() == 2002 ? 'Sin Conexión a MySQL (Error: 2002)' : 'Error: ' . $e->getMessage();
    exit;
}
?>

<!-- HTML del formulario -->
<div class="px-0">
    <div class="shadow">
        <div class="card-header mb-3" style="background-color: #16a085 !important;">
            <h5 style="color: white;">REGISTRAR SEGUIMIENTO</h5>
        </div>
        <div class="px-2">
            <form id="formRegSeguimiento">
                <input type="hidden" value="<?php echo htmlspecialchars($id_paciente); ?>" name="id_paciente">
                
                <!-- Datos personales -->
                <div class="row">
                    <?php
                    $personal_fields = ['nombre1', 'nombre2', 'apellido1', 'apellido2'];
                    foreach ($personal_fields as $field) {
                        echo "<div class='form-group col-md-3'>
                                <label>" . ucfirst(str_replace('_', ' ', $field)) . "</label>
                                <div class='form-control form-control-sm'>" . htmlspecialchars($persona[$field]) . "</div>
                              </div>";
                    }
                    ?>
                </div>

                <!-- Más campos del formulario -->
                <div class="row">
                    <div class="form-group col-md-3">
                        <label>Teléfono</label>
                        <div class="form-control form-control-sm"><?php echo htmlspecialchars($persona['telefono']); ?></div>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Fecha de nacimiento</label>
                        <div class="form-control form-control-sm"><?php echo htmlspecialchars($persona['fecha_nacimiento']); ?></div>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Fecha reporte al SIVIGILA</label>
                        <input type="date" class="form-control form-control-sm" name="fecha_atencion" readonly value="<?php echo htmlspecialchars($persona['fecha_atencion']); ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label>Fecha Seguimiento</label>
                        <input type="date" class="form-control form-control-sm" id="txtfechaseguimiento" name="txtfechaseguimiento" required>
                    </div>
                </div>

                <!-- Campos adicionales -->
                <?php
                $additional_fields = [
                    ['Peso (kg)', 'txtpeso', 'Peso en Kilogramos'],
                    ['Talla (cm)', 'txtalla', 'Talla en centímetros'],
                    ['Puntaje Z', 'txtpuntaje', 'SISVAN']
                ];

                echo "<div class='row'>";
                foreach ($additional_fields as $field) {
                    echo "<div class='form-group col-md-3'>
                            <label for='{$field[1]}'>{$field[0]}</label>
                            <input type='text' class='form-control form-control-sm' id='{$field[1]}' name='{$field[1]}' placeholder='{$field[2]}' required>
                          </div>";
                }
                echo "</div>";
                ?>

                <!-- Campos de radio buttons -->
                <?php
                $radio_fields = [
                    ['Gestión FTLC EPS', 'txtftlc', ['Si', 'No'], 'MostrarInpust'],
                    ['Manejo ambulatorio', 'txtambu', ['Si', 'No'], null, 'divamb'],
                    ['FTLC Oportunamente', 'txtftlcoportuna', ['Si', 'No'], 'MostrarInpust2', 'divoport'],
                    ['Adherencia a la FTLC', 'txtftlcadherencia', ['Si', 'No'], null, 'divadher'],
                    ['Completo Tratamiento', 'txtftlccompleto', ['Si', 'No'], null, 'divtrata'],
                    ['Manejo intrahospitalario', 'txthospitalario', ['Si', 'No'], null, 'divmanejo']
                ];

                foreach ($radio_fields as $field) {
                    $div_class = isset($field[4]) ? "form-group col-md-3 d-none' id='{$field[4]}'" : "form-group col-md-3";
                    echo "<div class='$div_class'>
                            <label for='{$field[1]}'>{$field[0]}</label>
                            <div id='{$field[1]}' class='form-control form-control-sm' style='display: flex; justify-content: center; align-items: center;'>";
                    foreach ($field[2] as $index => $option) {
                        $onclick = isset($field[3]) ? "onclick='{$field[3]}(" . ($index + 1) . ")'" : '';
                        echo "<input type='radio' name='{$field[1]}' id='{$field[1]}{$option}' value='" . ($index + 1) . "' $onclick>
                              <label for='{$field[1]}{$option}' class='mb-0 mx-2'>$option</label>";
                    }
                    echo "</div></div>";
                }
                ?>
            </form>
        </div>
    </div>
    <div class="text-center pt-3">
        <button type="button" class="btn btn-primary btn-sm" onclick="RegSeguimiento('r')">Registrar</button>
        <a type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</a>
    </div>
</div>
