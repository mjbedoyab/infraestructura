<?php 
  $dataHeader['titulo'] = "Ingresar Material";
  $this->load->view('layoutsc/header', $dataHeader); 

  $dataSidebar['session'] = $session;
  $dataSidebar['optionSelected'] = 'openListUsers';
  $this->load->view('layoutsc/sidebar', $dataSidebar); 
?>

<div class="content-wrapper">
    <div class="container py-4">
			<div class="card shadow rounded-3 p-4">
				<h2 class="text-center mb-4 font-weight-bold">Ingreso de Material</h2>

				<?php if ($this->session->flashdata('alert') == 'insert_ok'): ?>
				<script>
				Swal.fire({
					icon: 'success',
					title: 'Éxito',
					text: 'Material guardado correctamente.',
					confirmButtonText: 'Aceptar',
					confirmButtonColor: '#28a745'
				});
				</script>
				<?php elseif ($this->session->flashdata('alert') == 'update_ok'): ?>
				<script>
				Swal.fire({
					icon: 'success',
					title: 'Éxito',
					text: '✏️ Material actualizado correctamente.',
					confirmButtonText: 'Aceptar',
					confirmButtonColor: '#1068dbff'
				});
				</script>
				<?php elseif ($this->session->flashdata('alert') == 'incomplete'): ?>
				<script>
				Swal.fire({
					icon: 'warning',
					title: 'Campos incompletos',
					text: 'Por favor, complete todos los campos.',
					confirmButtonText: 'Aceptar',
					confirmButtonColor: '#f39c12'
				});
				</script>
				<?php elseif ($this->session->flashdata('alert') == 'invalid'): ?>
				<script>
				Swal.fire({
					icon: 'error',
					title: 'Valores inválidos',
					text: 'Por favor, ingrese valores numéricos válidos.',
					confirmButtonText: 'Reintentar',
					confirmButtonColor: '#e74c3c'
				});
				</script>
				<?php endif; ?>



				<form class="row" action="<?= base_url('index.php/despa/Material/creatematerial' . (isset($id_material) ? '/' . $id_material : '')) ?>" method="post">
					<?php if (isset($id_material)): ?>
						<input type="hidden" name="campo_id_material" value="<?= $id_material ?>">
					<?php endif; ?>

					<!-- INPUT HIDDEN id_item -->
					<input type="hidden" name="campo_id_item" id="campo_id_item" value="<?= $id_item ?? '' ?>">

					<div class="form-group col-md-6">
						<label for="campo_remision">Remisión</label>
						<input type="text" name="campo_remision" class="form-control" value="<?= $remision ?? '' ?>" required>
					</div>

					<div class="form-group col-md-6">
						<label for="campo_nombre_material">Nombre del material</label>
						<select name="campo_nombre_material" id="campo_nombre_material" class="form-control" required>
							<option value="">Seleccione un material</option>
							<?php foreach ($items as $item): ?>
								<option value="<?= $item->nombre_material ?>" 
									<?= (isset($nombre_material) && $nombre_material == $item->nombre_material) ? 'selected' : '' ?>
									data-id="<?= $item->id_item ?>"
									data-precio="<?= $item->precio_u ?>"
									data-descripcion="<?= $item->descripcion ?>"
									data-unidad="<?= $item->t_unidad ?>"
									data-sede="<?= $item->sede ?>"
								>
									<?= $item->nombre_material ?>--<?= $item->sede ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>

					<div class="form-group col-md-4">
						<label for="campo_unidad">Tipo de unidad</label>
						<input type="text" name="campo_unidad" id="campo_unidad" class="form-control" value="<?= $t_unidad ?? '' ?>" readonly required>
					</div>

					<div class="form-group col-md-4">
						<label for="campo_sede">Sede</label>
						<input type="text" name="campo_sede" id="campo_sede" class="form-control" value="<?= $sede ?? '' ?>" readonly required>
					</div>

					<div class="form-group col-md-4">
						<label for="campo_cantidad">Cantidad</label>
						<input type="number" name="campo_cantidad" id="campo_cantidad" class="form-control" value="<?= $cantidad ?? '' ?>" min="0" required>
					</div>

					<div class="form-group col-md-4">
						<label for="campo_precio">Precio Unitario</label>
						<input type="number" name="campo_precio" id="campo_precio" class="form-control" value="<?= $precio_u ?? '' ?>" step="0.01" min="0" readonly required>
					</div>

					<div class="form-group col-md-4">
						<label for="campo_total">Total</label>
						<input type="number" name="campo_total" id="campo_total" class="form-control" value="<?= $total_u ?? '' ?>" readonly>
					</div>

					<div class="form-group col-12">
						<label for="campo_descripcion">Descripción</label>
						<textarea name="campo_descripcion" id="campo_descripcion" class="form-control" readonly required><?= $descripcion ?? '' ?></textarea>
					</div>

					<div class="form-group col-md-6">
						<label for="campo_fecha">Fecha</label>
						<input type="date" name="campo_fecha" id="campo_fecha" class="form-control" value="<?= $fecha ?? '' ?>" required>
					</div>

					<div class="form-group col-12">
						<button type="submit" class="btn btn-primary btn-block">Guardar Material</button>
					</div>
				</form>
			</div>
		</div>
  </div>



<script>
  document.getElementById("campo_nombre_material").addEventListener("change", function () {
    const selected = this.options[this.selectedIndex];
    document.getElementById("campo_id_item").value = selected.getAttribute("data-id") || '';
    document.getElementById("campo_unidad").value = selected.getAttribute("data-unidad") || '';
    document.getElementById("campo_sede").value = selected.getAttribute("data-sede") || '';
    document.getElementById("campo_precio").value = selected.getAttribute("data-precio") || '';
    document.getElementById("campo_descripcion").value = selected.getAttribute("data-descripcion") || '';
    calcularTotal();
  });

  document.getElementById("campo_cantidad").addEventListener("input", calcularTotal);
  document.getElementById("campo_precio").addEventListener("input", calcularTotal);

  function calcularTotal() {
    const cantidad = parseFloat(document.getElementById("campo_cantidad").value) || 0;
    const precio = parseFloat(document.getElementById("campo_precio").value) || 0;
    document.getElementById("campo_total").value = (cantidad * precio).toFixed(2);
  }
</script>

<?php 
  $this->load->view('layoutsc/footer'); 
?>




