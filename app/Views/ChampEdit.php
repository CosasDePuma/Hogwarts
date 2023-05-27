<?php
class ChampEdit {
  var $campeonato;

  function __construct($campeonato) {
    $this->campeonato = $campeonato;
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
                  <?php
                  if (count($this->campeonato) != 0) {
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
                    <form action="../Controllers/APP_Controller.php?actionPage=editChamp&id=<?php echo $fila['campeonato_id'];?>" method="post">
                      <div class="row">
                        <div class="col-12">
                          <div class="row">
                            <div class="col-12">
                              <h3><strong>Campeonato seleccionado</strong></h3>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-2">
                              <p><strong>Nombre</strong></p>
                            </div>
                            <div class="col-4">
                              <p><?php echo $fila['campeonato_nombre'];?></p>
                            </div>
                            <div class="col-6">
                              <input type="text" class="form-control" name="nombre" value="<?php echo $fila['campeonato_nombre'];?>">
                            </div>
                          </div>
                          <hr>
                          <div class="row">
                            <div class="col-6">
                              <div class="row">
                                <div class="col-12">
                                  <p><strong>Descripción</strong></p>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-12">
                                  <p><?php echo $fila['campeonato_descripcion'];?></p>
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <textarea class="form-control" name="descripcion" rows="4" cols="80"><?php echo $fila['campeonato_descripcion'];?></textarea>
                            </div>
                          </div>
                          <hr>
                          <div class="row">
                            <div class="col-2">
                              <p><strong>Nivel</strong></p>
                            </div>
                            <div class="col-4">
                              <p><?php echo $textNivel;?></p>
                            </div>
                            <div class="col-6">
                              <select name="nivel" class="form-control">
                                <?php
                                switch ($textNivel) {
                                  case 1:
                                  ?>
                                  <option selected="selected" value="0">1</option>
                                  <option value="1">2</option>
                                  <option value="2">3</option>
                                  <?php
                                    break;
                                  case 2:
                                  ?>
                                  <option value="0">1</option>
                                  <option selected="selected" value="1">2</option>
                                  <option value="2">3</option>
                                  <?php
                                    break;
                                  case 3:
                                  ?>
                                  <option value="0">1</option>
                                  <option value="1">2</option>
                                  <option selected="selected" value="2">3</option>
                                  <?php
                                    break;
                                  default:
                                  ?>
                                  <option selected="selected" value="0">1</option>
                                  <option value="1">2</option>
                                  <option value="2">3</option>
                                  <?php
                                    break;
                                }
                                 ?>
                  						</select>
                            </div>
                          </div>
                          <hr>
                          <div class="row">
                            <div class="col-2">
                              <p><strong>Género</strong></p>
                            </div>
                            <div class="col-4">
                              <p><?php echo $textGenero;?></p>
                            </div>
                            <div class="col-6">
                              <select name="sexo" class="form-control">
                                <?php
                                switch ($textGenero) {
                                  case "Masculino":
                                  ?>
                                  <option selected="selected" value="hombre">Masculino</option>
                    							<option value="mujer">Femenino</option>
                    							<option value="mixto">Mixto</option>
                                  <?php
                                    break;
                                  case "Femenino":
                                  ?>
                                  <option value="hombre">Masculino</option>
                    							<option selected="selected" value="mujer">Femenino</option>
                    							<option value="mixto">Mixto</option>
                                  <?php
                                    break;
                                  case "Mixto":
                                  ?>
                                  <option value="hombre">Masculino</option>
                    							<option value="mujer">Femenino</option>
                    							<option selected="selected" value="mixto">Mixto</option>
                                  <?php
                                    break;
                                  default:
                                  ?>
                                  <option selected="selected" value="hombre">Masculino</option>
                    							<option value="mujer">Femenino</option>
                    							<option value="mixto">Mixto</option>
                                  <?php
                                    break;
                                }
                                 ?>
                  						</select>
                            </div>
                          </div>
                          <hr>
                        </div>
                      </div>
                      <div class="row">
                        <div class="offset-5 col-1">
                          <button type="submit" value="editChamp" class="btn btn-primary">Modificar</button>
                        </div>
                      </div>
                    </form>
                    <?php
                  }
                  else {
                  ?>
                    <p>No hay campeonatos en este momento.</p>
                  <?php } ?>
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
