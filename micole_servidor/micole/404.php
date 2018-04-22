<?php include("php/seguridad.php")?>

<!DOCTYPE html>
<html>
    <head>
        <?php include("includes/inc-metas.php");?>
        <title>decomap - error 404</title>

        <?php include("includes/inc-css.php");?>
        <script src="js/modernizr-custom.js"></script>
    </head>
    <body>

        <div class="sign-in-wrapper">
            <div class="sign-container lock-bg">
                <div class="text-center">
                    <h1 class="error-txt">404</h1>

                    <h3>Esta página no está disponible</h3>
                    <p>Es posible que el enlace que has seguido esté roto o que se haya eliminado la página</p>
                </div>
                
                <form class="form-inline text-center" role="form">
                    <div class="form-group">
                        <input class="form-control" placeholder="Buscar página" type="text">
                    </div>
                    <button type="submit" class="btn btn-info">Buscar</button>
                </form>
            </div>
        </div>

       <?php include("includes/inc-js.php");?>
    </body>
</html>