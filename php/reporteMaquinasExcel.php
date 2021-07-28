<?php
include("excelwriter.inc.php");
include("../../Conexion/conectaBase.php");
$sd =new conexion();
$sd->conectar();

$serie=$_GET["seriex"];
$ubi=$_GET["ubix"];
$ped=$_GET["pedx"];  if($ped=='' || $ped==' '){$ped='%';}
$fac=$_GET["facx"];  if($fac=='' || $fac==' '){$fac='%';}
$color='#E8F3FF';
$local='';

$consulta="select m.serie,prefijo,sufijo,serieCompleta sc,m.modelo,mueble,fabricante,lugarUbi,s.OfficeID, m.estatus
,u.rack,u.nivel,u.fila,u.columna,coordenadas,'#'+licencia licencia,Posicion,
j.modelo modJuego,j.acronimo juego,version,IP,film,cpuPlaca,s.cliente,s.nombre sala,x = SUBSTRING(U.bodega, 8,10)
from cmaquinas m left join csala s on (s.salaid=m.salaidfk)
left join cjuego j on (j.juegoid=m.juegoidfk)
left join cubicacion2 u on (u.ubicacionid=m.ubicacionidfk)";
if($serie!=''){
$bus = mssql_query("".$consulta." where serieCompleta='".$serie."' ");
$lub = mssql_query("".$consulta." where serieCompleta='".$serie."' ");

$reg = mssql_fetch_array($lub);
$ubi= $reg["lugarUbi"];

}else{

if($ubi=='%'){
$bus=mssql_query("".$consulta." ");
}
if($ubi=='Sala'){$sala=$_GET["salax"]; $region=$_GET["regionx"];
$bus=mssql_query("".$consulta." where lugarUbi='Sala' and regionidfk like '".$region."' and salaidfk like '".$sala."' ");}

if($ubi=='Transito'){//$sala=$_POST["salax"];
$bus=mssql_query("select m.serie,prefijo,sufijo,serieCompleta sc,modelo,mueble,fabricante,lugarUbi,s.OfficeID, m.estatus
,film,cpuPlaca,s.cliente,s.nombre sala,s2.nombre sala2,m.estatusidfk from cmaquinas m left join csala s on (s.salaid=m.salaidfk)
left join csala s2 on (s2.salaid=m.salaidfkObodegaidfk) where (m.lugarUbi='bodega' or m.lugarUbi='sala') and (m.estatusidfk=96 or m.estatusidfk=94) 
order by salaidfk");}

if($ubi=='Bodega'){$bodega=$_GET["bodegax"];
	$rack=$_GET["rackx"];  if($rack==''){$rack='%';}
$nivel=$_GET["nivelx"];  if($nivel==''){$nivel='%';}
	$bus=mssql_query("select m.serie,prefijo,sufijo,serieCompleta sc,modelo,mueble,fabricante,lugarUbi, m.estatus
,u.bodega,u.rack,u.nivel,u.fila,u.columna,film,local = SUBSTRING(U.bodega, 8,10)
from cmaquinas m left join cubicacion2 u on (u.ubicacionid=m.ubicacionidfk)
where lugarUbi='Bodega' and u.bodega like '".$bodega."' and u.rack like'".$rack."' and u.nivel like'".$nivel."' ");}

if($ubi=='A DESTRUIR'){//$bodega=$_POST["bodegax"];
	$bus=mssql_query("select * from cmaquinas where lugarUbi='".$ubi."' ");}
	
if($ubi=='varias'){//$bodega=$_POST["bodegax"];
	$bus=mssql_query("select * from cmaquinas where lugarUbi='Espana' or lugarUbi='Las vegas' or lugarUbi='robadas'");}

if($serie!='' && $serie!=' '){$maqx=mssql_query("select * from cmaquinas where serie='".$serie."' "); $maq = mssql_fetch_array($maqx);
if($maq["lugarUbi"]=='Sala'){echo"entra";$bus=mssql_query("select m.*,s.nombre ubi from cmaquinas m inner join csala s on (s.salaid=m.salaidfk) where m.serie='".$serie."'");}
if($maq["lugarUbi"]=='Bodega'){echo"entra2";$bus=mssql_query("select *,u.bodega+' R:'+u.rack+' N:'+u.nivel+' FC:'+u.fila+'-'+columna ubi from cmaquinas m inner join cubicacion2 u on (u.ubicacionid=m.ubicacionidfk)
where where m.serie='".$serie."'");}}

}
$excel=new ExcelWriter("reporteMaquinasExcel.xls");
if($excel==false) {   
        echo $excel->error;
}
//cabecera
if($ubi=='%' || $ubi=='Sala'){
$cabecera=array("SERIE", "PREFIJO", "SUFIJO", "SERIE COMPLETA", "MODELO", "MUEBLE", "FABRICANTE","ESTATUS", "ALMACEN", "LOCAL", "COORDENADAS", "LICENCIA", "POSICION", "MODELO JUEGO", "JUEGO", "VERSION", "IP", "FILM", "CPU PLACA", "CLIENTE", "SALA");
$excel->writeLine($cabecera);



			while($row = mssql_fetch_array($bus)){
				$salas=mssql_num_rows($bus);
				  if($row["OfficeID"]==NULL){$local=$row["x"];}else{$local=$row["OfficeID"];$row["rack"]='';}
	
	
$data=array('ser'=>''.$row["serie"].'', 'pre'=>''.$row["prefijo"].'', 'suf'=>''.$row["sufijo"].'', 'sc'=>''.$row["sc"].'', 'mod'=>''.$row["modelo"].'', 'mue'=>''.$row["mueble"].'', 'fab'=>''.$row["fabricante"].'','est'=>''.$row["estatus"].'', 'lug'=>''.$row["lugarUbi"].'', 'loc'=>''.$local.'', 'rac'=>''.$row["rack"].'', 'coo'=>''.$row["coordenadas"].'', 'lic'=>''.$row["licencia"].'', 'pos'=>''.$row["Posicion"].'', 'modj'=>''.$row["modJuego"].'', 'jue'=>''.$row["juego"].'', 'ver'=>''.$row["version"].'', 'ip'=>''.$row["ip"].'', 'fil'=>''.$row["film"].'', 'cpu'=>''.$row["cpuPlaca"].'', 'cli'=>''.$row["cliente"].'', 'sal'=>''.$row["sala"].''); 
	$excel->writeLine($data);
}
}
if($ubi=='Transito'){
$cabecera=array("SERIE", "PREFIJO", "SUFIJO", "SERIE COMPLETA", "MODELO", "MUEBLE", "FABRICANTE","ESTATUS", "ALMACEN", "LOCAL", "RACK", "NIVEL", "FILA", "COLUMNA", "FILM", "CLIENTE", "SALA");
$excel->writeLine($cabecera);

			while($row = mssql_fetch_array($bus)){//$salas=mssql_num_rows($bus);
				  if($row["OfficeID"]==NULL){$local=$row["local"];}else{$local=$row["OfficeID"];$row["rack"]='';}
if($row["estatusidfk"]==94){$ub='BODEGA A '; $nomOri=$row["sala"];}
if($row["estatusidfk"]==96){$ub='A BODEGA '; $nomOri=$row["sala2"];}

$data=array('ser'=>''.$row["serie"].'', 'pre'=>''.$row["prefijo"].'', 'suf'=>''.$row["sufijo"].'', 'sc'=>''.$row["sc"].'', 'mod'=>''.$row["modelo"].'', 'mue'=>''.$row["mueble"].'', 'fab'=>''.$row["fabricante"].'','est'=>''.$row["estatus"].'', 'lug'=>'TRANSITO - '.$nomOri.' '.$ub.'', 'loc'=>''.$local.'', 'rac'=>''.$row["rack"].'', 'niv'=>''.$row["nivel"].'', 'fia'=>''.$row["fila"].'', 'col'=>''.$row["columna"].'', 'fil'=>''.$row["film"].'', 'cli'=>''.$row["cliente"].'', 'sal'=>''.$row["sala"].''); 
	$excel->writeLine($data);}
			}
			
			
if($ubi=='Bodega'){
	$cabecera=array("SERIE", "PREFIJO", "SUFIJO", "SERIE COMPLETA", "MODELO", "MUEBLE", "FABRICANTE","ESTATUS", "ALMACEN", "LOCAL", "RACK", "NIVEL", "FILA", "COLUMNA", "FILM", "CLIENTE", "SALA");
$excel->writeLine($cabecera);

			while($row = mssql_fetch_array($bus)){//$salas=mssql_num_rows($bus);
				  if($row["OfficeID"]==NULL){$local=$row["local"];}else{$local=$row["OfficeID"];$row["rack"]='';}
if($row["estatusidfk"]==94){$ub='BODEGA A '.$row["sala"];}if($row["estatusidfk"]==96){$ub='A BODEGA'; $nomOri=$row["sala2"];}

$data=array('ser'=>''.$row["serie"].'', 'pre'=>''.$row["prefijo"].'', 'suf'=>''.$row["sufijo"].'', 'sc'=>''.$row["sc"].'', 'mod'=>''.$row["modelo"].'', 'mue'=>''.$row["mueble"].'', 'fab'=>''.$row["fabricante"].'','est'=>''.$row["estatus"].'', 'lug'=>'Bodega', 'loc'=>''.$local.'', 'rac'=>''.$row["rack"].'', 'niv'=>''.$row["nivel"].'', 'fia'=>''.$row["fila"].'', 'col'=>''.$row["columna"].'', 'fil'=>''.$row["film"].'', 'cli'=>''.$row["cliente"].'', 'sal'=>''.$row["sala"].''); 
	$excel->writeLine($data);
	}
}


if($ubi=='varias' || $ubi=='A DESTRUIR'){
	$cabecera=array("SERIE", "PREFIJO", "SUFIJO", "SERIE COMPLETA", "MODELO", "MUEBLE", "FABRICANTE","ESTATUS", "ALMACEN", "LOCAL", "RACK", "NIVEL", "FILA", "COLUMNA", "FILM", "CLIENTE", "SALA");
$excel->writeLine($cabecera);
			while($row = mssql_fetch_array($bus)){//$salas=mssql_num_rows($bus);
				  if($row["OfficeID"]==NULL){$local=$row["local"];}else{$local=$row["OfficeID"];$row["rack"]='';}
if($row["estatusidfk"]==94){$ub='BODEGA A '.$row["sala"];}if($row["estatusidfk"]==96){$ub='A BODEGA'; $nomOri=$row["sala2"];}

$data=array('ser'=>''.$row["serie"].'', 'pre'=>''.$row["prefijo"].'', 'suf'=>''.$row["sufijo"].'', 'sc'=>''.$row["sc"].'', 'mod'=>''.$row["modelo"].'', 'mue'=>''.$row["mueble"].'', 'fab'=>''.$row["fabricante"].'','est'=>''.$row["estatus"].'', 'lug'=>''.$row["lugarUbi"].'', 'loc'=>''.$local.'', 'rac'=>''.$row["rack"].'', 'niv'=>''.$row["nivel"].'', 'fia'=>''.$row["fila"].'', 'col'=>''.$row["columna"].'', 'fil'=>''.$row["film"].'', 'cli'=>''.$row["cliente"].'', 'sal'=>''.$row["sala"].''); 
	$excel->writeLine($data);}
	}
$excel->close();

?> 
<script type="text/javascript" >document.location='reporteMaquinasExcel.xls';</script>