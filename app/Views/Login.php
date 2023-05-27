<?php
class Login {
	function __construct() {
		$this->render();
	}
	function render() {
		include '../Views/Header.php';
?>
		<div class="container">
			<header id="head">
			<h1 class="page-header float-left">Club de Padel</h1>
		</header>
		<div class="clearfix"></div>
			<section >
				<form id="loginForm" name="logForm" action="LOGIN_Controller.php" method="post" onsubmit="return verifFormLog(this)">
					<div class="form-group">
						<label>Email</label>
						<input name="email" type="text" class="form-control" placeholder="Email" maxlength="60" onblur="verifMail(this)">
					</div>
					<div class="form-group">
						<label>Contraseña</label>
						<input name="password" type="password" class="form-control" placeholder="Contraseña" maxlength="255" onblur="verifPass(this)">
					</div>
					<div class="float-right">
						<input type="submit" class="btn btn-success btn-lg" value="Identifícarse">
					</div>
					<div class="float-left">
						<a href="REGISTER_Controller.php" class="btn btn-warning btn-lg regString">Regístrarse</a>
					</div>
					<div class="clearfix"></div>
				</form>
			</section>
		</div>
<?php
	include '../Views/Footer.php';
	}
}
?>
