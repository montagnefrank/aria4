<?php
require ("scripts/conn.php");
require ("scripts/islogged.php");


///////////////////////////////////////////////////////////////////////////////////////////DEBUG EN PANTALLA
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////CONEXION A DB
session_start();
$user = $_SESSION["login"];
$rol = $_SESSION["rol"];
$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////CAPA DE SEGURIDAD PARA EVITAR ACCESO A USUARIOS NO AUTORIZADOS
if ($rol == 4) {
    header("Location: ./php/mainroom.php");
} elseif ($rol == 5) {
    header("Location: ./php/administration.php");
} elseif ($rol == 6) {
    header("Location: ./php/services.php");
} elseif ($rol == 7) {
    header("Location: ./php/imp_etiquetas.php");
} elseif ($rol == 9) {
    header("Location: ./php/contabilidad.php");
} elseif ($rol == 10) {
    header("Location: ./php/imp_etiquetas.php");
}

//IDENTIFICAMOS EL ROL
$result_rol = mysqli_query($link, "SELECT idrol_user FROM tblusuario WHERE cpuser = '" . $user . "'");
$row_rol = mysqli_fetch_array($result_rol, MYSQLI_ASSOC);
$rol = $row_rol['idrol_user'];

//PANEL A MOSTRAR
$panel = $_GET['panel'];

//OBTENIENDO LA FINCA DEL USUARIO
$result_finca = mysqli_query($link, "SELECT finca FROM tblusuario WHERE cpuser = '" . $user . "'");
$row_finca = mysqli_fetch_array($result_finca, MYSQLI_ASSOC);
$finca = $row_finca['finca'];

if (isset($_POST['newtheme'])) {
    header('Refresh: 0;');
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>        
        <title>BurtonTech - Sistema de gestión de pedidos</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" type="text/css" id="theme" href="css/theme-eblooms-<?php
        $result_theme = mysqli_query($link, "SELECT theme FROM tblusuario WHERE cpuser='$user'");
        $row_theme = mysqli_fetch_array($result_theme, MYSQLI_ASSOC);
        $theme = $row_theme['theme'];
        echo $theme;
        ?>.css"/>
        <link rel="stylesheet" type="text/css" id="theme" href="css/custom.css"/>
    </head>
    <body>
        <div class="page-container page-navigation-top-fixed">
            <!-- SIDEBAR -->
            <?php
            if ($rol == 3) {
                require ("content/sidebar3.php");
            } else {
                require ("content/sidebar.php");
            }
            ?>
            <div class="page-content">
                <!-- STATUSBAR -->
                <?php require ("content/statusbar.php"); ?>          
                <!--PANEL A MOSTRAR-->                      
                <?php require ("content/panels/" . $panel); ?>                           
            </div>
        </div>
        <!-- MENSAJE DE SALIDA-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Salir de <strong>BurtonTech</strong> ?</div>
                    <div class="mb-content">
                        <p>¿Está seguro que desea salir?</p>                    
                        <p>Presione No si desea continuar trabajando. Presione Si para salir.</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="index.php" class="btn btn-info btn-lg">Si</a>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIN MENSAJE DE SALIDA-->
        <!-- PRELOADS -->
        <audio id="audio-alert" src="audio/alert.mp3" preload="auto"></audio>
        <audio id="audio-fail" src="audio/fail.mp3" preload="auto"></audio>
        <!-- FIN PRELOADS --> 

        <!--SCRIPTS Y PULGINS-->
        <?php require ("scripts/pagescripts.php"); ?>
    </body>
</html>
<?php mysqli_close($link); ?>