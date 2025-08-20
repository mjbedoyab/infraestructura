<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UsuariosModel extends CI_Model {

    /**
     * Valida el ingreso de un usuario comprobando email y contraseña.
     * Correo del usuario.
     * Contraseña sin encriptar ingresada por el usuario.
     * Retorna el usuario si las credenciales son correctas, false si no.
     */
    public function validarIngreso($email, $password){
        // Selecciona los campos necesarios, incluido 'password'
        $this->db->select('cedula, email, tipo, password');
        $this->db->where('email', $email);
        $this->db->where('estado', 'ACTIVO'); // Solo usuarios activos
        $usuario = $this->db->get('usuarios')->row();

        // Verifica que exista y que la contraseña coincida
        if ($usuario && password_verify($password, $usuario->password)) {
            return $usuario;
        }

        return false; // Credenciales incorrectas
    }

    /**
     * Obtiene la información de un usuario por su email.
     * Correo electrónico.
     * Retorna el usuario si existe, null si no.
     */
    public function getUsuarioByEmail($email){
        $this->db->select("cedula, tipo, estado");
        $this->db->where('email', $email);
        $registros = $this->db->get('usuarios')->result(); 

        if (sizeof($registros) != 0) {
            return $registros[0];
        } else {
            return null;
        }
    }

    /**
     * Inserta un nuevo usuario en la base de datos.
     * Cédula del usuario.
     * Correo electrónico.
     * Contraseña sin encriptar.
     * Tipo de usuario (admin, usuario, etc.).
     * true si se insertó correctamente.
     */
    public function insertar($cedula, $email, $password, $tipo){ 
        $data = [
            'cedula' => $cedula,
            'email' => $email,
            'password'=> password_hash($password, PASSWORD_BCRYPT), // Encripta la contraseña
            'tipo' => $tipo,
            'estado' => 'ACTIVO'
        ];
        return $this->db->insert('usuarios', $data);
    }

    /**
     * Busca un usuario por su cédula.
     * Cédula del usuario.
     * Retorna el usuario si existe, null si no.
     */
    public function findByCedula($cedula) {
        return $this->db->get_where('usuarios', ['cedula' => $cedula])->row();
    }

    /**
     * Actualiza los datos de un usuario.
     * Cédula del usuario.
     *  Nuevo email.
     * Nueva contraseña sin encriptar.
     * Nuevo tipo de usuario.
     * true si la actualización fue exitosa.
     */
   

	// Actualiza usuario con nueva contraseña
	public function actualizar($cedula, $email, $password, $tipo)
	{
		$data = [
			'email'   => $email,
			'password' => $password, // Ya viene con password_hash desde el controlador
			'tipo'     => $tipo
		];
		$this->db->where('cedula', $cedula);
		return $this->db->update('usuarios', $data);
	}

	// Actualiza usuario sin cambiar la contraseña
	public function actualizarSinPassword($cedula, $email, $tipo)
	{
		$data = [
			'email' => $email,
			'tipo'   => $tipo
		];
		$this->db->where('cedula', $cedula);
		return $this->db->update('usuarios', $data);
}

    /**
     * Elimina un usuario de la base de datos por su cédula.
     * Cédula del usuario.
     * true si la eliminación fue exitosa.
     */
    public function eliminar($cedula)
    {
        $this->db->where('cedula', $cedula);
        return $this->db->delete('usuarios');
    }

    /**
     * Busca un usuario por su correo electrónico.
     * Correo electrónico.
     * Retorna el usuario si existe, null si no.
     */
    public function findByCorreo($email) {
        return $this->db->get_where('usuarios', ['email' => $email])->row();
    }

	public function actualizarConCambioCedula($cedulaOriginal, $nuevaCedula, $email, $password, $tipo) {
		$data = [
			'cedula'   => $nuevaCedula,
			'email'    => $email,
			'password' => $password,
			'tipo'     => $tipo
		];
		$this->db->where('cedula', $cedulaOriginal);
		return $this->db->update('usuarios', $data);
	}

	public function actualizarSinPasswordConCambioCedula($cedulaOriginal, $nuevaCedula, $email, $tipo) {
		$data = [
			'cedula' => $nuevaCedula,
			'email'  => $email,
			'tipo'   => $tipo
		];
		$this->db->where('cedula', $cedulaOriginal);
		return $this->db->update('usuarios', $data);
	}


}
