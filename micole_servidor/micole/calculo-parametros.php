<?php 
    include("php/seguridad-admin.php");
    include("php/config.php");
    include("php/funciones.php");
    $subPag ='configadmin';
    $pag = 'parametros';
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
                                <h1 class="page-title"> Parámetros
                                    <small>listado de parámetros que afectan al cálculo de puntos</small>
                                </h1>
                            </div>
                            <div class="col-md-4">
                                <ul class="breadcrumb pull-right">
                                    <li>Home</li>
                                    <li><a href="calculo-parametros.php" class="active">Parámetros</a></li>
                                </ul>
                            </div>
                        </div>
                        <!--page title and breadcrumb end -->

                            <div class="col-md-12">
                                <div class="panel">
                                    <header class="panel-heading panel-border">
                                        Lista de parámetros
                                        <span class="tools pull-right">
                                            <a class="close-box fa fa-times" href="javascript:;"></a>
                                        </span>
                                    </header>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table  table-hover general-table">
                                                <?php
                                                    $selParametros = pg_exec("SELECT id_parametro
                                                                            , nombre
                                                                            , descripcion
                                                                            , nivel_aplica 
                                                                            , tipo_representacion
                                                                           FROM calculo_parametros
                                                                           ORDER BY orden_representacion ASC");
                                                    $numResultados = pg_numrows($selParametros);
                                                    if($numResultados == 0){
                                                        echo "No se han encontrado parámetros en la base de datos.";
                                                    }else{
                                                        echo "
                                                            <thead>
                                                                <tr>
                                                                    <th>Nombre</th>
                                                                    <th>Descripción</th>
                                                                    <th>Nivel</th>
                                                                    <th>Representacion</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                        ";

                                                        while($parametro = pg_fetch_row($selParametros)){
                                                            $p_id = $parametro[0];
                                                            $p_nombre = $parametro[1];
                                                            $p_desc = $parametro[2];
                                                            $p_nivel = $parametro[3];
                                                            $p_representacion = $parametro[4];
                                                            $p_txtRepresentacion = nombreElemento($p_representacion);

                                                            if($p_nivel == '0'){
                                                                $p_txtNivel='Todos';
                                                            }else{
                                                                $selNivel = pg_exec("SELECT nombre
                                                                           FROM niveles
                                                                           WHERE id_nivel='".$p_nivel."'");
                                                                $nivel = pg_fetch_row($selNivel);
                                                                $p_txtNivel=$nivel[0];
                                                            }
                                                            
                                                            echo "
                                                                <tr>
                                                                    <td>".$p_nombre."</td>
                                                                    <td>".$p_desc."</td>
                                                                    <td>".$p_txtNivel."</td>
                                                                    <td>".$p_txtRepresentacion."</td>
                                                                </tr>
                                                            ";
                                                        }
                                                        echo "</tbody>";
                                                    }
                                                ?>
                                            </table>
                                        </div>
                                        <div class="pull-right">
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
            <!--footer start-->
            <?php //include("includes/inc-footer.php");?>
            <!--footer end-->
        </div>
        <?php include("includes/inc-js.php");?>
        <script type="text/javascript">
            <?php
            if(isset($_GET['n']) && $_GET['n']=='act'){
            ?>
                toastr['success']('El nivel se ha actualizado correctamente.', 'Nivel actualizado');
            <?php   
            }if(isset($_GET['n']) && $_GET['n']=='ins'){
            ?>
                toastr['success']('El nivel se ha insertado correctamente.', 'Nivel insertado');
            <?php   
            }if(isset($_GET['n']) && $_GET['n']=='no'){
            ?>
             toastr['error']('No existe ese identificador de nivel en nuestra base de datos.', 'Nivel inexistente');
            <?php   
            }if(isset($_GET['n']) && $_GET['n']=='elim'){
            ?>
             toastr['error']('Nivel eliminado de nuestra base de datos.', 'Nivel eliminado');
            <?php   
            }
            ?>
        </script>
    </body>
</html>