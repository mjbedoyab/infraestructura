<?php
defined('BASEPATH') OR exit('No direct script access allowed');


Class HistorialModel extends CI_Model{
	
	public $table = 'historial';
    public $table_id = 'id_material';

    public function __construct(){
        $this->load->database();
    }

    function find($id_material){
        $this->db->select();
        $this->db->from($this->table);
        $this->db->where($this->table_id, $id_material);

        $query = $this->db->get();
        return $query->row();
    }

    function findAll(){
        $this->db->select();
        $this->db->from($this->table);
       
        $query = $this->db->get();
        return $query->result();
    }

    function insert($data){
        $this->db->insert($this->table, $data); 
        return $this->db->insert_id();

    }

    function update($id_material, $data){
		$this->db->where($this->table_id, $id_material); // Primero WHERE
		$this->db->update($this->table, $data); // Luego UPDATE
	}
    function delete($id_material){
        $this->db->where($this->table_id, $id_material);
        $this->db->delete($this->table);
        

    }

	public function listarItems() {
		$this->db->select('id_item, nombre_material, t_unidad, sede, descripcion, precio_u');
		$this->db->from('materiales'); // Asegúrate de que esta tabla exista
		$query = $this->db->get();
		return $query->result();
	}

	/**
     * Obtiene una lista de remisiones únicas desde el inventario.
     * Se usa para evitar mostrar duplicados.
     * Lista de remisiones únicas con un ID de ejemplo.
     */
    public function getRemisionesUnicas() {
        $this->db->select('MIN(id_material) as id_material, remision'); // ID más pequeño por remisión
        $this->db->from('inventario');
        $this->db->group_by('remision'); // Agrupa por remisión
        return $this->db->get()->result();
    }

    /**
     * Busca un material por su ID (otra forma de find()).
     */
    public function findById($id_material) {
        return $this->db->where('id_material', $id_material)
                        ->get('inventario')
                        ->row();
    }

	public function findBySede($sede)
	{
		$this->db->where('sede', $sede);
		$query = $this->db->get('historial'); // Cambia 'items' al nombre real de tu tabla
		return $query->result();
	}
}

