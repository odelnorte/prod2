<?php
include("../../Conexion/conectaBase.php");
$sd =new conexion();
$sd->conectar(); 

$serie=$_POST["txtSeriex"];
$tipoPlaca=$_POST["selectTipox"]; if($tipoPlaca=='Sin'){$tipoPlaca='Sin Placa';} if($tipoPlaca=='benusUno'){$tipoPlaca='BENUS 1.0';} if($tipoPlaca=='benusDos'){$tipoPlaca='BENUS 2.0';} if($tipoPlaca != '1' || $tipoPlaca != '2'){$cadena="and tipoPlaca like '".$tipoPlaca."'";} if($tipoPlaca=='1'){$cadena="and (a.tipoPlaca is NULL or a.tipoPlaca is not NULL)";} if($tipoPlaca=='2'){$cadena="and (tipoPlaca like '' or tipoPlaca is NULL)";}
$bodega=$_POST["selectBodegax"];
$region=$_POST["selectRegionx"];
$sala=$_POST["selectSalax"];
//echo".$tipoPlaca.-.$cadena.";
if($tipoPlaca!='1' && $bodega=='%' && $region=='%' && $sala=='%'){$cadenaCompleta="a.pais is NULL ".$cadena."";}else{
if($tipoPlaca=='1' && $bodega=='%' && $region=='%' && $sala=='%'){$cadenaCompleta="a.pais is NULL";}
else{
if($bodega != '%'){$cadenaCompleta="b.bodega like '".$bodega."' ".$cadena."";}
else{$cadenaCompleta="c.regionidfk like '".$region."' and c.salaid like '".$sala."' ".$cadena."";}}
}
//echo".$cadenaCompleta.";
//echo".$serie.-.$cadena/.-.$bodega.-.$region.-.$sala.";
$numero=0;
if($serie==''){
$consulta=mssql_query("select a.serieCompleta, a.lugarUbi, a.modelo, a.tipoPlaca, a.licencia, b.bodega,b.rack,c.nombre sala from cmaquinas a
left join cubicacion2 b on (b.ubicacionid=a.ubicacionidfk)
left join csala c on (c.salaid=a.salaidfk)
left join cregion d on (d.regionid=c.regionidfk)
where ".$cadenaCompleta."");
}else{
$consulta=mssql_query("select a.serieCompleta, a.lugarUbi, a.modelo, a.tipoPlaca, a.licencia, b.bodega,b.rack,c.nombre sala from cmaquinas a
left join cubicacion2 b on (b.ubicacionid=a.ubicacionidfk)
left join csala c on (c.salaid=a.salaidfk)
left join cregion d on (d.regionid=c.regionidfk)
where a.serieCompleta='".$serie."'");
	}

echo"<table id='tablaPlacas' border='1' cellspacing='1' cellpadding='5' align= 'center' style='width:100%; font-size:12px; border:0px;'>
					<thead style='font-size:12px;' >
		   			<tr style='background:#EEEEEE';>
					   	<th align='center'>Serie Completa</th>
						<th align='center'>Localizacion</th>
						<th align='center'>Rack</th>
						<th align='center'>Modelo</th>
						<th align='center'>Placa</th>
						<th align='center'>Licencia</th>
					</tr> 
					 </thead>";
					 echo "<tbody>";
	while($datos = mssql_fetch_array($consulta)){$numero=$numero+1;
	echo"
	<tr>
	<td>".$datos["serieCompleta"]."</td>
	<td>".$datos["sala"]." ".$datos["bodega"]."</td>
	<td>".$datos["rack"]."</td>
	<td>".$datos["modelo"]."</td>
	<td>".$datos["tipoPlaca"]."</td>
	<td>".$datos["licencia"]."</td>
	</tr>
	";}
echo"</tbody></table>||".$numero."||";

$sd->desconectar();
?>