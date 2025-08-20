<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Proyecto extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper(['form', 'url']);
		$this->load->library('upload');
		$this->load->model('ProyectoModel');
		$this->load->model('EvidenciaModel');
		$this->load->model('MaterialProyectoModel');
		$this->load->model('InventarioModel');
		$this->load->model('HistorialModel');
		$this->load->database();

		// Validación de sesión para permitir solo administradores activos
		if (!$this->session->has_userdata("session-mvc")) {
			redirect('Login/cerrarSession', 'refresh');
			die();
		}

		$session = $this->session->userdata("session-mvc");
		if ($session['tipo'] !== "AGROPECUARIO" || $session['estado'] !== "ACTIVO") {
			redirect('Login/cerrarSession', 'refresh');
			die();
		}
	}


	/**
	 * Subir y registrar una evidencia para un proyecto.
	 * Valida tipo de archivo y guarda el archivo en el servidor.
	 */
	public function createEvidencias() {
		$session = $this->session->userdata("session-mvc");

		$vdata = [
			"session" => $session,
			"proyectos" => $this->ProyectoModel->findAll(),
			"datosValidos" => $this->session->flashdata('datosValidos') ?? false,
			"datosIncompletos" => false
		];

		if ($this->input->server("REQUEST_METHOD") == "POST") {
			$id_proyecto = $this->input->post("id_proyecto");
			$nombre_evidencia = $this->input->post("nombre_evidencia");
			$archivo = $_FILES['evidencia']['name'];

			// Validación de campos obligatorios
			if (empty($id_proyecto) || empty($nombre_evidencia) || empty($archivo)) {
				$vdata["datosIncompletos"] = true;
				$this->load->view('agrope/evidenciaA', $vdata);
				return;
			}

			$tipo_archivo = $_FILES['evidencia']['type'];
			$temp = $_FILES['evidencia']['tmp_name'];
			$extension = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));

			// Tipos MIME válidos
			$es_valido = strpos($tipo_archivo, 'msword') !== false ||
						strpos($tipo_archivo, 'vnd.openxmlformats-officedocument.wordprocessingml.document') !== false ||
						strpos($tipo_archivo, 'vnd.ms-excel') !== false ||
						strpos($tipo_archivo, 'vnd.openxmlformats-officedocument.spreadsheetml.sheet') !== false ||
						strpos($tipo_archivo, 'pdf') !== false;

			$ext_permitidas = ['doc', 'docx', 'xls', 'xlsx', 'pdf'];
			if (!$es_valido || !in_array($extension, $ext_permitidas)) {
				$vdata['upload_error'] = 'Solo se permiten archivos Word, Excel o PDF (.doc, .docx, .xls, .xlsx, .pdf).';
				$this->load->view('agrope/evidenciaA', $vdata);
				return;
			}

			$nombre_archivo = uniqid() . '_' . $archivo;
			$ruta_destino = 'uploads/evidencias/';
			if (!is_dir($ruta_destino)) {
				mkdir($ruta_destino, 0777, true);
			}

			if (move_uploaded_file($temp, $ruta_destino . $nombre_archivo)) {
				$data = [
					"id_proyecto" => $id_proyecto,
					"nombre_evidencia" => $nombre_evidencia,
					"evidencia" => $nombre_archivo
				];

				$this->EvidenciaModel->insert($data);
				$this->session->set_flashdata('datosValidos', true);
				redirect('agrope/Proyecto/createEvidencias');
			} else {
				$vdata['upload_error'] = 'Error al mover el archivo al servidor.';
				$this->load->view('agrope/evidenciaA', $vdata);
				return;
			}
		}

		$this->load->view('agrope/evidenciaA', $vdata);
	}

	/**
	 * Eliminar una evidencia por su ID.
	 * Borra también el archivo físico en el servidor.
	 */
	public function borrarEvidencia($id) {
		$evidencia = $this->EvidenciaModel->find($id);
		if (!$evidencia) {
			show_error("No se encontró la evidencia con ID: $id", 404);
			return;
		}

		$archivo_path = 'uploads/evidencias/' . $evidencia->evidencia;
		if (file_exists($archivo_path)) {
			unlink($archivo_path);
		}

		$this->EvidenciaModel->delete($id);
		$this->session->set_flashdata('eliminado_ok', 'La evidencia se eliminó correctamente.');
		redirect('agrope/Inicio/listEvidencias');
	}

	/**
	 * Insertar o actualizar un material en un proyecto.
	 * Valida disponibilidad en inventario y descuenta cantidades.
	 */
	public function insertarMaterialProyecto() {
		// Obtener la información de la sesión activa
		$session = $this->session->userdata("session-mvc");

		// Obtener parámetros desde la URL (método GET)
		$id_proyecto = $this->input->get("id_proyecto");
		$id_material = $this->input->get("id_material");

		// Datos que se enviarán a la vista
		$vdata = [
			'session' => $session,
			'proyectos' => $this->ProyectoModel->findAll(),   // Lista de proyectos
			'materiales' => $this->InventarioModel->findAll(), // Lista de materiales
			'mensaje' => null,
			'error' => null,
			'id_proyecto' => $id_proyecto,
			'id_material' => $id_material,
			'cantidad' => '' // Cantidad inicial vacía
		];

		// Si viene un proyecto y material por GET, buscar si ya existe registro
		if ($id_proyecto && $id_material) {
			$registro = $this->MaterialProyectoModel->obtener($id_proyecto, $id_material);
			if ($registro) {
				// Si existe, cargar la cantidad actual para prellenar el formulario
				$vdata['cantidad'] = $registro->cantidad;
			}
		}

		// Si el formulario fue enviado por método POST
		if ($this->input->server("REQUEST_METHOD") === "POST") {
			// Obtener datos enviados por el usuario
			$id_proyecto = $this->input->post("id_proyecto");
			$id_material = $this->input->post("id_material");
			$cantidad = floatval($this->input->post("cantidad"));

			// Guardar valores en el array que se enviará a la vista
			$vdata['id_proyecto'] = $id_proyecto;
			$vdata['id_material'] = $id_material;
			$vdata['cantidad'] = $cantidad;

			// Validación: todos los campos obligatorios y cantidad > 0
			if (empty($id_proyecto) || empty($id_material) || $cantidad <= 0) {
				$vdata['error'] = "Todos los campos son obligatorios y la cantidad debe ser mayor a cero.";
				$this->load->view('agrope/materialProyectA', $vdata);
				return;
			}

			// Verificar que el material existe en inventario
			$material = $this->InventarioModel->find($id_material);
			if (!$material) {
				$vdata['error'] = "No se encontró el material en inventario.";
				$this->load->view('agrope/materialProyectA', $vdata);
				return;
			}

			// Validar que hay suficiente cantidad disponible en inventario
			$cantidadDisponible = floatval($material->cantidad);
			if ($cantidad > $cantidadDisponible) {
				$vdata['error'] = "Cantidad no disponible en inventario. Disponible: {$cantidadDisponible}";
				$this->load->view('agrope/materialProyectA', $vdata);
				return;
			}

			// Revisar si ya existe un registro para ese proyecto y material
			$registro_existente = $this->MaterialProyectoModel->obtener($id_proyecto, $id_material);

			// Si existe, actualizar la cantidad. Si no, insertar nuevo registro
			if ($registro_existente) {
				$ok = $this->MaterialProyectoModel->actualizar($id_proyecto, $id_material, $cantidad);

				if ($ok) {
					$vdata['mensaje'] = 'Registro actualizado correctamente.';
					$vdata['redirect_url'] = base_url('index.php/agrope/Inicio/litsProyect');
				} else {
					$vdata['error'] = 'Error al actualizar el registro.';
				}
			} else {
				$ok = $this->MaterialProyectoModel->insertar($id_proyecto, $id_material, $cantidad);

				if ($ok) {
					$vdata['mensaje'] = 'Registro insertado correctamente.';
					$vdata['redirect_url'] = base_url('index.php/agrope/Inicio/litsProyect');
				} else {
					$vdata['error'] = 'Error al insertar el registro.';
				}
			}

			// Si todo fue correcto, cargamos la misma vista pero con el SweetAlert y redirección
			$this->load->view('agrope/materialProyectA', $vdata);
			return;

		}

		// Cargar la vista del formulario con los datos actuales
		$this->load->view('agrope/materialProyectA', $vdata);
	}


	/**
	 * Eliminar un material asignado a un proyecto.
	 * Requiere ID del proyecto e ID del material.
	 */
	public function borrarMaterialProyecto($id_proyecto = null, $id_material = null) {
		if ($id_proyecto === null || $id_material === null) {
			show_error("Faltan parámetros para eliminar el material del proyecto.", 400);
			return;
		}

		$registro = $this->MaterialProyectoModel->obtener($id_proyecto, $id_material);
		if (!$registro) {
			show_error("No se encontró el material con ID Proyecto: $id_proyecto e ID Material: $id_material", 404);
			return;
		}

		$ok = $this->MaterialProyectoModel->eliminar($id_proyecto, $id_material);

		if ($ok) {
			$this->session->set_flashdata('materialEliminado', 'Material eliminado correctamente del proyecto.');
		} else {
			$this->session->set_flashdata('materialError', 'No se pudo eliminar el material del proyecto.');
		}

		redirect('agrope/Inicio/listarMaterialesProyecto');
	}
}



