<?php
include("../../Conexion/conectaBase.php");
//$n=$_POST["nx"];
$sd =new conexion();
$sd->conectar();

$ID=$_POST["folioIDx"];
$com=$_POST["comentariox"];
$estatus=$_POST["estatusMaqx"]; if($estatus=='completo'){$estatus='1';}else{$estatus='2';}
$serie=$_POST["serieMaqx"];
$usuarioID=$_POST["usuarioIDx"];

//echo" ".$ID."-".$com."-".$estatus."-".$serie."-".$usuarioID." "; return -1;

$datMaqx=mssql_query("select * from cmaquinas where serieCompleta = '".$serie."' and lugarUbi = 'Bodega'");
$datMaq=mssql_fetch_array($datMaqx);

if($datMaq["maquinaid"]=='' || $datMaq["maquinaid"]==' '){echo"sinSerie"; return -1;}

$usuariox=mssql_query("select * from cusuario where usuarioid=".$usuarioID." ");
$usuario= mssql_fetch_array($usuariox);

$datFolx=mssql_query("select * from tmaquinas_incompletas where folioID = ".$ID." ");
$datFol=mssql_fetch_array($datFolx);

if($com=='' || $com==' '){
$upd=mssql_query("update tmaquinas_incompletas set serieCompleta = '".$serie."', maquinaidfk = ".$datMaq["maquinaid"].", estatus = 2 where folioID = ".$ID." ");
$updMaquina=mssql_query("update cmaquinas set estatus = 'No Disponible', motivo = 'Mueble en Rehabilitacion' where maquinaid = ".$datMaq["maquinaid"]."");
}else{
	
	if($datFol["comentarios"]=='' || $datFol["comentarios"]==' '){$cc="comentarios='".$usuario["nombre"].' '.$usuario["apellido_paterno"].": '+Convert(varchar(17), GETDATE(), 13)+ ' ".$com."'";}
 else{$cc="comentarios=comentarios+'
".$usuario["nombre"].' '.$usuario["apellido_paterno"].": '+Convert(varchar(17), GETDATE(), 13)+ ' ".$com."'";}
	
	$upd=mssql_query("update tmaquinas_incompletas set serieCompleta = '".$serie."', maquinaidfk = ".$datMaq["maquinaid"].", ".$cc.", estatus = 2 where folioID = ".$ID." ");
	$updMaquina=mssql_query("update cmaquinas set estatus = 'No Disponible', motivo = 'Mueble en Rehabilitacion' where maquinaid = ".$datMaq["maquinaid"]."");
}

$sd->desconectar();
?>