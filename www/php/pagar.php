<?php 
    session_start();
	include ("conectarSQL.php");
    include ("conexion.php");
	include ("seguridad.php");
	
	$link = conectar(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE) or die('No pudo conectarse : '. mysql_error());

	  //recogiendo el id de la orden a pagar
	  $codi=$_GET["codigo"];
	  $sql= "SELECT * from tblcosto WHERE id_costo='".$codi."'"; 
	  $query= mysql_query($sql,$link);
	  $row = mysql_fetch_array($query);
	  $costo = $row['costo'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pagar Órden</title>
<link href="../css/estilo3_e.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="300" border="0" align="center" class="alert">
    <tr>
      <td height="30" colspan="2" align="center"><strong><span id="result_box" lang="en" xml:lang="en">Está seguro de pagar esta órden?</span></strong></td>
    </tr>
    <tr>
      <td align="center"><input name="si" type="submit" class="btn-danger" id="si" value="SI" /></td>
      <td align="center"><input name="no" type="submit" class="alert-info" id="no" value="NO" /></td>
    </tr>
  </table>
</form>
<?php 
  if(isset($_POST["si"])){
	        //poner la orden como pagada en la tabla de costo
			$sql1 = "UPDATE tblcosto SET credito = 0, pagado='Si', pago = '".$costo."'";
			$query1 = mysql_query($sql1,$link) or die ("Error ejecutando el pago");
			echo("<script>
			       alert('El pago se realizo satisfactoriamente');
				   window.close();
				   window.opener.document.location='pagosycreditos.php';
				   </script>");

  }
  
  if(isset($_POST["no"])){  
 	 echo("<script>window.close();
				   window.opener.document.location='pagosycreditos.php';
				   </script>");
   }  
  
  ?>
</body>
</html>