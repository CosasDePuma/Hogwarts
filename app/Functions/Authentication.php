<?php
function IsAuthenticated(){
	if (!isset($_SESSION['idUser'])){
		return false;
	}
	else{
		return true;
	}
}
?>