<?php
class reserva_Model {
  var $mysqli;
  var $id;
  var $hora;
  var $fecha;
  var $pista;
  var $email;

  var $max_pistas = 0;

  function __construct($id, $hora, $fecha, $pista, $email) {
    $this->id = $id;
    $this->hora = $hora;
    $this->fecha = $fecha;
    $this->pista = $pista;
    $this->email = $email;

		include_once '../Functions/AccessBD.php';  //Incluimos la funcion de acceso a la base de datos
    $this->mysqli = ConectarBD();  //Conectamos con la base de datos y guardamos el manejador en un atributo de la clase
    
    $this->max_pistas = $this->getMaxPistas();
  }
  function get(){
    $sql = "SELECT * FROM `reserva`";
		$resultado = $this->mysqli->query( $sql );
		if ( $resultado->num_rows == 0 ) {
			return null;
		} else {
      return $resultado;
		}
		$this->mysqli->close();
  }
  function add() {
    $sql = "SELECT `reserva_pista` FROM `reserva` WHERE `reserva_fecha` = '" . $this->fecha . "' AND `reserva_hora` = '" . $this->hora . "' ORDER BY `reserva_pista`;";
    $pistas = $this->mysqli->query($sql);
    
    // Comprobar pistas disponibles
    $pista = 1;
    while($pista <= $this->max_pistas && $pista == $pistas->fetch_assoc()['reserva_pista'])
    {
      $pista ++;
    }
    if($pista > $this->max_pistas)
    {
      return "No hay pistas disponibles en esa fecha y hora concreta.";
    }
    
    // Eliminar partidos promocionados cuando las pistas estén llenas
    else if ($pista >= $this->max_pistas)
    {
      $sql = "SELECT `partido_promocionado_id`
              FROM `partido_promocionado`
              WHERE `partido_promocionado_fecha` = '" . $this->fecha . "'
                AND `partido_promocionado_hora` = '" . $this->hora . "';";
      $partidos = $this->mysqli->query($sql);
      while($partido = $partidos->fetch_assoc())
      {
        include_once '../Models/Partido_Promocionado_Model.php';
        $partido_promocionado = new partido_promocionado_Model($partido['partido_promocionado_id'],$partido['partido_promocionado_hora'],$partido['partido_promocionado_fecha']);
        $partido_promocionado->delete();
      }
    }

    $sql = "SELECT p.pista_id FROM pista p WHERE p.pista_id NOT IN (SELECT p.pista_id FROM pista p, reserva r WHERE r.reserva_pista = p.pista_id)";
    $result = $this->mysqli->query($sql);
    $pista_libre = $result->fetch_array();
    $pista = $pista_libre['pista_id'];

    // Realizar reserva
    $sql = "INSERT INTO `reserva` VALUES (NULL, '" . $this->hora . "', '" . $this->fecha . "', '" . $pista . "', '" . $this->email . "')";
    if ($this->mysqli->query($sql) === false) {
			return "No es posible reservar la pista en esa fecha y horario concreto.";
		} else {
			return true;
		}
		$this->mysqli->close();
  }
  function delete() {
    $sql = "DELETE FROM `reserva` WHERE `reserva_id` = " . $this->id . ";";
    $resultado = $this->mysqli->query($sql);
    if ($resultado === false ) {
      return "Error al borrar el campeonato.";
    }
    else {
      return true;
    }
  }
  function isFull() {
    $sql = "SELECT * FROM reserva WHERE reserva_hora = '$this->hora' && reserva_fecha = '$this->fecha'";
    $resultado = $this->mysqli->query($sql);
    if ($resultado->num_rows == $this->max_pistas) {
      return true;
    } else {
      return false;;
    }
  }
  function getMaxPistas() {
    $sql = "SELECT * FROM pista";
    $result = $this->mysqli->query($sql);
    if ($result) {
      return $result->num_rows;
    } else {
      return 0;
    }
  }
}
?>
