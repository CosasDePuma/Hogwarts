<?php
class Asist_Model {
  var $mysqli;
  var $clase;
  var $datos;

  function __construct($clase,$datos) {
    $this->clase = $clase;
    $this->datos = $datos;

    include_once '../Functions/AccessBD.php';  //Incluimos la funcion de acceso a la base de datos
    $this->mysqli = ConectarBD();  //Conectamos con la base de datos y guardamos el manejador en un atributo de la clase
  }

  function asist() {
    $sql = "SELECT  `usuario_email` FROM `asistencia` WHERE `clase_id` = '". $this->clase ."'";
    $lista = $this->mysqli->query($sql);
    
    if ($lista === false) { return "No se ha podido actualizar la lista de alumnos."; }
    
    foreach($lista as $alumno) {
      $email = str_replace(".","_",$alumno['usuario_email']);
      $asistencia = isset($this->datos[$email]) ? 1 : 0;
      $sql = "UPDATE `asistencia` SET
                      `asistencia` = '". $asistencia ."'
                      WHERE ( `clase_id` = " . $this->clase . " AND
                      `usuario_email` = '" . $alumno['usuario_email'] ."')";
      if ( $this->mysqli->query($sql) === false ) { return "Error al editar la asistencia."; }
    }
    $this->mysqli->close();
    return true;
  }
}
?>
