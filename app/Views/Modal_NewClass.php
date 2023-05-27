<!-- Modal encargado de crear una nueva clase -->
<div class="modal fade" id="newClass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
  	<div class="modal-content">
  	<div class="modal-header">
        <h5 class="modal-title">Nueva Clase</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
  	</div>
    <div class="modal-body">
        <form action="../Controllers/APP_Controller.php?actionPage=addClass" method="post" id="form">
          <div class="form-group">
      			<label for="recipient-name" class="col-form-label">Nombre:</label>
      			<input type="text" class="form-control" name="nombre">
    		  </div>
          <div class="form-group">
      			<label for="recipient-name" class="col-form-label">Descripción:</label>
      			<textarea class="form-control" name="descripcion" rows="4" cols="80"></textarea>
    		  </div>
            <div class="form-group">
              <?php
                $timeStamp = time();
                $date = date('Y-m-d', $timeStamp);
              ?>
              <label for="recipient-name" class="col-form-label">Fecha:</label>
              <input type="date" class="form-control" name="fecha" min="<?php echo $date;?>" value="<?php echo $date;?>">
            </div>
            <div class="form-group">
                <label>Hora:</label>
                <select name="hora" class="form-control">
                    <option selected="selected" value="9:00">9:00</option>
                    <option value="10:30">10:30</option>
                    <option value="12:00">12:00</option>
                    <option value="13:30">13:30</option>
                    <option value="15:00">15:00</option>
                    <option value="16:30">16:30</option>
                    <option value="18:00">18:00</option>
                    <option value="19:30">19:30</option>
                </select>
            </div>

            <div class="modal-footer">
                <button type="submit"  class="btn btn-primary">Crear</button>
            </div>
        </form>
    </div>
  	</div>
    </div>
</div>