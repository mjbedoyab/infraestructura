<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
        $this->load->model('PersonasModel');
		$this->load->model('UsuariosModel');
		$this->load->model('InventarioModel');
		$this->load->model('HistorialModel');
		$this->load->model('ProyectoModel');
		$this->load->model('EvidenciaModel');
		$this->load->model('MaterialProyectoModel');
		$this->load->model('ItemsModel');	
		$this->load->model('FacturaModel');
		$this->load->model('FacturaRemisionModel');
		$this->load->model('EstadisticasModel');
        $this->load->database();
		
		$validacion = $this->session->has_userdata("session-mvc");
		if ($validacion) {
			$session = $this->session->userdata("session-mvc");
			if ($session['tipo']=="DESPACHO" && $session['estado']=="ACTIVO") {
				return false;
			}else{
				redirect('Login/cerrarSession','refresh');
				die();
			}
		}else{
			redirect('Login/cerrarSession','refresh');
			die();
		}
	}

	

	// --------------------- plantilla -------------------- //

	public function index(){
		$data['session'] = $this->session->userdata("session-mvc");

		$data['proy_agro'] = $this->EstadisticasModel->countProyectosAgropecuario();
		$data['proy_despacho'] = $this->EstadisticasModel->countProyectosDespacho();
		$data['proy_centro'] = $this->EstadisticasModel->countProyectosCentro();
		$data['proy_total'] = $this->EstadisticasModel->countProyectosTotal();
		$data['proy_pend'] = $this->EstadisticasModel->countProyectosPendiente();
		$data['proy_proceso'] = $this->EstadisticasModel->countProyectosEnProceso();
		$data['proy_final'] = $this->EstadisticasModel->countProyectosFinalizados();

		$data['usuarios_activos'] = $this->EstadisticasModel->countUsuariosActivos();
		$data['usuarios_agro'] = $this->EstadisticasModel->countUsuariosAgropecuario();
		$data['usuarios_despacho'] = $this->EstadisticasModel->countUsuariosDespacho();
		$data['usuarios_centro'] = $this->EstadisticasModel->countUsuariosCentro();
		$data['usuarios_admin'] = $this->EstadisticasModel->countUsuariosAdmin();

		$data['agropecuario'] = $this->EstadisticasModel->getEstadisticasAgropecuario();
		$data['despacho']     = $this->EstadisticasModel->getEstadisticasDespacho();
		$data['centro']       = $this->EstadisticasModel->getEstadisticasCentro();
		
		$this->load->view('despa/inicio', $data);
	}

	// ---------- plantilla usuarios -------------- //
	public function openCreateUser()
	{
		$data['session'] = $this->session->userdata("session-mvc");
		$this->load->view('despa/crearUsuario', $data);
	}


	// ----------------------- plantillas items agropecuario ---------------------- //

	public function createItemsA()
	{
		$data['session'] = $this->session->userdata("session-mvc"); 
		$this->load->view('despa/itemsA', $data);
	}

	public function listaItemsA()
	{
		$data['session'] = $this->session->userdata("session-mvc");

		// Filtrar por sede AGROECUARIO
		$data['items'] = $this->ItemsModel->findBySede('DESPACHO');

		$this->load->view('despa/listaItemsA', $data);
	}

	// ----------------------- materiales inventario ------------------ //

	public function openListUsers()
	{
		$data['session'] = $this->session->userdata("session-mvc");
		$data['items'] = $this->ItemsModel->findBySede('DESPACHO');
		$this->load->view('despa/materialA', $data);
	}

	public function openEditUsers()
	{
		$data['session'] = $this->session->userdata("session-mvc");
		$data['inventarios'] = $this->InventarioModel->findBySede('DESPACHO');
		$this->load->view('despa/inventarioA', $data);
	}

	public function openDeleteUsers()
	{
		$data['session'] = $this->session->userdata("session-mvc");
		$data['historials'] = $this->HistorialModel->findBySede('DESPACHO');
		$this->load->view('despa/historialA', $data);
	}

	// ---------------------- plantilla proyectos ---------------------- //

	public function litsProyect()
	{
		$data['session'] = $this->session->userdata("session-mvc");
		$data['proyectos'] = $this->ProyectoModel->findAllseded();
		$this->load->view('despa/listProyectA', $data);
	}

	// ---------- plantilla evidencias --------- //

	public function createEvidencia()
	{
		$data['session'] = $this->session->userdata("session-mvc");
		$data['proyectos'] = $this->ProyectoModel->findAllseded();
		$this->load->view('despa/evidenciaA', $data);
	}

	public function listEvidencias($id_proyecto = null) 
	{
		$session = $this->session->userdata("session-mvc");

		$this->load->model('EvidenciaModel');

		if ($id_proyecto !== null) {
			// Si llega un ID, muestra solo las evidencias de ese proyecto
			$evidencias = $this->EvidenciaModel->getByProyecto($id_proyecto);
		} else {
			// Si no llega ID, muestra todas las evidencias
			$evidencias = $this->EvidenciaModel->findAll();
		}

		$data = [
			'session' => $session,
			'evidencias' => $evidencias,
			'id_proyecto' => $id_proyecto
		];

		$this->load->view('despa/listevidenciaA', $data);
	}

	// ---------- plantillas materiales proyecto ----------------- //

	public function subirMaterialProyect()
	{
		$data['session'] = $this->session->userdata("session-mvc");
		$data['proyectos'] = $this->ProyectoModel->findAllseded(); // lista de proyectos
        $data['materiales'] = $this->InventarioModel->findBySede('DESPACHO'); // lista de materiales
		$this->load->view('despa/materialProyectA', $data);
	}

	public function listarMaterialesProyecto($id_proyecto)
	{
		$session = $this->session->userdata("session-mvc");

		// Llamar al método nuevo del modelo
		$materiales_proyecto = $this->MaterialProyectoModel->listarPorProyecto($id_proyecto);

		$data = [
			'session' => $session,
			'materiales_proyecto' => $materiales_proyecto,
			'id_proyecto' => $id_proyecto
		];

		$this->load->view('despa/listarMaterialProyectA', $data);
	}



}

/* End of file Inicio.php */
/* Location: ./application/controllers/vendedor/Inicio.php */
