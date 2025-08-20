<?php 
  $dataHeader['titulo'] = "List Usuario";
  $this->load->view('layouts/header', $dataHeader); 
?>

<?php 
  $dataSidebar['session'] = $session;
  $dataSidebar['optionSelected'] = 'openCrudAjax';
  $this->load->view('layouts/sidebar', $dataSidebar); 
?>

<!-- SweetAlert2 -->

<div class="content-wrapper">
  <div class="col-12 m-0 p-2 bg-white">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h1 class="text-primary text-center flex-grow-1 m-0">CONTACTOS</h1>
      <a href="<?= base_url('index.php/admin/Inicio/openCreateUser') ?>" class="btn btn-outline-success">
        <i class="nav-icon fa-solid fa-user-plus" style="color: #074d0fff;"></i> Crear Usuario
      </a>
    </div>

    <section class="content">
      <div class="card card-solid">
        <div class="card-body pb-0">
          <!-- Buscador centrado -->
          <div class="d-flex justify-content-center mb-3">
            <form action="<?= base_url('index.php/admin/Inicio/openCrudAjax') ?>" method="get" class="d-flex" style="max-width: 400px; width: 100%;">
              <input type="text" name="search" 
                class="form-control form-control-sm me-2" 
                placeholder="Buscar por nombre, apellido, correo o cédula"
                value="<?= isset($search) ? $search : '' ?>">
              <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-search"></i>
              </button>
            </form>
          </div>

          <div class="row">
            <?php if (!empty($personas)) : ?>
              <?php foreach($personas as $persona) : ?>
                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                  <div class="card bg-light d-flex flex-fill">
                    <div class="card-header text-muted border-bottom-0">
                      Digital Strategist
                    </div>
                    <div class="card-body pt-0">
                      <div class="row">
                        <div class="col-7">
                          <h2 class="lead"><b><?= $persona->nombres ?> <?= $persona->apellidos ?></b></h2>
                          <p class="text-muted text-sm"><b>Documento: </b><?= $persona->cedula ?></p>
                          <p class="text-muted text-sm"><b>Email: </b><?= $persona->email ?></p>
                          <ul class="ml-4 mb-0 fa-ul text-muted">
                            <li class="small">
                              <span class="fa-li"><i class="fas fa-lg fa-building"></i></span>
                              Dirección: <?= $persona->direccion ?>
                            </li>
                            <li class="small">
                              <span class="fa-li"><i class="fas fa-lg fa-phone"></i></span>
                              Teléfono: <?= $persona->telefono ?>
                            </li>
                          </ul>
                        </div>
                        <div class="col-5 text-center">
                          <img src="<?= base_url('uploads/fotos/' . ($persona->foto ?? 'default.png')) ?>" 
                               alt="user-avatar" 
                               class="img-circle img-fluid" 
                               style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                      </div>
                    </div>
                    <div class="card-footer">
                      <div class="d-flex justify-content-between">
                        <a href="<?= base_url('index.php/admin/Usuario/createUser?cedula=' . $persona->cedula); ?>" 
                           class="btn btn-outline-primary btn-sm">
                          <i class="nav-icon fa-solid fa-pen-nib"></i>
                        </a>
                        <a href="#" 
                           class="btn btn-outline-danger btn-sm btn-delete" 
                           data-url="<?= base_url('index.php/admin/Usuario/eliminarUsuario/' . $persona->cedula) ?>">
                          <i class="nav-icon fa-solid fa-trash fa-fade" ></i>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else : ?>
              <div class="col-12">
                <p class="text-center">No hay personas registradas</p>
              </div>
            <?php endif; ?>  
          </div>
        </div>

        <!-- Paginación dinámica -->
        <div class="card-footer">
          <?= $pagination ?>
        </div>
      </div>
    </section>
  </div>
</div>

<!-- Script SweetAlert -->
<script>
document.addEventListener("DOMContentLoaded", function() {
  // Confirmación antes de eliminar
  document.querySelectorAll('.btn-delete').forEach(function(button) {
    button.addEventListener('click', function(e) {
      e.preventDefault();
      const url = this.getAttribute('data-url');

      Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción eliminará el usuario permanentemente.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = url;
        }
      });
    });
  });

  // Mensaje de éxito después de eliminar
  <?php if ($this->session->flashdata('eliminado_ok')): ?>
    Swal.fire({
      title: '¡Eliminado!',
      text: 'El usuario ha sido eliminado correctamente.',
      icon: 'success',
      confirmButtonText: 'Aceptar'
    });
  <?php endif; ?>
});
</script>


<script src="<?= base_url('dist/js/my_script.js') ?>"></script>

<?php 
  $this->load->view('layouts/footer'); 
?>
