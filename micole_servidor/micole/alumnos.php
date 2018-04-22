<?php
    include("php/seguridad.php");
    include("php/config.php");
    include("php/funciones.php");
    $pag = "alumnos";

    if(isset($_GET['a']) && $_GET['a']!=''){
        //Chequeo que este centro puede ver los datos de este alumno
        $selAlumno = pg_exec("SELECT * FROM alumnos_a_centros WHERE id_alumno = '".$_GET['a']."' AND id_centro='".$_SESSION['user_id']."'");
        $numRegistros = pg_num_rows($selAlumno);
        if($numRegistros == 0){
            header("Location: alumnos.php?err=no");
            exit();
        }else{
            $tituloPag='Edición';
            $selAlumno = pg_exec("SELECT
              id_alumno, nombre_alumno, apellidos_alumno, dni_alumno, calc_hermanos, calc_padres, calc_renta,
              calc_flia_numerosa, calc_flia_monoparental, calc_discapacidad, calc_disc_flia_33_65, calc_disc_flia_65,
              calc_media_eso_fp, calc_id_calle, calc_id_num_poli, calle.nombre_via, id_nivel_educativo, id_tipo_educativo,
              id_idioma
              FROM alumnos
              INNER JOIN viales AS calle
              ON alumnos.calc_id_calle=calle.id_vial
              WHERE id_alumno = '".$_GET['a']."'");
              $alumno = pg_fetch_row($selAlumno);
              $a_id = $alumno[0];
              $a_nombre = $alumno[1];
              $a_apellidos = $alumno[2];
              $a_dni = $alumno[3];
              $a_hermanos = $alumno[4];
              $a_padres = $alumno[5];
              $a_renta = $alumno[6];
              $a_flia_numerosa = $alumno[7];
              $a_flia_monop = $alumno[8];
              $a_discap = $alumno[9];
              $a_flia_discap_33_65 = $alumno[10];
              $a_flia_discap_65 = $alumno[11];
              $a_media = $alumno[12];
              $a_id_calle = $alumno[13];
              $a_num_poli = $alumno[14];
              $a_nom_calle = $alumno[15];
              $a_nivel = $alumno[16];
              $a_modalidad = $alumno[17];
              $a_idioma = $alumno[18];
        }
    }else{
        $tituloPag='Alta';
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <?php include("includes/inc-metas.php");?>
        <title>micole - backoffice</title>

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
            <div id="content" class="ui-content">
                <div class="ui-content-body">
                    <div class="ui-container">
                        <div class="row">
                            <div class="col-md-8">
                                <h1 class="page-title">
                                    <?=$tituloPag?> alumno
                                    <small>Cálculo de puntos de un alumno</small>
                                </h1>
                            </div>
                            <div class="col-md-4">
                                <ul class="breadcrumb pull-right">
                                    <li>Home</li>
                                    <li><a href="alumnos.php" class="active">Alumnos</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <header class="panel-heading">
                                        Detalles de la inscripción<?php if(isset($_GET['a']) && $_GET['a'] !=''){ echo " - Alumno: ".$a_nombre." ".$a_apellidos;}?>
                                        <span class="tools pull-right">
                                            <a class="collapse-box fa fa-chevron-down" href="javascript:;"></a>
                                            <a class="close-box fa fa-times" href="javascript:;"></a>
                                        </span>
                                    </header>
                                    <div class="panel-body">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <form class="form-horizontal form-variance" method="post" action="libs/actualiza-alumno.php">
                                                        <?php
                                                            if(isset($_GET['a']) && $_GET['a'] != ''){
                                                                echo "<input type='hidden' name='actualiza' value='".$_GET['a']."'>";
                                                            }
                                                        ?>
                                                        <!-- Sistema para elección de modalidades -->

                                                        <div class="form-group">
                                                            <div class="col-sm-offset-2 col-sm-8">
                                                                <?php
                                                                $selNiveles = pg_exec("SELECT * FROM niveles
                                                                                          WHERE id_estado=35
                                                                                          ORDER BY id_nivel ASC");
                                                                while($nivel = pg_fetch_row($selNiveles)){
                                                                    $n_id=$nivel[0];
                                                                    $n_nombre=$nivel[1];
                                                                    $n_img=$nivel[4];
                                                                    $curso = devuelveCurso();
                                                                    $selNivelesDisp = pg_exec("SELECT *
                                                                                          FROM usuarios_a_tipos
                                                                                          INNER JOIN tipos_educativos
                                                                                          ON usuarios_a_tipos.id_tipo_educativo = tipos_educativos.id_tipo
                                                                                          WHERE curso= ".$curso."
                                                                                          AND usuarios_a_tipos.id_usuario=".$_SESSION['user_id']."
                                                                                          AND tipos_educativos.id_estado=37
                                                                                          AND tipos_educativos.id_nivel=".$n_id);
                                                                    $numRegistros = pg_num_rows($selNivelesDisp);
                                                                    if($numRegistros == 0){
                                                                        //El nivel esta inactivo
                                                                ?>
                                                                        <div class="contNivel">
                                                                            <div class="nivel nivelNoDisp" id="nvl_<?=$n_id?>" style="background-image: url('img/niveles/<?=$n_img?>_inac.png'); cursor: no-drop;"></div>
                                                                            <div class="nomNivel"><?= $n_nombre?></div>
                                                                        </div>
                                                                <?php
                                                                    }else{
                                                                        //El nivel esta desactivado
                                                                ?>
                                                                        <div class="contNivel">
                                                                            <div class="nivel nivelDisp" id="nvl_<?=$n_id?>" style="background-image: url('img/niveles/<?=$n_img?>_des.png'); cursor: pointer;"></div>
                                                                            <div class="nomNivel"><?= $n_nombre?></div>
                                                                        </div>
                                                                <?php
                                                                    }
                                                                }
                                                            ?>
                                                            </div>
                                                        </div>
                                                        <div class="contElemsModalidad"></div>
                                                        <div class="contElemsIdioma"></div>

                                                        <input name="nivel" type="hidden">
                                                        <input name="modalidad" type="hidden">
                                                        <input name="idioma" type="hidden">

                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Nombre</label>
                                                            <div class="col-sm-6">
                                                                <input class="form-control" name="nombre" autocomplete="off" type="text" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Apellidos</label>
                                                            <div class="col-sm-6">
                                                                <input class="form-control" name="apellidos" autocomplete="off" type="text" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">DNI/NIE/Nº Pasaporte</label>
                                                            <div class="col-sm-6">
                                                                <input class="form-control" name="dni" autocomplete="off" type="text" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-4 control-label">Calle</label>
                                                            <div class="col-sm-4">
                                                                <input class="form-control" name="calle" autocomplete="off" type="text" required>
                                                                <input name="id_calle" type="hidden">
                                                                <div class="contSugerencias contSugerenciasCalles">
                                                                    <div class="elemBuscador" id="contSugerenciasCalles"></div>
                                                                </div>
                                                            </div>
                                                            <label class="col-sm-1 control-label">Núm.</label>
                                                            <div class="col-sm-1">
                                                                <input class="form-control" name="num_policia" autocomplete="off" type="text" required>
                                                                <div class="contSugerencias contSugerenciasNum">
                                                                    <div class="elemBuscador" id="contSugerenciasNum"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="form-group mapa" id="map" style="height:400px;"></div> -->
                                                        <!-- Saco los parámetros select -->
                                                        <?php
                                                            $selParametros = pg_exec("SELECT * FROM calculo_parametros
                                                                                      WHERE tipo_representacion = 40
                                                                                      ORDER BY orden_representacion ASC");
                                                            while($parametro = pg_fetch_row($selParametros)){
                                                                $p_id=$parametro[0];
                                                                $p_nombre=$parametro[1];
                                                                $p_nivel_aplica=$parametro[3];
                                                                $p_tipo=$parametro[4];
                                                                ?>
                                                                    <div class="form-group">
                                                                        <label class="control-label col-lg-4"><?=$p_nombre;?></label>
                                                                        <div class="col-lg-6">
                                                                            <?php
                                                                                if($p_tipo == 39){
                                                                                    echo "<input class='form-control' name='param_".$p_id."' autocomplete='off' type='number' min='1' max='10' value='5' step='1'>";
                                                                                }else if($p_tipo == 40){
                                                                                    echo "<select class='form-control mb-10' name='param_".$p_id."'>";
                                                                                    $selOpciones = pg_exec("SELECT * FROM calculo_opciones
                                                                                                              WHERE id_parametro = ".$p_id."
                                                                                                              ORDER BY orden ASC");
                                                                                    while($opcion = pg_fetch_row($selOpciones)){
                                                                                        $o_id = $opcion[0];
                                                                                        $o_nombre = $opcion[1];
                                                                                        echo "<option value='".$o_id."'>".$o_nombre."</option>";
                                                                                    }
                                                                                    echo "</select>";
                                                                                }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                <?php
                                                            };
                                                        ?>
                                                        <div class="contMedia"></div>
                                                        <div class="pull-right">
                                                            <button type="button" class="btn btn-primary" onclick="window.history.go(-1); return false;">
                                                                <i class="fa fa-caret-left"></i> Volver
                                                            </button>

                                                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar </button>

                                                            <?php
                                                                if(isset($_GET['a'])&& $_GET['a']!=''){
                                                            ?>
                                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target=".example-modal-sm"><i class='fa fa-trash'></i> Eliminar</button>
                                                                <div class="modal fade example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                                                                    <div class="modal-dialog modal-sm" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                                                <h4 class="modal-title" id="mySmallModalLabel">¿Eliminar alumno? </h4>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <p>Si eliminas el alumno se perderán los datos guardados.</p>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                                                <a href='libs/actualiza-alumno.php?elimina=<?=$_GET['a']?>'><button type="button" class="btn btn-danger">Eliminar</button></a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php
                                                                }
                                                            ?>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--main content end-->

            <!--footer start-->
            <?php //include("includes/inc-footer.php");?>
            <!--footer end-->
        </div>
        <?php include("includes/inc-js.php");?>
        <!-- Funciones para las botoneras de la cabecera del formulario / incluye funcionalidad del mapa-->
        <script src="js/alumno-botoneras.js"></script>

        <!-- Funciones para el autocomplete de calles -->
        <script src="js/alumno-autocompletes.js"></script>
        <!-- Scripts especificos para este fichero -->
        <script type="text/javascript">
            <?php
            if(isset($_GET['a']) && $_GET['a']!=''){
            ?>
                //Completo los valores por defecto
                $("input[name='nombre']").val("<?= trim($a_nombre);?>");
                $("input[name='apellidos']").val("<?= trim($a_apellidos);?>");
                $("input[name='dni']").val("<?= trim($a_dni);?>");
                $("select[name='param_2']").val("<?= trim($a_hermanos);?>");
                $("select[name='param_3']").val("<?= trim($a_padres);?>");
                $("select[name='param_4']").val("<?= trim($a_renta);?>");
                $("select[name='param_5']").val("<?= trim($a_flia_numerosa);?>");
                $("select[name='param_6']").val("<?= trim($a_flia_monop);?>");
                $("select[name='param_7']").val("<?= trim($a_discap);?>");
                $("select[name='param_8']").val("<?= trim($a_flia_discap_33_65);?>");
                $("select[name='param_9']").val("<?= trim($a_flia_discap_65);?>");
                $("input[name='id_calle']").val("<?= trim($a_id_calle);?>");
                $("input[name='num_policia']").val("<?= trim($a_num_poli);?>");
                $("input[name='calle']").val("<?= trim($a_nom_calle);?>");
                $("input[name='nivel']").val("<?= trim($a_nivel);?>");
                $("input[name='modalidad']").val("<?= trim($a_modalidad);?>");
                $("input[name='idioma']").val("<?= trim($a_idioma);?>");
                $(document).ready(function(){
                    $("#nvl_<?=$a_nivel?>").trigger("click");
                    sleep(500).then(() => {
                      $("#mod_<?=$a_modalidad?>").trigger("click");
                      sleep(500).then(() => {
                        $("#lng_<?=$a_idioma?>").trigger("click");
                        $("input[name='param_10']").val("<?= trim($a_media);?>");
                      });
                    });

                });
            <?php
            }
            if(isset($_GET['err']) && $_GET['err']!=''){
                switch($_GET['err']){
                    case 'ins':
                        echo "
                            var titulo = 'Alumno insertado';
                            var msj = 'Los datos del alumno se han insertado correctamente.';
                            var tipo = 'success';
                        ";
                        break;
                    case 'act':
                        echo "
                            var titulo = 'Alumno actualizado';
                            var msj = 'Los datos del alumno se han actualizado correctamente.';
                            var tipo = 'success';
                        ";
                        break;
                    case 'elim':
                        echo "
                            var titulo = 'Alumno eliminado';
                            var msj = 'Los datos del alumno se han eliminado correctamente.';
                            var tipo = 'error';
                        ";
                        break;
                    case 'no':
                        echo "
                            var titulo = 'Sin permisos';
                            var msj = 'No estás autorizado para acceder a los datos de ese alumno.';
                            var tipo = 'error';
                        ";
                        break;
                    case 'bach':
                        echo "
                            var titulo = 'Error';
                            var msj = 'No se ha introducido una nota de ESO o FP.';
                            var tipo = 'error';
                        ";
                        break;
                    case 'dir':
                        echo "
                            var titulo = 'Error';
                            var msj = 'No se ha podido encontrar la direccion introducida.';
                            var tipo = 'error';
                        ";
                        break;
                    case 'datos':
                        echo "
                            var titulo = 'Error';
                            var msj = 'Hay datos sin completar.';
                            var tipo = 'error';
                        ";
                        break;
                    case 'mod':
                        echo "
                            var titulo = 'Error';
                            var msj = 'No se ha seleccionado una modalidad correcta';
                            var tipo = 'error';
                        ";
                        break;
                }
            ?>
                toastr[tipo](msj, titulo);
            <?php
            }
            ?>
        </script>
    </body>
</html>
