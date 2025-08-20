<?php 
  $dataHeader['titulo'] = "Material Proyecto";
  $this->load->view('layoutsc/header', $dataHeader); 
?>

<?php 
  $dataSidebar['session'] = $session;
  $dataSidebar['optionSelected'] = 'subirMaterialProyect';
  $this->load->view('layoutsc/sidebar', $dataSidebar); 
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <div class="col-12 m-0 p-3">
    <h2 class="text-center mb-4 font-weight-bold">
		<?= isset($id_proyecto) 
			? '<i class="nav-icon fa-solid fa-pencil" style="color: #0f58d7;"></i>  EDITAR MATERIAL DE PROYECTO' 
			: '<i class="nav-icon fa-solid fa-box-open" style="color: #1962e1;"></i>  SUBIR MATERIAL AL PROYECTO' 
		?>
	</h2>
  </div>

  <div class="col-md-10 offset-md-1">

    <!-- Mostrar mensajes de éxito o error -->
    <script>
		<?php if (!empty($mensaje) && !empty($redirect_url)): ?>
				Swal.fire({
						icon: 'success',
						title: 'Éxito',
						text: '<?= $mensaje ?>',
						confirmButtonColor: '#3085d6',
						confirmButtonText: 'Aceptar'
				}).then((result) => {
						if (result.isConfirmed) {
								window.location.href = "<?= $redirect_url ?>";
						}
				});
		<?php endif; ?>

		<?php if (!empty($error)): ?>
				Swal.fire({
						icon: 'error',
						title: 'Error',
						text: '<?= $error ?>',
						confirmButtonColor: '#d33',
						confirmButtonText: 'Aceptar'
				});
		<?php endif; ?>
		</script>

    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Formulario de asignación</h3>
      </div>

      <form method="post" action="<?= base_url('index.php/despa/Proyecto/insertarMaterialProyecto' . (isset($id_proyecto) ? '/' . $id_proyecto : '')) ?>">
        <div class="card-body">

					<!-- Proyecto -->
					<div class="form-group">
						<label for="id_proyecto">Proyecto</label>
						<select name="id_proyecto" id="id_proyecto" class="form-control" required>
							<option value="">Seleccione un proyecto</option>
							<?php foreach ($proyectos as $pro): ?>
								<option value="<?= $pro->id_proyecto ?>" <?= (isset($id_proyecto) && $id_proyecto == $pro->id_proyecto) ? 'selected' : '' ?>>
									<?= $pro->nombre ?>--<?= $pro->sede ?>
								</option>
							<?php endforeach; ?> 
						</select>
					</div>

					<!-- Material -->
					<div class="form-group">
						<label for="id_material">Material</label>
						<select name="id_material" id="id_material" class="form-control" required>
							<option value="">Seleccione un material</option>
							<?php foreach ($materiales as $mat): ?>
								<option value="<?= $mat->id_material ?>" <?= (isset($id_material) && $id_material == $mat->id_material) ? 'selected' : '' ?>>
									<?= $mat->remision ?> - <?= $mat->nombre_material ?> - <?= $mat->sede ?> - <?= $mat->descripcion ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>

					<!-- Cantidad -->
					<div class="form-group">
						<label for="cantidad">Cantidad a asignar</label>
						<input type="number" step="0.01" min="0" name="cantidad" id="cantidad"
								value="<?= isset($cantidad) ? $cantidad : '' ?>" class="form-control" required>
					</div>


        </div>

        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php 
  $this->load->view('layoutsc/footer'); 
?>



