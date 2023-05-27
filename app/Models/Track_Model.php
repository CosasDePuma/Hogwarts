<?php

class track_Model {

    var $id;
    var $suelo;
    var $pared;
    var $ubicacion;

    var $mysqli;

    function __construct($id, $suelo, $pared, $ubicacion) {
        $this->id = $id;
        $this->suelo = $suelo;
        $this->pared = $pared;
        $this->ubicacion = $ubicacion;

        //Incluimos la funcion de acceso a la base de datos
		include_once '../Functions/AccessBD.php';

		//Conectamos con la base de datos y guardamos el manejador en un atributo de la clase
		$this->mysqli = ConectarBD();
    }

    //Añadir una pista
    function add() {
        // Obtenemos el menor id
        $sql = "SELECT MIN(`pista_id`) AS min, MAX(`pista_id`) AS max FROM `pista`;";
        $result = $this->mysqli->query($sql);
        if(!$result) { return "Error en la inserción"; }
        $minmax = $result->fetch_array();
        // Maximo y minimo
        $min = $minmax['min'] - 1;
        $max = $minmax['max'] + 1; 
        // Calculamos el id que debería tener
        $id = $min < 1 ? $max : $min;
        $sql = "INSERT INTO `pista` VALUES ($id, '" . $this->suelo . "', '" . $this->ubicacion . "', '" . $this->pared . "')";
        if ($this->mysqli->query($sql) === true) {
            return true;
        } else return 'Error en la inserción';
        $this->mysqli->close();
    }

    //Devuelve todas las pistas
    function getAll() {
        $sql = "SELECT * FROM pista";
        $result = $this->mysqli->query($sql);
		if (!$result) {
			return 'Error en la consulta';
        } else return $result;
        $this->mysqli->close();
    }

    //Devuelve una pista
    function get() {
        $sql = "SELECT * FROM pista WHERE pista_id = '$this->id'";
        $result = $this->mysqli->query($sql);
		if (!$result) {
			return 'Error en la consulta';
        } else return $result;
        $this->mysqli->close();
    }

    //Editar pista
    function edit(){
        $sql = "SELECT * FROM pista WHERE pista_id LIKE '$this->id'";
        if ($this->mysqli->query($sql) === false) {
          return "Error al buscar el campeonato.";
        } else {
            $sql = "UPDATE pista SET
                        pista_suelo = '$this->suelo',
                        pista_pared = '$this->pared',
                        pista_ubicacion = '$this->ubicacion',
                        WHERE ( pista_id = '$this->id')";
            if ($this->mysqli->query($sql) === false) {
                return "Error al editar el campeonato.";
            } else {
                return true;
            }
        }
        $this->mysqli->close();
    }

    //Borrar pista
    function delete() {
        $sql = "DELETE FROM pista WHERE pista_id LIKE '$this->id'";
        if ($this->mysqli->query($sql)) {
            return true;
        }
        return 'Error en el borrado';
        $this->mysqli->close();
    }

}

?>
