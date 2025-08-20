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
			if ($session['tipo']=="ADMIN" && $session['estado']=="ACTIVO") {
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

	// -------------------- plantilla inicio ------------------- //
	public function index()
	{
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

		$this->load->view('admin/inicio', $data);
	}

	// --------------- plantilla factura ------------------ //
	public function createFactura()
	{
		$data['session'] = $this->session->userdata("session-mvc");
		$this->load->view('admin/factura', $data);
	}

	public function listaFactura()
	{
		$data['session'] = $this->session->userdata("session-mvc");
		$data['facturas'] = $this->FacturaModel->findAll();
		$this->load->view('admin/listaFactura', $data);
	}

	// ----------------- plantilla remisiones factura --------------- //
	public function remisionFactura()
	{
		$data['session'] = $this->session->userdata("session-mvc");
		$data['facturas'] = $this->FacturaModel->findAll();
		$data['inventarios'] = $this->InventarioModel->getRemisionesUnicas();
		$this->load->view('admin/remisionfactura', $data);
	}
	public function listaFacturaR()
	{
		$data['session'] = $this->session->userdata("session-mvc");
		$data['remifacts'] = $this->FacturaRemisionModel->findAll();
		$this->load->view('admin/listFacturaR', $data);
	}

	// -------- plantilla proyectos ----------- //
	public function createProyect()
	{
		$data['session'] = $this->session->userdata("session-mvc");
		$this->load->view('admin/proyecto', $data);
	}

	public function litsProyect()
	{
		$data['session'] = $this->session->userdata("session-mvc");
		$data['proyectos'] = $this->ProyectoModel->findAll();
		$this->load->view('admin/listProyect', $data);
	}

	// -----------plantillas items---------- //
	public function createItems()
	{
		$data['session'] = $this->session->userdata("session-mvc"); 
		$this->load->view('admin/items', $data);
	}

	public function listaItems()
	{
		$data['session'] = $this->session->userdata("session-mvc");
		$data['items'] = $this->ItemsModel->findAll(); // Obtiene todos los ítems
		$this->load->view('admin/listaItems', $data); // Asegúrate de que esa ruta sea correcta
	}


	// ---------- plantilla usuarios -------------- //
	public function openCreateUser()
	{
		$data['session'] = $this->session->userdata("session-mvc");
		$this->load->view('admin/crearUsuario', $data);
	}

	public function openCreateUsers()
	{
		$data['session'] = $this->session->userdata("session-mvc");
		$this->load->view('admin/crearUsuarios', $data);
	}

	public function openCrudAjax($page = 0)
	{
		$this->load->model('PersonasModel');
		$this->load->library('pagination');

		$data['session'] = $this->session->userdata("session-mvc");

		// Recibir búsqueda
		$search = $this->input->get('search');

		// Configuración paginación
		$config['base_url']    = base_url('index.php/admin/Inicio/openCrudAjax');
		$config['total_rows']  = $this->PersonasModel->searchCount($search);
		$config['per_page']    = 9;
		$config['page_query_string'] = TRUE; // para que preserve el ?search
		$config['query_string_segment'] = 'page';

		// Estilos Bootstrap
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

		$this->pagination->initialize($config);

		// Obtener página actual
		$page = $this->input->get('page') ? $this->input->get('page') : 0;

		// Traer datos filtrados
		$data['personas']   = $this->PersonasModel->searchPaginated($config['per_page'], $page, $search);
		$data['pagination'] = $this->pagination->create_links() ?: ''; // <- siempre existe
		$data['search']     = $search;

		$this->load->view('admin/crudAjax', $data);
	}

	// ------------- plantilla inventario e historial de material ---------------- //

	public function openListUsers()
	{
		$data['session'] = $this->session->userdata("session-mvc");
		$data['items'] = $this->ItemsModel->findAll();
		$this->load->view('admin/material', $data);
	}

	public function openEditUsers()
	{
		$data['session'] = $this->session->userdata("session-mvc");
		$data['inventarios'] = $this->InventarioModel->findAll();
		$this->load->view('admin/inventario', $data);
	}

	public function openDeleteUsers()
	{
		$data['session'] = $this->session->userdata("session-mvc");
		$data['historials'] = $this->HistorialModel->findAll();
		$this->load->view('admin/historial', $data);
	}

	public function borrar($id_material = null)
	{
		if ($id_material === null) {
			show_error("ID no proporcionado para eliminar el material.", 400);
			return;
		}

		// Verifica que exista el registro antes de eliminar
		$material = $this->InventarioModel->find($id_material);
		if (!$material) {
			show_error("No se encontró el material con ID: $id_material", 404);
			return;
		}

		// Elimina de inventario y también del historial si es necesario
		$this->InventarioModel->delete($id_material);
		$this->HistorialModel->delete($id_material); // Solo si se quiere eliminar también del historial

		// Mensaje flash para mostrar alerta en la vista
		$this->session->set_flashdata('materialEliminado', true);

		// Redirige a la función listado() (que debe mostrar la tabla)
		redirect("admin/Inicio/openEditUsers");
	}

	// ---------- plantilla evidencias --------- //

	public function createEvidencia()
	{
		$data['session'] = $this->session->userdata("session-mvc");
		$data['proyectos'] = $this->ProyectoModel->findAll();
		$this->load->view('admin/evidencia', $data);
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

		$this->load->view('admin/listevidencia', $data);
	}

	// ---------- plantillas materiales proyecto ----------------- //

	public function subirMaterialProyect()
	{
		$data['session'] = $this->session->userdata("session-mvc");
		$data['proyectos'] = $this->ProyectoModel->findAll(); // lista de proyectos
        $data['materiales'] = $this->InventarioModel->findAll(); // lista de materiales
		$this->load->view('admin/materialProyect', $data);
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

		$this->load->view('admin/listarMaterialProyect', $data);
	}


	/*public function listEvidencias(){
		$data['session'] = $this->session->userdata("session-mvc");
		$data['evidencias'] = $this->EvidenciaModel->findAll();
		$this->load->view('admin/listEvidencia', $data);
	}*/

}

/* End of file Inicio.php */
/* Location: ./application/controllers/admin/Inicio.php */
