<?php
include("../../Conexion/conectaBase.php");
$sd =new conexion();
$sd->conectar(); 
$estatus=$_POST["estatusx"];
$motivo=$_POST["motivox"];
$lista=$_POST["listaSerx"];
//echo".$estatus. - .$motivo. - .$lista.";
if($lista=='' || $lista==' ' || $lista==NULL){echo"||3||";}

$separar = explode(',',$lista); 
//$separar = explode(',,',$listaMsg);
//for ($i=0; $i<=$separar[$i].length; $i++){
//$dato = explode("--", $separar[$i]);

for ($i=0; $i<=$separar[$i].length; $i++){
		$dato = $separar[$i];
		$revisaContrato=mssql_query("select * from cmaquinas where maquinaid = ".$dato."");
		$rev=mssql_fetch_array($revisaContrato);
		if($rev["contratoidfk"]!=NULL)
		{$uno=1; if($uno==1){echo"||1||".$rev["serieCompleta"]."||".$rev["contratoidfk"]."";}
	}else{
		$update=mssql_query("update cmaquinas set estatus = '".$estatus."', motivo = '".$motivo."' where maquinaid = '".$dato."' ");}
		}echo"||2||";

$sd->desconectar();
?>