<?php
include("excelwriter.inc.php");
include("../../Conexion/conectaBase.php");
$sd =new conexion();
$sd->conectar();

$serie=$_GET["txtSeriex"];
$tipoPlaca=$_GET["selectTipox"]; if($tipoPlaca=='Sin'){$tipoPlaca='Sin Placa';} if($tipoPlaca=='benusUno'){$tipoPlaca='BENUS 1.0';} if($tipoPlaca=='benusDos'){$tipoPlaca='BENUS 2.0';} if($tipoPlaca != '1' || $tipoPlaca != '2'){$cadena="and tipoPlaca like '".$tipoPlaca."'";} if($tipoPlaca=='1'){$cadena="and (a.tipoPlaca is NULL or a.tipoPlaca is not NULL)";} if($tipoPlaca=='2'){$cadena="and (tipoPlaca like '' or tipoPlaca is NULL)";}
$bodega=$_GET["selectBodegax"];
$region=$_GET["selectRegionx"];
$sala=$_GET["salaOSx"];

if($tipoPlaca!='1' && $bodega=='%' && $region=='%' && $sala=='%'){$cadenaCompleta="a.pais is NULL ".$cadena."";}else{
if($tipoPlaca=='1' && $bodega=='%' && $region=='%' && $sala=='%'){$cadenaCompleta="a.pais is NULL";}
else{
if($bodega != '%'){$cadenaCompleta="b.bodega like '".$bodega."' ".$cadena."";}
else{$cadenaCompleta="c.regionidfk like '".$region."' and c.salaid like '".$sala."' ".$cadena."";}}
}

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
	
$excel=new ExcelWriter("reportePlacasExcel.xls");
if($excel==false) {   
        echo $excel->error;
}
//cabecera
$cabecera=array("Serie", "Ubicacion", "Rack", "Modelo", "Placa", "Licencia");
$excel->writeLine($cabecera);

while ($row=mssql_fetch_array($consulta)){
	$data=array('ser'=>''.$row["serieCompleta"].'', 'ubi'=>''.$row["sala"].' '.$row["bodega"].'', 'rack'=>''.$row["rack"].'', 'mod'=>''.$row["modelo"].'', 'placa'=>''.$row["tipoPlaca"].'', 'lic'=>''.$row["licencia"].''); 
	$excel->writeLine($data);
}
$excel->close();

?> 
<script type="text/javascript" >document.location='reportePlacasExcel.xls';</script>