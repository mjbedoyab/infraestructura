<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FacturaRemisionModel extends CI_Model {

    protected $table = 'factura_remision';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Insertar nueva factura-remisión
     */
    public function insertar($data) {
        // $data debe ser un array con: id_factura, factura, remision
        return $this->db->insert($this->table, $data);
    }

    /**
     * Listar todas las facturas-remisiones
     */
    public function findAll() {
        return $this->db->get($this->table)->result();
    }

    /**
     * Buscar una factura-remisión por ID
     */
    public function findById($id) {
        return $this->db->where('id', $id)->get($this->table)->row();
    }

    /**
     * Actualizar factura-remisión
     */
    public function actualizar($id, $data) {
        // $data debe contener los campos a actualizar
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    /**
     * Eliminar factura-remisión
     */
    public function eliminar($id) {
        return $this->db->where('id', $id)->delete($this->table);
    }
}
