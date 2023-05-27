<?php
class INFO_Model {
  var $mysqli;
  var $id;
  var $titulo;
  var $descripcion;
  var $idUsuario;

  function __construct($id, $titulo, $descripcion, $idUsuario) {
    $this->id = $id;
    $this->titulo = $titulo;
    $this->descripcion = $descripcion;
    $this->idUsuario = $idUsuario;

		include_once '../Functions/AccessBD.php';  //Incluimos la funcion de acceso a la base de datos
		$this->mysqli = ConectarBD();  //Conectamos con la base de datos y guardamos el manejador en un atributo de la clase
  }
  function getInfo(){
    $sql = "SELECT `informacion_interes_titulo`, `informacion_interes_descripcion` FROM informacion_interes ";
    $resultado = $this->mysqli->query( $sql );
		if ( $resultado->num_rows == 0 ) {
			return null;
		} else {
      return $resultado;
		}
		$this->mysqli->close();
  }

  function getNotifications() {
    $resultado = 0;
    # Recuperamos todas las notificaciones
    $sql = "SELECT `informacion_interes_id` FROM informacion_interes";
    $totales = $this->mysqli->query($sql);
    # Recuperamos cuántas notificaciones han sido leídas
    $sql = "SELECT `informacion_interes_id` FROM notificaciones WHERE (`usuario_email` = '" . $_SESSION["email"] . "')";
    $leidas = $this->mysqli->query($sql);

    # Comprobamos si ya han sido leídas
    foreach ($totales as $notificacion) {
      $notificada = false;
      $id = $notificacion['informacion_interes_id'];
      # - Código churro para una rápida implementación
      foreach($leidas as $row) {
        if (!$notificada) {
          $notificada = $id == $row['informacion_interes_id'];
        }
      }
      # Sumamos y actualizamos el contador
      if (!$notificada) {
        $resultado++;
        $this->avoidNotification($id);
      }
    }
    # Devolvemos la cantidad de notificaciones no leídas
    return $resultado;
  }

  function avoidNotification($id) {
    $sql = "INSERT INTO `notificaciones` VALUES ('" . $_SESSION['email'] . "', " . $id . ")";
    @$this->mysqli->query($sql);
  }

  function addEvent(){
    $sql = "INSERT INTO `informacion_interes` VALUES (NULL, '" . $this->titulo . "', '" . $this->descripcion . "', '" . $this->idUsuario . "')";
    if ($this->mysqli->query($sql) === false) {
			return "Error al añadir el evento.";
		} else {
			return true;
		}
		$this->mysqli->close();
  }
}
?>
