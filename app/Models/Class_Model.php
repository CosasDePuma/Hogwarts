<?php

class class_Model {

    var $id;
    var $fecha;
    var $hora;
    var $nombre;
    var $descripcion;
    var $entrenador;
    var $escuela;

    var $mysqli;

    function __construct($id, $fecha, $hora,$nombre,$descripcion,$entrenador,$escuela) {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->hora = $hora;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->entrenador = $entrenador;
        $this->escuela = $escuela;

        //Incluimos la funcion de acceso a la base de datos
		include_once '../Functions/AccessBD.php';

		//Conectamos con la base de datos y guardamos el manejador en un atributo de la clase
		$this->mysqli = ConectarBD();
    }

    //Añadir una clase
    function add() {
        $sql = "INSERT INTO `clase` VALUES (null, '" . $this->fecha . "', '" . $this->hora . "', '" . $this->nombre . "', '" . $this->descripcion . "', '" . $this->entrenador ."', null)";
        if ($this->mysqli->query($sql) === true) {
            return true;
        } else return 'Error en la inserción';
    }

    //Devuelve todas las clases
    function getAll() {
        $sql = "SELECT * FROM `clase`";
        $result = $this->mysqli->query($sql);
		if (!$result) {
			return 'Error en la consulta';
        } else return $result;
		$this->mysqli->close();
    }

    //Devuelve una clase
    function get() {
        $sql = "SELECT * FROM `clase` WHERE `clase_id` = '$this->id'";
        $result = $this->mysqli->query($sql);
		if (!$result) {
			return 'Error en la consulta';
		} else return $result;
    }

    // Inscribirse en una clase
    function inscribirse() {
        $sql = "INSERT INTO `asistencia` VALUES (" . $this->id . ", '" . $_SESSION["email"] . "', 0)";
        $result = $this->mysqli->query($sql);
        if (!result) {
            return false;
        }
        else return $result;
    }

    // Desinscribirse de una clase
    function desinscribirse() {
        $sql = "DELETE FROM `asistencia` WHERE (`clase_id` = " . $this->id . " AND `usuario_email` = '" . $_SESSION["email"] . "')";
        $result = $this->mysqli->query($sql);
        if (!result) {
            return false;
        }
        else return $result;
    }

    // Comprobar si ya está inscrito en una clase
    function estaInscrito() {
        $sql = "SELECT `usuario_email` FROM `asistencia` WHERE (`clase_id` = " . $this->id . " AND `usuario_email` = '" . $_SESSION["email"] . "')";
        $result = $this->mysqli->query($sql);
        return $result->num_rows != 0;
        if (!result) {
            return false;
        }
        else return $result;
    }

    // Devuelve la lista de asistencia
    function listaAsistencia() {
        $sql = "SELECT `usuario_email`, `asistencia` FROM `asistencia` WHERE `clase_id`=$this->id";
        return $this->mysqli->query($sql);
    }

    //Editar clase
    function edit(){
        $sql = "SELECT * FROM `clase` WHERE `clase_id` LIKE '$this->id'";
        if ($this->mysqli->query($sql) === false) {
          return "Error al buscar el campeonato.";
        } else {
            $sql = "UPDATE clase SET
                        clase_fecha = '$this->suelo',
                        clase_hora = '$this->pared',
                        clase_nombre = '$this->ubicacion',
                        clase_descripcion = '$this->suelo',
                        clase_entrenador = '$this->pared',
                        clase_escuela = '$this->ubicacion',
                        WHERE ( clase_id = '$this->id')";
            if ($this->mysqli->query($sql) === false) {
                return "Error al editar el campeonato.";
            } else {
                return true;
            }
        }
    }

    //Borrar clase
    function delete() {
        $sql = "DELETE FROM asistencia WHERE clase_id LIKE '$this->id'";
        @$this->mysqli->query($sql);
        $sql = "DELETE FROM clase WHERE clase_id LIKE '$this->id'";
        if ($this->mysqli->query($sql)) {
            return true;
        }
        return 'Error en el borrado';
    }

}

?>
