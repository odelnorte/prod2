<?php
include("excelwriter.inc.php");
include("../../Conexion/conectaBase.php");
$sd =new conexion();
$sd->conectar();

$bodega=$_GET["selectBodegaMaqx"];
$rack=$_GET["selectRackMaqx"];
$nivel=$_GET["selectNivelMaqx"];
//echo".$bodega. - .$rack. - .$nivel.";
$consultax=mssql_query("select a.bodega,a.rack,a.serie,b.estatus,b.motivo, b.modelo,b.tipoPlaca from cubicacion2 a inner join cmaquinas b on (b.ubicacionidfk=a.ubicacionid) where a.bodega = '".$bodega."' and a.rack = ".$rack." and a.nivel = ".$nivel." and a.serie is not null");

$excel=new ExcelWriter("reporteMaquinasBodegaExcel.xls");
if($excel==false) {   
        echo $excel->error;
}
//cabecera
$cabecera=array("Serie", "Modelo", "Bodega", "Rack", "Estatus", "Motivo","Tipo de Placa");
$excel->writeLine($cabecera);

while ($row=mssql_fetch_array($consultax)){
	$data=array('ser'=>''.$row["serie"].'', 'mod'=>''.$row["modelo"].'', 'bod'=>''.$row["bodega"].'', 'rac'=>''.$row["rack"].'', 'est'=>''.$row["estatus"].'', 'mot'=>''.$row["motivo"].'', 'placa'=>''.$row["tipoPlaca"].''); 
	$excel->writeLine($data);
}
$excel->close();

?> 
<script type="text/javascript" >document.location='reporteMaquinasBodegaExcel.xls';</script>