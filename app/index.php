<?php
include './Functions/Authentication.php';
if (!IsAuthenticated()){
	header('Location:./Controllers/LOGIN_Controller.php');
}
else{
	header('Location:./Controllers/APP_Controller.php?actionPage=list');
}
?>