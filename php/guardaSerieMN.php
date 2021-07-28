<?php
include("../../Conexion/conectaBase.php");
$valor=$_POST["valorx"];
$maq=$_POST["maqx"];

$sd =new conexion();
$sd->conectar();

$dato = explode("--", $maq);

if($dato[1]!='' && $dato[2]!=''){$update=mssql_query("update cmaquinas set serie='".$valor."', serieCompleta='".$dato[1]."/".$valor."-".$dato[2]."' where maquinaid=".$dato[0]." ");
}else{

if($dato[1]!=''){$update=mssql_query("update cmaquinas set serie='".$valor."', serieCompleta='".$dato[1]."/".$valor."' where maquinaid=".$dato[0]." "); }	
if($dato[2]!=''){$update=mssql_query("update cmaquinas set serie='".$valor."', serieCompleta='".$valor."-".$dato[2]."' where maquinaid=".$dato[0]." "); }
}

$sd->desconectar();
?>