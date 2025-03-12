
<?php include "../personas/read.php"; ?>

<main class="main-content position-relative border-radius-lg ">

	<div class="container">
		<div class="box">
			<h4 class="display-4 text-center">Personas</h4><br>
			<?php if (isset($_GET['success'])) { ?>
		    <div class="alert alert-success" role="alert">
			  <?php echo $_GET['success']; ?>
		    </div>
		    <?php } ?>
			<?php if (mysqli_num_rows($result)) { ?>
			<table class="table table-striped">
			  <thead>
			    <tr>
			      <th scope="col">#</th>
				  <th scope="col">Municipio</th>
			      <th scope="col">Tipo Identificacion</th>
			      <th scope="col">Identificacion</th>
			      <th scope="col">Primer nombre</th>
				  <th scope="col">Segundo nombre</th>
				  <th scope="col">Primer apellido</th>
				  <th scope="col">Segundo apellido</th>
				  <th scope="col">Regimen</th>
				  <th scope="col">Eps</th>
				  <th scope="col">Area de residencia</th>
				  <th scope="col">Barrio</th>
				  <th scope="col">Grupo poblacional</th>
				  <th scope="col">Grupo etnico</th>
				  <th scope="col">Direccion</th>
				  <th scope="col">Telefono</th>
				  <th scope="col">Genero</th>
				  <th scope="col">Estado</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php 
			  	   $i = 0;
			  	   while($rows = mysqli_fetch_assoc($result)){
			  	   $i++;
			  	 ?>
			    <tr>
			      <th scope="row"><?=$i?></th>
			      <td><?=$rows['municipio_id']?></td>
			      <td><?php echo $rows['tipo_identificacion_id']; ?></td>
				  <td><?php echo $rows['identificacion']; ?></td>
				  <td><?php echo $rows['nombre1']; ?></td>
				  <td><?php echo $rows['nombre2']; ?></td>
				  <td><?php echo $rows['apellido1']; ?></td>
				  <td><?php echo $rows['apellido2']; ?></td>
				  <td><?php echo $rows['regimen_id']; ?></td>
				  <td><?php echo $rows['eps_id']; ?></td>
				  <td><?php echo $rows['tipo_area_residencial_id']; ?></td>
				  <td><?php echo $rows['barrio_id']; ?></td>
				  <td><?php echo $rows['grupo_poblacional_id']; ?></td>
				  <td><?php echo $rows['grupo_etnico_id']; ?></td>
				  <td><?php echo $rows['direccion']; ?></td>
				  <td><?php echo $rows['telefono']; ?></td>
				  <td><?php echo $rows['genero']; ?></td>
				  <td><?php echo $rows['estado']; ?></td>
			      <td><a href="../vistapersona/update.php?id=<?=$rows['id']?>" 
			      	     class="btn btn-success">Actualizar</a>

			      	  <a href="../personas/delete.php?id=<?=$rows['id']?>" 
			      	     class="btn btn-danger">Eliminar</a>
			      </td>
			    </tr>
			    <?php } ?>
			  </tbody>
			</table>
			<?php } ?>
			<div class="link-right">
				<a href="../vistapersona/index.php" button type="submit"  class="btn btn-primary">Crear Paciente</a>
			</div>
		</div>
	</div>
    <?php include '../config/footer.php';  
    ?>

</main>