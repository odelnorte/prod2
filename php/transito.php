<?php 
include("../../Conexion/conectaBase.php");
$sd =new conexion();
$sd->conectar();
$maquinaid=$_POST["maquinaidx"];

$transito=mssql_query("update cmaquinas set transito=0 where maquinaid='".$maquinaid."' ");
	
$sd->desconectar();
?>