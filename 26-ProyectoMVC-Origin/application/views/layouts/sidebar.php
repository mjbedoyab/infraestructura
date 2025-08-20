      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-success elevation-4">
        <!-- Brand Logo -->
        <a href="<?= base_url('index.php/admin/Inicio') ?>" class="brand-link">
          <img src="<?= base_url('dist/img/logo2.png') ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light"> Infraestructura</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="<?= base_url('uploads/fotos/'.$session['foto']) ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
              <a href="<?= base_url('index.php/admin/Usuario/createUsers?cedula=' . $session['cedula']) ?>" class="d-block"><?= explode(" ", $session['nombres'])[0]." ".explode(" ", $session['apellidos'])[0] ?></a>
            </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <li class="nav-header">MENU ADMIN</li>
							<li class="nav-item">
                <a href="<?= base_url('index.php/admin/Inicio/listaFactura') ?>" class="nav-link <?= ($optionSelected=='listaFactura')? 'active':'' ?> ">
                  <i class="nav-icon fa-solid fa-sliders" style="color: #ffffffff;"></i>
                  <p>
                    Lista Factura
                  </p>
                </a>
              </li>
							<li class="nav-item">
                <a href="<?= base_url('index.php/admin/Inicio/listaFacturaR') ?>" class="nav-link <?= ($optionSelected=='listaFacturaR')? 'active':'' ?> ">
                  <i class="nav-icon fa-solid fa-book" style="color: #ffffffff;"></i>
                  <p>
                    Lista R Factura
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('index.php/admin/Inicio/openListUsers') ?>" class="nav-link <?= ($optionSelected=='openListUsers')? 'active':'' ?> ">
                  <i class="nav-icon fa-solid fa-toolbox" style="color: #ffffffff;"></i>
                  <p>
                    Registrar Matrial
                  </p>
                </a>
              </li>
							<!--<li class="nav-item">
                <a href="<?= base_url('index.php/admin/Inicio/createProyect') ?>" class="nav-link <?= ($optionSelected=='createProyect')? 'active':'' ?> ">
                  <i class="nav-icon fa-solid fa-cash-register" style="color: #ffffffff;"></i>
                  <p>
                    Registrar Proyecto
                  </p>
                </a>
              </li>-->
              <li class="nav-item">
                <a href="<?= base_url('index.php/admin/Inicio/openEditUsers') ?>" class="nav-link <?= ($optionSelected=='openEditUser')? 'active':'' ?> ">
                  <i class="nav-icon fa-solid fa-warehouse" style="color: #ffffffff;"></i>
                  <p>
                    Inventario Material
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('index.php/admin/Inicio/openDeleteUsers') ?>" class="nav-link <?= ($optionSelected=='openDeleteUser')? 'active':'' ?> ">
                  <i class="nav-icon fa-solid fa-landmark" style="color: #ffffffff;"></i>
                  <p>
                    Historial Material
                  </p>
                </a>
              </li>
							<li class="nav-item">
                <a href="<?= base_url('index.php/admin/Inicio/litsProyect') ?>" class="nav-link <?= ($optionSelected=='litsProyect')? 'active':'' ?>  ">
                  <i class="nav-icon fa-solid fa-list-check" style="color: #ffffffff;"></i>
                  <p>
                    List Proyect
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('index.php/admin/Inicio/openCrudAjax') ?>" class="nav-link <?= ($optionSelected=='openCrudAjax')? 'active':'' ?> ">
                  <i class="nav-icon fa-solid fa-users" style="color: #ffffffff;"></i>
                  <p>
                    List Usuarios
                  </p>
                </a>
              </li>
							<li class="nav-item">
                <a href="<?= base_url('index.php/admin/Inicio/createEvidencia') ?>" class="nav-link  <?= ($optionSelected=='createEvidencia')? 'active':'' ?>">
                  <i class="nav-icon fa-solid fa-file-import" style="color: #ffffffff;"></i>
                  <p>
                    Subir Evidencia
                  </p>
                </a>
              </li>
							<li class="nav-item">
                <a href="<?= base_url('index.php/admin/Inicio/subirMaterialProyect') ?>" class="nav-link <?= ($optionSelected=='subirMaterialProyect')? 'active':'' ?>">
                  <i class="nav-icon fa-solid fa-box-archive" style="color: #ffffffff;"></i>
                  <p>
                    Subir materialproyect
                  </p>
                </a>
              </li>
							<li class="nav-item">
                <a href="<?= base_url('index.php/admin/Inicio/createItems') ?>" class="nav-link <?= ($optionSelected=='createItems')? 'active':'' ?>">
                  <i class="nav-icon fa-solid fa-satellite" style="color: #ffffffff;"></i>
                  <p>
                    Subir Items
                  </p>
                </a>
              </li>
							<li class="nav-item">
                <a href="<?= base_url('index.php/admin/Inicio/listaItems') ?>" class="nav-link <?= ($optionSelected=='listaItems')? 'active':'' ?>">
                  <i class="nav-icon fa-solid fa-list" style="color: #ffffffff;"></i>
                  <p>
                    Lista Items
                  </p>
                </a>
              </li>
							
              <li class="nav-item">
                <a href="<?= base_url('index.php/Login/cerrarSession') ?>" class="nav-link">
                  <i class="nav-icon fa-solid fa-right-to-bracket fa-fade" style="color: #d92612;"></i>
                  <p>
                    Cerrar Sesion
                  </p>
                </a>
              </li>

            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>
