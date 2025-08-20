<?php 
  $dataHeader['titulo'] = "Crear o Editar Usuario";
  $this->load->view('layouts/header', $dataHeader); 
?>
<?php 
  $dataSidebar['session'] = $session;
  $dataSidebar['optionSelected'] = 'openCreateUser';
  $this->load->view('layouts/sidebar', $dataSidebar); 
?>

<div class="content-wrapper">
  <div class="col-12 m-0 p-3">
    <div class="col-12 m-0 p-3">
      <h1 class="text-primary text-center">
        <?= isset($persona) ? '<i class="nav-icon fa-solid fa-pencil" style="color: #0f58d7;"></i>  EDITAR USUARIO' : '<i class="nav-icon fa-solid fa-user-astronaut" style="color: #1962e1;"></i>  INGRESAR USUARIO' ?>
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

    <?php if (isset($insertado)) : ?>
      <script>
        Swal.fire({
          icon: 'success',
          title: 'Usuario ingresado',
          text: '✅ Usuario ingresado exitosamente.',
          confirmButtonColor: '#28a745'
        });
      </script>
    <?php elseif (isset($editado)) : ?>
      <script>
        Swal.fire({
          icon: 'info',
          title: 'Usuario editado',
          text: '✏️ Usuario editado exitosamente.',
          confirmButtonColor: '#17a2b8'
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


    <div class="row justify-content-center">
      <form class="mx-auto" action="<?= base_url('index.php/admin/Usuario/createUser') ?>" method="POST" enctype="multipart/form-data">
        
        <input type="hidden" name="modo" value="<?= isset($persona) ? 'editar' : 'crear' ?>">

        <div class="row justify-content-center d-flex align-items-stretch">
          <!-- FOTO -->
          <div class="col-md-6 mb-4 d-flex">
            <fieldset class="border p-4 rounded w-100 h-100 text-center" style="border: 2px dashed #dda0dd;">
              <legend class="w-auto px-2" style="color: #dda0dd; font-size: 14px;">💠 FOTO</legend>

              <label class="form-label mb-2" for="evidencia">Foto</label>
              <div class="d-flex justify-content-center mb-3">
                <img id="previewFoto" 
                     src="<?= isset($persona) && $persona->foto ? base_url('uploads/fotos/' . $persona->foto) : base_url('dist/img/user1-128x128.jpg') ?>" 
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
                         value="<?= isset($persona) ? $persona->cedula : '' ?>" required>
									<input type="hidden" name="cedula_original" value="<?= isset($persona) ? $persona->cedula : '' ?>">
			 
                </div>
                <div class="col">
                  <label for="new_nombres" class="form-label"><i class="fas fa-user"></i> Nombres</label>
                  <input type="text" class="form-control" id="new_nombres" name="new_nombres"
                         value="<?= isset($persona) ? $persona->nombres : '' ?>" required>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col">
                  <label for="new_apellidos" class="form-label"><i class="fas fa-user"></i> Apellidos</label>
                  <input type="text" class="form-control" id="new_apellidos" name="new_apellidos"
                         value="<?= isset($persona) ? $persona->apellidos : '' ?>" required>
                </div>
                <div class="col">
                  <label for="new_telefono" class="form-label"><i class="fas fa-phone"></i> Teléfono</label>
                  <input type="tel" class="form-control" id="new_telefono" name="new_telefono"
                         value="<?= isset($persona) ? $persona->telefono : '' ?>">
                </div>
              </div>

              <div class="row mb-3">
                <div class="col">
                  <label for="new_direccion" class="form-label"><i class="fas fa-map-marker-alt"></i> Dirección</label>
                  <input type="text" class="form-control" id="new_direccion" name="new_direccion"
                         value="<?= isset($persona) ? $persona->direccion : '' ?>">
                </div>
              </div>

              <div class="row mb-3">
									<div class="col">
										<label for="new_correo" class="form-label"><i class="fas fa-envelope"></i> Correo</label>
										<input type="email" class="form-control" id="new_correo" name="new_correo"
													value="<?= isset($persona) ? $persona->email : '' ?>" required>
									</div>
									<div class="col position-relative">
										<label for="new_password" class="form-label">
												<i class="fas fa-lock"></i> Password
										</label>
										<div class="input-group">
												<input type="password" class="form-control" id="new_password" name="new_password" value="">
												<button type="button" class="btn btn-outline-secondary" id="togglePassword">
														<i class="fas fa-eye"></i>
												</button>
										</div>
										<small class="text-muted">Dejar vacío si no deseas cambiarla.</small>
								  </div>
							</div>

							<div class="row mb-3">
								<div class="col">
									<label for="new_tipo" class="form-label"><i class="fas fa-user"></i> Tipo</label>
									<select class="form-control" id="new_tipo" name="new_tipo">
										<option value="CENTRO" <?= (isset($usuario) && $usuario->tipo == 'CENTRO') ? 'selected' : '' ?>>CENTRO</option>
										<option value="DESPACHO" <?= (isset($usuario) && $usuario->tipo == 'DESPACHO') ? 'selected' : '' ?>>DESPACHO</option>
										<option value="AGROPECUARIO" <?= (isset($usuario) && $usuario->tipo == 'AGROPECUARIO') ? 'selected' : '' ?>>AGROPECUARIO</option>
										<option value="ADMIN" <?= (isset($usuario) && $usuario->tipo == 'ADMIN') ? 'selected' : '' ?>>ADMINISTRADOR</option>
									</select>
								</div>
							</div>

            </fieldset>
          </div>
        </div>

        <div class="text-center">
          <button type="submit" class="btn btn-warning btn-rounded px-5 py-2" style="background-color: #f4a460; color: white; font-weight: bold;">
            <?= isset($persona) ? 'ACTUALIZAR' : 'INGRESAR' ?>
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
</script>
<script>
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
  $this->load->view('layouts/footer'); 
?>

