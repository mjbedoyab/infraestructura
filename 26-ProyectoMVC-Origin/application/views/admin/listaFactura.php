<?php 
  $dataHeader['titulo'] = "list Factura";
  $this->load->view('layouts/header', $dataHeader); 
?>

<?php 
  $dataSidebar['session'] = $session;
  $dataSidebar['optionSelected'] = 'listaFactura';
  $this->load->view('layouts/sidebar', $dataSidebar); 
?>

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="text-primary text-center flex-grow-1 m-0">INVENTARIO DE FACTURAS</h1>
    </div>
    <div class="col-12 m-0 p-2 bg-white">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header d-flex align-items-center">
                                <h3 class="card-title m-0">Facturas</h3>
                                <a href="<?= base_url('index.php/admin/Inicio/createFactura') ?>" 
                                   class="btn btn-outline-success ml-auto">
                                    <i class="nav-icon fa-solid fa-money-bill"></i> Crear Factura
                                </a>
                            </div>

                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>FACTURA</th>
                                            <th>EDITAR</th>
                                            <th>ELIMINAR</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($facturas)) : ?>
                                            <?php foreach ($facturas as $factura) : ?>
                                                <tr>
                                                    <td><?= $factura->id_factura ?></td>
                                                    <td><?= $factura->factura ?></td>
                                                    <td class="text-center">
                                                        <a href="<?= base_url('index.php/admin/Factura/createFactura/' . $factura->id_factura) ?>" 
                                                           class="btn btn-outline-info">
                                                            <i class="nav-icon fa-solid fa-pen-nib" style="color: #0d58d9;"></i>
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="#" 
                                                           class="btn btn-outline-secondary  btn-delete" 
                                                           data-url="<?= base_url('index.php/admin/Factura/borrar/' . $factura->id_factura) ?>">
                                                            <i class="nav-icon fa-solid fa-trash fa-fade" style="color: #e0400b;"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="4" class="text-center">No hay facturas registradas</td>
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
    // Confirmación antes de borrar
    document.querySelectorAll('.btn-delete').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.getAttribute('data-url');

            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción eliminará la factura permanentemente.",
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
    <?php if ($this->session->flashdata('FacturaEliminado')): ?>
        Swal.fire({
            title: '¡Eliminado!',
            text: 'La factura ha sido eliminada correctamente.',
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
