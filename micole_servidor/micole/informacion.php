<?php
    include("php/seguridad.php");
    include("php/config.php");
    include("php/funciones.php");
    $pag = "info";
    //Coge datos del centro
    $selCentro = pg_exec("SELECT us.nombre, us.apellidos, viales.nombre_via, us.num_policia, us.foto
        FROM usuarios AS us
        INNER JOIN viales
        ON us.id_vial = viales.id_vial
        WHERE id = '".$_SESSION['user_id']."'");
    $centro = pg_fetch_row($selCentro);
    $c_nombre = $centro[0]." ".$centro[1];
    $c_calle = $centro[2];
    $c_num = $centro[3];
    $c_img = $centro[4];
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
                                <h1 class="page-title"> Información
                                    <small>Información de la cuenta.</small>
                                </h1>
                            </div>
                            <div class="col-md-4">
                                <ul class="breadcrumb pull-right">
                                    <li>Home</li>
                                    <li><a href="informacion.php" class="active">Información</a></li>
                                </ul>
                            </div>
                        </div>
                        <!--page title and breadcrumb end -->

                        <div class="row">

                            <div class="col-md-12">
                                <div class="panel">
                                    <header class="panel-heading panel-border">
                                        Datos del centro
                                        <span class="tools pull-right">
                                            <a class="close-box fa fa-times" href="javascript:;"></a>
                                        </span>
                                    </header>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form class="form-horizontal form-variance" method="post" action="#">
                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label">Nombre del centro</label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" name="nombre" type="text" value="<?=$c_nombre?>" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label">Imagen de perfil</label>
                                                        <div class="col-sm-6">
                                                            <img src="./img/perfil/<?=$c_img?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label">Calle</label>
                                                        <div class="col-sm-4">
                                                            <input class="form-control" name="calle" type="text"  value="<?=$c_calle?>"disabled>
                                                        </div>
                                                        <label class="col-sm-1 control-label">Núm.</label>
                                                        <div class="col-sm-1">
                                                            <input class="form-control" name="num_policia" type="text"  value="<?=$c_num?>"disabled>
                                                        </div>
                                                    </div>
                                                    <div id="map" style="width: 100%; height: 400px;"></div>
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            Si desea modificar cualquier información, póngase en contacto con el administrador.
                                                        </div>
                                                    </div>
                                                    <div class="pull-right">
                                                        <button type="button" class="btn btn-primary" onclick="window.history.go(-1); return false;">
                                                            <i class="fa fa-caret-left"></i> Volver
                                                        </button>
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
            <!--main content end-->

            <!--footer start-->
            <?php include("includes/inc-footer.php");?>
            <!--footer end-->
        </div>
        <?php include("includes/inc-js.php");?>
        <script type="text/javascript">
            <?php
            if(isset($_GET['file']) && $_GET['file']=='ok'){
            ?>
                toastr['success']('El fichero se ha generado correctamente.', 'Fichero generado');
            <?php
            }
            ?>
        </script>
        <?php include("includes/inc-js-mapas-informacion.php");?>
        </script>
    </body>
</html>
