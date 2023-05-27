<?php
?>
		<script src="../Views/JS/jquery-3.4.1.slim.min.js"></script>
		<script src="../Views/JS/popper.min.js"></script>
		<script src="../Views/JS/bootstrap.min.js"></script>
		<?php
		if(isset($_SESSION['statusPosition']) && $_SESSION['statusPosition'] === 'Down'){
			include '../Views/MessageError.php';
		}
		?>
	</body>
</html>
