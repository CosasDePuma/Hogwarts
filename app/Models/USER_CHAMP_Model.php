<?php
class USER_CHAMP_Model {
  var $mysqli;
  var $emailCapitan;
  var $emailCompanero;
  var $NCampeonato;
  var $puntos;
  var $fase;

  function __construct($emailCapitan, $emailCompanero, $NCampeonato, $puntos, $fase) {
    $this->emailCapitan = $emailCapitan;
    $this->emailCompanero = $emailCompanero;
    $this->NCampeonato = $NCampeonato;
    $this->puntos = $puntos;
    $this->fase = $fase;

		include_once '../Functions/AccessBD.php';  //Incluimos la funcion de acceso a la base de datos
		$this->mysqli = ConectarBD();  //Conectamos con la base de datos y guardamos el manejador en un atributo de la clase
  }
  function registrar(){
    $sql = "SELECT `capitan_id` FROM `usuario_campeonato` WHERE (`capitan_id` = '" . $this->emailCapitan . "' AND `campeonato_id` = '" . $this->NCampeonato . "')";
    $resultado = $this->mysqli->query($sql);
    if ($resultado->num_rows == 20) {
			return "No es posible inscribirse plazas Completas.";
		} else {
      $sql = "INSERT INTO `usuario_campeonato` VALUES ('" . $this->emailCapitan . "', '" . $this->emailCompanero . "', '" . $this->NCampeonato . "', '" . $this->puntos . "', '" . $this->fase . "')";
      if ($this->mysqli->query($sql) === false) {
  			return "Equipo no registrado en el campeonato.";
  		} else {
  			return true;
  		}
		}
		$this->mysqli->close();
	}
  function leave() {
    $sql = "DELETE FROM `usuario_campeonato` WHERE (`capitan_id` = '" . $this->emailCapitan . "' AND `campeonato_id` = '" . $this->NCampeonato . "')";
    if ($this->mysqli->query($sql) === false) {
			return "Error al desinscribirse.";
		} else {
			return true;
		}
		$this->mysqli->close();
  }
  function isReg() {
    $sql = "SELECT `capitan_id`, `campeonato_id` FROM `usuario_campeonato` WHERE (`capitan_id` = '" . $this->emailCapitan . "' AND `campeonato_id` = '" . $this->NCampeonato . "')";
    $resultado = $this->mysqli->query($sql);
    if ($resultado->num_rows == 0) {
			return false;
		} else {
			return true;
		}
		$this->mysqli->close();
  }
  function getReg() {
    $sql = "SELECT `capitan_id` FROM `usuario_campeonato` WHERE `campeonato_id` = '" . $this->NCampeonato . "'";
    $resultado = $this->mysqli->query( $sql );
		if ( $resultado->num_rows == 0 ) {
			return null;
		} else {
      return $resultado;
		}
		$this->mysqli->close();
  }
}
?>
