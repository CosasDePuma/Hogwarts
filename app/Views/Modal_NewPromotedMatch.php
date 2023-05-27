<!-- Modal encargado de crear un nuevo partido promocionado -->
<div class="modal fade" id="newPromotedMatch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
  	<div class="modal-content">
  	<div class="modal-header">
        <h5 class="modal-title">Nuevo Partido Promocionado</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
  	</div>
    <div class="modal-body">
        <form action="../Controllers/APP_Controller.php?actionPage=addPromotedMatch" method="post" id="form">
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
