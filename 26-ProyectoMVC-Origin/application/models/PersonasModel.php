<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PersonasModel extends CI_Model {

	public $table = 'personas';     // Nombre de la tabla en la base de datos
    public $table_id = 'cedula';    // Llave primaria de la tabla

    public function __construct(){
        $this->load->database();    // Carga la conexión a la base de datos
    }

	/**
	 * Obtiene una persona por su correo electrónico.
	 * Correo electrónico a buscar.
	 * Retorna el primer registro encontrado o null si no existe.
	 */
	public function getPersonaByEmail($email){
		$this->db->where('email', $email);
		$registros = $this->db->get('personas')->result();

		if (sizeof($registros) != 0) {
			return $registros[0]; // Devuelve el primer resultado
		} else {
			return null; // Si no hay resultados
		}
	}

	/**
	 * Verifica si ya existe un registro con la misma cédula o email.
	 * true si no existe duplicado, false si ya existe.
	 */
	public function validarRegistro($cedula, $email){
		$this->db->select('*');
		$this->db->where("cedula", $cedula);
		$this->db->or_where("email", $email);
		$registros = $this->db->get('personas')->result();

		return (sizeof($registros) == 0);
	}

	/**
	 * Valida si una cédula ya existe en la base de datos.
	 * true si no existe, false si existe.
	 */
	public function validarCedula($cedula){
		$this->db->select('*');
		$this->db->where("cedula", $cedula);
		$registros = $this->db->get('personas')->result(); 

		return (sizeof($registros) == 0);
	}

	/**
	 * Valida si un email ya existe en la base de datos.
	 * true si no existe, false si existe.
	 */
	public function validarEmail($email){
		$this->db->select('*');
		$this->db->where("email", $email);
		$registros = $this->db->get('personas')->result();

		return (sizeof($registros) == 0);
	}

	/**
	 * Inserta una nueva persona en la base de datos.
	 */
	public function insertar($cedula, $nombres, $apellidos, $telefono, $direccion, $email, $foto)
	{
		$data = [
			'cedula' => $cedula,
			'nombres' => $nombres,
			'apellidos' => $apellidos,
			'telefono' => $telefono,
			'direccion' => $direccion,
			'email' => $email,
			'foto' => $foto
		];
		return $this->db->insert('personas', $data);
	}

	/**
	 * Actualiza los datos de una persona.
	 */
	public function actualizar($cedula, $nombres, $apellidos, $telefono, $direccion, $email, $foto) {
		$data = [
			'nombres'   => $nombres,
			'apellidos' => $apellidos,
			'telefono'  => $telefono,
			'direccion' => $direccion,
			'email'     => $email,
			'foto'      => $foto
		];
		$this->db->where('cedula', $cedula);
		return $this->db->update('personas', $data);
	}

	/**
	 * Busca una persona por cédula.
	 */
	public function findByCedula($cedula)
	{
		$this->db->where('cedula', $cedula);
		$query = $this->db->get('personas');
		return $query->row(); // Devuelve el registro como objeto
	}

	/**
	 * Lista todas las personas.
	 */
	function findAll(){
        $this->db->select();
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->result();
    }

	/**
	 * Elimina una persona por cédula.
	 */
	public function eliminar($cedula)
	{
		$this->db->where('cedula', $cedula);
		return $this->db->delete('personas');
	}

	/**
	 * Cuenta cuántas personas hay en la base de datos.
	 */
	public function countAll()
	{
		return $this->db->count_all($this->table);
	}

	/**
	 * Obtiene una lista paginada de personas.
	 */
	public function getPaginated($limit, $start)
	{
		$this->db->limit($limit, $start);
		$query = $this->db->get($this->table);
		return $query->result();
	}

	/**
	 * Cuenta cuántos registros coinciden con un término de búsqueda.
	 */
	public function searchCount($search = null)
	{
		if (!empty($search)) {
			$this->db->group_start()
				->like('nombres', $search)
				->or_like('apellidos', $search)
				->or_like('email', $search)
				->or_like('cedula', $search)
			->group_end();
		}
		return $this->db->count_all_results($this->table);
	}

	/**
	 * Obtiene resultados paginados filtrados por búsqueda.
	 */
	public function searchPaginated($limit, $start, $search = null)
	{
		if (!empty($search)) {
			$this->db->group_start()
				->like('nombres', $search)
				->or_like('apellidos', $search)
				->or_like('email', $search)
				->or_like('cedula', $search)
			->group_end();
		}
		$this->db->limit($limit, $start);
		$query = $this->db->get($this->table);
		return $query->result();
	}
	public function actualizarConCambioCedula($cedulaOriginal, $nuevaCedula, $nombres, $apellidos, $telefono, $direccion, $email, $foto) {
    $data = [
        'cedula'    => $nuevaCedula,
        'nombres'   => $nombres,
        'apellidos' => $apellidos,
        'telefono'  => $telefono,
        'direccion' => $direccion,
        'email'     => $email,
        'foto'      => $foto
    ];
    $this->db->where('cedula', $cedulaOriginal);
    return $this->db->update('personas', $data);
}

}


