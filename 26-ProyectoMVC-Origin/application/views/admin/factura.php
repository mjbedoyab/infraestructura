<?php 
$id_factura = $id_factura ?? null; // Evita el warning si no viene definida
$dataHeader['titulo'] = "Ingreso Factura";
$this->load->view('layouts/header', $dataHeader); 

$dataSidebar['session'] = $session;
$dataSidebar['optionSelected'] = 'createFactura';
$this->load->view('layouts/sidebar', $dataSidebar); 
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	

	<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
		<div class="card shadow-lg p-4" style="border: 2px dotted green; max-width: 400px; width: 100%;">
			
			<h4 class="text-center text-success mb-4">
				<?php echo $id_factura ? '<i class="fa-solid fa-pencil" style="color: #0f58d7;"></i> Editar Factura' : '<i class="fa-solid fa-file-invoice" style="color: #1866ec;"></i> Ingreso de Factura'; ?>
			</h4>

			<!-- SweetAlert2 -->
			<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 

			<?php if (!empty($datosIncompletos)): ?>
			<script>
			Swal.fire({
				icon: 'warning',
				title: 'Datos incompletos',
				text: '⚠️ Debe ingresar el número de factura.',
				confirmButtonText: 'Aceptar'
			});
			</script>
			<?php endif; ?>

			<?php if (!empty($datosValidos)): ?>
			<script>
			Swal.fire({
				icon: 'success',
				title: '¡Éxito!',
				text: 'Factura guardada correctamente.',
				confirmButtonColor: '#28a745'
				
			});
			</script>
			<?php endif; ?>

			<form action="<?php echo site_url('admin/Factura/createFactura' . ($id_factura ? '/' . $id_factura : '')); ?>" method="post">
				<div class="form-group">
					<label for="campo_factura" class="font-weight-bold">Número de Factura</label>
					<input type="text" 
						   class="form-control text-center" 
						   id="campo_factura" 
						   name="campo_factura" 
						   placeholder="Ingrese la factura" 
						   value="<?php echo set_value('campo_factura', $factura ?? ''); ?>"
						   required>
				</div>
				
				<div class="mt-4">
					<button type="submit" class="btn btn-success btn-block">
						<i class="fas fa-save"></i> Guardar Factura
					</button>
					<a href="<?php echo site_url('admin/Inicio/listaFactura'); ?>" class="btn btn-secondary btn-block">
						<i class="fas fa-arrow-left"></i> Volver
					</a>
				</div>
			</form>
		</div>
	</div>
</div>

<?php 
$this->load->view('layouts/footer'); 
?>

