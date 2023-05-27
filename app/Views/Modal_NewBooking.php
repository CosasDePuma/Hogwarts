<!-- Modal encargado de crear una nueva reserva -->
<div class="modal fade" id="newBooking" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
  	<div class="modal-content">
  	<div class="modal-header">
        <h5 class="modal-title">Reservar Pista</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
  	</div>
    <div class="modal-body">
        <form action="../Controllers/APP_Controller.php?actionPage=addBooking" method="post" id="form" onsubmit="">
            <div class="form-group">
              <?php
                $timeStamp = new DateTime('tomorrow');
                $date = $timeStamp->format('Y-m-d');
                ?>
              <label for="recipient-name" class="col-form-label">Fecha:</label>
              <input type="date" class="form-control" name="fecha" value="<?=$date?>" min="<?php echo $date;?>">
            </div>
            <script>
            var today = new Date().toISOString().split('T')[0];
            document.getElementsByName("fecha")[0].setAttribute('min', today);
            </script>
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
                <button type="submit" class="btn btn-primary">Reservar</button>
            </div>
        </form>
    </div>
  	</div>
    </div>
</div>
