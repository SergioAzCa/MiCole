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
                    <h3>Password olvidado</h3>
                    <p>Introduce tu dirección de correo y te llegará un nuevo password reseteado.</p>
                </div>

                <form class="sign-in-form" role="form" method="POST" action="#">
                    <div class="form-group">
                        <input class="form-control" placeholder="Email" required="" type="email">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Enviar nueva contraseña</button>
                </form>
                <div class="text-center copyright-txt">
                    <small>MICOLE - Copyright © <?= date('Y'); ?></small>
                </div>
            </div>
        </div>

        <?php include("includes/inc-js.php");?>
    </body>
</html>