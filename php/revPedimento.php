<?php 
include("../../Conexion/conectaBase.php");
$sd =new conexion();
$sd->conectar();
$maquina=$_POST["maquinax"];
//echo".$maquina.";
$revPedx=mssql_query("select * from cmaquinas where maquinaid = ".$maquina."");
$revPed=mssql_fetch_array($revPedx);
if($revPed["pedimento"]==NULL || $revPed["pedimento"]=='NULL' || $revPed["pedimento"]==''){echo"SinP";}
$sd->desconectar();
?>