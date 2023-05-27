<?php

class escuela_deportiva_Model {

    var $id;
    var $nombre;
    var $fecha_inscripcion;
    var $fecha_inicio;
    var $fecha_fin;
    var $nivel;

    var $mysqli;

    function __construct($id, $nombre, $fecha_inscripcion, $fecha_inicio,$fecha_fin,$nivel) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->fecha_inscripcion = $fecha_inscripcion;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
        $this->nivel = $nivel;

        //Incluimos la funcion de acceso a la base de datos
		include_once '../Functions/AccessBD.php';

		//Conectamos con la base de datos y guardamos el manejador en un atributo de la clase
		$this->mysqli = ConectarBD();
    }

    //Añadir una escuela_deportiva
    function add() {
        $sql = "INSERT INTO `escuela_deportiva` VALUES (NULL, '$this->nombre', '$this->fecha_inscripcion', '$this->fecha_inicio', '$this->fecha_fin', '$this->nivel');";
        if ($this->mysqli->query($sql) === false) {
            return 'Error en la inserción';
        }
        $this->mysqli->close();
        return true;
    }

    //Devuelve todas las escuela_deportivas
    function getAll() {
        $sql = "SELECT * FROM escuela_deportiva";
        $result = $this->mysqli->query($sql);
		if (!$result) {
			return 'Error en la consulta';
        }
        $this->mysqli->close();
        return $result;
    }

    //Devuelve una escuela_deportiva
    function get() {
        $sql = "SELECT * FROM escuela_deportiva WHERE escuela_deportiva_id = '$this->id'";
        $result = $this->mysqli->query($sql);
		if (!$result) {
			return 'Error en la consulta';
        } else return $result;
        $this->mysqli->close();
    }

    //Editar escuela_deportiva
    function edit(){
        $sql = "SELECT * FROM escuela_deportiva WHERE escuela_deportiva_id LIKE '$this->id'";
        if ($this->mysqli->query($sql) === false) {
          return "Error al buscar el campeonato.";
        } else {
            $sql = "UPDATE escuela_deportiva SET
                        escuela_deportiva_nombre = '$this->nombre',
                        escuela_deportiva_fecha_inicio = '$this->fecha_inicio',
                        escuela_deportiva_fecha_inscripcion = '$this->fecha_inscripcion',
                        escuela_deportiva_fecha_fin = '$this->fecha_fin',
                        escuela_deportiva_nivel = '$this->nivel',
                        WHERE ( escuela_deportiva_id = '$this->id')";
            if ($this->mysqli->query($sql) === false) {
                return "Error al editar el campeonato.";
            } else {
                return true;
            }
        }
        $this->mysqli->close();
    }

    //Borrar escuela_deportiva
    function delete() {
        $sql = "DELETE FROM escuela_deportiva WHERE escuela_deportiva_id LIKE '$this->id'";
        if ($this->mysqli->query($sql)) {
            return true;
        }
        return 'Error en el borrado';
        $this->mysqli->close();
    }

}

?>
