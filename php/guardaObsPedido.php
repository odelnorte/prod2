<?php 
include("../../Conexion/conectaBase.php");

$obs=$_POST["obsx"];
$sol=$_POST["solx"];
$usuarioID=$_POST["usuarioIDx"];

$sd =new conexion();
$sd->conectar();

$us=mssql_query("select usuarioid, usuario, nombre, apellido_paterno from cusuario where usuarioid=".$usuarioID."");$usx=mssql_fetch_array($us);

$update=mssql_query("update tsolicitud_refaccion set observaciones=observaciones+ '
'+'".$usx["nombre"].' '.$usx["apellido_paterno"].": ' +Convert(varchar(20), GETDATE(), 13)+' ".$obs."' where solicitud_refaccionid=".$sol." ");
$s=mssql_query("select observaciones from tsolicitud_refaccion where solicitud_refaccionid=".$sol." ");
$ss= mssql_fetch_array($s);
echo "<textarea cols='110' rows='6' id='txtObs".$sol."' readonly>".$ss["observaciones"]."</textarea>";

$sd->desconectar();
?>