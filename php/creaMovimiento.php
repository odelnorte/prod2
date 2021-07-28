<?php
include("../../Conexion/conectaBase.php");
$maquina=$_POST["maquinax"];
$serie=$_POST["seriex"];
$posicion=$_POST["posicionx"];
$bodega=$_POST["bodegax"];
$rack=$_POST["rackx"];
$nivel=$_POST["nivelx"];
$n=$_POST["nx"];
$destino=$_POST["destinox"];
$sd =new conexion();
$sd->conectar();

$pos = explode("-", $posicion);
if($pos[1]=='0'){$pos[1]='A';}		if($pos[1]=='1'){$pos[1]='B';}		if($pos[1]=='2'){$pos[1]='C';}		if($pos[1]=='3'){$pos[1]='D';}                
if($pos[1]=='4'){$pos[1]='E';}		if($pos[1]=='5'){$pos[1]='F';}		if($pos[1]=='6'){$pos[1]='G';}		if($pos[1]=='7'){$pos[1]='H';}                
if($pos[1]=='8'){$pos[1]='I';}		if($pos[1]=='9'){$pos[1]='J';}		if($pos[1]=='10'){$pos[1]='K';}		if($pos[1]=='11'){$pos[1]='L';}
if($pos[1]=='12'){$pos[1]='M';}		if($pos[1]=='13'){$pos[1]='N';}		if($pos[1]=='14'){$pos[1]='O';}		if($pos[1]=='15'){$pos[1]='P';}
if($pos[1]=='16'){$pos[1]='Q';}		if($pos[1]=='17'){$pos[1]='R';}		if($pos[1]=='18'){$pos[1]='S';}		if($pos[1]=='19'){$pos[1]='T';}
if($pos[1]=='20'){$pos[1]='U';}     if($pos[1]=='21'){$pos[1]='V';}     if($pos[1]=='22'){$pos[1]='W';}     if($pos[1]=='23'){$pos[1]='X';}
if($pos[1]=='24'){$pos[1]='Y';}     if($pos[1]=='25'){$pos[1]='Z';}
$fila=$pos[0]+1;

if($destino=='OS'){$ordenidSalaid=$_POST["ordenidx"]; $posicion=$_POST["posicionx"]; $p = explode("-", $posicion);
//echo".$p[0].-.$p[1].-.$p[2].";

	$arrgloOSsala = explode("-",$ordenidSalaid,2);
	$ordenid = $arrgloOSsala[0];
	$salaid = $arrgloOSsala[1];
	
	$OSSalasDescx=mssql_query("select * from tOrdenSalasDesc where ordenidfk = ".$ordenid." and salaDescidfk = ".$salaid."");
	//$datosSalasDesc=mssql_fetch_array($OSSalasDescx);
	$numOSDesc=mssql_num_rows($OSSalasDescx);
	
	if($numOSDesc > 0){
		$orden=mssql_query("select * from tOrdenSalasDesc where ordenidfk = ".$ordenid." and salaDescidfk = ".$salaid." "); 
	$ordenx=mssql_fetch_array($orden);
	$orix=mssql_query("select u.* from cmaquinas m inner join cubicacion2 u on (u.ubicacionid=m.ubicacionidfk) where maquinaid=".$maquina." ");
	$ori=mssql_fetch_array($orix);
	
	$cadena="".$ori["ubicacionid"]."||".$ori["bodega"]." R-".$ori["rack"]." N-".$ori["nivel"]." FC: ".$ori["fila"]."-".$ori["columna"]."|s|";
	
	$cadena=$cadena."OS".$p[0]."||".$ordenid." ".$ordenx["actividad"];
	//$cadena=$cadena."".$des["ubicacionid"]."||".$bodega." R-".$rack." N-".$nivel." FC: ".$fila."-".$pos[1];
	echo"".$cadena."";
	}// fin if($numOSDesc > 0)
	else{

	$orden=mssql_query("select * from torden_Servicio where ordenid = ".$ordenid." "); 
	$ordenx=mssql_fetch_array($orden);
	$orix=mssql_query("select u.* from cmaquinas m inner join cubicacion2 u on (u.ubicacionid=m.ubicacionidfk) where maquinaid=".$maquina." ");
	$ori=mssql_fetch_array($orix);
	
	$cadena="".$ori["ubicacionid"]."||".$ori["bodega"]." R-".$ori["rack"]." N-".$ori["nivel"]." FC: ".$ori["fila"]."-".$ori["columna"]."|s|";
	
	$cadena=$cadena."OS".$p[0]."||".$ordenid." ".$ordenx["actividad"];
	//$cadena=$cadena."".$des["ubicacionid"]."||".$bodega." R-".$rack." N-".$nivel." FC: ".$fila."-".$pos[1];
	echo"".$cadena."";
	}//Fin else if($numOSDesc > 0)

}
if($destino=='contrato'){$contratoid=$_POST["contratoidx"]; $posicion=$_POST["posicionx"]; $p = explode("-", $posicion);
//echo".$p[0].-.$p[1].-.$p[2].";
	$contrato=mssql_query("select * from tContratoNuevo where id= ".$contratoid." "); 
	$contratox=mssql_fetch_array($contrato);
	$orix=mssql_query("select u.* from cmaquinas m inner join cubicacion2 u on (u.ubicacionid=m.ubicacionidfk) where maquinaid=".$maquina." ");
	$ori=mssql_fetch_array($orix);
	
	$cadena="".$ori["ubicacionid"]."||".$ori["bodega"]." R-".$ori["rack"]." N-".$ori["nivel"]." FC: ".$ori["fila"]."-".$ori["columna"]."|s|";
	
	$cadena=$cadena."OS".$p[0]."||".$contratoid;
	//$cadena=$cadena."".$des["ubicacionid"]."||".$bodega." R-".$rack." N-".$nivel." FC: ".$fila."-".$pos[1];
	echo"".$cadena."";
}

if($destino==='Sala'){$salaid=$_POST["salaidx"]; $posicion=$_POST["posicionx"]; $p = explode("-", $posicion);
	$sala=mssql_query("select * from csala where salaid=".$salaid." "); $salax=mssql_fetch_array($sala);
	$orix=mssql_query("select u.* from cmaquinas m inner join cubicacion2 u on (u.ubicacionid=m.ubicacionidfk) where maquinaid=".$maquina." ");
	$ori=mssql_fetch_array($orix);
	
	$cadena="".$ori["ubicacionid"]."||".$ori["bodega"]." R-".$ori["rack"]." N-".$ori["nivel"]." FC: ".$ori["fila"]."-".$ori["columna"]."|s|";
	if($p[0]=='0'){$cadena=$cadena."sala".$p[1]."||".$salax["nombre"];}
	else{$cadena=$cadena."sala".$p[0]."".$p[1]."||".$salax["nombre"];}
	
	echo"".$cadena."";
	
}else{
if($n==1){
$orix=mssql_query("select u.* from cmaquinas m inner join cubicacion2 u on (u.ubicacionid=m.ubicacionidfk) where maquinaid=".$maquina." ");
$ori=mssql_fetch_array($orix);
$desx=mssql_query("select * from cubicacion2 where bodega='".$bodega."' and rack=".$rack." and nivel=".$nivel." and fila='".$fila."' and columna='".$pos[1]."' ");
$des=mssql_fetch_array($desx);
$transito=mssql_query("update cmaquinas set transito=1 where maquinaid='".$maquina."' ");
if($rack=='99'){$rack='Temporal';}
$cadena="".$ori["ubicacionid"]."||".$ori["bodega"]." R-".$ori["rack"]." N-".$ori["nivel"]." FC: ".$ori["fila"]."-".$ori["columna"]."|s|";
$cadena=$cadena."".$des["ubicacionid"]."||".$bodega." R-".$rack." N-".$nivel." FC: ".$fila."-".$pos[1];
echo"".$cadena."";}
if($n==2){
$desx=mssql_query("select * from cubicacion2 where bodega='".$bodega."' and rack=".$rack." and nivel=".$nivel." and fila='".$fila."' and columna='".$pos[1]."' ");
$des=mssql_fetch_array($desx);
$cadena="0||Nueva|s|";
$cadena=$cadena."".$des["ubicacionid"]."||".$bodega." R-".$rack." N-".$nivel." FC: ".$fila."-".$pos[1];
echo"".$cadena."";
}
}//fin }else{
$sd->desconectar();
?>