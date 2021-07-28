<?php
include("../../Conexion/conectaBase.php");
$usuarioID=$_POST["usuarioIDx"];
$cantidad=$_POST["cantx"];
$sol=$_POST["solx"];
$con=$_POST["conx"];
$clave=$_POST["clavex"];
$serie=$_POST["seriex"];
$n=$_POST["nx"];
$sd =new conexion();
$sd->conectar();

if($n==1){$dato='denominacion'; $echo=1; $campo='Denominacion';}
if($n==2){$dato='version'; $echo=2; $campo='Version';}
if($n==3){$dato='juegoidfk'; $echo=3; $campo='Juego';}

$datoAx=mssql_query("select * from dsolicitud_refaccion where solicitud_refaccionidfk=".$sol." and refaccionidfk=".$clave." and serie='".$serie."' ");
$datoA = mssql_fetch_array($datoAx);
$update = mssql_query("update dsolicitud_refaccion set ".$dato."='".$cantidad."' where solicitud_refaccionidfk=".$sol." and refaccionidfk=".$clave." and serie='".$serie."' ");
$ins=mssql_query("INSERT INTO cambiosSolRefaccion(solicitud_refaccionidfk,refaccionidfk,serie,fecha_hora,usuarioidfk,
campo,valorAnterior,valorNuevo) VALUES(".$sol.",".$clave.",'".$serie."',getdate(),".$usuarioID.",'".$campo."','".$datoA["".$dato.""]."','".$cantidad."')");
echo $echo;

$sd->desconectar();
?>