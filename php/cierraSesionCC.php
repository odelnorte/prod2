<?php
include("../../Conexion/conectaBase.php");
$sd =new conexion();
$sd->conectar();
$n = $_POST["nx"];
$usuarioID=$_POST["usuarioIDx"];
$usuariox=mssql_query("select * from cusuario where usuarioid=".$usuarioID." ");
$usuario=mssql_fetch_array($usuariox);
if($usuario["area"]!='AdministradorEspana'){
if($n==1){
session_start();
//$seid=session_id();
$_SESSION = array();
session_destroy();
/*$sesionidx=mssql_query("select top(1)* from sesiones where sesionid='".$seid."' order by fecha desc");
$sesionid=mssql_fetch_array($sesionidx);
$nr=mssql_num_rows($sesionidx);
if($nr==1){$up=mssql_query("update sesiones set fechaCierre=GETDATE() where id=".$sesionid["id"]." ");}*/
}
if($n==2){
$sesionidx=mssql_query("select top(1)* from sesiones where usuarioid=".$usuarioID." order by fecha desc");
$sesionid=mssql_fetch_array($sesionidx);
$nr=mssql_num_rows($sesionidx);
if($nr==1){$up=mssql_query("update sesiones set fechaCierre=GETDATE() where id=".$sesionid["id"]." ");}
//header("Location: ../index.html");
}
}
$sd->desconectar();
?>