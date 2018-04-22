<!DOCTYPE html>
<html>
    <head>
        <?php include("includes/inc-metas.php");?>
        <title>micole - backoffice</title>

        <?php include("includes/inc-css.php");?>
        <script src="js/modernizr-custom.js"></script>
    </head>
    <body>
        <div class="sign-in-wrapper">
            <div class="sign-container">
                <div class="text-center">
                    <h2 class="logo"><img src="img/logo-dark.png" alt="" width="130px"></h2>
                    <h4>Acceder al panel de administración</h4>
                </div>

                <form class="sign-in-form" role="form" method="POST" action="php/validar_usuario.php">
                    <div class="form-group">
                        <input class="form-control" placeholder="Usuario o E-mail" required="" type="text" name="usuario">
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Contraseña" required="" type="password" name="password">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-info btn-block">Login</button>
                    </div>
                    <!-- Si hay un error en el inicio de sesion, saca mensaje -->
                    <?php
                        if(isset($_GET['accesoErroneo'])){
                    ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <small>Datos incorrectos. Vuelve a intentarlo</small>
                    </div>
                    <?php       
                        }
                    ?>
                    
                    
                    <div class="text-center help-block">
                        <a href="forgot-password.php">
                            <small>Olvidaste tu password?</small>
                        </a>
                        <!-- <p class="text-muted help-block"><small>Do not have an account?</small></p> -->
                    </div>
                    <!-- <a class="btn btn-md btn-default btn-block" href="http://megadin.lab.themebucket.net/registration.html">Create an account</a> -->
                </form>
                <div class="text-center copyright-txt">
                    <small>MICOLE - Copyright © <?= date('Y'); ?></small>
                </div>
            </div>
        </div>

        <?php include("includes/inc-js.php");?>
    </body>
</html>