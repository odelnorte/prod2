<?php 
include("../../Conexion/conectaBase.php");
$sd =new conexion();
$sd->conectar();
$valor=$_POST["valorx"];


$salax=mssql_query("select OfficeID from csala where salaid=".$valor."");
$sala = mssql_fetch_array($salax); echo 'OfficeID '.$sala["OfficeID"];

$sd->desconectar();
?>