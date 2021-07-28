<?php
include('class.ezpdf.php');
include("../../Conexion/conectaBase.php");
$bodega= $_GET["bodegax"];
$rack= $_GET["rackx"];
$nivel= $_GET["nivelx"];


$sd =new conexion();
$sd->conectar();

$tabla=mssql_query("select m.serie,prefijo,sufijo,serieCompleta sc,modelo,mueble,fabricante,lugarUbi,
u.bodega,u.rack,u.nivel,u.fila,u.columna,film,local = SUBSTRING(U.bodega, 8,10)
from cmaquinas m left join cubicacion2 u on (u.ubicacionid=m.ubicacionidfk)
where lugarUbi='Bodega' and u.bodega like '".$bodega."' and u.rack like'".$rack."' and u.nivel like'".$nivel."' ");

while ($tablax=mssql_fetch_array($tabla)){
	if($tablax["OfficeID"]==NULL){$local=$tablax["local"];}else{$local=$tablax["OfficeID"];$tablax["rack"]='';}
	if($tablax["estatusidfk"]==94){$ub='BODEGA A '.$tablax["sala"];}if($tablax["estatusidfk"]==96){$ub='A BODEGA'; $nomOri=$tablax["sala2"];}
	
	if($ubi=='Transito'){echo"<td>TRANSITO - ".$nomOri." ".$ub."</td>";}
	if($ubi=='Bodega'){echo"<td>Bodega</td>";}
	if($ubi=='varias' || $ubi=='A DESTRUIR'){echo"<td>".$tablax["lugarUbi"]."</td>";}
						  
	$data[] = array('serie'=>''.$tablax["serie"].'', 'com'=>''.$tablax["sc"].'', 'mod'=>''.$tablax["modelo"].'', 'mueble'=>''.$tablax["mueble"].'', 'fab'=>''.$tablax["fabricante"].'','rack'=>''.$tablax["rack"].'', 'niv'=>''.$tablax["nivel"].'', 'fia'=>''.$tablax["fila"].'', 'col'=>''.$tablax["columna"].''); $ub=''; $nomOri='';
}

$pdf =& new Cezpdf('A4');
$pdf->ezSetMargins(0,0,0,0);
$options= array('spacing' =>1, 'fontSize' => 7, 'cols'=>array('serie'=>array('width'=>35),'com'=>array('width'=>50),'mod'=>array('width'=>50),'mueble'=>array('width'=>70),'fab'=>array('width'=>70),'rack'=>array('width'=>30),'niv'=>array('width'=>35),'fia'=>array('width'=>30),'col'=>array('width'=>50)) );

$datacreator = array (
					'Title'=>'Reporte de Maquinas Paradas',
					'Author'=>'operaciones del norte',
					'Subject'=>'reporte',
					'Creator'=>'',
					'Producer'=>''
					);
$pdf->addInfo($datacreator);

$pdf->ezText("       <b>Reporte de Maquinas </b>  ".date("d/m/Y")."",12);
$pdf->ezText("\n",5);

$titles = array('serie'=>'<b>SERIE</b>', 'com'=>'<b>SER. COMPLETA</b>', 'mod'=>'<b>MODELO</b>', 'mueble'=>'<b>MUEBLE</b>', 'fab'=>'<b>FABRICANTE</b>', 'rack'=>'<b>RACK</b>','niv'=>'<b>NIVEL</b>','fia'=>'<b>FILA</b>','col'=>'<b>COLUMNA</b>'); 
$pdf->ezTable($data,$titles,'',$options); 

$pdf->ezStream();
?>