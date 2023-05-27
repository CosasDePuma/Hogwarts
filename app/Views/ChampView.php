<?php
class ChampView {
  var $campeonato;
  var $registrado;
  var $registrados;
  var $resultados;

  function __construct($campeonato, $registrado, $registrados, $resultados) {
    $this->campeonato = $campeonato;
    $this->registrado = $registrado;
    $this->registrados = $registrados;
    $this->resultados = $resultados;
    $this->render();
  }
  function render() {
    include '../Views/Header.php';
    ?>
    <div class="container">
      <?php
      if (@count($this->registrado) != 0) {
        $reg = $this->registrado;
      }
      if (@count($this->campeonato) != 0) {
        $fila = mysqli_fetch_array($this->campeonato);
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
              <div class="row col-12">
                <form class="" action="../Controllers/APP_Controller.php?actionPage=list" method="post">
                  <input type="image" class="navbarIcon" src="../Views/ICON/home.png" alt="Inicio" title="Inicio">
                </form>
              </div>
              <?php
              if ($_SESSION['tipo'] == 'administrador') {
              ?>
                <div class="row col-12">
                  <form method="post">
                    <input type="image" class="navbarIcon" src="../Views/ICON/edit.png" alt="Editar" title="Editar" formaction="../Controllers/APP_Controller.php?actionPage=openChamp&name=<?php echo $fila['campeonato_nombre'];?>">
                  </form>
                </div>
                <div class="row col-12">
                  <form  method="post">
                    <input type="image" class="navbarIcon" src="../Views/ICON/delete.png" alt="Eliminar" title="Eliminar" formaction="../Controllers/APP_Controller.php?actionPage=removeChamp&id=<?php echo $fila['campeonato_id'];?>">
                  </form>
                </div>
                <div class="row col-12">
                  <form  method="post">
                    <input type="image" class="navbarIcon" src="../Views/ICON/close.png" alt="Cerrar" title="Cerrar" formaction="../Controllers/APP_Controller.php?actionPage=closeChamp&name=<?php echo $fila['campeonato_nombre'];?>">
                  </form>
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
              <div class="row">
                <div class="col-12">
                    <div class="row">
                      <div class="col-12">
                        <div class="row">
                          <div class="offset-5 col-4">
                            <h3><strong><?php echo $fila['campeonato_nombre'];?></strong></h3>
                          </div>
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
                                <p><?php echo $fila['campeonato_descripcion'];?></p>
                              </div>
                            </div>
                          </div>
                        </div>
                        <hr>
                        <div class="row">
                          <div class="col-2">
                            <h4><strong>Nivel:</strong></h4>
                          </div>
                          <div class="col-4">
                            <p><?php echo $textNivel;?></p>
                          </div>
                          <div class="col-2">
                            <h4><strong>Género:</strong></h4>
                          </div>
                          <div class="col-4">
                            <p><?php echo $textGenero;?></p>
                          </div>
                        </div>
                        <hr>
                      </div>
                    </div>
                  <?php
                  }
                  else {
                  ?>
                    <p>No hay campeonatos en este momento.</p>
                  <?php } ?>
                </div>
              </div>
              <?php
            if ($_SESSION['tipo'] == "deportista") {
              ?>
              <div class="row">
                <?php
                if ($reg === false) {
                ?>
                <div class="col-12">
                  <form action="../Controllers/APP_Controller.php?actionPage=inChamp&id=<?php echo $fila['campeonato_id'];?>" method="post">
                    <div class="row">
                      <div class="col-9">
                        <label class="col-form-label">Email de su compañero de equipo: </label>
                        <input type="text" name="companero" size="40%" style="border-radius: 10px;border: hidden;">
                      </div>
                      <div class="col-3">
                        <button type="submit" name="button" style="background-color: transparent; border: none; color: #DDD;">
                          <img src="../Views/ICON/inscribirse.png" alt="Inscribirse" title="Inscribirse" style="display: inline-block;">
                          <strong>Inscribirse</strong>
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
                <?php
                } else {
                  ?>
                  <div class="offset-5">
                    <form class="" action="../Controllers/APP_Controller.php?actionPage=deinChamp&id=<?php echo $fila['campeonato_id'];?>" method="post">
                      <button type="submit" name="button" style="background-color: transparent; border: none; color: #DDD;">
                        <img src="../Views/ICON/desinscribirse.png" alt="Desinscribirse" title="Desinscribirse" style="display: inline-block;">
                        <strong>Desinscribirse</strong>
                      </button>
                    </form>
                  </div>
                  <?php
                }
                ?>
              </div>
              <hr>
              <?php
              }
              ?>
              <div class="row"><!-- Tablas de los grupos de la liga regular -->
                <div class="col-12">
                  <?php
                  if ($this->registrados != null && @count($this->registrados) != 0) {
                    $cont = 0;
                    while ( $fila = mysqli_fetch_array($this->registrados)) {
                      $cont = $cont + 1;
                      list($nom, $rest) =  preg_split('[@]', $fila['capitan_id']);
                      $equipos[$cont] = $nom;
                    }
                    $count = 0;
                    while ($this->resultados != null && $res = mysqli_fetch_array($this->resultados)) {
                      $count = $count + 1;
                      $resLocal[$count] = $res['partido_resultado_local'];
                      $resVisit[$count] = $res['partido_resultado_visitante'];
                    }
                    if (isset($resLocal)) {
                      $maxRe = sizeof($resLocal);
                    } else {
                      $maxRe = 0;
                    }
                    if ($cont >= 13) {
                      $cont1 = 12;
                      $cont2 = $cont - 12;
                      /*
                      if ($cont1 == 12 && $cont2 <= 4) {
                        $cont1 = $cont1 - 4;
                        $cont2 = $cont2 + 4;
                      }
                      */
                    } else {
                      $cont1 = $cont;
                      $cont2 = 0;
                    }
                    if ($_SESSION['tipo'] == 'administrador') {
                      ?>
                      <div class="row col-12">
                        <h3>Administrador recuerde completar primero cada tupla antes de pasar a otra.</h3>
                      </div>
                      <?php
                      switch ($cont1) {
                        case 1:
                          ?>
                          <table class="table table-striped table-bordered table-condensed colors">
                            <tr>
                              <th><?php echo $equipos[1]?></th>
                            </tr>
                          </table>
                          <?php
                          break;
                        case 2:
                        ?>
                        <table class="table table-striped table-bordered table-condensed colors">
                          <?php
                          $conpteur = 1;
                          ?>
                          <tr>
                            <th class="groupetto">Grupo 1 L\V</th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                          </tr>
                          <?php
                          $conpteur = 1;
                          ?>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                          </tr>
                        </table>
                        <?php
                          break;
                        case 3:
                        ?>
                        <table class="table table-striped table-bordered table-condensed colors">
                          <?php
                          $conpteur = 1;
                          ?>
                          <tr>
                            <th class="groupetto">Grupo 1 L\V</th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                          </tr>
                          <?php
                          $conpteur = 1;
                          ?>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                          </tr>
                        </table>
                        <?php
                          break;
                        case 4:
                        ?>
                        <table class="table table-striped table-bordered table-condensed colors">
                          <?php
                          $conpteur = 1;
                          ?>
                          <tr>
                            <th class="groupetto">Grupo 1 L\V</th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                          </tr>
                          <?php
                          $conpteur = 1;
                          ?>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                          </tr>
                        </table>
                        <?php
                          break;
                        case 5:
                        ?>
                        <table class="table table-striped table-bordered table-condensed colors">
                          <?php
                          $conpteur = 1;
                          ?>
                          <tr>
                            <th class="groupetto">Grupo 1 L\V</th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                          </tr>
                          <?php
                          $conpteur = 1;
                          ?>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                          </tr>
                        </table>
                        <?php
                          break;
                        case 6:
                        ?>
                        <table class="table table-striped table-bordered table-condensed colors">
                          <?php
                          $conpteur = 1;
                          ?>
                          <tr>
                            <th class="groupetto">Grupo 1 L\V</th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                          </tr>
                          <?php
                          $conpteur = 1;
                          ?>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                          </tr>
                        </table>
                        <?php
                          break;
                        case 7:
                        ?>
                        <table class="table table-striped table-bordered table-condensed colors">
                          <?php
                          $conpteur = 1;
                          ?>
                          <tr>
                            <th class="groupetto">Grupo 1 L\V</th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                          </tr>
                          <?php
                          $conpteur = 1;
                          ?>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                          </tr>
                        </table>
                        <?php
                          break;
                        case 8:
                        ?>
                        <table class="table table-striped table-bordered table-condensed colors">
                          <?php
                          $conpteur = 1;
                          ?>
                          <tr>
                            <th class="groupetto">Grupo 1 L\V</th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                          </tr>
                          <?php
                          $conpteur = 1;
                          ?>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                          </tr>
                        </table>
                        <?php
                          break;
                        case 9:
                          ?>
                          <table class="table table-striped table-bordered table-condensed colors">
                            <?php
                            $conpteur = 1;
                            ?>
                            <tr>
                              <th class="groupetto">Grupo 1 L\V</th>
                              <th><?php echo $equipos[$conpteur++]?></th>
                              <th><?php echo $equipos[$conpteur++]?></th>
                              <th><?php echo $equipos[$conpteur++]?></th>
                              <th><?php echo $equipos[$conpteur++]?></th>
                              <th><?php echo $equipos[$conpteur++]?></th>
                              <th><?php echo $equipos[$conpteur++]?></th>
                              <th><?php echo $equipos[$conpteur++]?></th>
                              <th><?php echo $equipos[$conpteur++]?></th>
                              <th><?php echo $equipos[$conpteur++]?></th>
                            </tr>
                            <?php
                            $conpteur = 1;
                            ?>
                            <tr>
                              <td><?php echo $equipos[$conpteur++]?></td>
                              <td class="no"></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            </tr>
                            <tr>
                              <td><?php echo $equipos[$conpteur++]?></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td class="no"></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            </tr>
                            <tr>
                              <td><?php echo $equipos[$conpteur++]?></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td class="no"></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            </tr>
                            <tr>
                              <td><?php echo $equipos[$conpteur++]?></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td class="no"></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            </tr>
                            <tr>
                              <td><?php echo $equipos[$conpteur++]?></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td class="no"></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            </tr>
                            <tr>
                              <td><?php echo $equipos[$conpteur++]?></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td class="no"></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            </tr>
                            <tr>
                              <td><?php echo $equipos[$conpteur++]?></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td class="no"></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            </tr>
                            <tr>
                              <td><?php echo $equipos[$conpteur++]?></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td class="no"></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            </tr>
                            <tr>
                              <td><?php echo $equipos[$conpteur++]?></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td class="no"></td>
                            </tr>
                          </table>
                          <?php
                          break;
                        case 10:
                        ?>
                        <table class="table table-striped table-bordered table-condensed colors">
                          <?php
                          $conpteur = 1;
                          ?>
                          <tr>
                            <th class="groupetto">Grupo 1 L\V</th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                          </tr>
                          <?php
                          $conpteur = 1;
                          ?>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                          </tr>
                        </table>
                        <?php
                          break;
                        case 11:
                        ?>
                        <table class="table table-striped table-bordered table-condensed colors">
                          <?php
                          $conpteur = 1;
                          ?>
                          <tr>
                            <th class="groupetto">Grupo 1 L\V</th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                          </tr>
                          <?php
                          $conpteur = 1;
                          ?>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                          </tr>
                        </table>
                        <?php
                          break;
                        case 12:
                        ?>
                        <table class="table table-striped table-bordered table-condensed colors">
                          <?php
                          $conpteur = 1;
                          ?>
                          <tr>
                            <th class="groupetto">Grupo 1 L\V</th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                          </tr>
                          <?php
                          $conpteur = 1;
                          ?>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td class="no"></td>
                            <td>
                              <a data-toggle="modal" data-target="#newMatch">
                                Mod.
                              </a>
                            </td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                          </tr>
                        </table>
                        <?php
                          break;
                        default:
                          /* Esto no deberia pasar nunca */
                          break;
                      }
                      switch ($cont2) {
                        case 1:
                          ?>
                          <table class="table table-striped table-bordered table-condensed colors">
                            <tr>
                              <th><?php echo $equipos[$cont1 + 1]?></th>
                            </tr>
                          </table>
                          <?php
                          break;
                        case 2:
                        ?>
                        <table class="table table-striped table-bordered table-condensed colors">
                          <?php
                          $conpteur = $cont1 + 1;
                          ?>
                          <tr>
                            <th class="groupetto">Grupo 2 L\V</th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                          </tr>
                          <?php
                          $conpteur = $cont1 + 1;
                          ?>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                          </tr>
                        </table>
                        <?php
                          break;
                        case 3:
                        ?>
                        <table class="table table-striped table-bordered table-condensed colors">
                          <?php
                          $conpteur = $cont1 + 1;
                          ?>
                          <tr>
                            <th class="groupetto">Grupo 2 L\V</th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                          </tr>
                          <?php
                          $conpteur = $cont1 + 1;
                          ?>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                          </tr>
                        </table>
                        <?php
                          break;
                        case 4:
                        ?>
                        <table class="table table-striped table-bordered table-condensed colors">
                          <?php
                          $conpteur = $cont1 + 1;
                          ?>
                          <tr>
                            <th class="groupetto">Grupo 2 L\V</th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                          </tr>
                          <?php
                          $conpteur = $cont1 + 1;
                          ?>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                          </tr>
                        </table>
                        <?php
                          break;
                        case 5:
                        ?>
                        <table class="table table-striped table-bordered table-condensed colors">
                          <?php
                          $conpteur = $cont1 + 1;
                          ?>
                          <tr>
                            <th class="groupetto">Grupo 2 L\V</th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                          </tr>
                          <?php
                          $conpteur = $cont1 + 1;
                          ?>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                          </tr>
                        </table>
                        <?php
                          break;
                        case 6:
                        ?>
                        <table class="table table-striped table-bordered table-condensed colors">
                          <?php
                          $conpteur = $cont1 + 1;
                          ?>
                          <tr>
                            <th class="groupetto">Grupo 2 L\V</th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                          </tr>
                          <?php
                          $conpteur = $cont1 + 1;
                          ?>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                          </tr>
                        </table>
                        <?php
                          break;
                        case 7:
                        ?>
                        <table class="table table-striped table-bordered table-condensed colors">
                          <?php
                          $conpteur = $cont1 + 1;
                          ?>
                          <tr>
                            <th class="groupetto">Grupo 2 L\V</th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                          </tr>
                          <?php
                          $conpteur = $cont1 + 1;
                          ?>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                          </tr>
                        </table>
                        <?php
                          break;
                        case 8:
                        ?>
                        <table class="table table-striped table-bordered table-condensed colors">
                          <?php
                          $conpteur = $cont1 + 1;
                          ?>
                          <tr>
                            <th class="groupetto">Grupo 2 L\V</th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                          </tr>
                          <?php
                          $conpteur = $cont1 + 1;
                          ?>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                          </tr>
                        </table>
                        <?php
                          break;
                        case 9:
                          ?>
                          <table class="table table-striped table-bordered table-condensed colors">
                            <?php
                            $conpteur = $cont1 + 1;
                            ?>
                            <tr>
                              <th class="groupetto">Grupo 2 L\V</th>
                              <th><?php echo $equipos[$conpteur++]?></th>
                              <th><?php echo $equipos[$conpteur++]?></th>
                              <th><?php echo $equipos[$conpteur++]?></th>
                              <th><?php echo $equipos[$conpteur++]?></th>
                              <th><?php echo $equipos[$conpteur++]?></th>
                              <th><?php echo $equipos[$conpteur++]?></th>
                              <th><?php echo $equipos[$conpteur++]?></th>
                              <th><?php echo $equipos[$conpteur++]?></th>
                              <th><?php echo $equipos[$conpteur++]?></th>
                            </tr>
                            <?php
                            $conpteur = $cont1 + 1;
                            ?>
                            <tr>
                              <td><?php echo $equipos[$conpteur++]?></td>
                              <td class="no"></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            </tr>
                            <tr>
                              <td><?php echo $equipos[$conpteur++]?></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td class="no"></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            </tr>
                            <tr>
                              <td><?php echo $equipos[$conpteur++]?></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td class="no"></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            </tr>
                            <tr>
                              <td><?php echo $equipos[$conpteur++]?></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td class="no"></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            </tr>
                            <tr>
                              <td><?php echo $equipos[$conpteur++]?></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td class="no"></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            </tr>
                            <tr>
                              <td><?php echo $equipos[$conpteur++]?></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td class="no"></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            </tr>
                            <tr>
                              <td><?php echo $equipos[$conpteur++]?></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td class="no"></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            </tr>
                            <tr>
                              <td><?php echo $equipos[$conpteur++]?></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td class="no"></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            </tr>
                            <tr>
                              <td><?php echo $equipos[$conpteur++]?></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td class="no"></td>
                            </tr>
                          </table>
                          <?php
                          break;
                        case 10:
                        ?>
                        <table class="table table-striped table-bordered table-condensed colors">
                          <?php
                          $conpteur = $cont1 + 1;
                          ?>
                          <tr>
                            <th class="groupetto">Grupo 2 L\V</th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                          </tr>
                          <?php
                          $conpteur = $cont1 + 1;
                          ?>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                          </tr>
                        </table>
                        <?php
                          break;
                        case 11:
                        ?>
                        <table class="table table-striped table-bordered table-condensed colors">
                          <?php
                          $conpteur = $cont1 + 1;
                          ?>
                          <tr>
                            <th class="groupetto">Grupo 2 L\V</th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                          </tr>
                          <?php
                          $conpteur = $cont1 + 1;
                          ?>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            <td class="no"></td>
                          </tr>
                        </table>
                        <?php
                          break;
                          case 12:
                          ?>
                          <table class="table table-striped table-bordered table-condensed colors">
                            <?php
                            $conpteur = $cont1 + 1;
                            ?>
                            <tr>
                              <th class="groupetto">Grupo 2 L\V</th>
                              <th><?php echo $equipos[$conpteur++]?></th>
                              <th><?php echo $equipos[$conpteur++]?></th>
                              <th><?php echo $equipos[$conpteur++]?></th>
                              <th><?php echo $equipos[$conpteur++]?></th>
                              <th><?php echo $equipos[$conpteur++]?></th>
                              <th><?php echo $equipos[$conpteur++]?></th>
                              <th><?php echo $equipos[$conpteur++]?></th>
                              <th><?php echo $equipos[$conpteur++]?></th>
                              <th><?php echo $equipos[$conpteur++]?></th>
                              <th><?php echo $equipos[$conpteur++]?></th>
                              <th><?php echo $equipos[$conpteur++]?></th>
                              <th><?php echo $equipos[$conpteur++]?></th>
                            </tr>
                            <?php
                            $conpteur = $cont1 + 1;
                            ?>
                            <tr>
                              <td><?php echo $equipos[$conpteur++]?></td>
                              <td class="no"></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            </tr>
                            <tr>
                              <td><?php echo $equipos[$conpteur++]?></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td class="no"></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            </tr>
                            <tr>
                              <td><?php echo $equipos[$conpteur++]?></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td class="no"></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            </tr>
                            <tr>
                              <td><?php echo $equipos[$conpteur++]?></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td class="no"></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            </tr>
                            <tr>
                              <td><?php echo $equipos[$conpteur++]?></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td class="no"></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            </tr>
                            <tr>
                              <td><?php echo $equipos[$conpteur++]?></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td class="no"></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            </tr>
                            <tr>
                              <td><?php echo $equipos[$conpteur++]?></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td class="no"></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            </tr>
                            <tr>
                              <td><?php echo $equipos[$conpteur++]?></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td class="no"></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            </tr>
                            <tr>
                              <td><?php echo $equipos[$conpteur++]?></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td class="no"></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            </tr>
                            <tr>
                              <td><?php echo $equipos[$conpteur++]?></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td class="no"></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            </tr>
                            <tr>
                              <td><?php echo $equipos[$conpteur++]?></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td class="no"></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                            </tr>
                            <tr>
                              <td><?php echo $equipos[$conpteur++]?></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td><a data-toggle="modal" data-target="#newMatch">Mod.</a></td>
                              <td class="no"></td>
                            </tr>
                          </table>
                          <?php
                            break;
                        default:
                          /* Esto no deberia pasar nunca */
                          break;
                      }
                    }
                    switch ($cont1) {
                      case 1:
                        ?>
                        <table class="table table-striped table-bordered table-condensed colors">
                          <tr>
                            <th><?php echo $equipos[1]?></th>
                          </tr>
                        </table>
                        <?php
                        break;
                      case 2:
                      ?>
                      <table class="table table-striped table-bordered table-condensed colors">
                        <?php
                        $conpteur = 1;
                        ?>
                        <tr>
                          <th class="groupetto">Grupo 1 L\V</th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                        </tr>
                        <?php
                        $conpteur = 1;
                        $compRes = 1;
                        ?>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                        </tr>
                      </table>
                      <?php
                        break;
                      case 3:
                      ?>
                      <table class="table table-striped table-bordered table-condensed colors">
                        <?php
                        $conpteur = 1;
                        ?>
                        <tr>
                          <th class="groupetto">Grupo 1 L\V</th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                        </tr>
                        <?php
                        $conpteur = 1;
                        $compRes = 1;
                        ?>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                        </tr>
                      </table>
                      <?php
                        break;
                      case 4:
                      ?>
                      <table class="table table-striped table-bordered table-condensed colors">
                        <?php
                        $conpteur = 1;
                        ?>
                        <tr>
                          <th class="groupetto">Grupo 1 L\V</th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                        </tr>
                        <?php
                        $conpteur = 1;
                        $compRes = 1;
                        ?>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                        </tr>
                      </table>
                      <?php
                        break;
                      case 5:
                      ?>
                      <table class="table table-striped table-bordered table-condensed colors">
                        <?php
                        $conpteur = 1;
                        ?>
                        <tr>
                          <th class="groupetto">Grupo 1 L\V</th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                        </tr>
                        <?php
                        $conpteur = 1;
                        $compRes = 1;
                        ?>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                        </tr>
                      </table>
                      <?php
                        break;
                      case 6:
                      ?>
                      <table class="table table-striped table-bordered table-condensed colors">
                        <?php
                        $conpteur = 1;
                        ?>
                        <tr>
                          <th class="groupetto">Grupo 1 L\V</th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                        </tr>
                        <?php
                        $conpteur = 1;
                        $compRes = 1;
                        ?>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                        </tr>
                      </table>
                      <?php
                        break;
                      case 7:
                      ?>
                      <table class="table table-striped table-bordered table-condensed colors">
                        <?php
                        $conpteur = 1;
                        ?>
                        <tr>
                          <th class="groupetto">Grupo 1 L\V</th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                        </tr>
                        <?php
                        $conpteur = 1;
                        $compRes = 1;
                        ?>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                        </tr>
                      </table>
                      <?php
                        break;
                      case 8:
                      ?>
                      <table class="table table-striped table-bordered table-condensed colors">
                        <?php
                        $conpteur = 1;
                        ?>
                        <tr>
                          <th class="groupetto">Grupo 1 L\V</th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                        </tr>
                        <?php
                        $conpteur = 1;
                        $compRes = 1;
                        ?>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                        </tr>
                      </table>
                      <?php
                        break;
                      case 9:
                        ?>
                        <table class="table table-striped table-bordered table-condensed colors">
                          <?php
                          $conpteur = 1;
                          ?>
                          <tr>
                            <th class="groupetto">Grupo 1 L\V</th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                          </tr>
                          <?php
                          $conpteur = 1;
                          $compRes = 1;
                          ?>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td class="no"></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td class="no"></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td class="no"></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td class="no"></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td class="no"></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td class="no"></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td class="no"></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td class="no"></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td class="no"></td>
                          </tr>
                        </table>
                        <?php
                        break;
                      case 10:
                      ?>
                      <table class="table table-striped table-bordered table-condensed colors">
                        <?php
                        $conpteur = 1;
                        ?>
                        <tr>
                          <th class="groupetto">Grupo 1 L\V</th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                        </tr>
                        <?php
                        $conpteur = 1;
                        $compRes = 1;
                        ?>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                        </tr>
                      </table>
                      <?php
                        break;
                      case 11:
                      ?>
                      <table class="table table-striped table-bordered table-condensed colors">
                        <?php
                        $conpteur = 1;
                        ?>
                        <tr>
                          <th class="groupetto">Grupo 1 L\V</th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                        </tr>
                        <?php
                        $conpteur = 1;
                        $compRes = 1;
                        ?>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                        </tr>
                      </table>
                      <?php
                        break;
                      case 12:
                      ?>
                      <table class="table table-striped table-bordered table-condensed colors">
                        <?php
                        $conpteur = 1;
                        ?>
                        <tr>
                          <th class="groupetto">Grupo 1 L\V</th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                        </tr>
                        <?php
                        $conpteur = 1;
                        $compRes = 1;
                        ?>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td class="no"></td>
                          <td>
                            <a data-toggle="modal" data-target="#newMatch">
                              Mod.
                            </a>
                          </td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                        </tr>
                      </table>
                      <?php
                        break;
                      default:
                        /* Esto no deberia pasar nunca */
                        break;
                    }
                    switch ($cont2) {
                      case 1:
                        ?>
                        <table class="table table-striped table-bordered table-condensed colors">
                          <tr>
                            <th><?php echo $equipos[$cont1 + 1]?></th>
                          </tr>
                        </table>
                        <?php
                        break;
                      case 2:
                      ?>
                      <table class="table table-striped table-bordered table-condensed colors">
                        <?php
                        $conpteur = $cont1 + 1;
                        ?>
                        <tr>
                          <th class="groupetto">Grupo 2 L\V</th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                        </tr>
                        <?php
                        $conpteur = $cont1 + 1;
                        $compRes = 1;
                        ?>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                        </tr>
                      </table>
                      <?php
                        break;
                      case 3:
                      ?>
                      <table class="table table-striped table-bordered table-condensed colors">
                        <?php
                        $conpteur = $cont1 + 1;
                        ?>
                        <tr>
                          <th class="groupetto">Grupo 2 L\V</th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                        </tr>
                        <?php
                        $conpteur = $cont1 + 1;
                        $compRes = 1;
                        ?>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                        </tr>
                      </table>
                      <?php
                        break;
                      case 4:
                      ?>
                      <table class="table table-striped table-bordered table-condensed colors">
                        <?php
                        $conpteur = $cont1 + 1;
                        ?>
                        <tr>
                          <th class="groupetto">Grupo 2 L\V</th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                        </tr>
                        <?php
                        $conpteur = $cont1 + 1;
                        $compRes = 1;
                        ?>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                        </tr>
                      </table>
                      <?php
                        break;
                      case 5:
                      ?>
                      <table class="table table-striped table-bordered table-condensed colors">
                        <?php
                        $conpteur = $cont1 + 1;
                        ?>
                        <tr>
                          <th class="groupetto">Grupo 2 L\V</th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                        </tr>
                        <?php
                        $conpteur = $cont1 + 1;
                        $compRes = 1;
                        ?>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                        </tr>
                      </table>
                      <?php
                        break;
                      case 6:
                      ?>
                      <table class="table table-striped table-bordered table-condensed colors">
                        <?php
                        $conpteur = $cont1 + 1;
                        ?>
                        <tr>
                          <th class="groupetto">Grupo 2 L\V</th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                        </tr>
                        <?php
                        $conpteur = $cont1 + 1;
                        $compRes = 1;
                        ?>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                        </tr>
                      </table>
                      <?php
                        break;
                      case 7:
                      ?>
                      <table class="table table-striped table-bordered table-condensed colors">
                        <?php
                        $conpteur = $cont1 + 1;
                        ?>
                        <tr>
                          <th class="groupetto">Grupo 2 L\V</th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                        </tr>
                        <?php
                        $conpteur = $cont1 + 1;
                        $compRes = 1;
                        ?>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                        </tr>
                      </table>
                      <?php
                        break;
                      case 8:
                      ?>
                      <table class="table table-striped table-bordered table-condensed colors">
                        <?php
                        $conpteur = $cont1 + 1;
                        ?>
                        <tr>
                          <th class="groupetto">Grupo 2 L\V</th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                        </tr>
                        <?php
                        $conpteur = $cont1 + 1;
                        $compRes = 1;
                        ?>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                        </tr>
                      </table>
                      <?php
                        break;
                      case 9:
                        ?>
                        <table class="table table-striped table-bordered table-condensed colors">
                          <?php
                          $conpteur = $cont1 + 1;
                          ?>
                          <tr>
                            <th class="groupetto">Grupo 2 L\V</th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                          </tr>
                          <?php
                          $conpteur = $cont1 + 1;
                          $compRes = 1;
                          ?>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td class="no"></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td class="no"></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td class="no"></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td class="no"></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td class="no"></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td class="no"></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td class="no"></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td class="no"></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td class="no"></td>
                          </tr>
                        </table>
                        <?php
                        break;
                      case 10:
                      ?>
                      <table class="table table-striped table-bordered table-condensed colors">
                        <?php
                        $conpteur = $cont1 + 1;
                        ?>
                        <tr>
                          <th class="groupetto">Grupo 2 L\V</th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                        </tr>
                        <?php
                        $conpteur = $cont1 + 1;
                        $compRes = 1;
                        ?>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                        </tr>
                      </table>
                      <?php
                        break;
                      case 11:
                      ?>
                      <table class="table table-striped table-bordered table-condensed colors">
                        <?php
                        $conpteur = $cont1 + 1;
                        ?>
                        <tr>
                          <th class="groupetto">Grupo 2 L\V</th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                          <th><?php echo $equipos[$conpteur++]?></th>
                        </tr>
                        <?php
                        $conpteur = $cont1 + 1;
                        $compRes = 1;
                        ?>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                        </tr>
                        <tr>
                          <td><?php echo $equipos[$conpteur++]?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          <td class="no"></td>
                        </tr>
                      </table>
                      <?php
                        break;
                        case 12:
                        ?>
                        <table class="table table-striped table-bordered table-condensed colors">
                          <?php
                          $conpteur = $cont1 + 1;
                          ?>
                          <tr>
                            <th class="groupetto">Grupo 2 L\V</th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                            <th><?php echo $equipos[$conpteur++]?></th>
                          </tr>
                          <?php
                          $conpteur = $cont1 + 1;
                          $compRes = 1;
                          ?>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td class="no"></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td class="no"></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td class="no"></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td class="no"></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td class="no"></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td class="no"></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td class="no"></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td class="no"></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td class="no"></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td class="no"></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td class="no"></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                          </tr>
                          <tr>
                            <td><?php echo $equipos[$conpteur++]?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td><?php if ($compRes <= $maxRe){echo $resLocal[$compRes]." - ".$resVisit[$compRes++];}?></td>
                            <td class="no"></td>
                          </tr>
                        </table>
                        <?php
                          break;
                      default:
                        /* Esto no deberia pasar nunca */
                        break;
                    }
                  } else {
                  ?>
                  <div class="row col-12">
                    <p>No hay equipos inscritos en este momento.</p>
                  </div>
                  <?php
                  }
                  ?>
                </div>
              </div>
            </div>
            <div id="modales"><!--Incluimos los modales-->
              <?php
              include 'Modal_NewPartido.php';
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
