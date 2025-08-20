<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ItemsModel extends CI_Model {

    // Nombre de la tabla en la base de datos
    public $table = 'materiales';
    // Campo clave primaria de la tabla
    public $table_id = 'id_item';

    public function __construct() {
        // Carga la base de datos para que las funciones puedan usarla
        $this->load->database();
    }

    /**
     * Busca un registro en la tabla por su ID.
     * ID del ítem.
     * Retorna el objeto del ítem o null si no existe.
     */
    function find($id_item) {
        $this->db->select(); // Selecciona todos los campos
        $this->db->from($this->table); // Desde la tabla 'materiales'
        $this->db->where($this->table_id, $id_item); // Donde id_item sea igual al valor pasado

        $query = $this->db->get(); // Ejecuta la consulta
        return $query->row(); // Retorna solo la primera fila encontrada
    }

    /**
     * Obtiene todos los registros de la tabla.
     * Lista de todos los ítems.
     */
    function findAll() {
        $this->db->select(); // Selecciona todos los campos
        $this->db->from($this->table); // Desde la tabla 'materiales'

        $query = $this->db->get(); // Ejecuta la consulta
        return $query->result(); // Retorna todas las filas como un array de objetos
    }

    /**
     * Inserta un nuevo ítem en la base de datos.
     * Datos del nuevo ítem.
     * ID del ítem insertado.
     */
    function insert($data) {
        $this->db->insert($this->table, $data); // Inserta los datos
        return $this->db->insert_id(); // Retorna el ID autogenerado del nuevo ítem
    }

    /**
     * Actualiza un ítem existente.
     * ID del ítem a actualizar.
     * Nuevos datos para actualizar.
     */
    function update($id_item, $data) {
        $this->db->where($this->table_id, $id_item); // Filtra por el ID
        $this->db->update($this->table, $data); // Actualiza los datos
    }

    /**
     * Elimina un ítem por su ID.
     * ID del ítem a eliminar.
     */
    function delete($id_item) {
        $this->db->where($this->table_id, $id_item); // Filtra por el ID
        $this->db->delete($this->table); // Elimina el registro
    }

    /**
     * Lista todos los ítems disponibles en la tabla materiales.
     * Útil para llenar selects o mostrar catálogos.
     *  Lista de ítems.
     */
    public function listarItems() {
        return $this->db->get('materiales')->result(); // Obtiene todos los registros de la tabla 'materiales'
    }

	public function findBySede($sede)
	{
		$this->db->where('sede', $sede);
		$query = $this->db->get('materiales'); // Cambia 'items' al nombre real de tu tabla
		return $query->result();
	}
}

