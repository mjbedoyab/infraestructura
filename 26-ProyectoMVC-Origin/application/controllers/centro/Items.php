<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Items extends CI_Controller {

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
			if ($session['tipo'] !== "CENTRO" || $session['estado'] !== "ACTIVO") {
				redirect('Login/cerrarSession', 'refresh'); die();
			}
		} else {
			redirect('Login/cerrarSession', 'refresh'); die();
		}

	}

	public function createItemsA($id_item = null) {
		$vdata = [
			"nombre_material" => "",
			"t_unidad" => "",
			"precio_u" => "",
			"sede" => "",
			"descripcion" => "",
			"id_item" => "",
			"session" => $this->session->userdata("session-mvc"),
			"datosValidos" => $this->session->flashdata('datosValidos'),
			"editadoCorrectamente" => $this->session->flashdata('editadoCorrectamente'),
			"errorDuplicado" => $this->session->flashdata('errorDuplicado') // nuevo
		];

		if ($id_item) {
			$items = $this->ItemsModel->find($id_item);
			if ($items) {
				$vdata["id_item"] = $items->id_item;
				$vdata["nombre_material"] = $items->nombre_material;
				$vdata["t_unidad"] = $items->t_unidad;
				$vdata["precio_u"] = $items->precio_u;
				$vdata["sede"] = $items->sede;
				$vdata["descripcion"] = $items->descripcion;
			}
		}

		if ($this->input->server("REQUEST_METHOD") == "POST") {
			$data = [
				"id_item" => $this->input->post("campo_id"),
				"nombre_material" => $this->input->post("campo_nombre"),
				"t_unidad" => $this->input->post("campo_unidad"),
				"precio_u" => $this->input->post("campo_presio"), 
				"sede" => $this->input->post("campo_sede"),
				"descripcion" => $this->input->post("campo_descripcion")
			];

			$vdata = array_merge($vdata, $data);

			// Validar campos vacíos
			if (
				empty($data["id_item"]) || empty($data["nombre_material"]) || empty($data["t_unidad"]) ||
				empty($data["precio_u"]) || empty($data["sede"]) ||
				empty($data["descripcion"])
			) {
				$vdata["datosIncompletos"] = true;
				$this->load->view('centro/itemsA', $vdata);
				return;
			}

			// Validar si el ID ya existe (solo en creación)
			if (!$id_item) {
				$existe = $this->ItemsModel->find($data["id_item"]);
				if ($existe) {
					$this->session->set_flashdata('errorDuplicado', 'Ya existe un ítem con el ID ingresado.');
					redirect('centro/Items/createItemsA/');
					return;
				}
			}

			if ($id_item) {
				// Es edición
				$this->ItemsModel->update($id_item, $data);
				$this->session->set_flashdata('editadoCorrectamente', true);
				redirect('centro/Items/createItemsA/');
			} else {
				// Es creación
				$this->ItemsModel->insert($data);
				$this->session->set_flashdata('datosValidos', true);
				redirect('agrope/Items/createItemsA');
			}
		}

		$this->load->view('centro/itemsA', $vdata);
	}

	public function borrar($id_item = null)
	{
		if ($id_item === null) {
			show_error("ID no proporcionado para eliminar el item.", 400);
			return;
		}

		$item = $this->ItemsModel->find($id_item);
		if (!$item) {
			show_error("No se encontró el item con ID: $id_item", 404);
			return;
		}

		// Elimina el ítem
		$this->ItemsModel->delete($id_item);

		// Mensaje flash para mostrar en la vista
		$this->session->set_flashdata('materialEliminado', true);

		// Redirige al método que lista los ítems
		redirect('centro/Inicio/listaItemsA');
	}



	

	

	
}
