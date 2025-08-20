<?php 
  $dataHeader['titulo'] = "INICIO";
  $this->load->view('layouts/header', $dataHeader); 
?>

<?php 
  $dataSidebar['session'] = $session;
  $dataSidebar['optionSelected'] = '';
  $this->load->view('layouts/sidebar', $dataSidebar); 
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <div class="col-12 m-0 p-3">
    <h1 class="text-primary text-center">INICIO DEL USUARIO</h1>
  </div>

	<section class="content">

	
  <div class="row ">
    <!-- Proyectos Agropecuario -->
    <div class="col-lg-3 col-6">
      <div class="small-box bg-success">
        <div class="inner">
          <h3><?= $proy_agro ?></h3>
          <p>Proyectos Agropecuarios</p>
        </div>
        <div class="icon"><i class="fas fa-tractor"></i></div>
      </div>
    </div>

    <!-- Proyectos Despacho -->
    <div class="col-lg-3 col-6">
      <div class="small-box bg-info">
        <div class="inner">
          <h3><?= $proy_despacho ?></h3>
          <p>Proyectos Despacho</p>
        </div>
        <div class="icon"><i class="fas fa-truck"></i></div>
      </div>
    </div>

    <!-- Proyectos Centro -->
    <div class="col-lg-3 col-6">
      <div class="small-box bg-warning">
        <div class="inner">
          <h3><?= $proy_centro ?></h3>
          <p>Proyectos Centro</p>
        </div>
        <div class="icon"><i class="fas fa-building"></i></div>
      </div>
    </div>

    <!-- Total Proyectos -->
    <div class="col-lg-3 col-6">
      <div class="small-box bg-primary">
        <div class="inner">
          <h3><?= $proy_total ?></h3>
          <p>Total de Proyectos</p>
        </div>
        <div class="icon"><i class="fas fa-list"></i></div>
      </div>
    </div>

    <!-- Proyectos Pendientes -->
    <div class="col-lg-3 col-6">
      <div class="small-box bg-secondary">
        <div class="inner">
          <h3><?= $proy_pend ?></h3>
          <p>Proyectos Pendientes</p>
        </div>
        <div class="icon"><i class="fas fa-hourglass-half"></i></div>
      </div>
    </div>

    <!-- Proyectos en Proceso -->
    <div class="col-lg-3 col-6">
      <div class="small-box bg-orange">
        <div class="inner">
          <h3><?= $proy_proceso ?></h3>
          <p>Proyectos en Proceso</p>
        </div>
        <div class="icon"><i class="fas fa-cogs"></i></div>
      </div>
    </div>

    <!-- Proyectos Finalizados -->
    <div class="col-lg-3 col-6">
      <div class="small-box bg-teal">
        <div class="inner">
          <h3><?= $proy_final ?></h3>
          <p>Proyectos Finalizados</p>
        </div>
        <div class="icon"><i class="fas fa-check-circle"></i></div>
      </div>
    </div>

    <!-- Usuarios Activos -->
    <div class="col-lg-3 col-6">
      <div class="small-box bg-success">
        <div class="inner">
          <h3><?= $usuarios_activos ?></h3>
          <p>Usuarios Activos</p>
        </div>
        <div class="icon"><i class="fas fa-users"></i></div>
      </div>
    </div>

    <!-- Usuarios Agropecuario -->
    <div class="col-lg-3 col-6">
      <div class="small-box bg-green">
        <div class="inner">
          <h3><?= $usuarios_agro ?></h3>
          <p>Usuarios Agropecuarios</p>
        </div>
        <div class="icon"><i class="fas fa-user-tie"></i></div>
      </div>
    </div>

    <!-- Usuarios Despacho -->
    <div class="col-lg-3 col-6">
      <div class="small-box bg-info">
        <div class="inner">
          <h3><?= $usuarios_despacho ?></h3>
          <p>Usuarios Despacho</p>
        </div>
        <div class="icon"><i class="fas fa-user-cog"></i></div>
      </div>
    </div>

    <!-- Usuarios Centro -->
    <div class="col-lg-3 col-6">
      <div class="small-box bg-warning">
        <div class="inner">
          <h3><?= $usuarios_centro ?></h3>
          <p>Usuarios Centro</p>
        </div>
        <div class="icon"><i class="fas fa-user-shield"></i></div>
      </div>
    </div>

    <!-- Usuarios Admin -->
    <div class="col-lg-3 col-6">
      <div class="small-box bg-danger">
        <div class="inner">
          <h3><?= $usuarios_admin ?></h3>
          <p>Administradores</p>
        </div>
        <div class="icon"><i class="fas fa-user-secret"></i></div>
      </div>
    </div>
		<!-- Estadísticas por sede -->
		<div class="col-lg-3 col-6">
			<div class="small-box bg-success">
				<div class="inner">
					<h3><?= $agropecuario['cantidad_materiales'] ?></h3>
					<p> Items en Agropecuario</p>
					<h5>Total: $<?= number_format(floatval($agropecuario['total_precio']), 2, ',', '.') ?></h5>
				</div>
				<div class="icon"><i class="fas fa-tractor"></i></div>
			</div>
		</div>

		<div class="col-lg-3 col-6">
			<div class="small-box bg-info">
				<div class="inner">
					<h3><?= $despacho['cantidad_materiales'] ?></h3>
					<p> Items en Despacho</p>
					<h5>Total: $<?= number_format(floatval($despacho['total_precio']), 2, ',', '.') ?></h5>
				</div>
				<div class="icon"><i class="fas fa-truck"></i></div>
			</div>
		</div>

		<div class="col-lg-3 col-6">
			<div class="small-box bg-warning">
				<div class="inner">
					<h3><?= $centro['cantidad_materiales'] ?></h3>
					<p> Items en Centro</p>
					<h5>Total: $<?= number_format(floatval($centro['total_precio']), 2, ',', '.') ?></h5>
				</div>
				<div class="icon"><i class="fas fa-building"></i></div>
			</div>
		</div>

  </div>

	</section>

</div>

<?php 
  $this->load->view('layouts/footer'); 
?>

