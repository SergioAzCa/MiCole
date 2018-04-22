<?php
    include("php/seguridad.php");
    include("php/config.php");
    include("php/funciones.php");
    $pag = 'listado';

    $curso = devuelveCurso();
    //Para agregar condicionales al buscador
    $agregaCond = '';
    if(isset($_POST['nombre']) && $_POST['nombre']!=''){
        $nombre_cons = strtoupper($_POST['nombre']);
        $agregaCond .= " AND UPPER(al.nombre_alumno) LIKE '%".trim($nombre_cons)."%'";
    }
    if(isset($_POST['apellidos']) && $_POST['apellidos']!=''){
        $apellidos_cons = strtoupper($_POST['apellidos']);
        $agregaCond .= " AND UPPER(al.apellidos_alumno) LIKE '%".trim($apellidos_cons)."%'";
    }
    if(isset($_POST['dni']) && $_POST['dni']!=''){
        $dni_cons = strtoupper($_POST['dni']);
        $agregaCond .= " AND UPPER(al.dni_alumno) LIKE '%".trim($dni_cons)."%'";
    }
    if(isset($_POST['nivel']) && $_POST['nivel']!=''){
        $nivel_cons = $_POST['nivel'];
        $agregaCond .= " AND al.id_nivel_educativo=".$nivel_cons;
    }
   if(isset($_POST['modalidad']) && $_POST['modalidad']!=''){
        $modalidad_cons = $_POST['modalidad'];
        $agregaCond .= " AND al.id_tipo_educativo=".$modalidad_cons;
    }
    if(isset($_POST['idioma']) && $_POST['idioma']!=''){
        $idioma_cons = $_POST['idioma'];
        $agregaCond .= " AND al.id_idioma=".$idioma_cons;
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
                                <h1 class="page-title"> Listado alumnos
                                    <small>listado y filtro de alumnos almacenados</small>
                                </h1>
                            </div>
                            <div class="col-md-4">
                                <ul class="breadcrumb pull-right">
                                    <li>Home</li>
                                    <li><a href="listado-alumnos.php" class="active">Listado alumnos</a></li>
                                </ul>
                            </div>
                        </div>
                        <!--page title and breadcrumb end -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <form class="row order-srch-form" role="form" method="post" action="#">
                                                    <div class="form-group col-md-2">
                                                        <label class="sr-only">Nombre</label>
                                                        <input class="form-control" placeholder="Nombre" name="nombre" type="text" autocomplete="off">
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label class="sr-only">Apellidos</label>
                                                        <input class="form-control" placeholder="Apellidos" name="apellidos" type="text" autocomplete="off">
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label class="sr-only">DNI</label>
                                                        <input class="form-control" placeholder="DNI" name="dni" type="text" autocomplete="off">
                                                    </div>
                                                    <div class="form-group col-md-1">
                                                        <label class="sr-only">Niveles</label>
                                                        <select class="form-control" name="nivel">
                                                            <option selected="selected" disabled="disabled">Nivel</option>
                                                            <?php
                                                                $selNiveles = pg_exec("SELECT DISTINCT te.id_nivel,nv.nombre
                                                                                       FROM tipos_educativos AS te
                                                                                       INNER JOIN usuarios_a_tipos
                                                                                       ON te.id_tipo = usuarios_a_tipos.id_tipo_educativo
                                                                                       INNER JOIN niveles AS nv
                                                                                       ON nv.id_nivel = te.id_nivel
                                                                                       WHERE usuarios_a_tipos.id_usuario = ".$_SESSION['user_id']."
                                                                                       ORDER BY te.id_nivel ASC");
                                                                while($nivel = pg_fetch_row($selNiveles)){
                                                                    $n_id = $nivel[0];
                                                                    $n_nombre = $nivel[1];
                                                                    echo "<option value='".$n_id."'>".$n_nombre."</option>";
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label class="sr-only">Modalidades</label>
                                                        <select class="form-control" name="modalidad">
                                                            <option selected="selected" disabled="disabled">Modalidad</option>
                                                            <?php
                                                                $selModalidades = pg_exec("SELECT DISTINCT te.id_tipo,te.descripcion
                                                                                        FROM tipos_educativos AS te
                                                                                        INNER JOIN usuarios_a_tipos
                                                                                        ON te.id_tipo = usuarios_a_tipos.id_tipo_educativo
                                                                                        WHERE usuarios_a_tipos.id_usuario = ".$_SESSION['user_id']);
                                                                while($modalidad = pg_fetch_row($selModalidades)){
                                                                    $m_id = $modalidad[0];
                                                                    $m_nombre = $modalidad[1];
                                                                    echo "<option value='".$m_id."'>".$m_nombre."</option>";
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label class="sr-only">Idioma</label>
                                                        <select class="form-control" name="idioma">
                                                            <option selected="selected" disabled="disabled">Idioma</option>
                                                            <?php
                                                                $selIdiomas = pg_exec("SELECT DISTINCT ut.id_idioma, idi.nombre
                                                                                    FROM usuarios_a_tipos AS ut
                                                                                    INNER JOIN idiomas AS idi
                                                                                    ON ut.id_idioma = idi.id_idioma
                                                                                    WHERE idi.activo='T' AND
                                                                                    ut.id_usuario =".$_SESSION['user_id']);
                                                                while($idioma = pg_fetch_row($selIdiomas)){
                                                                    $i_id = $idioma[0];
                                                                    $i_nombre = $idioma[1];
                                                                    echo "<option value='".$i_id."'>".$i_nombre."</option>";
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span></button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="panel">
                                    <header class="panel-heading panel-border">
                                        Lista de alumnos
                                        <span class="tools pull-right">
                                            <a class="close-box fa fa-times" href="javascript:;"></a>
                                        </span>
                                    </header>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table  table-hover general-table">
                                                <?php
                                                    $selAlumnos = pg_exec("SELECT
                                                                        al.id_alumno
                                                                        ,al.nombre_alumno
                                                                        ,al.apellidos_alumno
                                                                        ,al.dni_alumno
                                                                        ,ne.nombre
                                                                        ,me.nombre
                                                                        ,idi.nombre
                                                                        ,al.calc_total
                                                                        FROM alumnos AS al
                                                                        INNER JOIN niveles AS ne
                                                                        ON al.id_nivel_educativo = ne.id_nivel
                                                                        INNER JOIN tipos_educativos AS me
                                                                        ON (al.id_tipo_educativo = me.id_tipo AND al.id_idioma=me.id_idioma)
                                                                        INNER JOIN idiomas AS idi
                                                                        ON al.id_idioma = idi.id_idioma
                                                                        INNER JOIN alumnos_a_centros AS alc
                                                                        ON al.id_alumno = alc.id_alumno
                                                                        INNER JOIN usuarios_a_tipos AS ut
                                                                        ON (al.id_tipo_educativo = ut.id_tipo_educativo AND al.id_idioma = ut.id_idioma)
                                                                        WHERE
                                                                        al.estado != 6 AND
                                                                        alc.id_centro = ".$_SESSION['user_id']."
                                                                        AND ut.curso=".$curso."
                                                                        ".$agregaCond."
                                                                        ORDER BY id_alumno");
                                                    $numResultados = pg_numrows($selAlumnos);
                                                    if($numResultados == 0){
                                                        echo "No se han encontrado alumnos en la base de datos.";
                                                    }else{
                                                        echo "
                                                            <thead>
                                                                <tr>
                                                                    <th>Nombre y apellidos</th>
                                                                    <th>DNI</th>
                                                                    <th>Nivel</th>
                                                                    <th>Modalidad</th>
                                                                    <th>Idioma</th>
                                                                    <th>Puntos</th>
                                                                    <th>Ver</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                        ";

                                                        while($alumno = pg_fetch_row($selAlumnos)){
                                                            $a_id = $alumno[0];
                                                            $a_nombre = $alumno[1]." ".$alumno[2];
                                                            $a_dni = $alumno[3];
                                                            $a_nivel_nombre = $alumno[4];
                                                            $a_tipo_nombre = $alumno[5];
                                                            $a_idioma_nombre = $alumno[6];
                                                            $a_puntos = $alumno[7];
                                                            echo "
                                                                <tr>
                                                                    <td>".$a_nombre."</td>
                                                                    <td>".$a_dni."</td>
                                                                    <td>".$a_nivel_nombre."</td>
                                                                    <td>".$a_tipo_nombre."</td>
                                                                    <td>".$a_idioma_nombre."</td>
                                                                    <td>".$a_puntos."</td>
                                                                    <td><a href='alumnos.php?a=".$a_id."' class='btn btn-sm btn-default'>Ver</a></td>
                                                                </tr>
                                                            ";
                                                        }
                                                        echo "</tbody>";
                                                    }
                                                ?>
                                            </table>
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
            if(isset($_GET['alumno']) && $_GET['alumno']!=''){
                switch($_GET['alumno']){
                    case 'no':
                        echo "
                            var titulo = 'Alumno inexistente';
                            var msj = 'El alumno seleccionado no existe.';
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
