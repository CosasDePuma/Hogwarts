<?php
class App {
  var $campeonatos;
  var $partidos;
  var $eventos;
  var $reservas;
  var $clases;

  function __construct($campeonatos, $partidos, $eventos, $reservas, $clases) {
    $this->campeonatos = $campeonatos;
    $this->partidos = $partidos;
    $this->eventos = $eventos;
    $this->reservas = $reservas;
    $this->clases = $clases;
    $this->render();
  }
  function render() {
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
        <section id="cuerpo">
          <div class="row">
            <div class="col-3">
              <?php
              if ($_SESSION['tipo'] == "administrador") {
                ?>
                <div class="row col-12">
                  <a data-toggle="modal" data-target="#newPromotedMatch">
                    <img class="navbarIcon" src="../Views/ICON/ball.png" alt="Promocionados"/>
                    Promocionados
                  </a>
                </div>
                <div class="row col-12">
                  <a data-toggle="modal" data-target="#newChamp">
                    <img class="navbarIcon" src="../Views/ICON/compet.png" alt="Competiciones"/>
                    Nuevo Campeonato
                  </a>
                </div>
                <div class="row col-12">
                  <a href="../Controllers/APP_Controller.php?actionPage=viewTracks">
                    <img class="navbarIcon" src="../Views/ICON/pista.png" alt="Pistas"/>
                    Gestionar Pistas
                  </a>
                </div>
              <?php
              }
              if ($_SESSION['tipo'] == "deportista") {
                ?>
                <div class="row col-12">
                  <a data-toggle="modal" data-target="#newBooking">
                    <img class="navbarIcon" src="../Views/ICON/pista.png" alt="Reservar una nueva Pista"/>
                    Reserva de Pistas
                  </a>
                </div>
              <?php
              }
              if ($_SESSION['tipo'] == "administrador") {
                ?>
                <div class="row col-12">
                  <a data-toggle="modal" data-target="#newEvent">
                    <img class="navbarIcon" src="../Views/ICON/event.png" alt="Añadir Eventos"/>
                    Añadir Información
                  </a>
                </div>
                <div class="row col-12">
                  <a data-toggle="modal" data-target="#newEscuelaDeportiva">
                    <img class="navbarIcon" src="../Views/ICON/ball.png" alt="Añadir Escuela Deportiva"/>
                    Crear Escuela Deportiva
                  </a>
                </div>
                <?php
              }
              if ($_SESSION['tipo'] == "entrenador") {
                ?>
                <div class="row col-12">
                  <a data-toggle="modal" data-target="#newClass">
                    <img class="navbarIcon" src="../Views/ICON/pista.png" alt="Crear una clase nueva"/>
                    Ofrecer Clase
                  </a>
                </div>
              <?php
              }
              ?>
            </div>
            <div class="col-9">
              <div class="row">
                <div class="col-12">
                  <img class="banniere" src="../Views/ICON/banniere.jpg"/>
                </div>
              </div>
              <div class="row" style="margin-top: 10px;"> <!-- Eventos -->
                <div class="col-12">
                  <?php
                  if (@count($this->eventos) != 0) {
                    ?>
                    <div class="row col-12">
                      <p><strong>Información Actual</strong></p>
                    </div>
                    <div class="row">
                      <div class="col-3">
                        <p><strong>Titulo</strong></p>
                      </div>
                      <div class="col-9">
                        <p><strong>Descripción</strong></p>
                      </div>
                    </div>
                    <?php
                    while ( $fila = mysqli_fetch_array($this->eventos) ) {
                      ?>
                      <div class="row">
                        <div class="col-3">
                          <p><?php echo $fila[ 'informacion_interes_titulo' ];?></p>
                        </div>
                        <div class="col-9">
                          <p><?php echo $fila[ 'informacion_interes_descripcion' ];?></p>
                        </div>
                      </div>
                      <?php
                    }
                  }
                  else {
                  ?>
                  <div class="row col-12">
                    <p>No hay información en este momento.</p>
                  </div>
                  <?php
                  }
                  ?>
                </div>
              </div>
              <hr>
              <div class="row" style="margin-top: 10px;"> <!-- Partidos -->
                <div class="col-12">
                  <?php
                  if (@count($this->partidos) != 0) {
                    ?>
                    <div class="row col-12">
                      <p><strong>Partidos Actuales</strong></p>
                    </div>
                    <div class="row">
                      <div class="col-3">
                        <p><strong>Fecha</strong></p>
                      </div>
                      <div class="col-3">
                        <p><strong>Hora</strong></p>
                      </div>
                      <div class="col-3">
                        <p><strong>Inscritos</strong></p>
                      </div>
                    </div>
                    <?php
                    foreach ($this->partidos as $partido) {
                      ?>
                      <div class="row">
                        <div class="col-3">
                          <p><?php echo date ("d-m-Y", strtotime($partido['partido_promocionado_fecha']));?></p>
                        </div>
                        <div class="col-3">
                          <p><?php echo date ("H:i", strtotime($partido['partido_promocionado_hora']));?></p>
                        </div>
                        <div class="col-3">
                          <p><?php echo $partido['partido_promocionado_num_deportistas'];?></p>
                        </div>
                        <div class="col-3">
                          <div class="row">
                            <div class="col-3">
                              <form method="post">
                                <input type="image" class="imgResize" src="../Views/ICON/see.png" alt="Ver" title="Ver" formaction="../Controllers/APP_Controller.php?actionPage=viewPromotedMatch&id=<?php echo $partido['partido_promocionado_id'];?>">
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php
                    }
                  } else {
                  ?>
                    <p>No hay partidos en este momento.</p>
                  <?php
                  }
                  ?>
                </div>
              </div>
              <hr>
              <div class="row" style="margin-top: 10px;"> <!-- Campeonatos -->
                <div class="col-12">
                  <?php
                  if (@count($this->campeonatos) != 0) {
                    ?>
                    <div class="row col-12">
                      <p><strong>Campeonatos Actuales</strong></p>
                    </div>
                    <div class="row">
                      <div class="col-6">
                        <p><strong>Nombre</strong></p>
                      </div>
                      <div class="col-2">
                        <p><strong>Nivel</strong></p>
                      </div>
                      <div class="col-2">
                        <p><strong>Género</strong></p>
                      </div>
                      <div class="col-2">
                        <p><strong>Acciones</strong></p>
                      </div>
                    </div>
                    <?php
                    while ( $fila = mysqli_fetch_array($this->campeonatos) ) {
                      $textGenero = "";
                      $textNivel = "";
                      if ($fila ['campeonato_sexo'] == 'hombre') {
                        $textGenero = "Masculino";
                      } elseif ($fila ['campeonato_sexo'] == 'mujer') {
                        $textGenero = "Femenino";
                      } else {
                        $textGenero = "Mixto";
                      }
                      if ($fila ['campeonato_nivel'] == 0) {
                        $textNivel = "1";
                      } elseif ($fila ['campeonato_nivel'] == 1) {
                        $textNivel = "2";
                      } elseif ($fila ['campeonato_nivel'] == 2) {
                        $textNivel = "3";
                      } else {
                        $textNivel = "Mixto";
                      }
                      ?>
                      <div class="row">
                        <div class="col-6">
                          <p><?php echo $fila['campeonato_nombre'];?></p>
                        </div>
                        <div class="col-2">
                          <p><?php echo $textNivel;?></p>
                        </div>
                        <div class="col-2">
                          <p><?php echo $textGenero;?></p>
                        </div>
                        <div class="col-2">
                          <div class="row">
                            <div class="col-3">
                              <form method="post">
                                <input type="image" class="imgResize" src="../Views/ICON/see.png" alt="Ver" title="Ver" formaction="../Controllers/APP_Controller.php?actionPage=champView&name=<?php echo $fila['campeonato_nombre'];?>&id=<?php echo $fila['campeonato_id'];?>">
                              </form>
                            </div>
                            <?php
                            if ($_SESSION['tipo'] == 'administrador') {
                            ?>
                              <div class="col-3">
                                <form method="post">
                                  <input type="image" class="imgResize" src="../Views/ICON/edit.png" alt="Editar" title="Editar" formaction="../Controllers/APP_Controller.php?actionPage=openChamp&name=<?php echo $fila['campeonato_nombre'];?>">
                                </form>
                              </div>
                              <div class="col-3">
                                <form  method="post">
                                  <input type="image" class="imgResize" src="../Views/ICON/delete.png" alt="Eliminar" title="Eliminar" formaction="../Controllers/APP_Controller.php?actionPage=removeChamp&id=<?php echo $fila['campeonato_id'];?>">
                                </form>
                              </div>
                              <div class="col-3">
                                <form  method="post">
                                  <input type="image" class="imgResize" src="../Views/ICON/close.png" alt="Cerrar" title="Cerrar" formaction="../Controllers/APP_Controller.php?actionPage=closeChamp&name=<?php echo $fila['campeonato_nombre'];?>">
                                </form>
                              </div>
                            <?php
                            }
                            ?>
                          </div>
                        </div>
                      </div>
                      <?php
                    }
                  }
                  else {
                  ?>
                    <p>No hay campeonatos en este momento.</p>
                  <?php } ?>
                </div>
              </div>
              <hr>
              <div class="row" style="margin-top: 10px;"> <!-- Clases -->
                <div class="col-12">
                  <?php
                  if (@count($this->clases) != 0) {
                    ?>
                    <div class="row col-12">
                      <p><strong>Clases Actuales</strong></p>
                    </div>
                    <div class="row">
                      <div class="col-3">
                        <p><strong>Nombre</strong></p>
                      </div>
                      <div class="col-3">
                        <p><strong>Fecha</strong></p>
                      </div>
                      <div class="col-3">
                        <p><strong>Hora</strong></p>
                      </div>
                    </div>
                    <?php
                    foreach ($this->clases as $clase) {
                      ?>
                      <div class="row">
                        <div class="col-3">
                          <p><?php echo $clase['clase_nombre'];?></p>
                        </div>
                        <div class="col-3">
                          <p><?php echo date ("d-m-Y", strtotime($clase['clase_fecha']));?></p>
                        </div>
                        <div class="col-3">
                          <p><?php echo date ("H:i", strtotime($clase['clase_hora']));?></p>
                        </div>
                        <div class="col-3">
                          <div class="row">
                            <div class="col-3">
                              <form method="post">
                                <input type="image" class="imgResize" src="../Views/ICON/see.png" alt="Ver" title="Ver" formaction="../Controllers/APP_Controller.php?actionPage=viewClass&id=<?php echo $clase['clase_id'];?>">
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php
                    }
                  } else {
                  ?>
                    <p>No hay clases en este momento.</p>
                  <?php
                  }
                  ?>
                </div>
              </div>
              <hr>
              <?php if($_SESSION['tipo'] == 'deportista') { ?>
              <div class="row" style="margin-top: 10px;"> <!-- Reservas -->
                <div class="col-12">
                  <?php
                  if (@count($this->reservas) != 0) {
                    ?>
                    <div class="row col-12">
                      <p><strong>Reservas Actuales</strong></p>
                    </div>
                    <div class="row">
                      <div class="col-2">
                        <p><strong>Pista</strong></p>
                      </div>
                      <div class="col-2">
                        <p><strong>Fecha</strong></p>
                      </div>
                      <div class="col-2">
                        <p><strong>Hora</strong></p>
                      </div>
                    </div>
                    <?php
                    $date = new DateTime('today');
                    $day = $date->format('Y-m-d');
                    $hour = $date->format('H-i-s');
                    while ( $fila = mysqli_fetch_array($this->reservas) ) {
                      if($fila['usuario_email'] == $_SESSION['email'] && $fila['reserva_fecha'] >= $day && $fila['reserva_hora'] >= $hour) { // Comprobar reservas activas
                      ?>
                      <div class="row">
                        <div class="col-2">
                          <p><?php echo $fila['reserva_pista'];?></p>
                        </div>
                        <div class="col-2">
                          <p><?php $reserva_fecha = new DateTime($fila['reserva_fecha']); echo $reserva_fecha->format('d/m/Y');?></p>
                        </div>
                        <div class="col-2">
                          <p><?php $reserva_hora = new DateTime($fila['reserva_hora']); echo $reserva_hora->format('H:i');?></p>
                        </div>
                        <div class="col-2">
                          <div class="row">
                              <div class="col-3">
                                <form  method="post">
                                  <input type="image" class="imgResize" src="../Views/ICON/delete.png" alt="Eliminar" title="Eliminar" formaction="../Controllers/APP_Controller.php?actionPage=deleteBooking&reserva_id=<?php echo $fila['reserva_id'];?>">
                                </form>
                              </div>
                          </div>
                        </div>
                      </div>
                      <?php
                        }
                      }
                    } else {
                      ?>
                      <p>No hay reservas asociadas a este usuario.</p>
                      <?php
                    }
                  } ?>
                </div>
              </div>
              <hr>
            </div>
          </div>
            <div id="modales"><!--Incluimos los modales-->
              <?php
              include 'Modal_NewEvent.php';
              include 'Modal_NewChamp.php';
              include 'Modal_NewPromotedMatch.php';
              include 'Modal_NewBooking.php';
              include 'Modal_NewClass.php';
              include 'Modal_NewEscuelaDeportiva.php';
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
