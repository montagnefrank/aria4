<?php 

///////////////////////////////////////////////////////////////////////////////////////////DEBUG EN PANTALLA
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

session_start();
require ("../scripts/conn.php");
require ("../scripts/islogged.php");

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////CONEXION A DB
$user = $_SESSION["login"];
$rol = $_SESSION["rol"];
$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
$idfiltro_ordenes=$_GET["codigo"];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Eliminar Filtro</title>
  <link href="../css/estilo3_e.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="300" border="0" align="center" class="alert">
    <tr>
      <td height="30" colspan="2" align="center"><strong><span id="result_box" lang="en" xml:lang="en">Está seguro de eliminar el Filtro seleccionado</span>?</strong></td>
    </tr>
    <tr>
      <td align="center"><input name="si" type="submit" class="btn-danger" id="si" value="SI" /></td>
      <td align="center"><input name="no" type="submit" class="alert-info" id="no" value="NO" /></td>
    </tr>
  </table>
</form>
  <?php 
  if(isset($_POST["si"])){

  $sql="DELETE FROM tblpaises_destino WHERE idpais='".$idfiltro_ordenes."'";
  $eliminado= mysqli_query($link, $sql);
  	if($eliminado){
		echo("<script> alert ('Filtro eliminado correctamente');
		               window.close();					   window.opener.document.location='crearfiltros.php';
		     </script>");
	 }else{
		 echo("<script> alert (".mysqli_error().");</script>");
		 } 
  }
  
   if(isset($_POST["no"])){  
  echo("<script> window.close()</script>");
  }
  
  ?>
</body>
</html>