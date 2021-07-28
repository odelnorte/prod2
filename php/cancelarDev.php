<?php
include("../../Conexion/conectaBase.php");
$sd =new conexion();
$sd->conectar(); 
$devolucion=$_POST["devolucionidx"];
$usuario=$_POST["usuarioIDx"];
//echo".$devolucion.";

$upd=mssql_query("update cdevolucionAlmacen set estatus = 4, usuarioCancela = ".$usuario." where devolucionid = ".$devolucion."");

$sd->desconectar();
?>