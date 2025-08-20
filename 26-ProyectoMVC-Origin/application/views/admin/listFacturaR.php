<?php 
  $dataHeader['titulo'] = "List Factura Remision";
  $this->load->view('layouts/header', $dataHeader); 
?>

<?php 
  $dataSidebar['session'] = $session;
  $dataSidebar['optionSelected'] = 'listaFacturaR';
  $this->load->view('layouts/sidebar', $dataSidebar); 
?>


<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="text-primary text-center flex-grow-1 m-0">REMISION DE FACTURAS</h1>
    </div>
    <div class="col-12 m-0 p-2 bg-white">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header d-flex align-items-center">
                                <h3 class="card-title m-0">Remisión Facturas</h3>
                                <a href="<?= base_url('index.php/admin/Inicio/remisionFactura') ?>" 
                                   class="btn btn-outline-success ml-auto">
                                    <i class="nav-icon fa-solid fa-money-bill"></i> Remision Factura
                                </a>
                            </div>

                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>FACTURA</th>
                                            <th>REMISIÓN</th>
                                            <th>EDITAR</th>
                                            <th>ELIMINAR</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($remifacts)) : ?>
                                            <?php foreach ($remifacts as $remi) : ?>
                                                <tr>
                                                    <td><?= $remi->id ?></td>
                                                    <td><?= $remi->factura ?></td>
                                                    <td><?= $remi->remision ?></td>
                                                    <td class="text-center">
                                                        <a href="<?= base_url('index.php/admin/Factura/remisionFactura/' . $remi->id) ?>" 
                                                           class="btn btn-outline-info ">
                                                            <i class="nav-icon fa-solid fa-pen-nib" style="color: #0d58d9;"></i>
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="#" 
                                                           class="btn btn-outline-secondary  btn-delete" 
                                                           data-url="<?= base_url('index.php/admin/Factura/borrarRemi/' . $remi->id) ?>">
                                                        	<i class="nav-icon fa-solid fa-trash fa-fade" style="color: #e0400b;"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="5" class="text-center">No hay facturas registradas</td>
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
                text: "Esta acción eliminará la remisión de factura.",
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

    // Mensaje después de eliminar
    <?php if ($this->session->flashdata('remisionFacturaEliminado')): ?>
        Swal.fire({
            title: '¡Eliminado!',
            text: 'La remisión de factura ha sido eliminada correctamente.',
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
