<?php

class partido_promocionado_Model {

    var $id;
    var $hora;
    var $fecha;

    var $mysqli;

    function __construct($id, $hora, $fecha) {
        $this->id = $id;
        $this->hora = $hora;
        $this->fecha = date('Y-m-d', strtotime($fecha));

        //Incluimos la funcion de acceso a la base de datos
		include_once '../Functions/AccessBD.php';

		//Conectamos con la base de datos y guardamos el manejador en un atributo de la clase
		$this->mysqli = ConectarBD();
    }

    //Añadir un partido promocionado nuevo
    function add() {
        $sql = "INSERT INTO partido_promocionado VALUES (null, '$this->hora', '$this->fecha')";
        if ($this->mysqli->query($sql)) {
            return true;
        } else return 'Error en la inserción';
    }

    //Devuelve todos los partidos promocionados y el número de usuarios inscritos
    function getAll() {
        $sql = "SELECT p.*, count(u.partido_promocionado_id) AS partido_promocionado_num_deportistas FROM partido_promocionado p 
                LEFT JOIN usuario_partido_promocionado u ON u.partido_promocionado_id = p.partido_promocionado_id
                GROUP BY p.partido_promocionado_id
                ORDER BY p.partido_promocionado_fecha, p.partido_promocionado_hora";
        $result = $this->mysqli->query($sql);
		if (!$result) {
			return 'Error en la consulta';
		} else return $result;
    }

    //Devuelve un partido promocionado
    function get() {
        $sql = "SELECT * FROM partido_promocionado WHERE partido_promocionado_id = '$this->id'";
        $result = $this->mysqli->query($sql);
		if (!$result) {
			return 'Error en la consulta';
		} else return $result;
    }

    //Borrar partido promocionado existente
    //Borra tambien todos los usuarios que estuviesen inscritos a ese partido
    function delete() {
        $sql = "DELETE FROM usuario_partido_promocionado WHERE partido_promocionado_id LIKE '$this->id'";
        if ($this->mysqli->query($sql)) {
            $sql = "DELETE FROM partido_promocionado WHERE partido_promocionado_id LIKE '$this->id'";
            if ($this->mysqli->query($sql)) {
                return true;
            }
        }
        return 'Error en el borrado';
    }

    //Inscribirse en un partido promocionado existente
    //Comprueba que el usuario no este ya inscrito en ese partido
    function enroll($user) {
        if (!$this->isFull()){
            $sql = "SELECT * FROM usuario_partido_promocionado WHERE partido_promocionado_id = '$this->id' && usuario_id = '$user'";
            $result = $this->mysqli->query($sql);
            if ($result->num_rows == 0) {
                $sql = "INSERT INTO usuario_partido_promocionado (usuario_id, partido_promocionado_id) VALUES ('$user','$this->id')";
                if ($this->mysqli->query($sql)) {
                    return true;
                } else return 'Error de inserción';
            } else return 'Ya estás inscrito en este partido';
        } else return 'El partido ya está lleno';
    }

    //Darse de baja de un partido promocionado
    function disenroll($user) {
        $sql = "SELECT * FROM usuario_partido_promocionado WHERE partido_promocionado_id = '$this->id' && usuario_id = '$user'";
        if ($this->mysqli->query($sql) == 1) {
            $sql = "DELETE FROM usuario_partido_promocionado WHERE partido_promocionado_id = '$this->id' && usuario_id = '$user'";
            if ($this->mysqli->query($sql)) {
                return true;
            } else return 'Error de borrado';
        } else return 'No estás inscrito en este partido';
    }


    //Devuelve los usuarios inscritos en un partido
    function getEnrolled() {
        $sql = "SELECT u.* FROM usuario u, usuario_partido_promocionado p WHERE p.partido_promocionado_id = '$this->id' && p.usuario_id = u.usuario_id";
        $result = $this->mysqli->query($sql);
		return $result;
    }

    //Comprueba si un partido promocionado tiene cuatro deportistas inscritos
    function isFull() {
        $sql = "SELECT * FROM usuario_partido_promocionado WHERE partido_promocionado_id = '$this->id'";
        $result = $this->mysqli->query($sql);
        if ($result->num_rows == 4) {
            return true;
        } else return false;
    }

}

?>
