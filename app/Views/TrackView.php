<?php

class track_View {

    var $pistas;

    function __construct($pistas){
        $this->pistas = $pistas;

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
        $pistas = $this->pistas;
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

            <div class="modal-footer">
                <button type="button" data-toggle="modal" data-target="#newTrack"  class="btn btn-primary">Añadir Pista</button>
            </div>
                <?php
              foreach ($pistas as $pista) {
                  ?>
              <div class="row">
                <div class="col-12">
                    <div class="row">
                      <div class="col-12">
                        <hr>
                        <div class="row">
                          <div class="col-2">
                            <h4><strong>Pista:</strong></h4>
                          </div>
                          <div class="col-8">
                            <?php echo $pista['pista_id']?>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-2">
                            <h4><strong>Ubicación:</strong></h4>
                          </div>
                          <div class="col-2">
                            <?php echo $pista['pista_ubicacion']?>
                          </div>
                          <div class="col-2">
                            <h4><strong>Suelo:</strong></h4>
                          </div>
                          <div class="col-2">
                            <?php echo $pista['pista_suelo']?>
                          </div>
                          <div class="col-2">
                            <h4><strong>Pared:</strong></h4>
                          </div>
                          <div class="col-2">
                            <?php echo $pista['pista_pared']?>
                          </div>
                        </div>
                          <form method="post">
                            <div class='modal-footer' style="border: none">
                              <button type="submit"  class="btn btn-danger" formaction="../Controllers/APP_Controller.php?actionPage=deleteTrack&id=<?php echo $pista['pista_id'];?>">Eliminar</button>
                            </div>
                          </form>
                        </div>
                        </hr>
                      </div>
                    </div> 
                </div>
                <?php
              }
                ?>
              </div>
            </div>
            <div id="modales"><!--Incluimos los modales-->
              <?php
              include 'Modal_NewTrack.php';
              ?>
            </div>
        </section>
    </div>
    <div class="clearfix"></div>
    <?php
    include '../Views/Footer.php';
  }
}
?>
