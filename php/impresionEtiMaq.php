<?php
require('../../ImpresionEtiquetas/php/pdf/code128.php');
include "../../ImpresionEtiquetas/php/phpqrcode.php";
include("../../Conexion/conectaBase.php");

$sd = new conexion();
$sd->conectar();

$ordenid= $_GET["ordenidx"];
$conx=mssql_query("select ma.maquinaid,ma.serieCompleta,ma.modelo,ma.mueble from solicitudMaquinasOS s inner join cmaquinas ma on (ma.maquinaid=s.maquinaidfk)
where s.ordenidfk=".$ordenid." ");
//$cadena=$id.";".$serie.";".$modelo.";".$mueble;

date_default_timezone_set('America/Mexico_City');
//$hoy = date("ym");
$fhoy = date("dmy");  
  $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';

    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    
    $filename = $PNG_TEMP_DIR.'test.png';
$pdf=new PDF_Code128('P','mm','per');
while($con=mssql_fetch_array($conx)){
	$cadena=$con["maquinaid"].";".$con["seriecompleta"].";".$con["modelo"].";".$con["mueble"];
	//IMPRESION ETIQUETA GRANDE
	$pdf->AddPage();
	$pdf->SetFont('Arial','',10);
//	$code=$codigo.' '.$lote. ' -'.$consec;
	//$pdf->Code128(5,3,$code,50,15);
	$pdf->SetXY(11,18);
	//$pdf->Write(5,"Hola Mundo");
	 //echo 'You can provide data in GET parameter: <a href="?data=like_that">like that</a><hr/>';    
      QRcode::png($cadena, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
	  $pdf->Image($PNG_WEB_DIR.basename($filename),7,5,160,160);        
    //display generated file
    //echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" />lklk<hr/>';  
	
}
//$Ruta = "../../Barcode/Maquinas/".$nombre.".pdf";	
$Ruta = "../Barcode/".$nombre.".pdf";	
$pdf->Output($Ruta,"F");
$pdf->Output();

prueba();

echo $lote."+++";
$sd->desconectar();