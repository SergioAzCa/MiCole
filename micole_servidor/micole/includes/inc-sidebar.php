<aside id="aside" class="ui-aside">
    <ul class="nav" ui-nav="">
        <li class="nav-head">
            <h5 class="nav-title text-uppercase light-txt">NAVEGACIÓN</h5>
        </li>
        <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] !== '' &&$_SESSION['user_tipo'] == 'usuario'){ ?>
            <li class="<?php if($pag=='home'){echo 'active';}?>">
                <a href="home.php"><i class="fa fa-home"></i><span>Home</span></a>
                <ul class="nav nav-sub">
                    <li class="nav-sub-header"><a href="home.php"><span>Home</span></a></li>
                </ul>
            </li>
            <li class="<?php if($pag=='alumnos'){echo 'active';}?>">
                <a href="alumnos.php"><i class="fa fa-users"></i><span>Alumnos</span></a>
                <ul class="nav nav-sub">
                    <li class="nav-sub-header"><a href="alumnos.php"><span>Alumnos</span></a></li>
                </ul>
            </li>
            <li class="<?php if($pag=='listado'){echo 'active';}?>">
                <a href="listado-alumnos.php"><i class="fa fa-list-ol"></i><span>Listado alumnos</span></a>
                <ul class="nav nav-sub">
                    <li class="nav-sub-header"><a href="listado-alumnos.php"><span>Listado alumnos</span></a></li>
                </ul>
            </li>
            <li class="<?php if($pag=='plazas'){echo 'active';}?>">
                <a href="plazas.php"><i class="fa fa-child"></i><span>Plazas</span></a>
                <ul class="nav nav-sub">
                    <li class="nav-sub-header"><a href="plazas.php"><span>Plazas</span></a></li>
                </ul>
            </li>
            <li class="<?php if($pag=='info'){echo 'active';}?>">
                <a href="informacion.php"><i class="fa fa-info-circle"></i><span>Información</span></a>
                <ul class="nav nav-sub">
                    <li class="nav-sub-header"><a href="informacion.php"><span>Información</span></a></li>
                </ul>
            </li>
        <?php } ?>
        <!-- Sólo aparece si la sesión la abre un admin -->
        <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] !== '' &&$_SESSION['user_tipo'] == 'admin'){ ?>
            <li class="<?php if($pag=='homeadmin'){echo 'active';}?>">
                <a href="admin-home.php"><i class="fa fa-home"></i><span>Home</span></a>
                <ul class="nav nav-sub">
                    <li class="nav-sub-header"><a href="admin-home.php"><span>Home</span></a></li>
                </ul>
            </li>
            <li class="<?php if($pag=='newuseradmin'){echo 'active';}?>">
                <a href="admin-home.php"><i class="fa fa-user-plus"></i><span>Crear usuario</span></a>
                <ul class="nav nav-sub">
                    <li class="nav-sub-header"><a href="admin-home.php"><span>Crear usuario</span></a></li>
                </ul>
            </li>
            <li class="<?php if($pag=='contoladmin'){echo 'active';}?>">
                <a href="admin-home.php"><i class="fa fa-user-secret"></i><span>Tomar control</span></a>
                <ul class="nav nav-sub">
                    <li class="nav-sub-header"><a href="admin-home.php"><span>Tomar control</span></a></li>
                </ul>
            </li>
            <li class="<?php if($subPag=='configadmin'){echo 'active';}?>">
                <a href="#"><i class="fa fa-gears"></i><span>Config. administración</span><i class="fa fa-angle-right pull-right"></i></a>
                <ul class="nav nav-sub <?php if($subPag=='configadmin'){echo 'nav-sub--open';}?>">
                    <li class="<?php if($pag=='niveles'){echo 'active';}?>"><a href="niveles.php"><span>Niveles</span></a></li>
                    <li class="<?php if($pag=='tipos'){echo 'active';}?>"><a href="tipos-educativos.php"><span>Modalidades</span></a></li>
                    <li class="<?php if($pag=='parametros'){echo 'active';}?>"><a href="calculo-parametros.php"><span>Parámetros</span></a></li>
                    <li class="<?php if($pag=='opciones'){echo 'active';}?>"><a href="calculo-opciones.php"><span>Opciones</span></a></li>
                </ul>
            </li>
        <?php } ?>

        <li class='txtPeq'>
            <a href="salir.php"><i class="fa fa-sign-out"></i><span>Cerrar sesión</span></a>
            <ul class="nav nav-sub">
                <li class="nav-sub-header"><a href="salir.php"><span>Cerrar sesión</span></a></li>
            </ul>
        </li>
    </ul>
</aside>
