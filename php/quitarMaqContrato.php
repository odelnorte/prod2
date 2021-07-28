<?php 
include("../../Conexion/conectaBase.php");
$sd =new conexion();
$sd->conectar();

$contrato=$_POST["contratoidx"];
$maquinaid=$_POST["maquinaidx"];
//echo".$contrato.-.$maquinaid."; return -1;
$revisaOSx=mssql_query("select * from cmaquinas where maquinaid = ".$maquinaid."");
$revisaOS=mssql_fetch_array($revisaOSx);
//echo".$contrato.-.$maquinaid.-.$revisaOS[ordenidfk]."; return -1;
if($revisaOS["ordenidfk"]==NULL || $revisaOS["ordenidfk"]=='NULL'){
$quitaContx=mssql_query("update cmaquinas set contratoidfk = NULL, estatus = 'Disponible',motivo='Disponible' where maquinaid = ".$maquinaid." and contratoidfk = ".$contrato."");
$deleteMaq=mssql_query("update maquinasCNuevos set maquinaidfk = NULL where contratoidfk = ".$contrato." and maquinaidfk = ".$maquinaid."");
}else{$uno=1; if($uno==1) {echo"||1||".$revisaOS["ordenidfk"].""; return -1;}}

 $sd->desconectar();
?>