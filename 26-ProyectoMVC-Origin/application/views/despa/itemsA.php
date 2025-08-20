<?php 
  $dataHeader['titulo'] = "Ingreso Item";
  $this->load->view('layoutsc/header', $dataHeader); 
?>
  <?php 
    $dataSidebar['session'] = $session;
    $dataSidebar['optionSelected'] = 'createItemsA';
    $this->load->view('layoutsc/sidebar', $dataSidebar); 
  ?>
<style>
  .border-dash-red {
    border: 2px dashed #E59232;
    padding: 25px;
    border-radius: 12px;
  }

  .border-dash-yellow {
    border: 2px dashed #E59232;
    padding: 25px;
    border-radius: 12px;
  }

  .form-control:focus {
    box-shadow: none;
  }

  .is-invalid + .invalid-feedback {
    display: block;
  }

  .btn-rounded {
    border-radius: 12px;
    padding: 10px 30px;
    font-weight: 500;
  }

  h2 {
    margin-bottom: 30px;
  }

  label {
    font-weight: 500;
  }
</style>

<div class="content-wrapper">
  
    <div class="container py-5">
		<h2 class="text-center mb-4 font-weight-bold">
			<?= isset($id_item) 
				? '<i class="nav-icon fa-solid fa-pencil" style="color: #0f58d7;"></i>  EDITAR ITEM' 
				: '<i class="nav-icon fa-solid fa-circle-plus" style="color: #0d5be3;"></i>  INGRESAR ITEM' 
			?>
		</h2>
		<?php if (isset($datosIncompletos) && $datosIncompletos): ?>
			<script>
			Swal.fire({
				icon: 'warning',
				title: 'Datos incompletos',
				text: 'Por favor, rellena todos los campos obligatorios antes de continuar.',
				confirmButtonColor: '#E59232'
			});
			</script>
		<?php endif; ?>
		<?php if (isset($datosValidos) && $datosValidos): ?>
			<script>
			Swal.fire({
				icon: 'success',
				title: '¡Éxito!',
				text: 'El material fue guardado correctamente.',
				confirmButtonColor: '#28a745'
			});
			</script>
		<?php endif; ?>
		<?php if (isset($editadoCorrectamente) && $editadoCorrectamente): ?>
		<script>
		Swal.fire({
			icon: 'info',
			title: '¡Editado correctamente!',
			text: 'El material fue actualizado con éxito.',
			confirmButtonColor: '#28a745'
		});
		</script>
		<?php endif; ?>
		<?php if (!empty($errorDuplicado)): ?>
		<script>
			Swal.fire({
				icon: 'error',
				title: 'Error',
				text: '<?= $errorDuplicado ?>',
				confirmButtonText: 'Entendido',
				confirmButtonColor: '#d33'
			});
		</script>
		<?php endif; ?>



		<form class="mx-auto" action="<?= base_url('index.php/despa/Items/createItemsA' . (isset($id_item) ? '/' . $id_item : '')) ?>" method="post">
		<div class="row justify-content-around">
			<div class="col-md-5 border-dash-red mb-4">

			<div class="form-group mt-4">
				<label for="nombre">ID ITEM</label>
				<input type="text" name="campo_id" class="form-control border-primary" id="nombre"
				value="<?= isset($id_item) ? $id_item : '' ?>" placeholder="Typing"
				style="text-transform: uppercase;"
				oninput="this.value = this.value.toUpperCase()">
				<small class="form-text text-muted">Assistive Text</small>
			</div>

			<div class="form-group mt-4">
				<label for="nombre">NOMBRE DEL MATERIAL</label>
				<input type="text" name="campo_nombre" class="form-control border-primary" id="nombre" value="<?= isset($nombre_material) ? $nombre_material : '' ?>" placeholder="Typing">
				<small class="form-text text-muted">Assistive Text</small>
			</div>

			<div class="form-group mt-4">
				<label for="unidad">PRESENTACION</label>
				<input type="text" name="campo_unidad" class="form-control border-primary" id="unidad" value="<?= isset($t_unidad) ? $t_unidad : '' ?>" placeholder="Typing">
				<small class="form-text text-muted">Assistive Text</small>
			</div>
				<div class="form-group mt-4">
					<label for="sede">SEDE</label>
					<select name="campo_sede" class="form-control border-primary <?= isset($datosIncompletos) && empty($sede) ? 'is-invalid' : '' ?>" id="sede" required>
						<option value="">Seleccione una sede</option>
						<option value="DESPACHO" <?= (isset($sede) && $sede == 'DESPACHO') ? 'selected' : '' ?>>DESPACHO</option>
					</select>
					<small class="form-text text-muted">Seleccione la sede correspondiente.</small>
				</div>


			</div>

			<div class="col-md-5 border-dash-yellow mb-4">
			<div class="form-group">
				<label for="presio">VALOR UNIDAD</label>
				<input type="number" step="0.01" name="campo_presio" class="form-control border-primary"
					id="pesio"
					value="<?= isset($precio_u) ? number_format((float)$precio_u, 2, '.', '') : '' ?>"
					placeholder="Typing">
			</div>

			<div class="form-group">
				<label for="descripcion">DESCRIPCION</label>
				<textarea name="campo_descripcion" class="form-control border-primary" rows="6" id="descripcion" placeholder="Typing"><?= isset($descripcion) ? $descripcion : '' ?></textarea>
			</div>
			</div>
		</div>

		<div class="text-center mt-3">
			<button type="submit" class="btn btn-warning btn-rounded">
				<?= isset($id_item) ? 'ACTUALIZAR' : 'INGRESAR' ?>
			</button>
		</div>
		</form>
    </div>
</div>
<?php 
  $this->load->view('layoutsc/footer'); 
?>
