<?php
session_start();
if(!isset($_REQUEST['email']) && !(isset($_REQUEST['password'])) && !(isset($_REQUEST['nombreCompleto']))) {
	include '../Views/Register.php';
	$register = new Register();
}
else{
	include '../Functions/AccessBD.php';
	include '../Models/USER_Model.php';
	$usuario = new USER_Model($_REQUEST['nombre'],$_REQUEST['apellido'],$_REQUEST['email'],password_hash($_REQUEST['password'], PASSWORD_DEFAULT), $_REQUEST['dni'],$_REQUEST['nivel'],$_REQUEST['sexo'],$_REQUEST['tipo']);
	$respuesta = $usuario->registro();
	if ($respuesta == false){
		$_SESSION['statusMessage'] = "Usuario registrado correctamente";
		$_SESSION['statusCode'] = "Success";
		$_SESSION['statusPosition'] = "Down";
		header('Location:../Controllers/LOGIN_Controller.php');
	}else{
		$_SESSION['statusMessage'] = $respuesta;
		$_SESSION['statusCode'] = "Warning";
		$_SESSION['statusPosition'] = "Down";
		header('Location:../Controllers/REGISTER_Controller.php');
	}
}
?>
