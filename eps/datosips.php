<?php
include '../config/plantilla.php';

?>
<div id="insert">
    <?php
    $key = array_search(2, array_column($modulos, 'id_modulo'));
    if ($key !== false) {
        if ((PermisosUsuario($opciones, 20, 1))) {
    ?>
            <div class="text-end">
                <?php
                if ((PermisosUsuario($opciones, 20, 2))) {
                ?>
                    <a class="btn btn-lg btn-success btn-sm mb-2" onclick="RegistrarDatosIps('r')"><i class="fas fa-plus-circle px-2"></i>REGISTRAR</a>
                <?php
                }
                ?>
            </div>
            <div class="table-responsive">
                <table id="tableDisponibilidad" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Disponibilidad FTLC</th>
                            <th>Disponibilidad F74</th>
                            <th>Profesionales Desnutrición</th>
                            <th>Profesionales Patrones</th>
                            <th>Fecha Entrega Farmacia</th>
                            <th>Fecha Disponibilidad Fórmula</th>
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