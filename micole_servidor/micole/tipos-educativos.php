<?php
    include("php/seguridad-admin.php");
    include("php/config.php");
    include("php/funciones.php");
    $subPag ='configadmin';
    $pag = 'tipos';
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

                        <!--page title and breadcrumb start -->
                        <div class="row">
                            <div class="col-md-8">
                                <h1 class="page-title"> Tipos educativos
                                    <small>listado de modalidades educativas</small>
                                </h1>
                            </div>
                            <div class="col-md-4">
                                <ul class="breadcrumb pull-right">
                                    <li>Home</li>
                                    <li><a href="tipos-educativos.php" class="active">Tipos educativos</a></li>
                                </ul>
                            </div>
                        </div>
                        <!--page title and breadcrumb end -->

                            <div class="col-md-12">
                                <div class="panel">
                                    <header class="panel-heading panel-border">
                                        Lista de tipos educativos
                                        <span class="tools pull-right">
                                            <a class="close-box fa fa-times" href="javascript:;"></a>
                                        </span>
                                    </header>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table  table-hover general-table">
                                                <?php
                                                    $selTipos = pg_exec("SELECT tipos_educativos.id_tipo
                                                                            ,tipos_educativos.nombre
                                                                            ,tipos_educativos.descripcion
                                                                            ,tipos_educativos.id_estado
                                                                            ,niveles.nombre
                                                                            ,idiomas.nombre
                                                                           FROM tipos_educativos
                                                                           INNER JOIN niveles
                                                                           ON tipos_educativos.id_nivel = niveles.id_nivel
                                                                           INNER JOIN idiomas
                                                                           ON tipos_educativos.id_idioma = idiomas.id_idioma
                                                                           WHERE tipos_educativos.id_estado != 6
                                                                           ORDER BY tipos_educativos.id_tipo ASC");
                                                    $numResultados = pg_numrows($selTipos);
                                                    if($numResultados == 0){
                                                        echo "No se han encontrado modalidades educativas en la base de datos.";
                                                    }else{
                                                        echo "
                                                            <thead>
                                                                <tr>
                                                                    <th>Nombre</th>
                                                                    <th>Descripción</th>
                                                                    <th>Nivel educativo</th>
                                                                    <th>Idioma</th>
                                                                    <th>Estado</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                        ";

                                                        while($tipo = pg_fetch_row($selTipos)){
                                                            $t_id = $tipo[0];
                                                            $t_nombre = $tipo[1];
                                                            $t_desc = $tipo[2];
                                                            $t_estado = $tipo[3];
                                                            $t_nivel = $tipo[4];
                                                            $t_idioma = $tipo[5];
                                                            $t_txtEstado = nombreElemento($t_estado);

                                                            switch($t_estado){
                                                                case '37':
                                                                    $t_claseTipo='label-recibido';
                                                                    break;
                                                                case '38':
                                                                    $t_claseTipo='label-reembolsado';
                                                                    break;
                                                            }
                                                            echo "
                                                                <tr>
                                                                    <td>".$t_nombre."</td>
                                                                    <td>".$t_desc."</td>
                                                                    <td>".$t_nivel."</td>
                                                                    <td>".$t_idioma."</td>
                                                                    <td><span class='label label-info ".$t_claseTipo."'>".$t_txtEstado."</span></td>
                                                                </tr>
                                                            ";
                                                        }
                                                        echo "</tbody>";
                                                    }
                                                ?>
                                            </table>
                                        </div>
                                        <div class="pull-right">
                                            <!-- <a href="detalles-tipo-educativo.php">
                                                <button type="button" class="btn btn-success">
                                                    <i class="fa fa-plus"></i> Insertar nuevo
                                                </button>
                                            </a> -->
                                            <button type="button" class="btn btn-primary" onclick="window.history.go(-1); return false;">
                                                <i class="fa fa-caret-left"></i> Volver
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--main content end-->
        </div>
        <?php include("includes/inc-js.php");?>
        <script type="text/javascript">
            <?php
            if(isset($_GET['t']) && $_GET['t']=='act'){
            ?>
                toastr['success']('La modalidad se ha actualizado correctamente.', 'Modalidad actualizada');
            <?php
            }if(isset($_GET['t']) && $_GET['t']=='ins'){
            ?>
                toastr['success']('La modalidad se ha insertado correctamente.', 'Modalidad insertada');
            <?php
            }if(isset($_GET['t']) && $_GET['t']=='no'){
            ?>
             toastr['error']('No existe ese identificador de modalidad en nuestra base de datos.', 'Modalidad inexistente');
            <?php
            }if(isset($_GET['t']) && $_GET['t']=='elim'){
            ?>
             toastr['error']('Modalidad eliminada de nuestra base de datos.', 'Modalidad eliminada');
            <?php
            }
            ?>
        </script>
    </body>
</html>
