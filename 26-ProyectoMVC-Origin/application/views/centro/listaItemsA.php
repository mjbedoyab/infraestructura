<?php 
  $dataHeader['titulo'] = "List Items";
  $this->load->view('layoutso/header', $dataHeader); 
?>

<?php 
  $dataSidebar['session'] = $session;
  $dataSidebar['optionSelected'] = 'listaItemsA';
  $this->load->view('layoutso/sidebar', $dataSidebar); 
?>

<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
		<div class="col-12 m-0 p-3">
			<h1 class="text-primary text-center">INVENTARIO DE ITEMS</h1>
		</div>
		<div class="col-12 m-0 p-2 bg-white">
			<section class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-12">

							<div class="card">
								<div class="card-header">
									<h3 class="card-title">ITEMS</h3>
								</div>
								<!-- /.card-header -->

								<div class="card-body">
									<table id="example1" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>ID</th>
												<th>NOMBRE MATERIAL</th>
												<th>PRESENTACIÓN</th>
												<th>VALOR UNIDAD</th>
												<th>SEDE</th>
												<th>DESCRIPCIÓN</th>
												<th>EDITAR</th>
												<th>ELIMINAR</th>
											</tr>
										</thead>
										<tbody>
											<?php if (!empty($items)) : ?>
												<?php foreach ($items as $key => $item) : ?>
													<tr>
														<th scope="row"><?php echo $item->id_item ?></th>
														<td><?php echo $item->nombre_material ?></td>
														<td><?php echo $item->t_unidad ?></td>
														<td><?php echo $item->precio_u ?></td>
														<td><?php echo $item->sede ?></td>
														<td><?php echo $item->descripcion ?></td>
														<td class="text-center">
															<a href="<?= base_url('index.php/centro/Items/createItemsA/' . $item->id_item) ?>" class="btn btn-outline-info">
																<i class="nav-icon fa-solid fa-pen-nib" style="color: #0d58d9;"></i>
															</a>
														</td>
														<td class="text-center">
															<a href="<?= base_url('index.php/centro/Items/borrar/' . $item->id_item) ?>" 
																class="btn btn-outline-secondary"
																onclick="return confirm('¿Estás seguro de que deseas eliminar este material?');">
																<i class="nav-icon fa-solid fa-trash fa-fade" style="color: #e0400b;"></i>
															</a>
														</td>
													</tr>
												<?php endforeach; ?>
											<?php else : ?>
												<tr>
													<td colspan="11" class="text-center">No hay personas registradas</td>
												</tr>
											<?php endif; ?>
										</tbody>
									</table>
								</div>
								<!-- /.card-body -->
							</div>

						</div>
						<!-- /.col -->
					</div>
					<!-- /.row -->
				</div>
				<!-- /.container-fluid -->
			</section>		
		</div>
	</div>
<!-- Main content -->
<script>
	// SweetAlert confirmación de borrado
	function confirmarEliminacion(id) {
		Swal.fire({
			title: '¿Estás seguro?',
			text: "Esta acción no se puede deshacer",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Sí, eliminar',
			cancelButtonText: 'Cancelar'
		}).then((result) => {
			if (result.isConfirmed) {
				window.location.href = "<?= base_url('index.php/centro/Items/borrar/') ?>" + id;
			}
		});
	}

	// SweetAlert después de eliminar (usando flashdata)
	<?php if ($this->session->flashdata('materialEliminado')): ?>
	Swal.fire({
		icon: 'success',
		title: 'Eliminado',
		text: 'El material se eliminó correctamente.',
		confirmButtonColor: '#3085d6',
		confirmButtonText: 'Aceptar'
	});
	<?php endif; ?>
</script>


<?php 
  $this->load->view('layoutso/footer'); 
?>
