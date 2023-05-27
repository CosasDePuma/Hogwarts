<!-- Modal encargado de crear una nueva pista -->
<div class="modal fade" id="newTrack" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
  	<div class="modal-content">
  	<div class="modal-header">
        <h5 class="modal-title">Nueva Pista</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
  	</div>
      <div class="modal-body">
    		<form method="post" id="form">
    		  <div class="form-group">
      			<label for="recipient-name" class="col-form-label">Ubicación:</label>
      			<select name="ubicacion" class="form-control">
                    <option selected="selected" value="Interior">Interior</option>
                    <option value="Exterior">Exterior</option>
                </select>
    		  </div>
              <div class="form-group">
      			<label for="recipient-name" class="col-form-label">Tipo de suelo:</label>
                <select name="suelo" class="form-control">
                    <option selected="selected" value="Hormigon">Hormigón</option>
                    <option value="Moqueta">Moqueta</option>
                    <option value="Cesped artificial">Césped artificial</option>
                </select>
    	      </div>
              <div class="form-group">
      			<label for="recipient-name" class="col-form-label">Tipo de pared:</label>
                <select name="pared" class="form-control">
                    <option selected="selected" value="Muro">Muro</option>
                    <option value="Cristal">Cristal</option>
                </select>
    	      </div>
          <div class="modal-footer">
            <button type="submit" value="newEvent" formaction="../Controllers/APP_Controller.php?actionPage=addTrack" class="btn btn-primary">Enviar</button>
      	  </div>
    		</form>
  	  </div>
  	</div>
    </div>
</div>