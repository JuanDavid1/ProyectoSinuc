<?php
include '../config/plantilla.php';
?>
<div id="insert">
    <?php
    $key = array_search(1, array_column($modulos, 'id_modulo'));
    if ($key !== false) {
        if ((PermisosUsuario($opciones, 10, 1))) {
    ?>
            <div class="text-end">
                <?php
                if ((PermisosUsuario($opciones, 10, 1))) {
                ?>
                    <a class="btn btn-lg btn-success btn-sm mb-2" onclick="RegistrarPecientes('r')"><i class="fas fa-plus-circle px-2"></i>REGISTRAR</a>
                <?php
                }
                ?>
            </div>
            <div class="table-responsive">
                <table id="tablePersonas" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Tipo Doc.</th>
                            <th>Documento</th>
                            <th>Nombre Completo</th>
                            <th>Fecha Nacimiento</th>
                            <th>Fecha Atención</th>
                            <th>EPS</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                    </tbody>
                </table>
            </div>
    <?php
        } else {
            echo '<div class="alert alert-danger text-center text-white"><b>No tienes permisos para ver este contenido</b></div>';
        }
    } else {
        echo '<div class="alert alert-danger text-center text-white"><b>No tienes permisos para ver este contenido</b></div>';
    }
    ?>
</div>