<?php
include("../../Conexion/conectaBase.php");
//$n=$_POST["nx"];
$sd =new conexion();
$sd->conectar();

$folio=$_POST["NumFoliox"];
$usuarioID=$_POST["usuarioIDx"];

$datos=mssql_query("select * from tmaquinas_incompletas where folioID = ".$folio."");
$dat=mssql_fetch_array($datos);

$upd=mssql_query("update tmaquinas_incompletas set estatus = 1, fechaCierre = getdate() where folioID = ".$folio."");
$updMaq=mssql_query("update cmaquinas set estatus = 'Disponible', motivo = 'Disponible' where maquinaid = ".$dat["maquinaidfk"]."");

$sd->desconectar();
?>