<?php 
    include("php/seguridad.php");
    include("php/config.php");
    include("php/funciones.php");
    $pag = 'plazas';
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
                                <h1 class="page-title"> Plazas
                                    <small>Configuración de oferta de plazas</small>
                                </h1>
                            </div>
                            <div class="col-md-4">
                                <ul class="breadcrumb pull-right">
                                    <li>Home</li>
                                    <li><a href="plazas.php" class="active">Plazas</a></li>
                                </ul>
                            </div>
                        </div>
                        <!--page title and breadcrumb end -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <header class="panel-heading panel-border">
                                        Plazas Ofertadas
                                        <span class="tools pull-right">
                                            <a class="close-box fa fa-times" href="javascript:;"></a>
                                        </span>
                                    </header>
                                    <div class="panel-body">
                                        <div class="col-md-12">
                                            <ul class="nav nav-tabs">
                                                <?php
                                                    $selNiveles= pg_exec("SELECT * FROM niveles ORDER BY id_nivel ASC");
                                                    $contador = 0;
                                                    while($nivel = pg_fetch_row($selNiveles)){
                                                        $n_nombre = $nivel[1];
                                                        $pintaActivo="";
                                                        if($contador == 0){
                                                            $pintaActivo = "active";
                                                        }
                                                        echo "<li class='".$pintaActivo."'><a href='#tab".$contador."' data-toggle='tab' aria-expanded='true'>".$n_nombre."</a></li>";
                                                        $contador++;
                                                    }
                                                ?>
                                            </ul>
                                            <form class="form-horizontal form-variance" method="post" action="libs/actualiza-modalidades-usuario.php">
                                                <div class="tab-content panel wrapper">
                                                    <?php
                                                        $selNiveles= pg_exec("SELECT * FROM niveles ORDER BY id_nivel ASC");
                                                        $contador = 0;
                                                        while($nivel = pg_fetch_row($selNiveles)){
                                                            $agregaClases = "";
                                                            if($contador == 0){
                                                                $agregaClases = " active in";
                                                            }
                                                    ?>
                                                    <div id="tab<?=$contador?>" class="tab-pane fade<?=$agregaClases?>">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <!-- Selecciono las modalidades de este nivel -->
                                                                <?php
                                                                    $selModalidades = pg_exec("SELECT te.id_tipo,
                                                                                                te.nombre,
                                                                                                te.id_nivel,
                                                                                                niveles.nombre,
                                                                                                idiomas.nombre,
                                                                                                te.id_idioma
                                                                                               FROM tipos_educativos AS te
                                                                                               INNER JOIN niveles
                                                                                               ON te.id_nivel = niveles.id_nivel
                                                                                               INNER JOIN idiomas
                                                                                               ON te.id_idioma=idiomas.id_idioma
                                                                                               WHERE te.id_nivel = ".$nivel[0]."
                                                                                               ORDER BY te.id_tipo ASC");
                                                                    while($modalidad = pg_fetch_row($selModalidades)){
                                                                        $m_id_tipo =$modalidad[0]; 
                                                                        $m_nombre = $modalidad[1];
                                                                        $m_id_nivel = $modalidad[2];
                                                                        $m_nombre_nivel = $modalidad[3];
                                                                        $m_idioma = $modalidad[4];
                                                                        $m_id_idioma = $modalidad[5];
                                                                        ?>
                                                                        <div class='form-group'>
                                                                            <label class='col-sm-5 control-label col-lg-5'><?= $m_nombre. " en ". $m_idioma?> </label>
                                                                            <div class='col-lg-5'>
                                                                                <div class="input-group mb-10">
                                                                                    <span class="input-group-addon">
                                                                                        <input type="checkbox" name="chbx_mod[]" value="<?=$m_id_tipo."_".$m_id_idioma?>">
                                                                                    </span>
                                                                                    <input class="form-control" name="plz_<?=$m_id_tipo."_".$m_id_idioma?>" type="number" min="1" step="1">
                                                                                    <span class='input-group-addon btn-default'>Plazas ofertadas</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                    }        
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                            $contador++;
                                                        }
                                                    ?>
                                                </div>
                                                <div class="pull-right">
                                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Guardar </button>
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
            <!--main content end-->

            <!--footer start-->
            <?php include("includes/inc-footer.php");?>
            <!--footer end-->
        </div>
        <?php include("includes/inc-js.php");?>
        <script type="text/javascript">
            <?php
            if(isset($_GET['m']) && $_GET['m']=='act'){
            ?>
                toastr['success']('Los valores se han actualizado correctamente.', 'Valores actualizados');
            <?php   
            }
            ?>
            
            //AJAX par rellenar automaticamente los valores en los campos
            $(document).ready(function(){
                $.ajax({
                    url: "ajax/carga-plazas.php",
                    type: 'POST',
                    data: {
                        "carga"  : "plazas"
                    },
                    cache: false,
                    success: function(response) {
                        var jsonData = JSON.parse(response);
                        for(var i=0; i<jsonData.length; i++){
                            var tipo_educativo = jsonData[i]['id_tipo'];
                            var plazas = jsonData[i]['plazas'];
                            var idioma = jsonData[i]['id_idioma'];
                            $("input[name='plz_"+tipo_educativo+"_"+idioma+"']").val(plazas);
                            $("input[name='chbx_mod[]'][value='"+tipo_educativo+"_"+idioma+"']").prop('checked', true);
                        }
                    }
                });
            });
        </script>
    </body>
</html>