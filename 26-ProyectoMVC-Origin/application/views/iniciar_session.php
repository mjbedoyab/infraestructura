<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= (isset($titulo)? $titulo : "APP INFRA" ) ?></title>
    <link rel="icon" href="<?= base_url('dist/img/logo2.png') ?>">
    <!-- CSS de Bootstrap y otros enlaces necesarios -->
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
        crossorigin="anonymous"
    />
    <link 
        href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.min.css"
        rel="stylesheet"
    />
    <link rel="stylesheet" href="<?= base_url('dist/css/css_login.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/dist/css/styles.css') ?>">
    <link 
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
	<section id="formulario_login">
		<div class="container">
			<div class="row justify-content-center">
				<!-- FORMULARIO DE INICIO DE SESIÓN -->
				<div class="col-lg-6 col-md-8 col-12">
					<div class="m-0 p-3">
						<h3 class="text-center mb-3"><b>INFRAESTRUCTURA</b></h3>

						<!-- ALERTAS CON SWEETALERT2 PARA ERRORES EN DATOS -->
						<?php if (isset($date_error)): ?>
							<script>
							Swal.fire({ title: 'DATOS INCORRECTOS', text: 'ERROR: USUARIO INEXISTENTE', icon: 'error' });
							</script>
						<?php endif ?>

						<?php if (isset($datosInvalidos)): ?>
							<script>
							Swal.fire({ title: 'DATOS INCORRECTOS', text: 'ERROR: DATOS NO COINCIDEN', icon: 'error' });
							</script>
						<?php endif ?>

						<?php if (isset($errorInData)): ?>
							<div class="alert alert-danger">DATOS INCOMPLETOS</div>
						<?php endif ?>

						<form action="<?= base_url('index.php/Login/validarIngreso') ?>" method="POST">
							<h3 class="mb-3"><b>LOGIN</b></h3>
							
							<div class="mb-3" data-validate="Valid email is required: ex@abc.xyz">
								<label for="campo_email" class="form-label"><b>E-mail:</b></label>
								<input 
									class="form-control <?= (isset($valueEmail) && $valueEmail!='')? 'is-valid': ((isset($errorInData))? 'is-invalid':'') ?>" id="campo_email" type="email" name="campo_email" value="<?= (isset($valueEmail))? $valueEmail : '' ?>">
							</div>

							<div class="mb-3" data-validate="Password is required">
								<label for="campo_password" class="form-label"><b>Password:</b></label>
								<input class="form-control <?= (isset($valueEmail) && $valuePassword!='')? 'is-valid': ((isset($errorInData))? 'is-invalid':'') ?>" id="campo_password" type="password" name="campo_password" value="<?= (isset($valuePassword))? $valuePassword : '' ?>">
							</div>

							<p class="mb-3">
								¿Has olvidado la contraseña?
								<a href="#" title="Recuperar Contraseña">Recuperar aquí</a>
							</p>

							<div class="row justify-content-center mb-3">
								<div class="col-12 col-lg-6">
									<button class="col-12 btn btn-primary" type="submit">INICIAR</button>
								</div>
							</div>
						</form>

						<div class="text-center">
							<p>Continuar con</p>
							<i class="fab fa-google social-btn" title="Google" style="cursor: pointer;"onclick="location.href='#'"></i>
							<i class="fab fa-github social-btn" title="GitHub" style="cursor: pointer;"onclick="location.href='#'"></i>
							<i class="fab fa-facebook-f social-btn" title="Facebook" style="cursor: pointer;"onclick="location.href='#'"></i>
						</div>

						<div class="row justify-content-center">
							<div class="col-12 col-lg-12">
								<p class="mb-0">Disfruta y Aprende</p>
							</div>
						</div>
					</div>
				</div>

				<!-- IMAGEN DE LA SECCIÓN DE FORMULARIO -->
				<div class="col-lg-6 col-md-6 col-12 p-0">
					<div class="m-0 p-5">
						<img src="<?= base_url('dist/img/img_agro/logo_final.png') ?>"
							alt="img_agro"
							class="img-fluid">
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Alerta para datos invalidos al final, para consistencia -->
	<?php if (isset($errorInData)): ?>
	<script>
		Swal.fire({ title: 'DATOS INVALIDOS', text: 'El correo y contraseña son obligatorios.', icon: 'error' });
	</script>
	<?php endif ?>

	<!-- Scripts JS -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.20/dist/sweetalert2.all.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/bootstrap.bundle.min.js"></script>

</body>
</html>

