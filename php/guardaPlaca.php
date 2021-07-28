<?php
include("../../Conexion/conectaBase.php");
$sd =new conexion();
$sd->conectar(); 

$maquinaid=$_POST["maquinaidx"];
$valor=$_POST["valorx"]; if($valor=='0'){$valor=NULL;}
$usuario=$_POST["usuarioIDx"];

$query=mssql_query("select * from cmaquinas where maquinaid = $maquinaid");
$datos=mssql_fetch_array($query);

$nsert=mssql_query("insert into cambiosPlacas(campo,valorAnterior,valorNuevo,usuarioidfk,fecha,maquinaidfk)values('Placa','".$datos["tipoPlaca"]."','".$valor."',".$usuario.",GETDATE()
,".$maquinaid.")");

$update=mssql_query("update cmaquinas set tipoPlaca = '".$valor."' where maquinaid = $maquinaid");


$sd->desconectar();
?>