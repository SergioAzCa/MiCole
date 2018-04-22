<?php 
    include("php/seguridad-admin.php");
    include("php/config.php");
    include("php/funciones.php");
    $subPag ='configadmin';
    $pag = 'niveles';
    if(isset($_GET['n']) && $_GET['n'] != ''){
        $txtPeq = "Edición de la información de un nivel.";
        $vble = $_GET['n'];
        $selNivel = pg_exec("SELECT * FROM niveles WHERE id_nivel = '".$_GET['n']."'");
        $numRegistros = pg_num_rows($selNivel);
        if($numRegistros == 0){
            header("Location: niveles.php?n=no");
            exit();
        }else{
            $nivel = pg_fetch_row($selNivel);
            $n_id = $nivel[0];
            $n_nombre = $nivel[1];
            $n_estado = $nivel[2];
            $n_desc = $nivel[3];
        }
    }else{
        $txtPeq = "Inserción de un nuevo nivel.";
        $vble = 'inserta';
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
                        <!--page title and breadcrumb start -->
                        <div class="row">
                            <div class="col-md-8">
                                <h1 class="page-title"> Niveles
                                    <small><?= $txtPeq;?></small>
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <header class="panel-heading panel-border">
                                        Niveles
                                        <span class="tools pull-right">
                                            <a class="close-box fa fa-times" href="javascript:;"></a>
                                        </span>
                                    </header>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form class="form-horizontal form-variance" method="post" action="libs/actualiza-tipos-nivel.php">
                                                    <input name="nivel" type="hidden" value='<?= $vble;?>'>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Nombre</label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" name="nombre" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Descripción</label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" name="descripcion" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label col-lg-3">Estado</label>
                                                        <div class="col-lg-6">
                                                            <select class="form-control mb-10" name="estado">
                                                                <?php
                                                                    $selEstados = pg_exec("SELECT id_elemento, nombre 
                                                                                           FROM elementos
                                                                                           WHERE tipo_elemento = 'estado_nivel_tipo'
                                                                                           ORDER BY id_elemento ASC");
                                                                    while($estado = pg_fetch_row($selEstados)){
                                                                        echo "<option value='".$estado[0]."'>".$estado[1]."</option>";
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="pull-right">
                                                        <button type="submit" class="btn btn-success">
                                                            <i class="fa fa-save"></i> Guardar
                                                        </button>
                                                        
                                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target=".example-modal-sm"><i class='fa fa-trash'></i> Eliminar</button>

                                                        <div class="modal fade example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                                                            <div class="modal-dialog modal-sm" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                                        <h4 class="modal-title" id="mySmallModalLabel">¿Eliminar nivel? </h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Si eliminas el nivel, desaparecerán los tipos educativos asociados.</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                                        <a href='libs/actualiza-tipos-nivel.php?elimina=nivel&valor=<?=$_GET['n']?>'><button type="button" class="btn btn-danger">Eliminar</button></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
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
            if(isset($_GET['n']) && $_GET['n']!=''){
            ?>
                //Completo los valores por defecto
                $("input[name='nombre']").val("<?= trim($n_nombre);?>");
                $("input[name='descripcion']").val("<?= trim($n_desc);?>");
                $("select[name='estado']").val("<?= trim($n_estado);?>");
            <?php   
            }
            ?>
        </script>
    </body>
</html>