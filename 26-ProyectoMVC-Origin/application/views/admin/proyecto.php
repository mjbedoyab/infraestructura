<?php 
  $dataHeader['titulo'] = "Ingresar Proyecto";
  $this->load->view('layouts/header', $dataHeader); 
?>

<?php 
  $dataSidebar['session'] = $session;
  $dataSidebar['optionSelected'] = 'createProyect';
  $this->load->view('layouts/sidebar', $dataSidebar); 
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <div class="container py-5">
        <h2 class="text-center mb-4 font-weight-light">
			<?= isset($id_proyecto) 
				? '<i class="nav-icon fa-solid fa-pencil" style="color: #0f58d7;"></i>  EDITAR PROYECTO' 
				: '<i class="nav-icon fa-solid fa-folder-plus" style="color: #1962e1;"></i>  INGRESAR NUEVO PROYECTO' 
			?>
		</h2>


        <!-- Alerta con SweetAlert2 -->
		        <?php if (isset($datosIncompletos) && $datosIncompletos): ?>
            <script>
            Swal.fire({
                icon: 'error',
                title: 'Campos incompletos',
                text: 'Todos los campos son obligatorios.',
                confirmButtonColor: '#d33'
            });
            </script>
        <?php endif; ?>

        <?php if (isset($datosValidos) && $datosValidos): ?>
            <script>
            Swal.fire({
                icon: 'success',
                title: 'Proyecto guardado',
                text: 'El proyecto ha sido guardado correctamente.',
                confirmButtonColor: '#28a745'
            });
            </script>
        <?php endif; ?>


        <!-- Formulario -->
        <form class="mx-auto" action="<?= base_url('index.php/admin/Proyecto/createProyect' . (isset($id_proyecto) ? '/' . $id_proyecto : '')); ?>" method="POST">
            <div class="row justify-content-center d-flex align-items-stretch">
                <!-- Columna izquierda -->
                <div class="col-md-5 mb-4 d-flex">
                    <fieldset class="border p-4 rounded w-100 h-100" style="border: 2px dashed #dda0dd;">
                        <legend class="w-auto px-2" style="color: #dda0dd; font-size: 14px;">💠 DETALLES DEL PROYECTO</legend>

                        <div class="form-group">
                            <label for="campo_nombre">Nombres del Proyecto</label>
                            <input type="text" class="form-control" id="campo_nombre" name="campo_nombre" value="<?= isset($nombre) ? $nombre : '' ?>" placeholder="Type here">
                        </div>

                        <div class="form-group">
                            <label for="campo_departamento">Departamento</label>
                            <input type="text" class="form-control" id="campo_departamento" name="campo_departamento" value="<?= isset($departamento) ? $departamento : '' ?>" placeholder="Typing |">
                        </div>

                        <div class="form-group">
                            <label for="campo_ciudad">Ciudad</label>
                            <input type="text" class="form-control" id="campo_ciudad" name="campo_ciudad" value="<?= isset($ciudad) ? $ciudad : '' ?>" placeholder="Typing |">
                        </div>

                        <div class="form-group">
                            <label for="campo_encargado">Persona Encargada</label>
                            <input type="text" class="form-control" id="campo_encargado" name="campo_encargado" value="<?= isset($encargado) ? $encargado : '' ?>" placeholder="Typing |">
                        </div>
                    </fieldset>
                </div>

                <!-- Columna derecha -->
                <div class="col-md-5 mb-4 d-flex">
                    <fieldset class="border p-4 rounded w-100 h-100" style="border: 2px dashed #f4a460;">
                        <legend class="w-auto px-2" style="color: #f4a460; font-size: 14px;">💠 DETALLES DEL PROYECTO</legend>

                        <div class="form-group">
							<label for="campo_sede">Sede</label>
							<select class="form-control" id="campo_sede" name="campo_sede">
								<option value="AGROPECUARIO" <?= isset($sede) && $sede == "AGROPECUARIO" ? 'selected' : '' ?>>AGROPECUARIO</option>
								<option value="DESPACHO" <?= isset($sede) && $sede == "DESPACHO" ? 'selected' : '' ?>>DESPACHO</option>
								<option value="CENTRO" <?= isset($sede) && $sede == "CENTRO" ? 'selected' : '' ?>>CENTRO</option>
							</select>
						</div>


                        <div class="form-group">
                            <label for="campo_estado">Estado</label>
                            <select class="form-control" id="campo_estado" name="campo_estado">
                                <option value="PENDIENTE" <?= isset($estado) && $estado == "PENDIENTE" ? 'selected' : '' ?>>PENDIENTE</option>
                                <option value="ENPROCESO" <?= isset($estado) && $estado == "ENPROCESO" ? 'selected' : '' ?>>ENPROCESO</option>
                                <option value="FINALIZADO" <?= isset($estado) && $estado == "FINALIZADO" ? 'selected' : '' ?>>FINALIZADO</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="campo_fecha_inicial">Fecha Inicio</label>
                            <input type="date" class="form-control" id="campo_fecha_inicial" name="campo_fecha_inicial" value="<?= isset($fecha_inicio) ? $fecha_inicio : '' ?>">
                        </div>

                        <div class="form-group">
                            <label for="campo_fecha_final">Fecha Fin</label>
                            <input type="date" class="form-control" id="campo_fecha_final" name="campo_fecha_final" value="<?= isset($fecha_final) ? $fecha_final : '' ?>">
                        </div>
                    </fieldset>
                </div>
            </div>

            <!-- Botón -->
            <div class="text-center">
                <button type="submit" class="btn px-5 py-2" style="background-color: #f4a460; color: white; font-weight: bold;">INGRESAR</button>
            </div>
        </form>
    </div>
</div>

<?php 
  $this->load->view('layouts/footer'); 
?>


