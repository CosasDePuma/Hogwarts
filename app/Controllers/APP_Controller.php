<?php
session_start();
if(!isset($_REQUEST['actionPage'])) { $_REQUEST['actionPage'] = "list"; }
switch($_REQUEST['actionPage'])
{
	case 'addEvent':
		addEvent();
		break;
	case 'addChamp':
		addChamp();
		break;
	case 'editChamp':
		editChamp();
		break;
	case 'removeChamp':
		removeChamp();
		break;
	case 'openChamp':
		openChamp();
		break;
	case 'champView':
		champView();
		break;
	case 'closeChamp':
		closeChamp();
		break;
	case 'inChamp':
		inChamp(); /* Inscribirse en un campeonato */
		break;
	case 'deinChamp':
		deinChamp(); /* Desinscribirse en un campeonato */
		break;
	case 'addMatch':
		addMatch();
		break;
	case 'addPromotedMatch':
		addPromotedMatch();
		break;
	case 'getPromotedMatch':
		getPromotedMatch();
		break;
	case 'viewPromotedMatch':
		viewPromotedMatch();
		break;
	case 'deletePromotedMatch':
		deletePromotedMatch();
		break;
	case 'enrollPromotedMatch':
		enrollPromotedMatch();
		break;
	case 'disenrollPromotedMatch':
		disenrollPromotedMatch();
		break;
	case 'addBooking':
		addBooking();
		break;
	case 'deleteBooking':
		deleteBooking();
		break;
	case 'viewTracks':
		viewTracks();
		break;
	case 'addTrack':
		addTrack();
		break;
	case 'deleteTrack':
		deleteTrack();
		break;	
	case 'addClass':
		addClass();
		break;	
	case 'viewClass':
		viewClass();
		break;	
	case 'deleteClass':
		deleteClass();
		break;
	case 'inscribirseClass':
		inscribirseClass();
		break;
	case 'desinscribirseClass':
		desinscribirseClass();
		break;
	case 'actualizarAsistencia':
		asistido();
		break;
	case 'addEscuelaDeportiva':
		newEscuelaDeportiva();
		break;
	default:
		if (isset($_SESSION['email'])) {
			include '../Views/App.php';
			getNotifications();
			$campeonatos = getComp();
			$partidos = getPromotedMatch();
			$eventos = getEvents();
			$reservas = getBooking();
			$clases = getClases();
      $app = new App($campeonatos, $partidos ,$eventos, $reservas, $clases);
		} else {
			include '../Views/Login.php';
			$login = new Login();
		}
		break;
}
function getMatchRes(){
	include_once '../Models/Match_Model.php';
  $info = new MATCH_Model("","","","","","",$_REQUEST['name']);
	$infoBD = $info->getResult();
	return $infoBD;
}
function addMatch(){
	include_once '../Models/Match_Model.php';
	$info = new MATCH_Model("", $_REQUEST['emailLocal'], $_REQUEST['emailVisit'], $_REQUEST['setLocal'], $_REQUEST['setVisit'], $_REQUEST['fecha'],$_REQUEST['campeonato']);
	$respuesta = $info->addMatch();
	if ($respuesta === true){
		$_SESSION['statusMessage'] = "Partido añadido correctamente.";
		$_SESSION['statusCode'] = "Success";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	}else{
		$_SESSION['statusMessage'] = $respuesta;
		$_SESSION['statusCode'] = "Warning";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	}
}
function getComp(){
	include_once '../Models/CHAMP_Model.php';
  $info = new CHAMP_Model("","","","","","");
	$infoBD = $info->getChamp();
	return $infoBD;
}
function addChamp(){
	include_once '../Models/CHAMP_Model.php';
	$info = new CHAMP_Model("",$_REQUEST['nombre'],$_REQUEST['descripcion'],$_REQUEST['nivel'],$_REQUEST['sexo'],"");
	$respuesta = $info->addChamp();
	if ($respuesta === true){
		$_SESSION['statusMessage'] = "Campeonato añadido correctamente.";
		$_SESSION['statusCode'] = "Success";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	}else{
		$_SESSION['statusMessage'] = $respuesta;
		$_SESSION['statusCode'] = "Warning";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	}
}
function editChamp() {
	include_once '../Models/CHAMP_Model.php';
	$info = new CHAMP_Model($_REQUEST['id'],$_REQUEST['nombre'],$_REQUEST['descripcion'],$_REQUEST['nivel'],$_REQUEST['sexo'],"");
	$respuesta = $info->editChamp();
	if ($respuesta === true){
		$_SESSION['statusMessage'] = "Campeonato editado correctamente.";
		$_SESSION['statusCode'] = "Success";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	}else{
		$_SESSION['statusMessage'] = $respuesta;
		$_SESSION['statusCode'] = "Warning";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	}
}
function removeChamp() {
	include_once '../Models/CHAMP_Model.php';
	$info = new CHAMP_Model($_REQUEST['id'],"","","","","");
	$respuesta = $info->deleteChamp();
	if ($respuesta === true){
		$_SESSION['statusMessage'] = "Campeonato eliminado correctamente.";
		$_SESSION['statusCode'] = "Success";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	}else{
		$_SESSION['statusMessage'] = $respuesta;
		$_SESSION['statusCode'] = "Warning";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	}
}
function openChamp() {
	include_once '../Models/CHAMP_Model.php';
	$info = new CHAMP_Model("",$_REQUEST['name'],"","","","");
	$campeonato = getComp();
	include '../Views/ChampEdit.php';
	if (new ChampEdit($campeonato)) {
	}else{
		$_SESSION['statusMessage'] = "Error al abrir el elemento seleccionado";
		$_SESSION['statusCode'] = "Warning";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	}
}
function champView() {
	include_once '../Models/CHAMP_Model.php';
	$info = new CHAMP_Model("",$_REQUEST['name'],"","","","");
	$campeonato = getComp();
	$estaRegistrado = isRegChamp();
	$registrados = getRegChamp();
	$resultados = getMatchRes();
	include '../Views/ChampView.php';
	if (new ChampView($campeonato,$estaRegistrado,$registrados,$resultados)) {
	}else{
		$_SESSION['statusMessage'] = "Error al abrir el elemento seleccionado";
		$_SESSION['statusCode'] = "Warning";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	}
}
function closeChamp() {
	include_once '../Models/CHAMP_Model.php';
	$info = new CHAMP_Model("",$_REQUEST['name'],"","","","");
	$respuesta = $info->closeChamp();
	if ($respuesta === true){
		$_SESSION['statusMessage'] = "Inscripciones cerradas correctamente.";
		$_SESSION['statusCode'] = "Success";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	}else{
		$_SESSION['statusMessage'] = $respuesta;
		$_SESSION['statusCode'] = "Warning";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	}
}
function inChamp() {
	include_once '../Models/USER_CHAMP_Model.php';
	$info = new USER_CHAMP_Model($_SESSION['email'],$_REQUEST['companero'],$_REQUEST['id'],0,0);
	$respuesta = $info->registrar();
	if ($respuesta === true){
		$_SESSION['statusMessage'] = "Inscritos correctamente.";
		$_SESSION['statusCode'] = "Success";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	}else{
		$_SESSION['statusMessage'] = $respuesta;
		$_SESSION['statusCode'] = "Warning";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	}
}
function deinChamp() {
	include_once '../Models/USER_CHAMP_Model.php';
	$info = new USER_CHAMP_Model($_SESSION['email'],"",$_REQUEST['id'],"","");
	$respuesta = $info->leave();
	if ($respuesta === true){
		$_SESSION['statusMessage'] = "Desinscritos correctamente.";
		$_SESSION['statusCode'] = "Success";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	}else{
		$_SESSION['statusMessage'] = $respuesta;
		$_SESSION['statusCode'] = "Warning";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	}
}
function isRegChamp() {
	include_once '../Models/USER_CHAMP_Model.php';
	$info = new USER_CHAMP_Model($_SESSION['email'],"",$_REQUEST['id'],"","");
	$respuesta = $info->isReg();
	if ($respuesta) {
		return true;
	} else {
		return false;
	}
}
function getRegChamp() {
	include_once '../Models/USER_CHAMP_Model.php';
	$info = new USER_CHAMP_Model("","",$_REQUEST['id'],"","");
	$infoBD = $info->getReg();
	return $infoBD;
}
function getEvents(){
	include_once '../Models/INFO_Model.php';
  	$info = new INFO_Model("","","",$_SESSION['email']);
	$infoBD = $info->getInfo();
	return $infoBD;
}
function getNotifications(){
	if($_SESSION["tipo"] != "administrador")
	{
		include_once '../Models/INFO_Model.php';
		$info = new INFO_Model("","","",$_SESSION['email']);
		$resultado = $info->getNotifications();
		if($resultado > 0) {
			$_SESSION['statusMessage'] = $resultado == 1 ? "Existe un anuncio nuevo." : "Existen un total de " . $resultado . " anuncios nuevos.";
			$_SESSION['statusCode'] = "Info";
			$_SESSION['statusPosition'] = "Top";
		}
	}
}
function addEvent(){
	include_once '../Models/INFO_Model.php';
	$info = new INFO_Model("",$_REQUEST['titulo'],$_REQUEST['descripcion'],$_SESSION['email']);
	$respuesta = $info->addEvent();
	if ($respuesta === true){
		$_SESSION['statusMessage'] = "Evento añadido correctamente.";
		$_SESSION['statusCode'] = "Success";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	}else{
		$_SESSION['statusMessage'] = $respuesta;
		$_SESSION['statusCode'] = "Warning";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	}
}
function addPromotedMatch() {
	include_once '../Models/Reserva_Model.php';
	$reserva = new reserva_Model("",$_REQUEST['hora'],$_REQUEST['fecha'],"","");
	$respuesta = $reserva->isFull();
	if ($respuesta === true){
		$_SESSION['statusMessage'] = "Pistas llenas para esa fecha y hora";
		$_SESSION['statusCode'] = "Warning";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	} else {
		include_once '../Models/Partido_Promocionado_Model.php';
		$partido_promocionado = new partido_promocionado_Model("",$_REQUEST['hora'],$_REQUEST['fecha']);
		$respuesta = $partido_promocionado->add();
		if ($respuesta === true) {
			$_SESSION['statusMessage'] = "Partido promocionado añadido correctamente";
			$_SESSION['statusCode'] = "Success";
			$_SESSION['statusPosition'] = "Top";
			header('Location:../Controllers/APP_Controller.php?actionPage=list');
		} else {
			$_SESSION['statusMessage'] = $respuesta;
			$_SESSION['statusCode'] = "Warning";
			$_SESSION['statusPosition'] = "Top";
			header('Location:../Controllers/APP_Controller.php?actionPage=list');
		}
	}
}
function getPromotedMatch() {
	include_once '../Models/Partido_Promocionado_Model.php';
	$partido_promocionado = new partido_promocionado_Model("","","");
	$respuesta = $partido_promocionado->getAll();
	$rows = [];
	while ($row = $respuesta->fetch_array()){
		$rows[] = $row;
	}
	return $rows;
}
function viewPromotedMatch() {
	include_once '../Models/Partido_Promocionado_Model.php';
	$partido_promocionado = new partido_promocionado_Model($_REQUEST['id'],"","");
	$partido = $partido_promocionado->get()->fetch_array();
	$respuesta = $partido_promocionado->getEnrolled();
	$inscritos = [];
	while ($row = $respuesta->fetch_array()){
		$inscritos[] = $row;
	}
	include '../Views/Partido_Promocionado_View.php';
	if (new partido_promocionado_View($partido, $inscritos)) {
	} else {
		$_SESSION['statusMessage'] = "Error al abrir el elemento seleccionado";
		$_SESSION['statusCode'] = "Warning";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	}
}
function deletePromotedMatch() {
	include_once '../Models/Partido_Promocionado_Model.php';
	$partido_promocionado = new partido_promocionado_Model($_REQUEST['id'],"","");
	$respuesta = $partido_promocionado->delete();
	if ($respuesta === true){
		$_SESSION['statusMessage'] = "Partido eliminado correctamente.";
		$_SESSION['statusCode'] = "Success";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	} else {
		$_SESSION['statusMessage'] = $respuesta;
		$_SESSION['statusCode'] = "Warning";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	}
}
function enrollPromotedMatch() {
	include_once '../Models/Partido_Promocionado_Model.php';
	$partido_promocionado = new partido_promocionado_Model($_REQUEST['id'],"","");
	$respuesta = $partido_promocionado->enroll($_SESSION['id']);
	if ($respuesta === true) {
		if ($partido_promocionado->isFull()){
			include_once '../Models/Reserva_Model.php';
			$partido = $partido_promocionado->get()->fetch_array();
			$hora = $partido['partido_promocionado_hora'];
			$fecha = $partido['partido_promocionado_fecha'];
			$reserva = new reserva_Model("",$hora,$fecha,"",$_SESSION['email']);
			$respuesta = $reserva->add();
			if ($respuesta === true) {
				$_SESSION['statusMessage'] = "Reserva añadida correctamente.";
				$_SESSION['statusCode'] = "Success";
				$_SESSION['statusPosition'] = "Top";
			} else {
				$_SESSION['statusMessage'] = $respuesta;
				$_SESSION['statusCode'] = "Warning";
				$_SESSION['statusPosition'] = "Top";
			}
			header('Location:../Controllers/APP_Controller.php?actionPage=list');

		} else {
			$_SESSION['statusMessage'] = "Inscrito en el partido de forma correcta";
			$_SESSION['statusCode'] = "Success";
			$_SESSION['statusPosition'] = "Top";
			header('Location:../Controllers/APP_Controller.php?actionPage=list');
		}
	} else {
		$_SESSION['statusMessage'] = $respuesta;
		$_SESSION['statusCode'] = "Warning";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	}
}
function disenrollPromotedMatch() {
	include_once '../Models/Partido_Promocionado_Model.php';
	$partido_promocionado = new partido_promocionado_Model($_REQUEST['id'],"","");
	$respuesta = $partido_promocionado->disenroll($_SESSION['id']);
	if ($respuesta === true) {
		$_SESSION['statusMessage'] = "Desinscrito en el partido de forma correcta";
		$_SESSION['statusCode'] = "Success";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	} else {
		$_SESSION['statusMessage'] = $respuesta;
		$_SESSION['statusCode'] = "Warning";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	}
}

function addBooking()
{
	include_once '../Models/Reserva_Model.php';
	$reserva_model = new reserva_Model("",$_REQUEST['hora'],$_REQUEST['fecha'],"",$_SESSION['email']);
	$respuesta = $reserva_model->add();
	if ($respuesta === true){
		$_SESSION['statusMessage'] = "Reserva añadida correctamente.";
		$_SESSION['statusCode'] = "Success";
		$_SESSION['statusPosition'] = "Top";
	}else{
		$_SESSION['statusMessage'] = $respuesta;
		$_SESSION['statusCode'] = "Warning";
		$_SESSION['statusPosition'] = "Top";
	}
	header('Location:../Controllers/APP_Controller.php?actionPage=list');
}

function getBooking()
{
	include_once '../Models/Reserva_Model.php';
  	$reservas = new reserva_Model("","","","",$_SESSION['email']);
	$resultado = $reservas->get();
	return $resultado;
}

function deleteBooking()
{
	include_once '../Models/Reserva_Model.php';
	$reservas = new reserva_Model($_REQUEST['reserva_id'],"","","","");
	$respuesta = $reservas->delete();
	if ($respuesta === true){
		$_SESSION['statusMessage'] = "Reserva eliminada correctamente.";
		$_SESSION['statusCode'] = "Success";
		$_SESSION['statusPosition'] = "Top";
	}else{
		$_SESSION['statusMessage'] = $respuesta;
		$_SESSION['statusCode'] = "Warning";
		$_SESSION['statusPosition'] = "Top";
	}
	header('Location:../Controllers/APP_Controller.php?actionPage=list');
}

function viewTracks() {
	include_once '../Models/track_Model.php';
	$pista = new track_Model("","","","");
	$respuesta = $pista->getAll();
	$rows = [];
	while ($row = $respuesta->fetch_array()){
		$rows[] = $row;
	}
	include '../Views/trackView.php';
	new track_View($rows);
}

function addTrack() {
	include_once '../Models/Track_Model.php';
	$track = new track_Model("",$_REQUEST['suelo'],$_REQUEST['pared'],$_REQUEST['ubicacion']);
	$respuesta = $track->add();
	if ($respuesta === true){
		$_SESSION['statusMessage'] = "Pista añadida correctamente.";
		$_SESSION['statusCode'] = "Success";
		$_SESSION['statusPosition'] = "Top";
	}else{
		$_SESSION['statusMessage'] = $respuesta;
		$_SESSION['statusCode'] = "Warning";
		$_SESSION['statusPosition'] = "Top";
	}
	header('Location:../Controllers/APP_Controller.php?actionPage=viewTracks');
}

function deleteTrack() {
	include_once '../Models/Track_Model.php';
	$track = new track_Model($_REQUEST['id'],"","","","");
	$respuesta = $track->delete();
	if ($respuesta === true){
		$_SESSION['statusMessage'] = "Pista eliminada correctamente.";
		$_SESSION['statusCode'] = "Success";
		$_SESSION['statusPosition'] = "Top";
	}else{
		$_SESSION['statusMessage'] = $respuesta;
		$_SESSION['statusCode'] = "Warning";
		$_SESSION['statusPosition'] = "Top";
	}
	header('Location:../Controllers/APP_Controller.php?actionPage=viewTracks');
}

function addClass() {
	include_once '../Models/Class_Model.php';
	//Clase que no pertenece a escuela deportiva
	$class = new class_Model("",$_REQUEST['fecha'],$_REQUEST['hora'],$_REQUEST['nombre'],$_REQUEST['descripcion'],$_SESSION['email'],"");
	$respuesta = $class->add();
	if ($respuesta === true){
		$_SESSION['statusMessage'] = "Clase añadida correctamente.";
		$_SESSION['statusCode'] = "Success";
		$_SESSION['statusPosition'] = "Top";
	}else{
		$_SESSION['statusMessage'] = $respuesta;
		$_SESSION['statusCode'] = "Warning";
		$_SESSION['statusPosition'] = "Top";
	}
	header('Location:../Controllers/APP_Controller.php?actionPage=list');
}

function getClases() {
	include_once '../Models/Class_Model.php';
	$class = new class_Model("","","","","","","");
	$respuesta = $class->getAll();
	$rows = [];
	while ($row = $respuesta->fetch_array()){
		$rows[] = $row;
	}
	return $rows;
}

function viewClass() {
	include_once '../Models/Class_Model.php';
	$class = new class_Model($_REQUEST['id'],"","","","","","");
	$clases = $class->get()->fetch_array();
	// Obtenemos si está inscrito
	$inscrito = false;
	if($_SESSION["tipo"] == "deportista") {
		$inscrito = $class->estaInscrito();
	}
	// Obtenemos la asistencia
	$asistencia = false;
	if($_SESSION["tipo"] == "entrenador") {
		$asistencia = $class->listaAsistencia();
	}
	include '../Views/ClassView.php';
	if (new Class_View($clases,$inscrito,$asistencia)) {
	} else {
		$_SESSION['statusMessage'] = "Error al abrir el elemento seleccionado";
		$_SESSION['statusCode'] = "Warning";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	}
}

function inscribirseClass() {
	include_once '../Models/Class_Model.php';
	$class = new class_Model($_REQUEST['id'],"","","","","","");
	$resultado = $class->inscribirse();
	if ($resultado != false) {
		$_SESSION['statusMessage'] = "Inscrito en la clase " . $_REQUEST["id"];
		$_SESSION['statusCode'] = "Success";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	} else {
		$_SESSION['statusMessage'] = "No puedes inscribirte en esta clase";
		$_SESSION['statusCode'] = "Warning";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	}
}

function desinscribirseClass() {
	include_once '../Models/Class_Model.php';
	$class = new class_Model($_REQUEST['id'],"","","","","","");
	$resultado = $class->desinscribirse();
	if ($resultado != false) {
		$_SESSION['statusMessage'] = "Inscripción de la clase " . $_REQUEST["id"] . " anulada";
		$_SESSION['statusCode'] = "Success";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	} else {
		$_SESSION['statusMessage'] = "No puedes anular la inscripción en esta clase";
		$_SESSION['statusCode'] = "Warning";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	}
}


function deleteClass() {
	include_once '../Models/Class_Model.php';
	$class = new class_Model($_REQUEST['id'],"","","","","","");
	$respuesta = $class->delete();
	if ($respuesta === true){
		$_SESSION['statusMessage'] = "Clase eliminada correctamente.";
		$_SESSION['statusCode'] = "Success";
		$_SESSION['statusPosition'] = "Top";
	}else{
		$_SESSION['statusMessage'] = $respuesta;
		$_SESSION['statusCode'] = "Warning";
		$_SESSION['statusPosition'] = "Top";
	}
	header('Location:../Controllers/APP_Controller.php?actionPage=list');
}

function asistido() {
	include_once '../Models/Asist_Model.php';
	$class = new Asist_Model($_REQUEST["id"],$_POST);
	$resultado = $class->asist();
	if ($resultado == true) {
		$_SESSION['statusMessage'] = "La asistencia ha sido correctamente correctamente actualizada.";
		$_SESSION['statusCode'] = "Success";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	} else {
		$_SESSION['statusMessage'] = $resultado;
		$_SESSION['statusCode'] = "Warning";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	}
}

function newEscuelaDeportiva() {
	include_once '../Models/Escuela_Deportiva_Model.php';
	$escuela = new escuela_deportiva_Model("",$_REQUEST['nombre'],$_REQUEST['fecha_inscripcion'],$_REQUEST['fecha_inicio'],$_REQUEST['fecha_fin'],$_REQUEST['nivel']);
	$resultado = $escuela->add();
	if ($resultado === true) {
		include_once '../Models/Class_Model.php';
		$fecha_fin = $_REQUEST['fecha_fin'];
		$fecha_clase = $_REQUEST['fecha_inicio'];
		while ($fecha_fin >= $fecha_clase) {
			$clase = new class_Model("", $fecha_clase,"12:00",$_REQUEST['nombre'],"Clase de la escuela deportiva: " . $_REQUEST['nombre'] . "", $_REQUEST['mail'],"");
			if(!$clase->add()) {
				$_SESSION['statusMessage'] = "No se han podido crear todas las clases de la escuela deportiva.";
				$_SESSION['statusCode'] = "Warning";
				$_SESSION['statusPosition'] = "Top";
				header('Location:../Controllers/APP_Controller.php?actionPage=list');
			}
			$fecha_clase = strtotime($fecha_clase);
			$fecha_clase = date("Y-m-d", strtotime("+1 month", $fecha_clase));
		}
		$_SESSION['statusMessage'] = "Escuela deportiva añadida correctamente.";
		$_SESSION['statusCode'] = "Success";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	} else {
		$_SESSION['statusMessage'] = $resultado;
		$_SESSION['statusCode'] = "Warning";
		$_SESSION['statusPosition'] = "Top";
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	}

}

?>
