<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Material extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(['form', 'url']);
		$this->load->model('InventarioModel');
		$this->load->model('HistorialModel');
		$this->load->model('ItemsModel');
		$this->load->database();

		// Validación de sesión
		$validacion = $this->session->has_userdata("session-mvc");
		if ($validacion) {
			$session = $this->session->userdata("session-mvc");
			if ($session['tipo'] !== "AGROPECUARIO" || $session['estado'] !== "ACTIVO") {
				redirect('Login/cerrarSession', 'refresh'); die();
			}
		} else {
			redirect('Login/cerrarSession', 'refresh'); die();
		}
	}

	public function creatematerial($id_material = null)
	{
		$session = $this->session->userdata("session-mvc");

		// Cargar modelos
		$this->load->model('InventarioModel');
		$this->load->model('HistorialModel');

		$data['session'] = $session;
		$data['items'] = $this->InventarioModel->listarItems(); 
		$data['titulo'] = $id_material ? 'Editar Material' : 'Agregar Material';

		// Si es edición, cargar datos actuales
		if ($id_material !== null && $this->input->method() !== 'post') {
			$material = $this->InventarioModel->find($id_material);

			if (!$material) {
				show_error("No se encontró el material con ID: $id_material", 404);
				return;
			}

			$data = array_merge($data, [
				'id_material' => $material->id_material,
				'id_item' => $material->id_item,
				'remision' => $material->remision,
				'nombre_material' => $material->nombre_material,
				't_unidad' => $material->t_unidad,
				'sede' => $material->sede,
				'cantidad' => $material->cantidad, 
				'precio_u' => $material->precio_u,
				'total_u' => $material->total_u,
				'descripcion' => $material->descripcion,
				'fecha' => $material->fecha
			]);
		}

		// Validar si se envió el formulario
		if ($this->input->method() === 'post') {
			$id_item = $this->input->post('campo_id_item');
			$remision = $this->input->post('campo_remision');
			$nombre_material = $this->input->post('campo_nombre_material');
			$t_unidad = $this->input->post('campo_unidad');
			$sede = $this->input->post('campo_sede');
			$cantidad = $this->input->post('campo_cantidad');
			$precio_u = $this->input->post('campo_precio');
			$total_u = $this->input->post('campo_total');
			$descripcion = $this->input->post('campo_descripcion');
			$fecha = $this->input->post('campo_fecha');

			// Validación básica
			if (
				empty($id_item) || empty($remision) || empty($nombre_material) ||
				empty($t_unidad) || empty($sede) || $cantidad === '' || $precio_u === '' ||
				empty($total_u) || empty($descripcion) || empty($fecha)
			) {
				$data['datosIncompletos'] = true;
			} elseif (!is_numeric($cantidad) || !is_numeric($precio_u) || $cantidad < 0 || $precio_u < 0) {
				$data['datosInvalidos'] = true;
			} else {
				// Datos válidos
				$materialData = [
					'id_item' => $id_item,
					'remision' => $remision,
					'nombre_material' => $nombre_material,
					't_unidad' => $t_unidad,
					'sede' => $sede,
					'cantidad' => $cantidad,
					'precio_u' => $precio_u,
					'total_u' => $total_u,
					'descripcion' => $descripcion,
					'fecha' => $fecha
				];

				if ($id_material === null) {
					// Insertar
					$this->InventarioModel->insert($materialData);
					$this->HistorialModel->insert($materialData);
					$this->session->set_flashdata('alert', 'insert_ok');
				} else {
					// Actualizar
					$this->InventarioModel->update($id_material, $materialData);
					$this->HistorialModel->update($id_material, $materialData);
					$this->session->set_flashdata('alert', 'update_ok');
				}

				// Redirigir para evitar duplicados y conservar mensaje
				redirect('agrope/Material/creatematerial');
				return;
			}
		}

		// Cargar vista
		$this->load->view('agrope/materialA', $data);
	}

	public function borrar($id_material = null)
	{
		if ($id_material === null) {
			show_error("ID no proporcionado para eliminar el inventario.", 400);
			return;
		}

		$item = $this->InventarioModel->find($id_material);
		if (!$item) {
			show_error("No se encontró el inventario con ID: $id_material", 404);
			return;
		}

		// Elimina el ítem
		$this->InventarioModel->delete($id_material);

		// Mensaje flash para mostrar en la vista
		$this->session->set_flashdata('materialEliminado', true);

		// Redirige al método que lista los ítems
		redirect('agrope/Inicio/openEditUsers');
	}

	public function borrarh($id_material = null)
	{
		if ($id_material === null) {
			show_error("ID no proporcionado para eliminar el inventario.", 400);
			return;
		}

		$item = $this->HistorialModel->find($id_material);
		if (!$item) {
			show_error("No se encontró el inventario con ID: $id_material", 404);
			return;
		}

		// Elimina el ítem
		$this->HistorialModel->delete($id_material);

		// Mensaje flash para mostrar en la vista
		$this->session->set_flashdata('materialEliminado', true);

		// Redirige al método que lista los ítems
		redirect('agrope/Inicio/openDeleteUsers');
	}

	
}



