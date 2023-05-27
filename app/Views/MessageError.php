<!-- Codigo que se encarga de mostrar los mensajes del sistema. -->
<div class="container" id="menssageBar">
	<div class="row">
		<div class="col"></div>
		<div class="col-6">
			<?php
				if(isset($_SESSION['statusCode'])){
			?>
				<?php if($_SESSION['statusCode'] === 'Success'){ ?>
					<div class="alert alert-success"><?php echo $_SESSION['statusMessage'];?></div>
				<?php } ?>
				<?php if($_SESSION['statusCode'] === 'Info'){?>
					<div class="alert alert-info"><?php echo $_SESSION['statusMessage'];?></div>
				<?php } ?>
				<?php if($_SESSION['statusCode'] === 'Warning'){?>
					<div class="alert alert-warning"><?php echo $_SESSION['statusMessage'];?></div>
				<?php } ?>
				<?php if($_SESSION['statusCode'] === 'Danger'){?>
					<div class="alert alert-danger"><?php echo $_SESSION['statusMessage'];?></div>
				<?php } ?>
				<?php
					unset($_SESSION["statusCode"]);
					unset($_SESSION["statusMessage"]);
					unset($_SESSION["statusPosition"]);
				?>
			<?php } ?>
		</div>
		<div class="col"></div>
	</div>
	<script type="text/javascript">
		var menssageBar = document.getElementById('menssageBar');
		setTimeout(function() {menssageBar.remove()}, 5000);
	</script>
</div>
