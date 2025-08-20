<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProyectoModel extends CI_Model {

    public $table = 'proyecto';            // Nombre de la tabla en la base de datos
    public $table_id = 'id_proyecto';      // Llave primaria de la tabla

    public function __construct(){
        $this->load->database();           // Carga la conexión a la base de datos
    }

    /**
     * Busca un proyecto por su ID.
     * ID del proyecto.
     * Retorna el registro como objeto o null si no existe.
     */
    public function find($id_proyecto){
        $this->db->select();                                   // Selecciona todos los campos
        $this->db->from($this->table);                         // Desde la tabla de proyectos
        $this->db->where($this->table_id, $id_proyecto);       // Filtra por ID

        $query = $this->db->get();
        return $query->row(); // Retorna un solo registro
    }

    /**
     * Obtiene todos los proyectos.
     * Lista de proyectos.
     */
    public function findAll(){
        $this->db->select();               // Selecciona todos los campos
        $this->db->from($this->table);     // Desde la tabla de proyectos
        $query = $this->db->get();
        return $query->result();           // Retorna múltiples registros
    }

    /**
     * Inserta un nuevo proyecto en la base de datos.
     * Datos del proyecto (nombre, descripción, etc.).
     * ID del nuevo proyecto o false si falla.
     */
    public function insert($data){
        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id(); // Retorna el ID generado
        }
        return false; // Si falla, retorna false
    }

    /**
     * Actualiza un proyecto existente.
     * ID del proyecto a actualizar.
     * Datos nuevos.
     * true si la actualización fue exitosa.
     */
    public function update($id_proyecto, $data){
        $this->db->where($this->table_id, $id_proyecto); // Filtra por ID
        return $this->db->update($this->table, $data);   // Ejecuta la actualización
    }

    /**
     * Elimina un proyecto por su ID.
     * ID del proyecto a eliminar.
     * true si la eliminación fue exitosa, false si no existe.
     */
    public function delete($id_proyecto){
        if ($this->find($id_proyecto)) { // Verifica que exista antes de borrar
            $this->db->where($this->table_id, $id_proyecto);
            return $this->db->delete($this->table);
        }
        return false; // No se encontró el proyecto
    }

	public function findAllsede(){
		$this->db->select();               // Selecciona todos los campos
		$this->db->from($this->table);     // Desde la tabla de proyectos
		$this->db->where('sede', 'AGROPECUARIO'); // Filtrar por sede Agropecuario
		$query = $this->db->get();
		return $query->result();           // Retorna múltiples registros
	}
	public function findAllseded(){
		$this->db->select();               // Selecciona todos los campos
		$this->db->from($this->table);     // Desde la tabla de proyectos
		$this->db->where('sede', 'DESPACHO'); // Filtrar por sede Agropecuario
		$query = $this->db->get();
		return $query->result();           // Retorna múltiples registros
	}
	public function findAllsedeO(){
		$this->db->select();               // Selecciona todos los campos
		$this->db->from($this->table);     // Desde la tabla de proyectos
		$this->db->where('sede', 'CENTRO'); // Filtrar por sede Agropecuario
		$query = $this->db->get();
		return $query->result();           // Retorna múltiples registros
	}

}
?>


