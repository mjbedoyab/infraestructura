<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EstadisticasModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Obtener estadísticas para sede AGROPECUARIO
     */
    public function getEstadisticasAgropecuario() {
        $this->db->select('COUNT(*) AS cantidad_materiales, SUM(precio_u) AS total_precio');
        $this->db->from('materiales');
        $this->db->where('sede', 'AGROPECUARIO');
        $query = $this->db->get();
        return $query->row_array();
    }

    /**
     * Obtener estadísticas para sede DESPACHO
     */
    public function getEstadisticasDespacho() {
        $this->db->select('COUNT(*) AS cantidad_materiales, SUM(precio_u) AS total_precio');
        $this->db->from('materiales');
        $this->db->where('sede', 'DESPACHO');
        $query = $this->db->get();
        return $query->row_array();
    }

    /**
     * Obtener estadísticas para sede CENTRO
     */
    public function getEstadisticasCentro() {
        $this->db->select('COUNT(*) AS cantidad_materiales, SUM(precio_u) AS total_precio');
        $this->db->from('materiales');
        $this->db->where('sede', 'CENTRO');
        $query = $this->db->get();
        return $query->row_array();
    }

	/* ===== PROYECTOS ===== */

    // Cantidad de proyectos por sede
    public function countProyectosAgropecuario() {
        return $this->db->where('sede', 'AGROPECUARIO')->count_all_results('proyecto');
    }

    public function countProyectosDespacho() {
        return $this->db->where('sede', 'DESPACHO')->count_all_results('proyecto');
    }

    public function countProyectosCentro() {
        return $this->db->where('sede', 'CENTRO')->count_all_results('proyecto');
    }

    // Cantidad total de proyectos
    public function countProyectosTotal() {
        return $this->db->count_all('proyecto');
    }

    // Cantidad de proyectos por estado
    public function countProyectosPendiente() {
        return $this->db->where('estado', 'PENDIENTE')->count_all_results('proyecto');
    }

    public function countProyectosEnProceso() {
        return $this->db->where('estado', 'ENPROCESO')->count_all_results('proyecto');
    }

    public function countProyectosFinalizados() {
        return $this->db->where('estado', 'FINALIZADO')->count_all_results('proyecto');
    }

    /* ===== USUARIOS ===== */

    // Cantidad de usuarios activos
    public function countUsuariosActivos() {
        return $this->db->where('estado', 'ACTIVO')->count_all_results('usuarios');
    }

    // Cantidad de usuarios por tipo
    public function countUsuariosAgropecuario() {
        return $this->db->where('tipo', 'AGROPECUARIO')->count_all_results('usuarios');
    }

    public function countUsuariosDespacho() {
        return $this->db->where('tipo', 'DESPACHO')->count_all_results('usuarios');
    }

    public function countUsuariosCentro() {
        return $this->db->where('tipo', 'CENTRO')->count_all_results('usuarios');
    }

    public function countUsuariosAdmin() {
        return $this->db->where('tipo', 'ADMIN')->count_all_results('usuarios');
    }
}
