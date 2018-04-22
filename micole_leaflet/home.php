<?php
    include("php/seguridad.php");
    include("php/config.php");
    include("php/funciones.php");

    $pag = 'home';
    $curso = devuelveCurso();

    $selAlumnos = pg_exec("SELECT COUNT(*) FROM alumnos
        INNER JOIN alumnos_a_centros
        ON alumnos.id_alumno = alumnos_a_centros.id_alumno
        WHERE alumnos.curso=".$curso."
        and alumnos.estado=42
        AND alumnos_a_centros.id_centro=".$_SESSION['user_id']);
    $num_alumnos = pg_fetch_row($selAlumnos);
    $num_alumnos = number_format($num_alumnos[0], 0, ",", ".");

    $selPlazas = pg_exec("SELECT SUM(plazas) FROM usuarios_a_tipos
        WHERE curso=".$curso."
        AND id_usuario=".$_SESSION['user_id']);
    $num_plazas = pg_fetch_row($selPlazas);
    $num_plazas = number_format($num_plazas[0], 0, ",", ".");
?>

<!DOCTYPE html>
<html>
    <head>
        <?php include("includes/inc-metas.php");?>
        <title>decomap - backoffice</title>

        <?php include("includes/inc-css.php");?>
        <script src="js/modernizr-custom.js"></script>
    </head>
    <body>
        <div id="ui" class="ui">
            <!--header start-->
            <?php include("includes/inc-header.php");?>
            <!--header end-->

            <!--sidebar start-->
            <?php include("includes/inc-sidebar.php");?>
            <!--sidebar end-->

            <!--main content start-->
            <div id="content" class="ui-content ui-content-aside-overlay">
                <div class="ui-content-body">

                    <div class="ui-container">

                        <!--page title and breadcrumb start -->
                        <div class="row">
                            <div class="col-md-8">
                                <h1 class="page-title"> Panel de administración
                                    <small>datos, estadísticas, gráficos, enlaces, informes y más!</small>
                                </h1>
                            </div>
                            <div class="col-md-4">
                                <ul class="breadcrumb pull-right">
                                    <li>Home</li>
                                    <li><a href="#" class="active">Panel</a></li>
                                </ul>
                            </div>
                        </div>
                        <!--page title and breadcrumb end -->

                        <!--states start-->
                        <div class="row">
                          <a href="listado-alumnos.php">
                            <div class="col-md-3 col-sm-6">
                                <div class="panel short-states bg-danger">
                                    <div class="pull-right state-icon">
                                        <i class="fa fa-users"></i>
                                    </div>
                                    <div class="panel-body">
                                        <h1 class="light-txt"><?= $num_alumnos;?></h1>
                                        <strong class="text-uppercase">ALUMNOS INSCRITOS</strong>
                                    </div>
                                </div>
                            </div>
                          </a>
                          <a href="plazas.php">
                            <div class="col-md-3 col-sm-6">
                                <div class="panel short-states bg-info">
                                    <div class="pull-right state-icon">
                                        <i class="fa fa-child"></i>
                                    </div>
                                    <div class="panel-body">
                                        <h1 class="light-txt"><?= $num_plazas;?></h1>
                                        <strong class="text-uppercase">PLAZAS TOTALES</strong>
                                    </div>
                                </div>
                            </div>
                          </a>
                            <div class="col-md-3 col-sm-6">
                                <div class="panel short-states bg-warning">
                                    <div class="pull-right state-icon">
                                        <i class="fa fa-line-chart"></i>
                                    </div>
                                    <div class="panel-body">
                                        <h1 class="light-txt"><?= calculaPorcentajeCubierto();?>%</h1>
                                        <strong class="text-uppercase">PORCENTAJE CUBIERTO</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="panel short-states bg-primary">
                                    <div class="pull-right state-icon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    <div class="panel-body">
                                        <h1 class="light-txt"><?= calculaListaEspera();?></h1>
                                        <strong class="text-uppercase">EN LISTA DE ESPERA</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--states end-->

                        <div class="row">
                            <div class="col-md-7 ">
                                <div class="panel">
                                    <header class="panel-heading panel-border">
                                        ÚLTIMOS ALUMNOS INSCRITOS
                                        <span class="tools pull-right">
                                            <a class="refresh-box fa fa-repeat" href="javascript:;"></a>
                                            <a class="collapse-box fa fa-chevron-down" href="javascript:;"></a>
                                            <a class="close-box fa fa-times" href="javascript:;"></a>
                                        </span>
                                    </header>
                                    <div class="panel-body">
                                        <div class="order-short-info">
                                            <span class="mtop-10"> Alumnos inscritos: <strong><?= $num_alumnos;?></strong></span>
                                            <a href="listado-alumnos.php" class="pull-right pull-left-xs btn btn-primary btn-sm"><i class="fa fa-users" style="position: relative; right: 4px;"></i>Ver alumnos</a>
                                        </div>
                                        <hr>
                                        <div class="table-responsive">
                                            <table class="table table-hover latest-order">
                                                <thead>
                                                <tr>
                                                    <th>Nombre y apellidos</th>
                                                    <th>DNI</th>
                                                    <th>Modalidad</th>
                                                    <th>Idioma</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                <?php
                                                    $selAlumnos = pg_exec("SELECT al.nombre_alumno, al.apellidos_alumno, al.dni_alumno, idi.nombre, te.descripcion, al.id_alumno
                                                                            FROM alumnos AS al
                                                                            INNER JOIN idiomas AS idi
                                                                            ON al.id_idioma = idi.id_idioma
                                                                            INNER JOIN tipos_educativos AS te
                                                                            ON (al.id_tipo_educativo = te.id_tipo AND al.id_idioma = te.id_idioma)
                                                                            INNER JOIN alumnos_a_centros AS ac
                                                                            ON ac.id_alumno = al.id_alumno
                                                                            WHERE ac.id_centro = ".$_SESSION['user_id']."
                                                                            and al.estado=42
                                                                            ORDER BY al.id_alumno DESC
                                                                            LIMIT 5");
                                                    while($alumno = pg_fetch_row($selAlumnos)){
                                                        $a_nombre = $alumno[0]." ".$alumno[1];
                                                        $a_dni = $alumno[2];
                                                        $a_idioma = $alumno[3];
                                                        $a_modalidad = $alumno[4];
                                                        $a_id = $alumno[5];

                                                        echo "
                                                            <tr>
                                                                <td><a href='alumnos.php?a=".$a_id."'>".$a_nombre."</a></td>
                                                                <td>".$a_dni."</td>
                                                                <td>".$a_modalidad."</td>
                                                                <td>".$a_idioma."</td>
                                                            </tr>
                                                        ";
                                                    }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--charts end-->
                            <div class="col-md-5">
                                <div class="panel">
                                    <header class="panel-heading panel-border">
                                        PLAZAS TOTALES
                                        <span class="tools pull-right">
                                            <a class="refresh-box fa fa-repeat" href="javascript:;"></a>
                                            <a class="collapse-box fa fa-chevron-down" href="javascript:;"></a>
                                            <a class="close-box fa fa-times" href="javascript:;"></a>
                                        </span>
                                    </header>
                                    <div class="panel-body">
                                        <div class="order-short-info">
                                            <span class="mtop-10"> Plazas totales: <strong><?= $num_plazas;?></strong></span>
                                            <a href="plazas.php" class="pull-right pull-left-xs btn btn-primary btn-sm"><i class="fa fa-child" style="position: relative; right: 4px;"></i>Asignar plazas</a>
                                        </div>
                                        <hr>
                                        <div class="table-responsive">
                                            <table class="table table-hover latest-order">
                                                <thead>
                                                <tr>
                                                    <th>Modalidad</th>
                                                    <th>Idioma</th>
                                                    <th>Plazas</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    $selModalidades = pg_exec("SELECT te.descripcion, idiomas.nombre, ut.plazas
                                                                            FROM usuarios_a_tipos AS ut
                                                                            INNER JOIN tipos_educativos AS te
                                                                            ON (ut.id_tipo_educativo = te.id_tipo AND ut.id_idioma = te.id_idioma)
                                                                            INNER JOIN idiomas
                                                                            ON ut.id_idioma = idiomas.id_idioma
                                                                            LIMIT 5");
                                                    while($modalidad = pg_fetch_row($selModalidades)){
                                                        $m_desc = $modalidad[0];
                                                        $m_idioma = $modalidad[1];
                                                        $m_plazas = $modalidad[2];
                                                        echo "
                                                            <tr>
                                                                <td>".$m_desc."</td>
                                                                <td>".$m_idioma."</td>
                                                                <td>".$m_plazas."</td>
                                                            </tr>
                                                        ";
                                                    }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Comienza mapa -->
                        <div class="row">
                          <div class="col-md-12">
                              <div class="panel">
                                  <header class="panel-heading">
                                      Alumnos por zonas
                                      <span class="tools pull-right">
                                          <a class="close-box fa fa-times" href="javascript:;"></a>
                                      </span>
                                  </header>
                                  <div class="panel-body">
                                      <div class="form-group mapa" id="map" style="height: 370px"></div>
                                  </div>
                              </div>
                          </div>
                        </div>

                        <!-- Comienzan gráficos -->
                        <div class="row">
                          <div class="col-md-12">
                              <div class="panel">
                                  <header class="panel-heading">
                                      Altas por modalidad
                                      <span class="tools pull-right">
                                          <a class="close-box fa fa-times" href="javascript:;"></a>
                                      </span>
                                  </header>
                                  <div class="panel-body">
                                      <div id="nb-chart" style="height: 370px; z-index:0;"></div>
                                  </div>
                              </div>
                          </div>
                        </div>



                        <!-- <div class="row">
                            <div class="col-md-6">
                                <div class="panel">
                                    <header class="panel-heading">
                                        basic line
                                        <span class="tools pull-right">
                                            <a class="close-box fa fa-times" href="javascript:;"></a>
                                        </span>
                                    </header>
                                    <div class="panel-body">
                                        <div id="b-line" style="height: 370px"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel">
                                    <header class="panel-heading">
                                        basic area
                                        <span class="tools pull-right">
                                            <a class="close-box fa fa-times" href="javascript:;"></a>
                                        </span>
                                    </header>
                                    <div class="panel-body">
                                        <div id="b-area" style="height: 370px"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel">
                                    <header class="panel-heading">
                                        Rainfall and Evaporation
                                        <span class="tools pull-right">
                                            <a class="close-box fa fa-times" href="javascript:;"></a>
                                        </span>
                                    </header>
                                    <div class="panel-body">
                                        <div id="rainfall" style="height: 370px"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel">
                                    <header class="panel-heading">
                                        Basic Scatter Chart
                                        <span class="tools pull-right">
                                            <a class="close-box fa fa-times" href="javascript:;"></a>
                                        </span>
                                    </header>
                                    <div class="panel-body">
                                        <div id="bs-chart" style="height: 370px"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel">
                                    <header class="panel-heading">
                                        Basic Pie Chart
                                        <span class="tools pull-right">
                                            <a class="close-box fa fa-times" href="javascript:;"></a>
                                        </span>
                                    </header>
                                    <div class="panel-body">
                                        <div id="basic-Pie" style="height: 370px"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel">
                                    <header class="panel-heading">
                                        Nested Pie Chart
                                        <span class="tools pull-right">
                                            <a class="close-box fa fa-times" href="javascript:;"></a>
                                        </span>
                                    </header>
                                    <div class="panel-body">
                                        <div id="np-Pie" style="height: 370px"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel">
                                    <header class="panel-heading">
                                        Doughnut Pie Chart
                                        <span class="tools pull-right">
                                            <a class="close-box fa fa-times" href="javascript:;"></a>
                                        </span>
                                    </header>
                                    <div class="panel-body">
                                        <div id="doughnut" style="height: 370px"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel">
                                    <header class="panel-heading">
                                        Basic Radar Chart
                                        <span class="tools pull-right">
                                            <a class="close-box fa fa-times" href="javascript:;"></a>
                                        </span>
                                    </header>
                                    <div class="panel-body">
                                        <div id="radar" style="height: 370px"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel">
                                    <header class="panel-heading">
                                        Gauge
                                        <span class="tools pull-right">
                                            <a class="close-box fa fa-times" href="javascript:;"></a>
                                        </span>
                                    </header>
                                    <div class="panel-body">
                                        <div id="gauge" style="height: 370px"></div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
            <!--main content end-->

            <!--footer start-->
            <?php include("includes/inc-footer.php");?>
            <!--footer end-->
        </div>
        <?php include("includes/inc-js.php");?>
        <?php include("includes/inc-js-home.php");?>
        <?php include("includes/inc-js-mapas-home.php");?>
    </body>
</html>
