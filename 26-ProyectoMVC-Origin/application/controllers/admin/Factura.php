<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Factura extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(['form', 'url']);
		$this->load->model('InventarioModel');
		$this->load->model('HistorialModel');
		$this->load->model('ItemsModel');
		$this->load->model('FacturaModel');
		$this->load->model('FacturaRemisionModel');
		$this->load->database();

		// Validación de sesión
		$validacion = $this->session->has_userdata("session-mvc");
		if ($validacion) {
			$session = $this->session->userdata("session-mvc");
			if ($session['tipo'] !== "ADMIN" || $session['estado'] !== "ACTIVO") {
				redirect('Login/cerrarSession', 'refresh'); die();
			}
		} else {
			redirect('Login/cerrarSession', 'refresh'); die();
		}
	}


	public function createFactura ($id_factura = null){

		$session = $this->session->userdata("session-mvc");

		$vdata = [
			"factura" => "", "factura" => "", "id_factura" => $id_factura,
			"session" => $session,
			"datosValidos" => $this->session->flashdata('datosValidos') ?? false,
			"datosIncompletos" => false
		];

		// Si es edición
		if ($id_factura) {
			$factura = $this->FacturaModel->find($id_factura);
			if ($factura) {
				$vdata["factura"] = $factura->factura;
			}
		}

		if ($this->input->server("REQUEST_METHOD") == "POST") {
			$data = [
				"factura" => $this->input->post("campo_factura"),
			];

			$vdata = array_merge($vdata, $data);

			// Validación básica
			if (
				empty($data["factura"]) 
			) {
				$vdata["datosIncompletos"] = true;
				$this->load->view('admin/factura', $vdata);
				return;
			}

			// Guardar
			if ($id_factura) {
				$this->FacturaModel->update($id_factura, $data);
			} else {
				$this->FacturaModel->insert($data);
			}

			$this->session->set_flashdata('datosValidos', true);
			redirect('admin/Factura/createFactura');
		}

		$this->load->view('admin/factura', $vdata);

	}

	public function borrar($id_factura = null)
	{
		if ($id_factura === null) {
			show_error("ID no proporcionado para eliminar la factura.", 400);
			return;
		}

		$remi = $this->FacturaModel->find($id_factura);
		if (!$remi) {
			show_error("No se encontró la factura con ID: $id_factura", 404);
			return;
		}

		// Elimina el ítem
		$this->FacturaModel->delete($id_factura);

		// Mensaje flash para mostrar en la vista
		$this->session->set_flashdata('FacturaEliminado', true);

		// Redirige al método que lista los ítems
		redirect('admin/Inicio/listaFactura');
	}


	public function remisionFactura($id = null)
	{
		$session = $this->session->userdata("session-mvc");

		$data = [
			'session'     => $session,
			'facturas'    => $this->FacturaModel->findAll(),
			'inventarios' => $this->InventarioModel->getRemisionesUnicas(),
			'id'          => $id,
			'id_factura'  => '',
			'id_material' => '',
			'edit_id'     => null
		];

		if ($id !== null) {
			$facturaRemision = $this->FacturaRemisionModel->findById($id);
			if (!$facturaRemision) {
				show_404();
			}

			// Aquí buscamos el id_material real a partir de la remisión guardada
			$inventario = $this->InventarioModel->findByRemision($facturaRemision->remision);

			$data['id_factura'] = $facturaRemision->id_factura;
			$data['id_material'] = $inventario ? $inventario->id_material : '';
			$data['edit_id'] = $id;
		}

		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$id_factura_post = $this->input->post('campo_factura');
			$id_material_post = $this->input->post('campo_remision');

			$facturaData = $this->FacturaModel->findById($id_factura_post);
			$remisionData = $this->InventarioModel->findById($id_material_post);

			if (!$facturaData || !$remisionData) {
				show_error('Factura o remisión inválida.');
			}

			$dataInsert = [
				'id_factura' => $facturaData->id_factura,
				'factura'    => $facturaData->factura,
				'remision'   => $remisionData->remision
			];

			if ($id !== null) {
				$this->FacturaRemisionModel->actualizar($id, $dataInsert);
				$this->session->set_flashdata('success', 'Factura-Remisión actualizada correctamente.');
			} else {
				$this->FacturaRemisionModel->insertar($dataInsert);
				$this->session->set_flashdata('success', 'Factura-Remisión registrada correctamente.');
			}

			redirect('admin/Factura/remisionFactura');
		}

		$this->load->view('admin/remisionfactura', $data);
	}



	public function borrarRemi($id = null)
	{
		if ($id === null) {
			show_error("ID no proporcionado para eliminar la remision factura.", 400);
			return;
		}

		$remi = $this->FacturaRemisionModel->findById($id);
		if (!$remi) {
			show_error("No se encontró la remision factura con ID: $id", 404);
			return;
		}

		// Elimina el ítem
		$this->FacturaRemisionModel->eliminar($id);

		// Mensaje flash para mostrar en la vista
		$this->session->set_flashdata('remisionFacturaEliminado', true);

		// Redirige al método que lista los ítems
		redirect('admin/Inicio/listaFacturaR');
	}




	
}
