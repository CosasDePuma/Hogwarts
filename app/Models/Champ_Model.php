<?php
class CHAMP_Model {
  var $mysqli;
  var $id;
  var $nombre;
  var $descripcion;
  var $nivel;
  var $genero;
  var $escerrado;

  function __construct($id, $nombre, $descripcion, $nivel, $genero, $escerrado) {
    $this->id = $id;
    $this->nombre = $nombre;
    $this->descripcion = $descripcion;
    $this->nivel = $nivel;
    $this->genero = $genero;
    $this->escerrado = $escerrado;

		include_once '../Functions/AccessBD.php';  //Incluimos la funcion de acceso a la base de datos
		$this->mysqli = ConectarBD();  //Conectamos con la base de datos y guardamos el manejador en un atributo de la clase
  }
  function getChamp(){
    $sql = "SELECT * FROM `campeonato`";
		$resultado = $this->mysqli->query( $sql );
		if ( $resultado->num_rows == 0 ) {
			return null;
		} else {
      return $resultado;
		}
		$this->mysqli->close();
  }
  function addChamp(){
    $sql = "INSERT INTO `campeonato` VALUES (NULL, '" . $this->nombre . "', '" . $this->descripcion . "', '" . $this->nivel . "', '" . $this->genero . "', 0)";
    if ($this->mysqli->query($sql) === false) {
			return "Error al añadir el campeonato.";
		} else {
			return true;
		}
		$this->mysqli->close();
  }
  function editChamp(){
    $sql = "SELECT  `campeonato_nombre`, `campeonato_descripcion`, `campeonato_nivel`, `campeonato_sexo` FROM `campeonato` WHERE `campeonato_id` LIKE '". $this->id ."'";
    if ($this->mysqli->query($sql) === false) {
      return "Error al buscar el campeonato.";
    } else {
  		$sql = "UPDATE `campeonato` SET
                      `campeonato_nombre` = '".$this->nombre."',
                      `campeonato_descripcion` = '".$this->descripcion."',
                      `campeonato_nivel` = '".$this->nivel."',
                      `campeonato_sexo` = '".$this->genero."'
                      WHERE ( `campeonato_id` = '".$this->id."')";
      if ( $this->mysqli->query($sql) === false ) {
        return "Error al editar el campeonato.";
      }
      else {
        return true;
      }
    }
    $this->mysqli->close();
  }
  function deleteChamp(){
    $sql = "DELETE FROM `usuario_campeonato` WHERE `campeonato_id` LIKE '$this->id'";
    if ($this->mysqli->query($sql) == true) {
      $sql = "DELETE FROM `campeonato` WHERE `campeonato_id` LIKE '$this->id'";
      if ($this->mysqli->query($sql) == true) {
        return true;
      } else {
        return 'Error en el borrado';
      }

    } else {
      return 'Error en el borrado de los participantes.';
    }
  }
  function closeChamp() {
    $sql = "SELECT * FROM `campeonato` WHERE `campeonato_nombre` LIKE '". $this->nombre ."'";
    if ($this->mysqli->query($sql) === false) {
      return "Error al buscar el campeonato.";
    } else {
  		$sql = "UPDATE `campeonato` SET
                      `campeonato_escerrado` = 1
                      WHERE (`campeonato_nombre` = '".$this->nombre."')";
      if ( $this->mysqli->query($sql) === false ) {
        return "Error al editar el campeonato.";
      }
      else {
        return true;
      }
    }
    $this->mysqli->close();
  }
}
?>
