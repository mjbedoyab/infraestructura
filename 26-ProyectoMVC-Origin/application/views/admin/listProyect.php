<?php 
  $dataHeader['titulo'] = "list Proyect";
  $this->load->view('layouts/header', $dataHeader); 
?>

<?php 
  $dataSidebar['session'] = $session;
  $dataSidebar['optionSelected'] = 'litsProyect';
  $this->load->view('layouts/sidebar', $dataSidebar); 
?>

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="text-primary text-center flex-grow-1 m-0">LISTA DE PROYECTOS</h1>
    </div>
    <div class="col-12 m-0 p-2 bg-white">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header d-flex align-items-center">
                                <h3 class="card-title m-0">Lista Proyecto</h3>
                                <a href="<?= base_url('index.php/admin/Inicio/createProyect') ?>" 
                                   class="btn btn-outline-success ml-auto">
                                    <i class="nav-icon fa-solid fa-cash-register"></i> Crear Proyecto
                                </a>
                            </div>

                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>NOMBRE PROYECTO</th>
                                            <th>DEPARTAMENTO</th>
                                            <th>CIUDAD</th>
                                            <th>ENCARGADO D' PROYECTO</th>
                                            <th>SEDE</th>
                                            <th>ESTADO</th>
                                            <th>FECHA INICIAL</th>
                                            <th>FECHA FINAL</th>
                                            <th>EVIDENCIAS</th>
                                            <th>MATERIALES</th>
                                            <th>EDITAR</th>
                                            <th>ELIMINAR</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($proyectos)) : ?>
                                            <?php foreach ($proyectos as $proyecto) : ?>
                                                <tr>
                                                    <th scope="row"><?= $proyecto->id_proyecto ?></th>
                                                    <td><?= $proyecto->nombre ?></td>
                                                    <td><?= $proyecto->departamento ?></td>
                                                    <td><?= $proyecto->ciudad ?></td>
                                                    <td><?= $proyecto->encargado ?></td>
                                                    <td><?= $proyecto->sede ?></td>
                                                    <td><?= $proyecto->estado ?></td>
                                                    <td><?= $proyecto->fecha_inicio ?></td>
                                                    <td><?= $proyecto->fecha_final ?></td>
                                                    <td class="text-center">
                                                        <a href="<?= base_url('index.php/admin/Inicio/listEvidencias/' . $proyecto->id_proyecto) ?>" class="btn btn-outline-primary">
                                                            <i class="nav-icon fa-solid fa-box-archive" style="color: #2aac39;"></i>
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="<?= base_url('index.php/admin/Inicio/listarMaterialesProyecto/' . $proyecto->id_proyecto) ?>" class="btn btn-outline-warning">
                                                            <i class="nav-icon fa-solid fa-screwdriver-wrench" style="color: #f26507;"></i>
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="<?= base_url('index.php/admin/Proyecto/createProyect/' . $proyecto->id_proyecto) ?>" class="btn btn-outline-info">
                                                            <i class="nav-icon fa-solid fa-pen-nib" style="color: #0d58d9;"></i>
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="#" 
                                                           class="btn btn-outline-secondary btn-delete" 
                                                           data-url="<?= base_url('index.php/admin/Proyecto/borrar/' . $proyecto->id_proyecto) ?>">
                                                            <i class="nav-icon fa-solid fa-trash fa-fade" style="color: #e0400b;"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="13" class="text-center">No hay proyectos registrados</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
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
                text: "Esta acción eliminará el proyecto permanentemente.",
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
    <?php if ($this->session->flashdata('proyectoEliminado')): ?> 
        Swal.fire({
            title: '¡Eliminado!',
            text: 'El proyecto ha sido eliminado correctamente.',
            icon: 'success',
            confirmButtonText: 'Aceptar'
        });
    <?php endif; ?>
});
</script>

<!-- Main content -->


<?php 
  $this->load->view('layouts/footer'); 
?>
