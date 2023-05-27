<?php

class class_View {

    var $clase;

    function __construct($clase,$inscrito,$asistencia){
        $this->clase = $clase;
        $this->inscrito = $inscrito;
        $this->asistencia = $asistencia;

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
        $clase = $this->clase;
        $fecha = date("d-m-Y", strtotime($clase['clase_fecha']));
        $hora = date("H:i", strtotime($clase['clase_hora']));
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
                    <div class="row ">
                      <div class="col-12">
                      <hr>
                      <div class="row justify-content-center">
                            <h3><strong><?php echo $clase['clase_nombre'];?></strong></h3>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-12">
                            <div class="row">
                              <div class="col-12">
                                <h4><strong>Descripción</strong></h4>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-12">
                                <p><?php echo $clase['clase_descripcion'];?></p>
                              </div>
                            </div>
                          </div>
                        </div>
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
                        <div>
                        </div>
                        <?php
                            if ($_SESSION['tipo'] == 'entrenador') {
                              ?>
                        <hr>
                        <div class="row">
                          <div class="col-12">
                            <div class="row">
                              <div class="col-12">
                                <h4><strong>Lista de asistencia</strong></h4>
                                <form method="post">
                              </div>
                            </div>
                              <?php
                              foreach($this->asistencia as $alumno) {
                                ?>
                              <div class="col-12">
                                <input type="checkbox" name="<?php echo($alumno['usuario_email']);?>" value="1" <?php if ($alumno["asistencia"] == 1) { echo("checked"); }?>>
                                  <span style="margin: 20px"><?php echo($alumno['usuario_email']);?></span>  
                                </input>
                              </div>
                            <?php
                              }
                              ?>
                                <div class='modal-footer' style="border: none">
                                  <button type="submit"  class="btn btn-info" formaction="../Controllers/APP_Controller.php?actionPage=actualizarAsistencia&id=<?php echo $clase['clase_id'];?>">Actualizar asistencia</button>
                                </div>
                              </form>
                            </div>
                          </div>
                              <?php
                            } else if ($_SESSION['tipo'] == 'deportista') {
                              if (!$this->inscrito) {
                              ?>
                            <form method="post">
                            <div class='modal-footer'>
                                <button type="submit"  class="btn btn-info" formaction="../Controllers/APP_Controller.php?actionPage=inscribirseClass&id=<?php echo $clase['clase_id'];?>">Inscribirse</button>
                            </div>
                            </form>
                              <?php
                              } else {
                                ?>
                              <form method="post">
                              <div class='modal-footer'>
                                  <button type="submit"  class="btn btn-danger" formaction="../Controllers/APP_Controller.php?actionPage=desinscribirseClass&id=<?php echo $clase['clase_id'];?>">Anular inscripción</button>
                              </div>
                              </form>
                                <?php
                              }
                            }
                        ?>
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
