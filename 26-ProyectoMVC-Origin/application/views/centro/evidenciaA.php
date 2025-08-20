<?php 
  $dataHeader['titulo'] = "Ingresar Evidencia";
  $this->load->view('layoutso/header', $dataHeader); 
?>

<?php 
  $dataSidebar['session'] = $session;
  $dataSidebar['optionSelected'] = 'createEvidencia';
  $this->load->view('layoutso/sidebar', $dataSidebar); 
?>

<div class="content-wrapper">
  <div class="col-12 m-0 p-3">
    <h2 class="text-primary text-center"><i class="fa-solid fa-folder-open" style="color: #0e5ce1;"></i> INGRESAR EVIDENCIA</h2> 
  </div>

  <div class="container mt-5">
    <!-- FORMULARIO HTML PURO PARA SUBIR ARCHIVOS -->
    <form action="<?= base_url('index.php/centro/Proyecto/createEvidencias'); ?>" method="POST" enctype="multipart/form-data">

      <div class="form-group">
        <label for="id_proyecto">Proyecto:</label>
        <select name="id_proyecto" class="form-control" required>
          <option value="">Seleccione un proyecto</option>
          <?php foreach ($proyectos as $proy): ?>
            <option value="<?= $proy->id_proyecto ?>"><?= $proy->nombre ?>--<?= $proy->sede ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label for="nombre_evidencia">Nombre de la evidencia:</label>
        <input type="text" name="nombre_evidencia" class="form-control" required>
      </div>

      <div class="form-group">
        <label for="evidencia">Archivo (Word, Excel y Pdf):</label>
        <input type="file" name="evidencia" class="form-control-file" accept=".doc,.docx,.xls,.xlsx,.pdf" required>
      </div>

      <button type="submit" class="btn btn-primary btn-block">Subir Evidencia</button>
    </form>
  </div>
</div>

<!-- SweetAlert para mensajes -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (isset($datosValidos) && $datosValidos): ?>
  <script>
    Swal.fire({
      title: '¡Guardado!',
      text: 'La evidencia fue registrada correctamente.',
      icon: 'success',
      confirmButtonText: 'Aceptar'
    });
  </script>
<?php endif; ?>

<?php if (isset($datosIncompletos) && $datosIncompletos): ?>
  <script>
    Swal.fire({
      title: 'Campos incompletos',
      text: 'Por favor, completa todos los campos obligatorios.',
      icon: 'error',
      confirmButtonText: 'OK'
    });
  </script>
<?php endif; ?>

<?php if (isset($upload_error)): ?>
  <script>
    Swal.fire({
      title: 'Error al subir archivo',
      html: `<?= $upload_error ?>`,
      icon: 'error',
      confirmButtonText: 'OK'
    });
  </script>
<?php endif; ?>

<?php 
  $this->load->view('layoutso/footer'); 
?>


