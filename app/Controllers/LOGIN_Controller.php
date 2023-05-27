<?php
session_start();
if(!isset($_REQUEST['email']) && !(isset($_REQUEST['password']))) {
	include '../Views/Login.php';
	$login = new Login();
}
else{
	include '../Functions/AccessBD.php';
	include '../Models/USER_Model.php';
	$usuario = new USER_Model("", "", $_REQUEST['email'],$_REQUEST['password'],"", "", "", "");
	$respuesta = $usuario->login();
	$tipo = new USER_Model("", "", $_REQUEST['email'],"","", "", "", "");
	$data = $tipo->getTipo();
	$id = $usuario->getId();
	if ($respuesta === true){
		$_SESSION['statusMessage'] = "Logueado correctamente";
		$_SESSION['statusCode'] = "Success";
		$_SESSION['statusPosition'] = "Top";
		$_SESSION['email'] = $_REQUEST['email'];
		$_SESSION['tipo'] = $data;
		$_SESSION['id'] = $id;
		header('Location:../Controllers/APP_Controller.php?actionPage=list');
	}else{
		$_SESSION['statusMessage'] = $respuesta;
		$_SESSION['statusCode'] = "Warning";
		$_SESSION['statusPosition'] = "Down";
		header('Location:../Controllers/LOGIN_Controller.php');
	}
}
?>
