<?php 
  $dataHeader['titulo'] = "Remisiones Factura";
  $this->load->view('layouts/header', $dataHeader); 
?>

<?php 
  $dataSidebar['session'] = $session;
  $dataSidebar['optionSelected'] = 'remisionFactura';
  $this->load->view('layouts/sidebar', $dataSidebar); 
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	
	<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
		<div class="card shadow-lg p-4" style="border: 2px dotted green; max-width: 400px; width: 100%;">

			<h4 class="text-center text-success mb-4">
				<?php echo isset($id) && $id
					? '<i class="fa-solid fa-pencil" style="color: #0f58d7;"></i> Editar Factura Remision' 
					: '<i class="fa-solid fa-receipt" style="color: #155ad1;"></i> Ingreso de Factura Remision'; ?>
			</h4>
				

			<form action="<?= base_url('index.php/admin/Factura/remisionFactura' . (isset($id) ? '/' . $id : '')) ?>" method="post">
				<div class="form-group">
					<label for="campo_factura" class="font-weight-bold">Número de Factura</label>
					<select name="campo_factura" id="campo_factura" class="form-control" required>
						<option value="">Seleccione una factura</option>
						<?php foreach ($facturas as $factura): ?>
							<option value="<?= $factura->id_factura ?>" <?= (isset($id_factura) && $id_factura == $factura->id_factura) ? 'selected' : '' ?>>
								<?= $factura->factura ?>
							</option>
						<?php endforeach; ?> 
					</select>
				</div>

				<div class="form-group">
					<label for="campo_remision" class="font-weight-bold">Número de Remisión</label>
					<select name="campo_remision" id="campo_remision" class="form-control" required>
						<option value="">Seleccione una remisión</option>
						<?php foreach ($inventarios as $inventario): ?>
							<option value="<?= $inventario->id_material ?>" 
								<?= (isset($id_material) && $id_material == $inventario->id_material) ? 'selected' : '' ?>>
								<?= $inventario->remision ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				
				<div class="mt-4">
					<button type="submit" class="btn btn-success btn-block">
						<i class="fas fa-save"></i> Guardar Factura
					</button>
					<a href="<?= base_url('index.php/admin/Inicio/listaFacturaR') ?>" class="btn btn-secondary btn-block">
						<i class="fas fa-arrow-left"></i> Volver
					</a>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
<?php if ($this->session->flashdata('success')): ?>
	Swal.fire({
		icon: 'success',
		title: 'Éxito',
		text: '<?= $this->session->flashdata('success'); ?>',
		confirmButtonColor: '#28a745'
	});
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
	Swal.fire({
		icon: 'error',
		title: 'Error',
		text: '<?= $this->session->flashdata('error'); ?>',
		confirmButtonColor: '#d3750bff'
	});
<?php endif; ?>
</script>

<?php 
  $this->load->view('layouts/footer'); 
?>
