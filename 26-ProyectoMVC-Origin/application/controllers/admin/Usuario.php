<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
        $this->load->model('PersonasModel');
		$this->load->model('UsuariosModel');
        $this->load->database();

		// Validación de sesión: Solo permite acceso a administradores activos
		$validacion = $this->session->has_userdata("session-mvc");
		if ($validacion) {
			$session = $this->session->userdata("session-mvc");
			if ($session['tipo']=="ADMIN" && $session['estado']=="ACTIVO") {
				return false;
			} else { 
				redirect('Login/cerrarSession','refresh');
				die();
			}
		} else {
			redirect('Login/cerrarSession','refresh');
			die();
		}
	}

	/**
	 * Página principal de Usuario.
	 * Actualmente no realiza ninguna acción por defecto.
	 */
	public function index(){
		// Ninguna acción.
	}

	/**
	 * Crear o editar usuarios con paginación.
	 * - Si se pasa cédula por GET, carga datos para edición.
	 * - Si se envía formulario por POST, valida y guarda datos.
	 * - Gestiona la carga de fotos.
	 * - Lista usuarios paginados para mostrar en la vista.
	 */
	
	public function createUser($page = 0)
	{
		$this->load->library('pagination');
		$data['session'] = $this->session->userdata("session-mvc");
		$data['upload_error'] = null;
		$data['error'] = null;
		$data['cedula_original'] = null;

		// Inicialización por defecto (modo creación)
		$personaDefault = (object)[
			'cedula'    => '',
			'nombres'   => '',
			'apellidos' => '',
			'telefono'  => '',
			'direccion' => '',
			'email'     => '',
			'foto'      => 'default.png'
		];
		$usuarioDefault = (object)[
			'email' => '',
			'tipo'  => ''
		];

		$data['persona'] = $personaDefault;
		$data['usuario'] = $usuarioDefault;

		// --- Modo edición
		$cedulaEditar = $this->input->get('cedula');
		if ($cedulaEditar) {
			$persona = $this->PersonasModel->findByCedula($cedulaEditar);
			$usuario = $this->UsuariosModel->findByCedula($cedulaEditar);

			if ($persona) {
				$data['persona'] = $persona;
				$data['cedula_original'] = $cedulaEditar;
			}
			if ($usuario) {
				$data['usuario'] = $usuario;
			}
		}

		// --- Si envían formulario
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$cedulaOriginal = $this->input->post('cedula_original'); // Para editar
			$cedula     = $this->input->post('new_cedula');
			$nombres    = $this->input->post('new_nombres');
			$apellidos  = $this->input->post('new_apellidos');
			$telefono   = $this->input->post('new_telefono');
			$direccion  = $this->input->post('new_direccion');
			$email      = $this->input->post('new_correo');
			$password   = $this->input->post('new_password');
			$tipo       = $this->input->post('new_tipo');
			$modo       = $this->input->post('modo');

			// Configuración para subir foto
			$config['upload_path']   = './uploads/fotos/';
			$config['allowed_types'] = 'jpg|jpeg|png|webp|svg';
			$config['max_size']      = 10240;
			$config['file_name']     = 'foto_' . $cedula;
			$this->load->library('upload', $config);

			$foto = 'default.png';
			if (!empty($_FILES['evidencia']['name'])) {
				if ($this->upload->do_upload('evidencia')) {
					$upload_data = $this->upload->data();
					$foto = $upload_data['file_name'];
				} else {
					$data['upload_error'] = $this->upload->display_errors();
				}
			}

			// --- Edición de usuario
			if ($modo == 'editar') {
				$persona = $this->PersonasModel->findByCedula($cedulaOriginal);
				if ($persona) {
					if ($foto == 'default.png') {
						$foto = $persona->foto;
					}

					$this->PersonasModel->actualizarConCambioCedula(
						$cedulaOriginal, $cedula, $nombres, $apellidos, $telefono, $direccion, $email, $foto
					);

					if (!empty($password)) {
						$this->UsuariosModel->actualizarConCambioCedula(
							$cedulaOriginal, $cedula, $email, password_hash($password, PASSWORD_BCRYPT), $tipo
						);
					} else {
						$this->UsuariosModel->actualizarSinPasswordConCambioCedula(
							$cedulaOriginal, $cedula, $email, $tipo
						);
					}

					$data['editado'] = true;
				}
			}
			// --- Nuevo usuario
			else {
				$existeCedula = $this->PersonasModel->findByCedula($cedula);
				$existeCorreo = $this->UsuariosModel->findByCorreo($email);

				if ($existeCedula || $existeCorreo) {
					$data['error'] = "Ya existe un usuario con esta cédula o correo electrónico.";
				} else {
					$this->PersonasModel->insertar($cedula, $nombres, $apellidos, $telefono, $direccion, $email, $foto);
					$this->UsuariosModel->insertar($cedula, $email, $password, $tipo);
					$data['insertado'] = true;
				}
			}
		}

		// --- Configuración de paginación
		$config['base_url']   = base_url('index.php/admin/Usuario/createUser');
		$config['total_rows'] = $this->PersonasModel->countAll();
		$config['per_page']   = 9;
		$config['uri_segment'] = 4;

		// Estilo Bootstrap
		$config['full_tag_open']   = '<ul class="pagination justify-content-center">';
		$config['full_tag_close']  = '</ul>';
		$config['first_tag_open']  = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close'] = '</span></li>';
		$config['last_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close']  = '</span></li>';
		$config['next_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['next_tag_close']  = '</span></li>';
		$config['prev_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['prev_tag_close']  = '</span></li>';
		$config['cur_tag_open']    = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']   = '</span></li>';
		$config['num_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']   = '</span></li>';

		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

		$data['personas'] = $this->PersonasModel->getPaginated($config['per_page'], $page);
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		// Vista
		$this->load->view('admin/crearUsuario', $data);
	}




	public function createUsers()
	{
		$data['session'] = $this->session->userdata("session-mvc");
		$data['upload_error'] = null;
		$data['error'] = null;
		$data['editado'] = $this->session->flashdata('editado'); // usar flashdata para mostrar mensaje una sola vez

		// Cargar datos actuales
		$cedulaSesion = $data['session']['cedula'];
		$data['persona'] = $this->PersonasModel->findByCedula($cedulaSesion);
		$data['usuario'] = $this->UsuariosModel->findByCedula($cedulaSesion);

		if (!$data['persona']) {
			show_error("No se encontró el usuario para editar", 404);
			return;
		}

		// Si envían formulario
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$cedula     = $cedulaSesion;
			$nombres    = $this->input->post('new_nombres');
			$apellidos  = $this->input->post('new_apellidos');
			$telefono   = $this->input->post('new_telefono');
			$direccion  = $this->input->post('new_direccion');
			$email      = $this->input->post('new_correo');
			$password   = $this->input->post('new_password');
			$tipo       = $data['usuario']->tipo;

			// Configuración de subida de foto
			$config['upload_path']   = './uploads/fotos/';
			$config['allowed_types'] = 'jpg|jpeg|png|webp|svg';
			$config['max_size']      = 10240;
			$config['file_name']     = 'foto_' . $cedula;
			$this->load->library('upload', $config);

			$foto = $data['persona']->foto;
			if (!empty($_FILES['evidencia']['name'])) {
				if ($this->upload->do_upload('evidencia')) {
					$upload_data = $this->upload->data();
					$foto = $upload_data['file_name'];
				} else {
					$data['upload_error'] = $this->upload->display_errors();
				}
			}

			// Actualizar datos
			$this->PersonasModel->actualizar($cedula, $nombres, $apellidos, $telefono, $direccion, $email, $foto);

			if (!empty($password)) {
				$this->UsuariosModel->actualizar($cedula, $email, password_hash($password, PASSWORD_BCRYPT), $tipo);
			} else {
				$this->UsuariosModel->actualizarSinPassword($cedula, $email, $tipo);
			}

			// Actualizar sesión
			$data['session']['nombres'] = $nombres;
			$data['session']['apellidos'] = $apellidos;
			$data['session']['foto'] = $foto;
			$data['session']['correo'] = $email;
			$this->session->set_userdata("session-mvc", $data['session']);

			// Guardar mensaje para la próxima carga
			$this->session->set_flashdata('editado', true);

			// Redirigir para evitar reenvío al hacer F5
			redirect(base_url('index.php/admin/Usuario/createUsers'));
		}

		// Cargar vista
		$this->load->view('admin/crearUsuarios', $data);
	}


	/**
	 * Insertar un nuevo usuario desde un formulario simple.
	 * Valida que todos los campos estén completos y que no existan duplicados.
	 */
	public function insertarUsuario()
	{
		$cedula = $this->input->post('new_cedula');
		$nombres = $this->input->post('new_nombres');
		$apellidos = $this->input->post('new_apellidos');
		$telefono = $this->input->post('new_telefono');
		$direccion = $this->input->post('new_direccion');
		$email = $this->input->post('new_correo');
		$password = $this->input->post('new_password');
		$tipo = $this->input->post('new_tipo');

		$data['session'] = $this->session->userdata("session-mvc");

		if (
			$cedula != "" && $nombres != "" && $apellidos != "" &&
			$telefono != "" && $direccion != "" && $email != "" &&
			$password != "" && $tipo != ""
		) {
			$this->load->model('PersonasModel');
			$this->load->model('UsuariosModel');

			$cedulaValida = $this->PersonasModel->validarCedula($cedula);
			$emailValido  = $this->PersonasModel->validarEmail($email);

			if ($cedulaValida && $emailValido) {
				$this->PersonasModel->insertar($cedula, $nombres, $apellidos, $telefono, $direccion, $email);
				$this->UsuariosModel->insertar($cedula, $email, $password, $tipo);

				$data['registroExitoso'] = true;
			} else {
				$data['datosRepetidos']  = true;
				$data['cedulaRepetida']  = !$cedulaValida;
				$data['emailRepetido']   = !$emailValido;
			}
		} else {
			$data['datosIncompletos'] = true;
		}

		$this->load->view('admin/crearUsuario', $data);
	}

	/**
	 * Listar usuarios en un CRUD usando AJAX.
	 * Carga todos los usuarios sin paginación y muestra vista crudAjax.
	 */
	public function crudAjax()
	{
		$vdata['session'] = $this->session->userdata("session-mvc");
		$this->load->model('PersonasModel');
		$vdata['personas'] = $this->PersonasModel->findAll();
		$vdata['pagination'] = ''; 
		$this->load->view('admin/crudAjax', $vdata);
	}

	/**
	 * Eliminar un usuario por cédula.
	 * Borra datos en tablas usuarios y personas.
	 * También elimina la foto si no es la imagen por defecto.
	 */
	public function eliminarUsuario($cedula = null)
	{
		if ($cedula === null) {
			show_error("No se proporcionó la cédula para eliminar el usuario.", 400);
			return;
		}

		$persona = $this->PersonasModel->findByCedula($cedula);
		if (!$persona) {
			show_error("No se encontró la persona con cédula: $cedula", 404);
			return;
		}

		$this->UsuariosModel->eliminar($cedula);
		$this->PersonasModel->eliminar($cedula);

		if ($persona->foto && $persona->foto != 'default.png') {
			$rutaFoto = FCPATH . 'uploads/fotos/' . $persona->foto;
			if (file_exists($rutaFoto)) {
				unlink($rutaFoto);
			}
		}

		$this->session->set_flashdata('eliminado_ok', 'Usuario eliminado correctamente.');
		redirect('admin/Usuario/crudAjax');
	}
}

/* End of file Usuario.php */
/* Location: ./application/controllers/admin/Usuario.php */

