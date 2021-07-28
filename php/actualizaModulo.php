<?php
session_start();
$usuario2=$_POST["usuarioidx"];
//$contrasena2=$_POST["contrasena"];

include("../../Conexion/conectaBase.php");
$sd =new conexion();
$sd->conectar(); 
$consulta="select * from cusuario where usuarioid=".$usuario2." ";
$ejecuta=mssql_query($consulta);
$verifica=mssql_fetch_array($ejecuta);

$nr=mssql_num_rows($ejecuta);

if($nr == 1){	$_SESSION["autenticado"] = "si";
				$_SESSION["usuario"] = $verifica["usuario"];
				$_SESSION["nombre"] = $verifica["nombre"]." ".$verifica["apellido_paterno"];
				$_SESSION["area"]=$verifica["area"];
				$_SESSION["usuarioid"]=$usuario2;
}
else {header("Location: ../index.html");}
?>