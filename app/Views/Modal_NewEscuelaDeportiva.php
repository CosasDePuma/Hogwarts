<!-- Modal encargado de crear una nueva escuela deportiva -->
<div class="modal fade" id="newEscuelaDeportiva" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
  	<div class="modal-content">
  	<div class="modal-header">
        <h5 class="modal-title">Crear Escuela Deportiva</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
  	</div>
    <div class="modal-body">
        <form action="../Controllers/APP_Controller.php?actionPage=addEscuelaDeportiva" method="post" id="form">

            <div class="form-group">
      			<label for="recipient-name" class="col-form-label">Nombre:</label>
      			<input type="text" class="form-control" name="nombre">
    		</div>

            <?php
                $timeStamp = time();
                $date = date('Y-m-d', $timeStamp);
            ?>

            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Fecha límite de inscripción:</label>
              <input type="date" class="form-control" name="fecha_inscripcion" min="<?php echo $date;?>" value="<?php echo $date;?>">
            </div>

            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Fecha de inicio:</label>
              <input type="date" class="form-control" name="fecha_inicio" min="<?php echo $date;?>" value="<?php echo $date;?>">
            </div>

            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Fecha de fin:</label>
              <input type="date" class="form-control" name="fecha_fin" min="<?php echo $date;?>" value="<?php echo $date;?>">
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
      			<label for="recipient-name" class="col-form-label">Email del entrenador responsable:</label>
      			<input type="text" class="form-control" name="mail">
    		</div>

            <div class="modal-footer">
                <button type="submit"  class="btn btn-primary">Crear</button>
            </div>
        </form>
    </div>
  	</div>
    </div>
</div>
