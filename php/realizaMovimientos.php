<?php 
include("../../Conexion/conectaBase.php");
$sd =new conexion();
$sd->conectar();
$listaMov=$_POST["listaMovx"];
$listaDes=$_POST["listaDesx"];
$destino=$_POST["destinox"];
$usuarioID=$_POST["usuarioIDx"];

$movimiento = explode(",", $listaMov);
$num=count($movimiento);

$movimientoRes = explode(",", $listaDes);
$numRes=count($movimientoRes);


for ($j=0; $j<=$numRes; $j++){
if($movimientoRes[$j]!=''){
	$datoRes = explode("--", $movimientoRes[$j]);
		$transito=mssql_query("update cmaquinas set transito=0 where maquinaid='".$datoRes[0]."' ");}		
}


if($destino=='Bodega'){
for ($i=0; $i<=$num; $i++){
if($movimiento[$i]!=''){
	$dato = explode("--", $movimiento[$i]);
		$updateUbicacion2=mssql_query("update cubicacion2 set serie='".$dato[3]."' where ubicacionid=".$dato[2]." ");
		/*$serieCMaquina=mssql_query("select maquinaid from cmaquinas where maquinaid='".$dato[0]."' "); $seriex = mssql_fetch_array($serieCMaquina);*/ 
		$selectSerie=mssql_query("select * from cubicacion2 where serie='".$dato[3]."' "); $res = mssql_fetch_array($selectSerie); 
		$ser = explode(" ", $res["bodega"]);
		$updateCMaquinas=mssql_query("update cmaquinas set lugarUbi='".$ser[0]."', local='".$ser[1]."', sala='".$res["bodega"]."', ubicacionidfk=".$dato[2].", salaidfk=NULL, estatusidfk=NULL, transito='0', salaObodega=NULL, salaidfkObodegaidfk=NULL where maquinaid='".$dato[0]."' ");
		$insert=mssql_query("insert into tmovimientoMaquinas (fecha, origen, destino, origenID, destinoID, ubicacion, usuarioidfk, maquinaidfk)
							values (getdate(), 'sala', '".$res["bodega"]."', ".$dato[4].", ".$dato[2].", '".$dato[5]."', '".$usuarioID."', ".$dato[0].") ");
		/*$cadena=$cadena.$dato[0].'-'.$dato[4].'||';}else{$cadena=$cadena.'vacio ||';*/}
		
}
}else{
	for ($i=0; $i<=$num; $i++){
if($movimiento[$i]!=''){
	$dato = explode("--", $movimiento[$i]);
		$updateUbicacion2=mssql_query("update cmaquinas set ubicacionidfk=NULL, salaidfk=".$dato[2].", estatusidfk=94, lugarUbi='Sala' where maquinaid=".$dato[0]." ");
		$transito=mssql_query("update cmaquinas set transito=0 where maquinaid='".$dato[0]."' ");
		$insert=mssql_query("insert into tmovimientoMaquinas (fecha, origen, destino, origenID, destinoID, ubicacion, usuarioidfk, maquinaidfk)
							values (getdate(), 'sala', 'sala', ".$dato[4].", ".$dato[2].", '".$dato[5]."', '".$usuarioID."', ".$dato[0].") ");
		/*$cadena=$cadena.$dato[0].'-'.$dato[4].'||';}else{$cadena=$cadena.'vacio ||';*/}
		
}
}

/*echo $listaMov.'-||-'.$cadena;*/
	
$sd->desconectar();
?>