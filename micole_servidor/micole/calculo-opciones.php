<?php 
    include("php/seguridad-admin.php");
    include("php/config.php");
    include("php/funciones.php");
    $subPag ='configadmin';
    $pag = 'opciones';
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
                                <h1 class="page-title"> Opciones
                                    <small>listado de opciones que afectan al cálculo de puntos</small>
                                </h1>
                            </div>
                            <div class="col-md-4">
                                <ul class="breadcrumb pull-right">
                                    <li>Home</li>
                                    <li><a href="calculo-opciones.php" class="active">Opciones</a></li>
                                </ul>
                            </div>
                        </div>
                        <!--page title and breadcrumb end -->

                            <div class="col-md-12">
                                <div class="panel">
                                    <header class="panel-heading panel-border">
                                        Lista de opciones
                                        <span class="tools pull-right">
                                            <a class="close-box fa fa-times" href="javascript:;"></a>
                                        </span>
                                    </header>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table  table-hover general-table">
                                                <?php
                                                    $selOpciones = pg_exec("SELECT 
                                                                            calculo_opciones.id_opcion
                                                                            ,calculo_opciones.nombre
                                                                            ,calculo_opciones.descripcion
                                                                            ,calculo_parametros.nombre
                                                                            ,calculo_opciones.puntos
                                                                            FROM calculo_opciones
                                                                            INNER JOIN calculo_parametros
                                                                            ON calculo_opciones.id_parametro = calculo_parametros.id_parametro
                                                                            ORDER BY calculo_parametros.id_parametro, calculo_opciones.orden");
                                                    $numResultados = pg_numrows($selOpciones);
                                                    if($numResultados == 0){
                                                        echo "No se han encontrado opciones en la base de datos.";
                                                    }else{
                                                        echo "
                                                            <thead>
                                                                <tr>
                                                                    <th>Nombre</th>
                                                                    <th>Descripción</th>
                                                                    <th>Parámetro</th>
                                                                    <th>Ptos.</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                        ";

                                                        while($opcion = pg_fetch_row($selOpciones)){
                                                            $o_nombre = $opcion[1];
                                                            $o_desc = $opcion[2];
                                                            $o_parametro = $opcion[3];
                                                            $o_puntos = $opcion[4];
                                                            
                                                            echo "
                                                                <tr>
                                                                    <td>".$o_nombre."</td>
                                                                    <td>".$o_desc."</td>
                                                                    <td>".$o_parametro."</td>
                                                                    <td>".$o_puntos."</td>
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
    </body>
</html>