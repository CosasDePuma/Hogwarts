<?php
class USER_Model {
	var $nombre;
	var $apellido;
	var $email;
	var $contrasenha;
	var $dni;
	var $nivel;
	var $sexo;
	var $tipo;
	var $mysqli;

	function __construct($nombre, $apellido, $email, $contrasenha, $dni, $nivel, $sexo, $tipo) {
		$this->nombre = $nombre;
		$this->apellido = $apellido;
		$this->email = $email;
		$this->contrasenha = $contrasenha;
		$this->dni = $dni;
		$this->nivel = $nivel;
		$this->sexo = $sexo;
		$this->tipo = $tipo;

		//Incluimos la funcion de acceso a la base de datos
		include_once '../Functions/AccessBD.php';

		//Conectamos con la base de datos y guardamos el manejador en un atributo de la clase
		$this->mysqli = ConectarBD();
	}

	//Funcion: Comprueba si el usuario existe, si existe, comprueba la contraseña. Si coincide la contraseña retorna true
	function login() {
		$sql = "SELECT * FROM `usuario` WHERE usuario_email like '" . $this->email . "'";
		$resultado = $this->mysqli->query( $sql );
		if ( $resultado->num_rows == 0 ) {
			return 'El usuario no existe';
		} else {
			$tupla = $resultado->fetch_array();
			if ( password_verify($this->contrasenha, $tupla[4])) {
				/* Ni idea de porque no quiere funcionar con $tupla['usuario_contraseña'] */
				return true;	/* Posiblemente sea por la ñ de contraseña, la sol seria cambiar la BD. */
			} else {
				return 'La contraseña para este usuario no es correcta';
			}
		}
		$this->mysqli->close();
	}

	//Funcion: Realiza el registro de un usuario. Si se produce un error retorna true
	function registro(){
		$sql = "INSERT INTO `usuario` VALUES (NULL,'" . $this->nombre . "','" . $this->apellido . "','" . $this->email . "','" . $this->contrasenha . "','" . $this->dni . "','" . $this->nivel . "','" . $this->sexo . "','" . $this->tipo . "')";
		if ($this->mysqli->query($sql) === false) {
			return "Usuario no registrado. Ocurrio un problema...";
		} else {
			return false;
		}
		$this->mysqli->close();
	}

	//Funcion: Devuelve el tipo del usuario deseado.
	function getTipo(){
		$sql = "SELECT usuario_tipo FROM usuario WHERE (`usuario_email` COLLATE utf8_bin = '$this->email')";
		$resultado = $this->mysqli->query( $sql );
		if ( $resultado->num_rows == 0 ) {
			return 'El usuario no existe';
		} else {
			$tupla = $resultado->fetch_array();
			$retour = $tupla[ 'usuario_tipo' ];
			return $retour;
		}
	}

	//Funcion: Devuelve el id del usuario deseado.
	function getId(){
		$sql = "SELECT usuario_id FROM usuario WHERE (`usuario_email` COLLATE utf8_bin = '$this->email')";
		$resultado = $this->mysqli->query( $sql );
		if ( $resultado->num_rows == 0 ) {
			return 'El usuario no existe';
		} else {
			$tupla = $resultado->fetch_array();
			$retour = $tupla[ 'usuario_id' ];
			return $retour;
		}
	}
}
?>
