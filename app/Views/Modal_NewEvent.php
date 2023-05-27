<!-- Modal encargado de crear un nuevo evento. -->
<div class="modal fade" id="newEvent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
  	<div class="modal-content">
  	  <div class="modal-header">
    		<h5 class="modal-title">Nuevo evento</h5>
    		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    		  <span aria-hidden="true">&times;</span>
    		</button>
  	  </div>
  	  <div class="modal-body">
    		<form action="../Controllers/APP_Controller.php?actionPage=addEvent" method="post" id="form">
    		  <div class="form-group">
      			<label for="recipient-name" class="col-form-label">Titulo:</label>
      			<input type="text" class="form-control" name="titulo">
    		  </div>
          <div class="form-group">
      			<label for="recipient-name" class="col-form-label">Descripción:</label>
            <textarea class="form-control" name="descripcion" rows="4" cols="80"></textarea>
    		  </div>
          <div class="modal-footer">
            <button type="submit" value="newEvent" class="btn btn-primary">Enviar</button>
      	  </div>
    		</form>
  	  </div>
  	</div>
  </div>
</div>
