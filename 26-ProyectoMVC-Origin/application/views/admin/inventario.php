<?php 
  $dataHeader['titulo'] = "Inventario";
  $this->load->view('layouts/header', $dataHeader); 
?>

<?php 
  $dataSidebar['session'] = $session;
  $dataSidebar['optionSelected'] = 'openEditUser';
  $this->load->view('layouts/sidebar', $dataSidebar); 
?>

<!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
		<div class="col-12 m-0 p-3">
			<h1 class="text-primary text-center">INVENTARIO DE MATERIALES DISPONIBLES</h1>
		</div>
		<div class="col-12 m-0 p-2 bg-white">
			<section class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-12">

							<div class="card">
								<div class="card-header">
									<h3 class="card-title">MATERIALES</h3>
								</div>
								<!-- /.card-header -->

								<div class="card-body">
									<table id="example1" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>ID</th>
												<th>REMISIÓN</th>
												<th>NOMBRE MATERIAL</th>
												<th>PRESENTACIÓN</th>
												<th>SEDE</th>
												<th>CANTIDAD</th>
												<th>VALOR UNIDAD</th>
												<th>DESCRIPCIÓN</th>
												<th>TOTAL</th>
												<th>FECHA</th>
												<th>EDITAR</th>
												<th>ELIMINAR</th>
											</tr>
										</thead>
										<tbody>
											<?php if (!empty($inventarios)) : ?>
												<?php foreach ($inventarios as $key => $inventario) : ?>
													<tr>
														<th scope="row"><?php echo $inventario->id_material ?></th>
														<td><?php echo $inventario->remision ?></td>
														<td><?php echo $inventario->nombre_material ?></td>
														<td><?php echo $inventario->t_unidad ?></td>
														<td><?php echo $inventario->sede ?></td>
														<td><?php echo $inventario->cantidad ?></td>
														<td><?php echo $inventario->precio_u ?></td>
														<td><?php echo $inventario->descripcion ?></td>
														<td><?php echo $inventario->total_u ?></td>
														<td><?php echo $inventario->fecha ?></td>
														<td class="text-center">
															<a href="<?= base_url('index.php/admin/Material/creatematerial/' . $inventario->id_material) ?>" class="btn btn-outline-info">
																<i class="nav-icon fa-solid fa-pen-nib" style="color: #0d58d9;"></i>
															</a>
														</td>
														<td class="text-center">
															<a href="<?= base_url('index.php/admin/Material/borrar/' . $inventario->id_material) ?>" 
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


<?php if ($this->session->flashdata('materialEliminado')): ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Eliminado',
      text: 'El material ha sido eliminado correctamente.',
      confirmButtonText: 'Aceptar'
    });
  </script>
<?php endif; ?>

<?php 
  $this->load->view('layouts/footer'); 
?>


