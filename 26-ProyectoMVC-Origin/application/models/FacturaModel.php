<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FacturaModel extends CI_Model {

    // Nombre de la tabla en la base de datos
    public $table = 'facturas';
    // Nombre del campo que actúa como clave primaria
    public $table_id = 'id_factura';

    public function __construct(){
        // Carga la conexión a la base de datos
        $this->load->database();
    }

    /**
     * Busca una factura por su ID.
     * $id_factura ID de la factura.
     * Retorna la factura encontrada o null si no existe.
     */
    function find($id_factura){
        $this->db->select();
        $this->db->from($this->table);
        $this->db->where($this->table_id, $id_factura);
        $query = $this->db->get();
        return $query->row();
    }

    /**
     * Obtiene todas las facturas registradas.
     * Lista de facturas.
     */
    function findAll(){
        $this->db->select();
        $this->db->from($this->table); 
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Inserta una nueva factura en la base de datos.
     * Datos de la factura.
     * ID de la factura insertada.
     */
    function insert($data){
        $this->db->insert($this->table, $data); 
        return $this->db->insert_id();
    }

    /**
     * Actualiza los datos de una factura existente.
     * ID de la factura a actualizar.
     * Datos a actualizar.
     * true si se actualizó correctamente.
     */
    function update($id_factura, $data){
        $this->db->where($this->table_id, $id_factura); // Aplica la condición WHERE
        return $this->db->update($this->table, $data); // Ejecuta el UPDATE
    }

    /**
     * Elimina una factura de la base de datos.
     * ID de la factura a eliminar.
     * true si la eliminación fue exitosa.
     */
    function delete($id_factura){
        $this->db->where($this->table_id, $id_factura);
        return $this->db->delete($this->table);
    }

    /**
     * Busca una factura por su ID (otra forma de hacerlo).
     * ID de la factura.
     * Retorna la factura encontrada o null si no existe.
     */
    public function findById($id_factura) {
        return $this->db->where('id_factura', $id_factura)
                        ->get($this->table)
                        ->row();
    }
}
?>

