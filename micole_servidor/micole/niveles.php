<?php
    include("php/seguridad-admin.php");
    include("php/config.php");
    include("php/funciones.php");
    $subPag ='configadmin';
    $pag = 'niveles';
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
                                <h1 class="page-title"> Niveles
                                    <small>listado de niveles</small>
                                </h1>
                            </div>
                            <div class="col-md-4">
                                <ul class="breadcrumb pull-right">
                                    <li>Home</li>
                                    <li><a href="niveles.php" class="active">Niveles</a></li>
                                </ul>
                            </div>
                        </div>
                        <!--page title and breadcrumb end -->

                            <div class="col-md-12">
                                <div class="panel">
                                    <header class="panel-heading panel-border">
                                        Lista de niveles
                                        <span class="tools pull-right">
                                            <a class="close-box fa fa-times" href="javascript:;"></a>
                                        </span>
                                    </header>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table  table-hover general-table">
                                                <?php
                                                    $selNiveles = pg_exec("SELECT id_nivel, nombre, id_estado, descripcion
                                                                           FROM niveles
                                                                           WHERE id_estado != 6
                                                                           ORDER BY id_nivel ASC");
                                                    $numResultados = pg_numrows($selNiveles);
                                                    if($numResultados == 0){
                                                        echo "No se han encontrado niveles en la base de datos.";
                                                    }else{
                                                        echo "
                                                            <thead>
                                                                <tr>
                                                                    <th>Id. Nivel</th>
                                                                    <th>Nombre</th>
                                                                    <th>Descripción</th>
                                                                    <th>Estado</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                        ";

                                                        while($nivel = pg_fetch_row($selNiveles)){
                                                            $n_id = $nivel[0];
                                                            $n_nombre = $nivel[1];
                                                            $n_estado = $nivel[2];
                                                            $n_desc = $nivel[3];
                                                            $n_txtEstado = nombreElemento($n_estado);

                                                            switch($n_estado){
                                                                case '35':
                                                                    $n_claseNivel='label-recibido';
                                                                    break;
                                                                case '36':
                                                                    $n_claseNivel='label-reembolsado';
                                                                    break;
                                                            }
                                                            echo "
                                                                <tr>
                                                                    <td>Nº ".$n_id."</td>
                                                                    <td>".$n_nombre."</td>
                                                                    <td>".$n_desc."</td>
                                                                    <td><span class='label label-info ".$n_claseNivel."'>".$n_txtEstado."</span></td>
                                                                </tr>
                                                            ";
                                                        }
                                                        echo "</tbody>";
                                                    }
                                                ?>
                                            </table>
                                        </div>
                                        <div class="pull-right">
                                            <!-- <a href="detalles-nivel.php">
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
