<?php
include '../../config/plantilla.php';
$id = $_POST['id'];
try {
    $cmd = new PDO("$bd_driver:host=$bd_servidor;dbname=$bd_base;$charset", $bd_usuario, $bd_clave);
    $cmd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $sql = "SELECT `id_doc`, `descripcion` FROM `tipo_seguimiento`";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $tipos = $sql->fetchAll();
    $sql = "SELECT
            `id_nivel`
            , `descripcion`
        FROM
            `educativo` order by descripcion asc";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $educativos = $sql->fetchAll();
    $sql = "SELECT
            `id_familia`
            , `descripcion`
        FROM
            `familia` order by descripcion asc";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $familiar = $sql->fetchAll();
    $sql = "SELECT
                `categoria_id`
                , `nombre`
            FROM
                `categoria` order by nombre asc";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $categorias = $sql->fetchAll();
    $sql = "SELECT
                `id`
                , `nombre`
            FROM
                `cuidador` order by nombre asc";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $cuidador = $sql->fetchAll();
    $sql = "SELECT
                `id_clasi`
                , `nombre`
            FROM
                `clasificacion` order by nombre asc";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $clasificacion = $sql->fetchAll();
    $sql = "SELECT
                `id_talla`
                , `nombre`
            FROM
                `talla` order by nombre asc";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $tallaedad = $sql->fetchAll();
    $sql = "SELECT
                `id_peso`
                , `nombre`
            FROM
                `peso` ";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $pesoedad = $sql->fetchAll();
    $sql = "SELECT
                `id_observa`
                , `nombre`
            FROM
                `observaciones` ";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $observa = $sql->fetchAll();
    $sql = "SELECT
                `id_comple`
                , `nombre`
            FROM
                `complemento` order by nombre asc ";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $complemento = $sql->fetchAll();
    $sql = "SELECT
                `id_progra`
                , `nombre`
            FROM
                `programa` order by nombre asc ";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $programa = $sql->fetchAll();
    $sql = "SELECT
                `id_signo`
                , `nombre`
            FROM
                `signos` order by nombre asc ";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $signo = $sql->fetchAll();
    $sql = "SELECT
                `id_nacimiento`
                , `nombre`
            FROM
                `nacimiento` order by nombre asc ";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $nacimiento = $sql->fetchAll();
    $sql = "SELECT
                `id_semana`
                , `nombre`
            FROM
                `semanas`";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $semana = $sql->fetchAll();

    $sql = "SELECT
                `id_exclusiva`
                , `nombre`
            FROM
                `exclusiva` order by nombre asc ";
    $sql = $cmd->prepare($sql);
    $sql->execute();
    $exclusiva = $sql->fetchAll();
    $cmd = null;
} catch (PDOException $e) {
    echo $e->getCode() == 2002 ? 'Sin Conexión a Mysql (Error: 2002)' : 'Error: ' . $e->getMessage();
}

?>

<div id="insert">
    <input type="hidden" id="peReg" value="1">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Gestión de Archivos</button>
            <button class="nav-link" id="nav-profileiec-tab" data-bs-toggle="tab" data-bs-target="#nav-profileiec" type="button" role="tab" aria-controls="nav-profileiec" aria-selected="false">Seguimiento</button>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <form id="formCargaDocs">
                <input type="hidden" name="id" id="id_paciente" value="<?php echo $id ?>">
                <div class="row">
                    <div class="form-group col-md-3">
                        <label class="form-label" for="slcTipo">Tipo de Siguimiento</label>
                        <select class='form-control form-control-sm' name="slcTipo[]" id="slcTipo">
                            <option value="0">--Seleccionar--</option>
                            <?php foreach ($tipos as $t) { ?>
                                <option value="<?php echo $t['id_doc'] ?>"><?php echo $t['descripcion'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-8">
                        <label class="form-label">Selecciona un archivo</label>
                        <input class='form-control form-control-sm' type="file" name="archivo[]">
                    </div>
                    <div class="form-group col-md-1">
                        <label class="form-label"> </label>
                        <div class='form-control form-control-sm p-0 border-0'>
                            <button type="button" class="btn btn-primary mb-0 py-2 w-100" onclick="addFile()"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                </div>
                <div id="uploadFiles">
                </div>
            </form>
            <button class="btn btn-primary btn-sm" onclick="SubirDocumento()">Subir archivo</button>
            <div class="table-responsive">
                <table class="table table-sm table-striped w-100" id="tableCargaFiles">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>categoria</th>
                            <th>Archivo</th>
                            <th>fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-profileiec" role="tabpanel" aria-labelledby="nav-profileiec-tab">
            <div class="table-responsive">
                <div class="text-end">
                    
                </div>
                <input type="hidden" value="<?php echo $_POST['id'] ?>" id="id_paciente">
                <table class="table table-sm table-striped w-100" id="tableCargarSec">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Fecha de SIVIGILA</th>
                            <th>Fecha del Seguimiento</th>
                            <th>Peso</th>
                            <th>Talle</th>
                            <th>Puntaje Z</th>
                            <th>FTLC Oportuna</th>
                            <th>ESTADO</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>