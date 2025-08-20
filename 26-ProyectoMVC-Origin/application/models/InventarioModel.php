<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InventarioModel extends CI_Model {

    // Nombre de la tabla en la base de datos
    public $table = 'inventario';
    // Nombre del campo clave primaria
    public $table_id = 'id_material';

    public function __construct() {
        // Carga la conexión a la base de datos de CodeIgniter
        $this->load->database();
    }

    /**
     * Busca un material específico por su ID.
     * ID del material.
     * Retorna un solo registro o null si no existe.
     */
    function find($id_material) {
        $this->db->select();
        $this->db->from($this->table);
        $this->db->where($this->table_id, $id_material);

        $query = $this->db->get();
        return $query->row(); // Retorna solo la primera fila
    }

    /**
     * Obtiene todos los registros de la tabla inventario.
     * Lista de todos los materiales en inventario.
     */
    function findAll() {
        $this->db->select();
        $this->db->from($this->table);

        $query = $this->db->get();
        return $query->result(); // Retorna todas las filas
    }

    /**
     * Inserta un nuevo registro en inventario.
     *  Datos del material a insertar.
     *  ID del material recién insertado.
     */
    function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id(); // Retorna el ID generado
    }

    /**
     * Actualiza un material existente.
     * ID del material a actualizar.
     * Datos a actualizar.
     */
    function update($id_material, $data) {
        $this->db->where($this->table_id, $id_material); // Filtra por ID
        $this->db->update($this->table, $data); // Actualiza los datos
    }

    /**
     * Elimina un material del inventario.
     * ID del material a eliminar.
     */
    function delete($id_material) {
        $this->db->where($this->table_id, $id_material);
        $this->db->delete($this->table);
    }

    /**
     * Lista todos los ítems disponibles en la tabla "materiales".
     * Esto se usa, por ejemplo, para llenar selects en formularios.
     * Lista de ítems.
     */
    public function listarItems() {
        $this->db->select('id_item, nombre_material, t_unidad, sede, descripcion, precio_u');
        $this->db->from('materiales'); // Tabla que contiene los materiales base
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
		$query = $this->db->get('inventario'); // Cambia 'items' al nombre real de tu tabla
		return $query->result();
	}
	public function findByRemision($remision)
	{
		$this->db->select('*');
		$this->db->from($this->table); // $this->table debería ser 'inventario' o el nombre real
		$this->db->where('remision', $remision);
		$query = $this->db->get();

		
		return $query->row(); 
	}
}
?>
