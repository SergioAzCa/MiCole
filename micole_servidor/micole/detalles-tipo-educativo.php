<?php 
    include("php/seguridad-admin.php");
    include("php/config.php");
    include("php/funciones.php");
    $subPag ='configadmin';
    $pag = 'tipos';
    if(isset($_GET['t']) && $_GET['t'] != ''){
        $txtPeq = "Edición de la información de una modalidad educativa.";
        $vble = $_GET['t'];
        $selTipo = pg_exec("SELECT te.id_tipo
                            ,te.nombre
                            ,te.descripcion
                            ,niveles.nombre
                            ,te.id_estado
                            ,niveles.id_nivel
                            ,te.id_idioma
                            FROM tipos_educativos AS te
                            INNER JOIN niveles 
                            ON te.id_nivel = niveles.id_nivel
                            WHERE te.id_tipo = '".$_GET['t']."'");
        $numRegistros = pg_num_rows($selTipo);
        if($numRegistros == 0){
            header("Location: tipos_educativos.php?t=no");
            exit();
        }else{
            $tipo = pg_fetch_row($selTipo);
            $t_id = $tipo[0];
            $t_nombre = $tipo[1];
            $t_desc = $tipo[2];
            $t_nivel = $tipo[3];
            $t_estado = $tipo[4];
            $t_id_nivel = $tipo[5];
            $t_idioma = $tipo[6];
        }
    }else{
        $txtPeq = "Inserción de una nueva modalidad.";
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
                                <h1 class="page-title"> Tipos educativos
                                    <small><?= $txtPeq;?></small>
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <header class="panel-heading panel-border">
                                        Tipos educativos
                                        <span class="tools pull-right">
                                            <a class="close-box fa fa-times" href="javascript:;"></a>
                                        </span>
                                    </header>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form class="form-horizontal form-variance" method="post" action="libs/actualiza-tipos-nivel.php">
                                                    <input name="modalidad" type="hidden" value='<?= $vble;?>'>
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
                                                        <label class="col-sm-3 control-label col-lg-3">Nivel asociado</label>
                                                        <div class="col-lg-6">
                                                            <select class="form-control mb-10" name="tipo_nivel">
                                                                <?php
                                                                    $selNiveles = pg_exec("SELECT id_nivel, nombre 
                                                                                           FROM niveles
                                                                                           WHERE id_estado = '35'
                                                                                           ORDER BY id_nivel ASC");
                                                                    while($nivel = pg_fetch_row($selNiveles)){
                                                                        echo "<option value='".$nivel[0]."'>".$nivel[1]."</option>";
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label col-lg-3">Idioma</label>
                                                        <div class="col-lg-6">
                                                            <select class="form-control mb-10" name="idioma">
                                                                <?php
                                                                    $selIdiomas = pg_exec("SELECT id_idioma, nombre 
                                                                                           FROM idiomas
                                                                                           WHERE activo = 'T'
                                                                                           ORDER BY id_idioma ASC");
                                                                    while($idioma = pg_fetch_row($selIdiomas)){
                                                                        echo "<option value='".$idioma[0]."'>".$idioma[1]."</option>";
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label col-lg-3">Estado</label>
                                                        <div class="col-lg-6">
                                                            <select class="form-control mb-10" name="estado">
                                                                <?php
                                                                    $selEstados = pg_exec("SELECT id_elemento, nombre 
                                                                                           FROM elementos
                                                                                           WHERE tipo_elemento = 'estado_tipo_modalidad'
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
                                                                        <h4 class="modal-title" id="mySmallModalLabel">¿Eliminar modalidad? </h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Si eliminas la modalidad, desaparecerá todo su contenido.</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                                        <a href='libs/actualiza-tipos-nivel.php?elimina=modalidad&valor=<?=$_GET['t']?>'><button type="button" class="btn btn-danger">Eliminar</button></a>
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
            if(isset($_GET['t']) && $_GET['t']!=''){
            ?>
                //Completo los valores por defecto
                $("input[name='nombre']").val("<?= trim($t_nombre);?>");
                $("input[name='descripcion']").val("<?= trim($t_desc);?>");
                $("select[name='tipo_nivel']").val("<?= trim($t_id_nivel);?>");
                $("select[name='idioma']").val("<?= trim($t_idioma);?>");
                $("select[name='estado']").val("<?= trim($t_estado);?>");
            <?php   
            }
            ?>
        </script>
    </body>
</html>