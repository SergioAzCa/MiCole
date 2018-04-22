<?php include("php/seguridad.php")?>

<!DOCTYPE html>
<html><head>
        <?php include("includes/inc-metas.php");?>
        <title>decomap - error 500</title>

        <?php include("includes/inc-css.php");?>
        <script src="js/modernizr-custom.js"></script>
    </head>
    <body>
        <div class="sign-in-wrapper">
            <div class="sign-container lock-bg">
                <div class="text-center">
                    <h1 class="error-txt">500</h1>
                    <h3>Error interno del servidor</h3>
                    <p>Algo salió mal, contacta con nosotros si el error persiste</p>
                    <br>
                    <a href="home.php" class="btn btn-info">Volver al panel</a>
                </div>
            </div>
        </div>
        <?php include("includes/inc-js.php");?>
    </body>
</html>