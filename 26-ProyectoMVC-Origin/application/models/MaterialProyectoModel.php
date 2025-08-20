<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MaterialProyectoModel extends CI_Model {

    // Nombre de la tabla que guarda la relación material-proyecto
    public $tabla = 'materialproyecto';

    /**
     * Inserta un material en un proyecto, restando del inventario.
     * 
     * @param int $id_proyecto ID del proyecto.
     * @param int $id_material ID del material.
     * @param float $cantidad Cantidad a asignar.
     * @return bool Retorna true si se insertó correctamente, false si no hay inventario suficiente.
     */
    public function insertar($id_proyecto, $id_material, $cantidad) {
        // Obtiene datos del material desde el inventario
        $material = $this->db->get_where('inventario', ['id_material' => $id_material])->row();

        // Validar que el material exista y que haya suficiente cantidad disponible
        if (!$material || $material->cantidad < $cantidad) {
            log_message('error', 'Error: inventario insuficiente o material no encontrado');
            return false;
        }

        // Validar que el precio unitario esté definido correctamente
        if (!isset($material->precio_u) || !is_numeric($material->precio_u)) {
            log_message('error', 'Error: precio_u no definido correctamente');
            return false;
        }

        // Calcular el total (cantidad × precio unitario)
        $total = $cantidad * (double) $material->precio_u;

        // Insertar el registro en materialproyecto
        $data = [
            'id_proyecto' => $id_proyecto,
            'id_material' => $id_material,
            'cantidad' => $cantidad,
            'total' => $total
        ];
        $this->db->insert($this->tabla, $data);

        // Restar la cantidad del inventario
        $this->db->set('cantidad', 'cantidad - ' . (float)$cantidad, false)
                 ->where('id_material', $id_material)
                 ->update('inventario');

        // Recalcular el total_u (valor total en inventario)
        $nueva_cantidad = $material->cantidad - $cantidad;
        $nuevo_total_u = $nueva_cantidad * $material->precio_u;

        $this->db->set('total_u', $nuevo_total_u)
                 ->where('id_material', $id_material)
                 ->update('inventario');

        return true;
    }

    /**
     * Actualiza la cantidad de un material asignado a un proyecto.
     * 
     * @param int $id_proyecto ID del proyecto.
     * @param int $id_material ID del material.
     * @param float $nueva_cantidad Nueva cantidad a asignar.
     * @return bool Retorna true si se actualizó correctamente, false si no hay inventario suficiente o no existe el registro.
     */
    public function actualizar($id_proyecto, $id_material, $nueva_cantidad) {
        // Obtener el registro actual de materialproyecto
        $registro = $this->db->get_where($this->tabla, [
            'id_proyecto' => $id_proyecto,
            'id_material' => $id_material
        ])->row();

        if (!$registro) return false;

        // Obtener datos del material en inventario
        $material = $this->db->get_where('inventario', ['id_material' => $id_material])->row();
        if (!$material) return false;

        // Calcular diferencia entre la nueva cantidad y la anterior
        $cantidad_diff = $nueva_cantidad - $registro->cantidad;

        // Si se está aumentando la cantidad, verificar si hay suficiente inventario
        if ($cantidad_diff > 0 && $material->cantidad < $cantidad_diff) return false;

        // Calcular nuevo total
        $nuevo_total = $nueva_cantidad * $material->precio_u;

        // Actualizar el registro en materialproyecto
        $this->db->where([
            'id_proyecto' => $id_proyecto,
            'id_material' => $id_material
        ])->update($this->tabla, [
            'cantidad' => $nueva_cantidad,
            'total' => $nuevo_total
        ]);

        // Ajustar inventario
        $this->db->set('cantidad', 'cantidad - ' . $cantidad_diff, false)
                 ->where('id_material', $id_material)
                 ->update('inventario');

        // Recalcular total_u
        $nueva_cantidad_inv = $material->cantidad - $cantidad_diff;
        $nuevo_total_u = $nueva_cantidad_inv * $material->precio_u;

        $this->db->set('total_u', $nuevo_total_u)
                 ->where('id_material', $id_material)
                 ->update('inventario');

        return true;
    }

    /**
     * Elimina un material de un proyecto y devuelve la cantidad al inventario.
     * 
     * ID del proyecto.
     * ID del material.
     * Retorna true si se eliminó correctamente, false si no existe el registro.
     */
    public function eliminar($id_proyecto, $id_material) {
        // Obtener el registro en materialproyecto
        $registro = $this->db->get_where($this->tabla, [
            'id_proyecto' => $id_proyecto,
            'id_material' => $id_material
        ])->row();

        if (!$registro) return false;

        // Eliminar el registro de materialproyecto
        $this->db->delete($this->tabla, [
            'id_proyecto' => $id_proyecto,
            'id_material' => $id_material
        ]);

        // Devolver la cantidad al inventario
        $this->db->set('cantidad', 'cantidad + ' . $registro->cantidad, false)
                 ->where('id_material', $id_material)
                 ->update('inventario');

        // Recalcular total_u
        $material = $this->db->get_where('inventario', ['id_material' => $id_material])->row();
        $nueva_cantidad = $material->cantidad + $registro->cantidad;
        $nuevo_total_u = $nueva_cantidad * $material->precio_u;

        $this->db->set('total_u', $nuevo_total_u)
                 ->where('id_material', $id_material)
                 ->update('inventario');

        return true;
    }

    /**
     * Lista todos los materiales asignados a un proyecto con detalles.
     * 
     * ID del proyecto.
     * Lista de materiales con datos del proyecto y del inventario.
     */
    public function listarPorProyecto($id_proyecto) {
        $this->db->select('
            mp.id_proyecto,
            mp.id_material,
            p.nombre AS nombre_proyecto,
            i.remision,
            i.nombre_material,
            i.t_unidad,
            i.sede,
            i.precio_u,
            i.descripcion,
            mp.cantidad,
            mp.total
        ');
        $this->db->from('materialproyecto mp');
        $this->db->join('proyecto p', 'mp.id_proyecto = p.id_proyecto');
        $this->db->join('inventario i', 'mp.id_material = i.id_material');
        $this->db->where('mp.id_proyecto', $id_proyecto);
        return $this->db->get()->result();
    }

    /**
     * Obtiene un material específico asignado a un proyecto.
     * 
     * ID del proyecto.
     * ID del material.
     * Objeto con los datos del material en el proyecto o null si no existe.
     */
    public function obtener($id_proyecto, $id_material) {
        return $this->db->get_where($this->tabla, [
            'id_proyecto' => $id_proyecto,
            'id_material' => $id_material
        ])->row();
    }
}

