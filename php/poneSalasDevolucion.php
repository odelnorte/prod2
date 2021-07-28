<?php
include("conectaBase.php");
$sd =new conexion();
$sd->conectar();  

$valor=$_POST["valorx"];
//echo".$valor.";
$salax=mssql_query("select * from csala where regionidfk = $valor order by nombre");
echo"<select id='selectSalaDevolucion'>
<option value=''>Selecciona Sala</option>";
while($sala=mssql_fetch_array($salax)){echo"
<option value=".$sala["salaid"].">".$sala["nombre"]."</option>";}
echo"</select>";

$sd->desconectar();
?>