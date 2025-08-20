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
			if ($session['tipo']=="CENTRO" && $session['estado']=="ACTIVO") {
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
	


	public function createUser()
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
			redirect(base_url('index.php/centro/Usuario/createUser'));
		}

		// Cargar vista
		$this->load->view('centro/crearUsuario', $data);
	}



}

/* End of file Usuario.php */
/* Location: ./application/controllers/admin/Usuario.php */

