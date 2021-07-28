<?php
include("../../Conexion/conectaBase.php");
$reg=$_POST["regx"];

$sd =new conexion();
$sd->conectar();

$csala=mssql_query("select salaid, nombre, OfficeID, cliente from csala where regionidfk=".$reg." order by nombre ");

echo "<select style='font-size:10px' id='selectSalaAT'>";
			while ($csalax=mssql_fetch_array($csala)){
			echo"<option value='".$csalax["salaid"]."'>".$csalax['nombre']."</option>";
		    }
echo "</select>";

$sd->desconectar();
?>