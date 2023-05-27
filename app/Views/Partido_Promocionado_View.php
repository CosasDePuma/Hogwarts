<?php

class partido_promocionado_View {

    var $partido;
    var $inscritos;

    function __construct($partido, $inscritos){
        $this->partido = $partido;
        $this->inscritos = $inscritos;

        $this->render();
    }

    function render(){
        include '../Views/Header.php';
    ?>
    <div class="container">
        <header id="head" class="row">
          <div class="col-12">
            <h1 class="page-header float-left">Club de Padel</h1>
            <a href="#" id="userName"class="dropdown-toggle user-header float-right" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <?php
                if (strlen($_SESSION['email']) > 20) {
                    echo (substr($_SESSION['email'], 0, 7)) . '...';
                } else {
                    echo $_SESSION['email'];
                }
                ?>
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li>
                  <a href="../Functions/LogOut.php" class="logLink">
                    <img class="header-icon" src="../Views/ICON/logout.png">
                    <p class="texmod">Cerrar Sesión</p>
                  </a>
                </li>
            </ul>
          </div>
        </header>
        <div class="clearfix"></div>
        <div class="row col-12">
          <?php
          if (isset($_SESSION['statusPosition']) && $_SESSION['statusPosition'] === 'Top') {
              include '../Views/MessageError.php';
          }
          ?>
        </div>
        <?php
        $partido = $this->partido;
        $fecha = date("d-m-Y", strtotime($partido['partido_promocionado_fecha']));
        $hora = date("H:i", strtotime($partido['partido_promocionado_hora']));
        $inscritos = $this->inscritos;
        
        ?>
      
        <section id="cuerpo">
          <div class="row">
            <div class="col-3">
              <div class="row col-12">
                <form class="" action="../Controllers/APP_Controller.php?actionPage=list" method="post">
                  <input type="image" class="navbarIcon" src="../Views/ICON/home.png" alt="Inicio" title="Inicio">
                </form>
              </div>
            </div>
            <div class="col-9">
              <div class="row">
                <div class="col-12">
                  <img class="banniere" src="../Views/ICON/banniere.jpg"/>
                </div>
              </div>
              
              <div class="row">
                <div class="col-12">
                    <div class="row">
                      <div class="col-12">
                        <hr>
                        <div class="row">
                          <div class="col-2">
                            <h4><strong>Fecha:</strong></h4>
                          </div>
                          <div class="col-2">
                            <p><?php echo $fecha;?></p>
                          </div>
                          <div class="col-2">
                            <h4><strong>Hora:</strong></h4>
                          </div>
                          <div class="col-2">
                            <p><?php echo $hora;?></p>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-3">
                            <h4><strong>Participantes:</strong></h4>
                          </div>
                        <?php
                        $numInscritos = 0;
                        if (count($inscritos) > 0){
                            foreach($inscritos as $inscrito){
                              $numInscritos++;
                                ?>  
                                <div class="col-1">
                                    <p><?php echo $inscrito['usuario_nombre'];?></p>
                                </div>
                                <?php
                            }
                        } else {
                            ?>  
                            <div class="col-4">
                                <p>Todavía no hay nadie inscrito</p>
                            </div>
                            <?php
                        }
                            ?>
                        </div>
                        <div>
                        <?php
                        
                        if ($_SESSION['tipo'] == 'administrador') {
                            ?>  
                            <form method="post">
                            <div class="modal-footer">
                                <button type="submit"  class="btn btn-danger" formaction="../Controllers/APP_Controller.php?actionPage=deletePromotedMatch&id=<?php echo $partido['partido_promocionado_id'];?>">Eliminar</button>
                            </div>
                            </form>
                            <?php
                        } elseif ($_SESSION['tipo'] == 'deportista' && $numInscritos < 4) {
                          $isInscrito = false;
                          foreach ($inscritos as $inscrito) {
                            if ($_SESSION['id'] == $inscrito['usuario_id']) {
                              $isInscrito = true;
                            }
                          } 
                          if ($isInscrito == true ){
                            ?> 
                            <form method="post">
                            <div class="modal-footer">
                              <button type="submit"  class="btn btn-danger" formaction="../Controllers/APP_Controller.php?actionPage=disenrollPromotedMatch&id=<?php echo $partido['partido_promocionado_id'];?>">Desincribirse</button>
                            </div>
                            </form>
                            <?php
                          } else {
                            ?> 
                            <form method="post">
                            <div class="modal-footer">
                              <button type="submit"  class="btn btn-primary" formaction="../Controllers/APP_Controller.php?actionPage=enrollPromotedMatch&id=<?php echo $partido['partido_promocionado_id'];?>">Inscribirse</button>
                            </div>
                            </form>
                            <?php
                          }
                        }
                        ?>
                        </div>
                        </hr>
                      </div>
                    </div> 
                </div>
              </div>
            </div>
        </section>
    </div>
    <div class="clearfix"></div>
    <?php
    include '../Views/Footer.php';
  }
}
?>
