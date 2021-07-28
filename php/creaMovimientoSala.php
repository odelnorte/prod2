<?php
include("../../Conexion/conectaBase.php");
$serie=$_POST["seriex"];
$posicion=$_POST["posicionx"];
$bodega=$_POST["bodegax"];
$rack=$_POST["rackx"];
$nivel=$_POST["nivelx"];
$destino=$_POST["destinox"];
$maquina=$_POST["maquinax"];

$sd =new conexion();
$sd->conectar();

$pos = explode("-", $posicion);
if($pos[1]=='0'){$pos[1]='A';}			if($pos[1]=='1'){$pos[1]='B';}			if($pos[1]=='2'){$pos[1]='C';}			if($pos[1]=='3'){$pos[1]='D';}
if($pos[1]=='4'){$pos[1]='E';}			if($pos[1]=='5'){$pos[1]='F';}			if($pos[1]=='6'){$pos[1]='G';}			if($pos[1]=='7'){$pos[1]='H';}
if($pos[1]=='8'){$pos[1]='I';}			if($pos[1]=='9'){$pos[1]='J';}			if($pos[1]=='10'){$pos[1]='K';}			if($pos[1]=='11'){$pos[1]='L';}
if($pos[1]=='12'){$pos[1]='M';}			if($pos[1]=='13'){$pos[1]='N';}			if($pos[1]=='14'){$pos[1]='O';}			if($pos[1]=='15'){$pos[1]='P';}
if($pos[1]=='16'){$pos[1]='Q';}		    if($pos[1]=='17'){$pos[1]='R';}		    if($pos[1]=='18'){$pos[1]='S';}		    if($pos[1]=='19'){$pos[1]='T';}
$fila=$pos[0]+1;

if($destino=='Sala'){$salaidO=$_POST["salaidOx"]; $salaidD=$_POST["salaidDx"]; $maquina=$_POST["maquinax"]; $posicion=$_POST["posicionx"]; $p = explode("-", $posicion);
	$salaO=mssql_query("select * from csala where salaid=".$salaidO." "); $salaOx=mssql_fetch_array($salaO);
	$salaD=mssql_query("select * from csala where salaid=".$salaidD." "); $salaDx=mssql_fetch_array($salaD);
	$select=mssql_query("select * from cmaquinas where maquinaid=".$maquina." ");
	$selectx=mssql_fetch_array($select);
	$transito=mssql_query("update cmaquinas set transito=1 where maquinaid=".$maquina." ");
	
	echo $serie.'||'.$salaOx["nombre"].'||'.$salaOx["salaid"].'||'.$salaDx["nombre"].'||'.$salaDx["salaid"].'||'.$selectx["maquinaid"];
}else{
	$des=mssql_query("select * from cubicacion2 where bodega='".$bodega."' and rack=".$rack." and nivel=".$nivel." and fila=".$fila." and columna='".$pos[1]."' ");
	$desx=mssql_fetch_array($des);

	$select=mssql_query("select * from cmaquinas where maquinaid=".$maquina." ");
	$selectx=mssql_fetch_array($select);
	$transito=mssql_query("update cmaquinas set transito=1 where maquinaid=".$selectx["maquinaid"]." ");

	$posicion=$fila.'-'.$pos[1];
	echo $serie.'||'.$selectx["salaObodega"].'||'.$selectx["salaidfkObodegaidfk"].'|| '.$bodega.'   R-'.$rack.'   N-'.$nivel.'   P-'.$posicion.'||'.$desx["ubicacionid"].'||'.$selectx["maquinaid"];
}
$sd->desconectar();
?>