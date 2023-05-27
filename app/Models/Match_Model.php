<?php
class MATCH_Model {
  var $mysqli;
  var $id;
  var $emailLocal;
  var $emailVisitante;
  var $setsLocal;
  var $setsVisitante;
  var $fecha;
  var $campeonato;

  function __construct($id, $emailLocal, $emailVisitante, $setsLocal, $setsVisitante, $fecha, $campeonato) {
    $this->id = $id;
    $this->emailLocal = $emailLocal;
    $this->emailVisitante = $emailVisitante;
    $this->setsLocal = $setsLocal;
    $this->setsVisitante = $setsVisitante;
    $this->fecha = $fecha;
    $this->campeonato = $campeonato;

		include_once '../Functions/AccessBD.php';  //Incluimos la funcion de acceso a la base de datos
		$this->mysqli = ConectarBD();  //Conectamos con la base de datos y guardamos el manejador en un atributo de la clase
  }
  function getMatch(){
    $sql = "SELECT * FROM `partido`";
		$resultado = $this->mysqli->query( $sql );
		if ( $resultado->num_rows == 0 ) {
			return null;
		} else {
      return $resultado;
		}
		$this->mysqli->close();
  }
  function getResult() {
    $sql = "SELECT  `partido_resultado_local`, `partido_resultado_visitante` FROM `partido` WHERE (`campeonato_nombre` = '" . $this->campeonato . "')";
    $resultado = $this->mysqli->query( $sql );
		if ( !$resultado || $resultado->num_rows == 0 ) {
			return null;
		} else {
      return $resultado;
		}
		$this->mysqli->close();
  }
  function addMatch(){
    $sql = "INSERT INTO `partido` VALUES (NULL, '" . $this->setsLocal . "', '" . $this->setsVisitante . "', '" . $this->fecha . "', '" . $this->emailLocal . "', '" . $this->emailVisitante . "','" . $this->campeonato . "')";
    if ($this->mysqli->query($sql) === false) {
			return "Error al añadir el partido.";
		} else {
			return true;
		}
		$this->mysqli->close();
  }
}
?>
