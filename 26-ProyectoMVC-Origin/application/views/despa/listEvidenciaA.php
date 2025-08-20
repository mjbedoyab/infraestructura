<?php 
  $dataHeader['titulo'] = "List Evidencia";
  $this->load->view('layoutsc/header', $dataHeader); 
?>

<?php 
  $dataSidebar['session'] = $session;
  $dataSidebar['optionSelected'] = 'listEvidencias';
  $this->load->view('layoutsc/sidebar', $dataSidebar); 
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <div class="col-12 m-0 p-3">
    <h1 class="text-primary text-center">LISTA EVIDENCIA</h1>
  </div>

  <div class="col-12 m-0 p-2 bg-white">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">EVIDENCIAS</h3>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="tablaEvidencias" class="table table-striped table-bordered">
                  <thead class="thead-dark">
                    <tr>
                      <th>ID</th>
                      <th>Nombre del Proyecto</th>
                      <th>Nombre de la Evidencia</th>
                      <th>Archivo</th>
					  <th>Borrar</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($evidencias as $ev): ?>
                      <tr>
                        <td><?= $ev->id ?></td>
                        <td><?= $ev->nombre_proyecto ?></td>
                        <td><?= $ev->nombre_evidencia ?></td>
                        <td>
                          <a href="<?= base_url('uploads/evidencias/' . $ev->evidencia) ?>" target="_blank" class="btn btn-outline-info">
                            <i class="nav-icon fa-solid fa-file fa-bounce" style="color: #da7e16;"></i> <?= $ev->evidencia ?>
                          </a>
                        </td>
												<td class="text-center">
													<a href="<?= base_url('index.php/despa/Proyecto/borrarEvidencia/' . $ev->id) ?>" class="btn btn-outline-danger">
														<i class="nav-icon fa-solid fa-trash fa-fade"></i>
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
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>		
  </div>
</div>

<?php if ($this->session->flashdata('eliminado_ok')): ?>
<script>
  Swal.fire({
    icon: 'success',
    title: '¡Eliminado!',
    text: '<?= $this->session->flashdata('eliminado_ok') ?>',
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Aceptar'
  });
</script>
<?php endif; ?>


<?php 
  $this->load->view('layoutsc/footer'); 
?>

