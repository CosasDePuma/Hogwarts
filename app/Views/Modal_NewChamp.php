<!-- Modal encargado de crear un nuevo campeonato. -->
<div class="modal fade" id="newChamp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  	<div class="modal-content">
  	  <div class="modal-header">
    		<h5 class="modal-title">Nuevo Campeonato</h5>
    		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    		  <span aria-hidden="true">&times;</span>
    		</button>
  	  </div>
  	  <div class="modal-body">
    		<form action="../Controllers/APP_Controller.php?actionPage=addChamp" method="post" id="form">
    		  <div class="form-group">
      			<label for="recipient-name" class="col-form-label">Nombre:</label>
      			<input type="text" class="form-control" name="nombre">
    		  </div>
          <div class="form-group">
      			<label for="recipient-name" class="col-form-label">Descripción:</label>
      			<textarea class="form-control" name="descripcion" rows="4" cols="80"></textarea>
    		  </div>
          <div class="form-group">
						<label>Nivel Deportivo</label>
						<select name="nivel" class="form-control">
							<option selected="selected" value="0">1</option>
							<option value="1">2</option>
							<option value="2">3</option>
						</select>
					</div>
          <div class="form-group">
						<label>Género</label>
						<select name="sexo" class="form-control">
							<option selected="selected" value="hombre">Masculino</option>
							<option value="mujer">Femenino</option>
							<option value="mixto">Mixto</option>
						</select>
					</div>
          <div class="modal-footer">
            <button type="submit" value="newChamp" class="btn btn-primary">Crear</button>
      	  </div>
    		</form>
  	  </div>
  	</div>
  </div>
</div>
