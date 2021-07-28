<?php
include("../../Conexion/conectaBase.php");
$sd =new conexion();
$sd->conectar();  

$txtFHRCalendario111=$_POST["txtFHRCalendario111x"];	
$txtFHRCalendario222=$_POST["txtFHRCalendario222x"];	
$txtSerieAT=$_POST["txtSerieATx"];	
$selectUbicacionAT=$_POST["selectUbicacionATx"];	
$selectBodegaAT=$_POST["selectBodegaATx"];


if($txtSerieAT!=''){
$sql = mssql_query("select cmaq.serie, tmov.fecha, tmov.origen, tmov.destino, cu.nombre nombreUsuario, tmov.origenID, tmov.destinoID, tmov.maquinaidfk
from tmovimientoMaquinas tmov
inner join cmaquinas cmaq on (cmaq.maquinaid=tmov.maquinaidfk)
inner join cusuario cu on (cu.usuarioid=tmov.usuarioidfk)
where cmaq.serie='".$txtSerieAT."' ");
}



if($txtSerieAT==''){
$sql = mssql_query("select cmaq.serie, tmov.fecha, tmov.origen, tmov.destino, cu.nombre nombreUsuario, tmov.origenID, tmov.destinoID
from tmovimientoMaquinas tmov
inner join cmaquinas cmaq on (cmaq.maquinaid=tmov.maquinaidfk)
inner join cusuario cu on (cu.usuarioid=tmov.usuarioidfk)
where (tmov.origen like '".$selectBodegaAT."' or tmov.destino like '".$selectBodegaAT."') and (convert(char(10),tmov.fecha,103) BETWEEN convert(datetime,'".$txtFHRCalendario111."',103) AND convert(datetime,'".$txtFHRCalendario222."',103)) ");	
}

echo"<table id='tablaMaqsAT' border='1' cellspacing='1' cellpadding='5' align= 'center' style='width:100%; font-size:12px; border:0px;'>
	<thead style='font-size:12px;' >
		<tr style='background:#EEEEEE';>
			<th align='center'>Serie
			<th align='center'>Fecha
			<th align='center'>Origen
			<th align='center'>Destino
			<th align='center'>Usuario
		</tr> 
	</thead>";
	  
echo "<tbody>";
	while ($res=mssql_fetch_array($sql)){
		if($res["origen"]=='sala' || $res["origen"]=='Sala'){$ori = mssql_query("select salaid, nombre from csala where salaid=".$res["origenID"]." "); 
		$orix=mssql_fetch_array($ori); $res["origen"]=$orix["nombre"];}
		else{
			if($res["origenID"]==NULL)
				$ori = mssql_query("select * from cubicacion2 where ubicacionid is null "); 
			else
				$ori = mssql_query("select * from cubicacion2 where ubicacionid=".$res["origenID"]." "); 
		$orix=mssql_fetch_array($ori); $res["origen"]="B-".$orix["bodega"]." R-".$orix["rack"]." N-".$orix["nivel"]." FC-".$orix["fila"]."-".$orix["columna"]; }
		
		if($res["destino"]=='sala' || $res["destino"]=='Sala'){$des = mssql_query("select salaid, nombre from csala where salaid=".$res["destinoID"]." "); 
		$desx=mssql_fetch_array($des); $res["destino"]=$desx["nombre"];}
		else{
			if($res["destinoID"]==NULL)
				$des = mssql_query("select * from cubicacion2 where ubicacionid is null "); 
			else
				$des = mssql_query("select * from cubicacion2 where ubicacionid=".$res["destinoID"]." "); 
				
		$desx=mssql_fetch_array($des); $res["destino"]="B-".$desx["bodega"]." R-".$desx["rack"]." N-".$desx["nivel"]." FC-".$desx["fila"]."-".$desx["columna"];}
		
		echo "<tr style='font-size:12px;'>
	    		<td>".$res["serie"]."</td>
				<td>".$res["fecha"]."</td>
				<td>".$res["origen"]."</td>
				<td>".$res["destino"]."</td>
				<td>".$res["nombreUsuario"]."</td>
			 </tr>";
	}

 $sd->desconectar();
?>