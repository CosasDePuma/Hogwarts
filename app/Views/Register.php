<?php
class Register {
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
			<section id="registerForm">
				<form name="regForm" action="REGISTER_Controller.php" method="post" onsubmit="return verifFormReg(this)">
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label>Nombre</label>
								<input type="text" name="nombre" class="form-control" placeholder="Nombre" maxlength="50" onblur="verifPseudo(this)">
							</div>
							<div class="form-group">
								<label>Apellidos</label>
								<input type="text" name="apellido" class="form-control" placeholder="Apellidos" maxlength="70" onblur="verifPseudo(this)">
							</div>
							<div class="form-group">
								<label>DNI</label>
								<input type="text" name="dni" class="form-control" placeholder="DNI" maxlength="10" >
							</div>
							<div class="form-group">
								<label>Nivel Deportivo</label>
								<select name="nivel" class="form-control">
									<option selected="selected" value="0">Básico</option>
									<option value="1">Intermedio</option>
									<option value="2">Alto</option>
								</select>
							</div>
						</div>
						<div class="col">
							<div class="form-group">
								<label>Género</label>
								<select name="sexo" class="form-control">
									<option selected="selected">Hombre</option>
									<option>Mujer</option>
									<option>Otro</option>
								</select>
							</div>
							<div class="form-group">
								<label>Tipo de Usuario</label>
								<select name="tipo" class="form-control">
									<option selected="selected">Deportista</option>
									<option>Entrenador</option>
								</select>
							</div>
							<div class="form-group">
								<label>Email</label>
								<input type="email" name="email" class="form-control" placeholder="Email" maxlength="100" size="104" onblur="verifMail(this)">
							</div>
							<div class="form-group">
								<label>Contraseña</label>
								<input type="password" name="password" class="form-control" placeholder="Contraseña" maxlength="30" onblur="verifPass(this)">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-6">
							<div class="float-right">
								<a class="btn btn-danger btn-lg" href="../Controllers/LOGIN_Controller.php">&nbsp&nbsp&nbsp&nbsp Atras &nbsp&nbsp&nbsp&nbsp</a>
							</div>
						</div>
						<div class="col-6">
							<div class="float-left">
								<input type="submit" class="btn btn-success btn-lg" value="Registrarse">
							</div>
						</div>
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
