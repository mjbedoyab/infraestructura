<?php 
  $dataHeader['titulo'] = " Perfil";
  $this->load->view('layoutss/header', $dataHeader); 
?>
<?php 
  $dataSidebar['session'] = $session;
  $dataSidebar['optionSelected'] = '';
  $this->load->view('layoutss/sidebar', $dataSidebar); 
?>

<div class="content-wrapper">
  <div class="col-12 m-0 p-3">
    <div class="col-12 m-0 p-3">
      <h1 class="text-primary text-center">
        <i class="nav-icon fa-solid fa-pencil" style="color: #0f58d7;"></i> Editar Perfil
      </h1>
    </div>

    <?php if (!empty($upload_error)) : ?>
      <script>
        Swal.fire({
          icon: 'error',
          title: 'Error de carga',
          text: '<?= $upload_error ?>',
          confirmButtonColor: '#d33'
        });
      </script>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
      <script>
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: '<?= $error ?>',
          confirmButtonColor: '#d33'
        });
      </script>
    <?php endif; ?>

    <?php if ($editado): ?>
      <script>
        Swal.fire({
          icon: 'info',
          title: 'Perfil actualizado',
          text: 'Los cambios se guardaron correctamente.',
          confirmButtonColor: '#28a745'
        });
      </script>
    <?php endif; ?>

    <div class="row justify-content-center">
      <form class="mx-auto" action="<?= base_url('index.php/agrope/Usuario/createUser') ?>" method="POST" enctype="multipart/form-data">
        
        <div class="row justify-content-center d-flex align-items-stretch">
          <!-- FOTO -->
          <div class="col-md-6 mb-4 d-flex">
            <fieldset class="border p-4 rounded w-100 h-100 text-center" style="border: 2px dashed #dda0dd;">
              <legend class="w-auto px-2" style="color: #dda0dd; font-size: 14px;">💠 FOTO</legend>

              <div class="d-flex justify-content-center mb-3">
                <img id="previewFoto" 
                     src="<?= $persona->foto ? base_url('uploads/fotos/' . $persona->foto) : base_url('dist/img/user1-128x128.jpg') ?>" 
                     alt="user-avatar" 
                     class="img-circle img-fluid" 
                     style="width: 120px; height: 120px; object-fit: cover;">
              </div>

              <div class="mb-3">
                <label class="form-label">Archivo (jpg, jpeg, png...)</label>
                <div class="d-flex justify-content-center">
                  <label class="btn btn-outline-primary">
                    <i class="fas fa-upload"></i> Seleccionar archivo
                    <input type="file" name="evidencia" id="evidencia" accept=".jpg,.jpeg,.png,.webp,.svg" hidden>
                  </label>
                </div>
              </div>
            </fieldset>
          </div>

          <!-- DATOS -->
          <div class="col-md-6 mb-4 d-flex">
            <fieldset class="border p-4 rounded w-100 h-100" style="border: 2px dashed #f4a460;">
              <legend class="w-auto px-2" style="color: #f4a460; font-size: 14px;">💠 DATOS PERSONALES</legend>

              <div class="row mb-3">
                <div class="col">
                  <label for="new_cedula" class="form-label"><i class="fas fa-id-card"></i> Cédula</label>
                  <input type="number" class="form-control" id="new_cedula" name="new_cedula"
                         value="<?= $persona->cedula ?>" readonly>
                </div>
                <div class="col">
                  <label for="new_nombres" class="form-label"><i class="fas fa-user"></i> Nombres</label>
                  <input type="text" class="form-control" id="new_nombres" name="new_nombres"
                         value="<?= $persona->nombres ?>" required>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col">
                  <label for="new_apellidos" class="form-label"><i class="fas fa-user"></i> Apellidos</label>
                  <input type="text" class="form-control" id="new_apellidos" name="new_apellidos"
                         value="<?= $persona->apellidos ?>" required>
                </div>
                <div class="col">
                  <label for="new_telefono" class="form-label"><i class="fas fa-phone"></i> Teléfono</label>
                  <input type="tel" class="form-control" id="new_telefono" name="new_telefono"
                         value="<?= $persona->telefono ?>">
                </div>
              </div>

              <div class="row mb-3">
                <div class="col">
                  <label for="new_direccion" class="form-label"><i class="fas fa-map-marker-alt"></i> Dirección</label>
                  <input type="text" class="form-control" id="new_direccion" name="new_direccion"
                         value="<?= $persona->direccion ?>">
                </div>
              </div>

              <div class="row mb-3">
                <div class="col">
                  <label for="new_correo" class="form-label"><i class="fas fa-envelope"></i> Correo</label>
                  <input type="email" class="form-control" id="new_correo" name="new_correo"
                         value="<?= $persona->email ?>" required>
                </div>
                <div class="col position-relative">
                  <label for="new_password" class="form-label">
                      <i class="fas fa-lock"></i> Password
                  </label>
                  <div class="input-group">
                      <input type="password" class="form-control" id="new_password" name="new_password">
                      <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                          <i class="fas fa-eye"></i>
                      </button>
                  </div>
                  <small class="text-muted">Dejar vacío si no deseas cambiarla.</small>
                </div>
              </div>

            </fieldset>
          </div>
        </div>

        <div class="text-center">
          <button type="submit" class="btn btn-warning btn-rounded px-5 py-2" style="background-color: #f4a460; color: white; font-weight: bold;">
            ACTUALIZAR PERFIL
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  document.getElementById('evidencia').addEventListener('change', function (event) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        document.getElementById('previewFoto').src = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  });

  document.getElementById("togglePassword").addEventListener("click", function () {
    const passwordInput = document.getElementById("new_password");
    const icon = this.querySelector("i");

    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      icon.classList.remove("fa-eye");
      icon.classList.add("fa-eye-slash");
    } else {
      passwordInput.type = "password";
      icon.classList.remove("fa-eye-slash");
      icon.classList.add("fa-eye");
    }
  });
</script>

<?php 
  $this->load->view('layoutss/footer'); 
?>


