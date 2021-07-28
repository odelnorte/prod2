<?php
include("../../Conexion/conectaBase.php");
/*$selectEstado=$_POST["valorx"];*/
$listaMsg=$_POST["listaMsgx"];
$listaDes=$_POST["listaDesx"];
$usuarioID=$_POST["usuarioIDx"];
$n=$_POST["nx"];
$destino=$_POST["destinox"];

$sd =new conexion();
$sd->conectar();

$movimientoRes = explode(",", $listaDes);
$numRes=count($movimientoRes);


for ($j=0; $j<=$numRes; $j++){
if($movimientoRes[$j]!=''){
	$datoRes = explode("--", $movimientoRes[$j]);
		$transito=mssql_query("update cmaquinas set transito=0 where maquinaid='".$datoRes[0]."' ");}		
}

$separar = explode(',,',$listaMsg); 

if($destino=='Sala'){
	$salaid=$_POST["salaidx"];
for ($i=0; $i<=$separar[$i].length; $i++){
	$dato = explode("--", $separar[$i]);
	$orix=mssql_query("select u.* from cmaquinas m inner join cubicacion2 u on (u.ubicacionid=m.ubicacionidfk) where maquinaid=".$dato[0]." ");
	$ori=mssql_fetch_array($orix);
	$upCMaquinas=mssql_query("update cmaquinas set lugarUbi='Sala', salaidfk=".$salaid.", ubicacionidfk=NULL, estatusidfk=94 where maquinaid=".$dato[0]." ");
	$upCUbi=mssql_query("update cubicacion2 set serie=NULL where ubicacionid=".$ori["ubicacionid"]." ");
	$dato2 = explode("-", $dato[1]);
    $insert=mssql_query("insert into tmovimientoMaquinas (fecha, origen, destino, origenID, destinoID, ubicacion, usuarioidfk, maquinaidfk)
    values (getdate(), '".$ori["bodega"]."', '".$destino."', ".$dato2[1].", ".$salaid.", '', ".$usuarioID.", ".$dato[0].") ");
	}
	
}else{
if($n==1){
for ($i=0; $i<=$separar[$i].length; $i++){
		if($separar[$i]!=''){$separaDatos = explode('--',$separar[$i]);
		         for ($j=0; $j<=$separaDatos[$j].length; $j++){$maquina=$separaDatos[0];$origen=str_replace("bodega-","",$separaDatos[1]);
				 $destino=str_replace("bodega-","",$separaDatos[2]);
				 $orix=mssql_query("select * from cubicacion2 where ubicacionid=".$origen." ");$ori=mssql_fetch_array($orix);
				 $desx=mssql_query("select * from cubicacion2 where ubicacionid=".$destino." ");$des=mssql_fetch_array($desx);
				 $insert=mssql_query("insert into tmovimientoMaquinas(fecha,origen,destino,origenID,destinoID,ubicacion,usuarioidfk,maquinaidfk)
                 values(GETDATE(),'".$ori["bodega"]."','".$des["bodega"]."',".$origen.",".$destino.",'',".$usuarioID.",$maquina)");
				 $maqx=mssql_query("select * from cmaquinas where maquinaid=".$maquina." ");  $maq=mssql_fetch_array($maqx);
				 $update=mssql_query("update cubicacion2 set serie='".$maq["serieCompleta"]."' where ubicacionid=".$destino." ");
				 $update=mssql_query("update cubicacion2 set serie=NULL where ubicacionid=".$origen." ");
				 $update=mssql_query("update cmaquinas set ubicacionidfk=".$destino.",lugarUbi='Bodega' where maquinaid=".$maquina." ");
				 $transito=mssql_query("update cmaquinas set transito=0 where maquinaid='".$maquina."' ");
				 }
		}
}
}//fin if n==1
if($n==2){for ($i=0; $i<=$separar[$i].length; $i++){
		if($separar[$i]!=''){$separaDatos = explode('--',$separar[$i]);
		$maquina=$separaDatos[0];//$origen=str_replace("bodega-","",$separaDatos[1]);
		$destino=str_replace("bodega-","",$separaDatos[2]);
        $desx=mssql_query("select * from cubicacion2 where ubicacionid=".$destino." ");$des=mssql_fetch_array($desx);				 
		$insert=mssql_query("insert into tmovimientoMaquinas(fecha,origen,destino,origenID,destinoID,ubicacion,usuarioidfk,maquinaidfk)
                 values(GETDATE(),'Nueva','".$des["bodega"]."',0,".$destino.",'',".$usuarioID.",$maquina)");
	   $maqx=mssql_query("select * from cmaquinas where maquinaid=".$maquina." ");  $maq=mssql_fetch_array($maqx);
 	   $update=mssql_query("update cubicacion2 set serie='".$maq["serieCompleta"]."' where ubicacionid=".$destino." ");
	   $update=mssql_query("update cmaquinas set lugarUbi='Bodega',ubicacionidfk=".$destino." where maquinaid=".$maquina." ");
		}}
}
}//fin }else{
?>