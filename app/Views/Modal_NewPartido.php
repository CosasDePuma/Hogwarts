<!-- Modal encargado de crear un nuevo partido. -->
<div class="modal fade" id="newMatch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  	<div class="modal-content">
  	  <div class="modal-header">
    		<h5 class="modal-title">Generar Partido</h5>
    		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    		  <span aria-hidden="true">&times;</span>
    		</button>
  	  </div>
  	  <div class="modal-body">
    		<form action="../Controllers/APP_Controller.php?actionPage=addMatch" method="post" id="form">
          <?php
            $timeStamp = time();
            $date = date('Y-m-d', $timeStamp);
          ?>
          <input style="display: none;" type="date" name="fecha" value="<?php echo $date;?>">
    		  <div class="form-group">
      			<label for="recipient-name" class="col-form-label">Sets Local</label>
      			<input type="text" class="form-control" name="setLocal">
    		  </div>
          <div class="form-group">
      			<label for="recipient-name" class="col-form-label">Sets Visitante</label>
      			<input type="text" class="form-control" name="setVisit">
    		  </div>
          <div class="form-group">
      			<label for="recipient-name" class="col-form-label">Email Capitan Local</label>
      			<input type="text" class="form-control" name="emailLocal">
    		  </div>
          <div class="form-group">
      			<label for="recipient-name" class="col-form-label">Email Capitan Visitante</label>
      			<input type="text" class="form-control" name="emailVisit">
    		  </div>
          <div class="form-group">
      			<label for="recipient-name" class="col-form-label">Nombre Campeonato</label>
      			<input type="text" class="form-control" name="campeonato">
    		  </div>
          <div class="modal-footer">
            <button type="submit" value="newMatch" class="btn btn-primary">Enviar</button>
      	  </div>
    		</form>
  	  </div>
  	</div>
  </div>
</div>
