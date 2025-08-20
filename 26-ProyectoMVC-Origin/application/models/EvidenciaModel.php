<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EvidenciaModel extends CI_Model {

    private $table = 'evidenciasproyect';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Insertar nueva evidencia
    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    // Obtener todas las evidencias con el nombre del proyecto
    public function findAll() {
        $this->db->select('e.*, p.nombre AS nombre_proyecto');
        $this->db->from($this->table . ' e');
        $this->db->join('proyecto p', 'p.id_proyecto = e.id_proyecto');
        return $this->db->get()->result();
    }

    // Buscar evidencia por ID
    public function find($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->table)->row();
    }

    // Buscar evidencias por proyecto
    public function findByProyecto($id_proyecto) {
        $this->db->where('id_proyecto', $id_proyecto);
        return $this->db->get($this->table)->result();
    }

    // Actualizar evidencia
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    // Eliminar evidencia
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

	public function getByProyecto($id_proyecto) {
		$this->db->select('evidenciasproyect.*, proyecto.nombre AS nombre_proyecto');
		$this->db->from('evidenciasproyect');
		$this->db->join('proyecto', 'proyecto.id_proyecto = evidenciasproyect.id_proyecto');
		$this->db->where('evidenciasproyect.id_proyecto', $id_proyecto);
		return $this->db->get()->result();
	}

}
