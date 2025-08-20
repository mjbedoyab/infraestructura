<?php 
  $dataHeader['titulo'] = "List Material Proyect";
  $this->load->view('layoutso/header', $dataHeader); 
?>

<?php 
  $dataSidebar['session'] = $session;
  $dataSidebar['optionSelected'] = 'listarMaterialesProyecto';
  $this->load->view('layoutso/sidebar', $dataSidebar); 
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <div class="col-12 m-0 p-3">
    <h1 class="text-primary text-center">LISTA DE MATERIALES PARA PROYECTO</h1>
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

              <div class="card-body">
					<table id="example1" class="table table-bordered table-striped">
					<thead>
						<tr>
						<th>Proyecto</th>
						<th>Remisión</th>
						<th>Material</th>
						<th>Presentacion</th>
						<th>sede</th>
						<th>Precio Unitario</th>
						<th>Descripción</th>
						<th>Cantidad</th>
						<th>Total</th>
						<th>Editar</th>
						<th>Borrar</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($materiales_proyecto as $mp): ?>
						<tr>
							<td><?php echo $mp->nombre_proyecto ?></td>
							<td><?php echo $mp->remision ?></td>
							<td><?php echo $mp->nombre_material ?></td>
							<td><?php echo $mp->t_unidad ?></td>
							<td><?php echo $mp->sede ?></td>
							<td>$<?php echo number_format($mp->precio_u, 0, ',', '.') ?></td>
							<td><?php echo $mp->descripcion ?></td>
							<td><?php echo $mp->cantidad ?></td>
							<td>$<?php echo number_format($mp->total, 0, ',', '.') ?></td>
							<td class="text-center">
							    <a href="<?= base_url('index.php/centro/Proyecto/insertarMaterialProyecto?id_proyecto=' . $mp->id_proyecto . '&id_material=' . $mp->id_material) ?>"
									class="btn btn-outline-info">
									<i class="nav-icon fa-solid fa-pen-nib" style="color: #0d58d9;"></i>
								</a>

							</td>
							<td class="text-center">
							<a href="<?= base_url('index.php/centro/Proyecto/borrarMaterialProyecto/'  . $mp->id_proyecto . '/' . $mp->id_material) ?>" 
								class="btn btn-outline-secondary" 
								onclick="return confirm('¿Estás seguro de que deseas eliminar este material?');">
								<i class="nav-icon fa-solid fa-trash fa-fade" style="color: #e0400b;"></i>
							</a>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
					</table>
              </div>
              <!-- /.card-body -->
            </div>

          </div>
        </div>
      </div>
    </section>		
  </div>
</div>

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
  $this->load->view('layoutso/footer'); 
?>

