<?php
    $query = "SELECT nombre, apellidos, foto FROM public.usuarios WHERE id = '".$_SESSION['user_id']."'";
    $resultados = pg_exec($query);
    $numResultados = pg_numrows($resultados);
    $dato = pg_fetch_row($resultados);

    $user_nombre = $dato[0];
    $user_apellido = $dato[1];
    $user_foto = $dato[2];

    $nombre_completo = $user_nombre." ".$user_apellido;
?>

<header id="header" class="ui-header">
    <div class="navbar-header">
        <!--logo start-->
        <a href="home.php" class="navbar-brand">
            <span class="logo"><img src="img/logo-dark.png" alt=""></span>
            <span class="logo-compact"><img src="img/logo-icon-dark.png" alt=""></span>
        </a>
        <!--logo end-->
    </div>

    <div class="navbar-collapse nav-responsive-disabled">

        <!--toggle buttons start-->
        <ul class="nav navbar-nav">
            <li>
                <a class="toggle-btn" data-toggle="ui-nav" href="#">
                    <i class="fa fa-bars"></i>
                </a>
            </li>
        </ul>
        <!-- toggle buttons end -->

        <!--notification start-->
        <ul class="nav navbar-nav navbar-right">

            <li class="dropdown dropdown-usermenu">
                <a href="#" class=" dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                    <div class="user-avatar"><img src="<?= $fotoPerfilBO.$user_foto?>" alt="<?=$nombre_completo;?>"></div>
                    <span class="hidden-sm hidden-xs"><?= $nombre_completo;?></span>
                    <span class="caret hidden-sm hidden-xs"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                    <!-- <li><a href="#"><i class="fa fa-user"></i>  Perfil</a></li>
                    <li class="divider"></li> -->
                    <li><a href="salir.php"><i class="fa fa-sign-out"></i> Salir</a></li>
                </ul>
            </li>
        </ul>
        <!--notification end-->
    </div>
</header>
