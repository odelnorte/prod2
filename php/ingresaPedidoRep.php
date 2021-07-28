<?php
include("../../Conexion/conectaBase.php");
$sd =new conexion();
$sd->conectar();
$NumFolio=$_POST["folx"];
$soli2=$_POST["solx"];
$observaciones=$_POST["texax"];
$valor=$_POST["valorx"];
$j=$_POST["jx"];
$sala=$_POST["salax"]; if($sala==0){$sala='NULL';}
$tecnico=$_POST["tecnicox"]; 
$usuarioID=$_POST["usuarioIDx"];
$area=$_POST["areax"];  if($area==0){$area='NULL';}
$paisID=$_POST["paisIDx"]; if($paisID=='' && $paisID==' '){$paisID='1';}
$proyecto=$_POST["proyectox"];
//if($tecnico==0 && $area!='NULL'){$tecnico=10;}
$con=$j-1;
$banderaSol=0;
$banderaRepetido=0;
$arr=$_POST["arreglox"];
$cadenas = explode(".%.",$arr);
$folx=mssql_query("select folioID from tmaquinas_incompletas where folioID = ".$NumFolio." ");
$fol = mssql_fetch_array($folx);

$folio=$fol["folioID"]
;if($tecnico==0){  //if($area!='NULL'){$te='NULL'; $tecnico=$te;}
	/*else{*/$tecx=mssql_query("select top(1)s.* from tsolicitud_servicio s where folio_solicitudidfk='".$folio."' order by s.solicitud_servicioid desc");
$tec = mssql_fetch_array($tecx);$tecnico=$tec["tecnicoidfk"];//}
if($tecnico==''){$tecnico = 0;}

}
if($soli2!=''){$estSolx=mssql_query("select * from tsolicitud_refaccion where solicitud_refaccionid=".$soli2." ");
$estSol = mssql_fetch_array($estSolx);
  if($estSol["estatusidfk"]!=87){$valor=2;$pedidox=mssql_query("select * from tsolicitud_refaccion where folio_solicitudidfk='".$folio."' ");
   echo".-.||"; while($pedido = mssql_fetch_array($pedidox))
    {$con=1;if($pedido["estatusidfk"]==87){$id="tablaNuevoPedido".$NumFolio."";echo"<span id='spanNuevoPedido".$folio."'>";}else{$id="tablaPedido".$pedido["solicitud_refaccionid"]."";}
	echo"<fieldset id='fieldset".$folio."'><legend>Pedido ".$pedido["solicitud_refaccionid"]."</legend>
<table id='".$id."' width='100%' border='0' cellspacing='0' cellpadding='2' style='font-size:11px'>
				<tr> <th bgcolor='#F5F5F5' style='width:20px; border:#ccc solid 1px'></th>   
				<th bgcolor='#F5F5F5' style='border:#ccc solid 1px';>Clave</th><th bgcolor='#F5F5F5' style='border:#ccc solid 1px';>Descripcion</th>
				<th bgcolor='#F5F5F5' style='border:#ccc solid 1px';>Cant</th><th bgcolor='#F5F5F5' style='border:#ccc solid 1px';>Serie</th>
		
		
		
		
				</tr>";
$refx=mssql_query("select r.clave,cantidad,serie,view2,denominacion,licencia,version,ip,j.nombre juego,ds.descripcion,ds.diagnostico,r.nombre ref from dsolicitud_refaccion ds
inner join crefaccion r on (r.refaccionid=ds.refaccionidfk) inner join cjuego j on (j.juegoid=ds.juegoidfk) 
where solicitud_refaccionidfk=".$pedido["solicitud_refaccionid"]." ");$con=1;
$obsx=mssql_query("select observaciones from tsolicitud_refaccion where solicitud_refaccionid=".$soli2." ");
$obs = mssql_fetch_array($obsx);
while($ref = mssql_fetch_array($refx))
    {
echo"<tr><td bgcolor='#F5F5F5' style='width:20px; border:#ccc solid 1px' align='center'>".$con."</td>
     <td align='center'>".$ref["cantidad"]."</td>
	 <td>".$ref["descripcion"]."</td></tr>";$con++;
	}/*while2*/ echo"</table>
			Obsevaciones: &nbsp;<textarea cols='70' rows='2' id='texaObservaciones".$sol["solicitud_refaccionid"].$NumFolio."' style='color:#666'>".$obs["observaciones"]."</textarea></legend></fieldset>";$banderaSol=1;
	  
	}/*while1*/echo"<span id='spanNuevoPedido".$folio."'>";
	  	  $soli2='';
	  }/*if !=87*/
  }/*soli2!=''*/

if($soli2==''){
if($folio==''){$folio='0';}
$estatusPedido='30';
if($paisID!='1'){$estatusPedido='30';}
$estatusPedido=29;
$insert=mssql_query("INSERT INTO tsolicitud_refaccion(folio_solicitudidfk,estatusidfk,fecha_cancelacion,fecha_creacion,fecha_entrega,observaciones,paqueteria,numero_guia,fecha_envio,estatus,usuarioidfk,salaidfk,tecnicoidfk,fechaStock,impresion,departamentoidfk,proyecto,tipoPedido) VALUES('".$folio."',".$estatusPedido.",null,GETDATE(),null,'".$observaciones."','','',null,'',".$usuarioID.",".$sala.",".$tecnico.",getdate(),'0',".$area.",'".$proyecto."','Produccion')");

$solx=mssql_query("select top(1)* from tsolicitud_refaccion where folio_solicitudidfk='".$folio."' order by fecha_creacion desc,solicitud_refaccionid desc");
$sol = mssql_fetch_array($solx);}else{$sol["solicitud_refaccionid"]=$soli2;

for($i=0;$i<=$con;$i++){
	$refacciones2 = explode("||",$cadenas[$i]);
	$refx2=mssql_query("select * from crefaccion where clave='".$refacciones2[0]."' ");
	$ref2 = mssql_fetch_array($refx2);
	$piezasx=mssql_query("select * from dsolicitud_refaccion where solicitud_refaccionidfk=".$soli2." and refaccionidfk=".$ref2["refaccionid"]." and serie='".$refacciones2[2]."' ");
	$num_rows = mssql_num_rows($piezasx);
	if($num_rows>0){$banderaRepetido=1;}
	}
if($banderaRepetido==0){
$update=mssql_query("UPDATE tsolicitud_refaccion SET observaciones='".$observaciones."' where solicitud_refaccionid=".$soli2." ");}
}
if($banderaRepetido==0){
for($i=0;$i<=$con;$i++){
	$refacciones = explode("||",$cadenas[$i]);
	$refx=mssql_query("select * from crefaccion where clave='".$refacciones[0]."' ");
	$ref = mssql_fetch_array($refx);
	  if($ref["refaccionid"]!=''){//echo $refacciones[0];
	$insert2=mssql_query("INSERT INTO dsolicitud_refaccion(solicitud_refaccionidfk,refaccionidfk,cantidad,serie,view2,descripcion,folioRetorno,estatusidfk
,denominacion,licencia,version,ip,juegoidfk,entregaParcial,estatus_fr,observacion,similaridfk,salidaidfk,no_guia,patrimonioidfk
,localizacion,refaccionRetorno,serieEnvia,diagnostico)
 VALUES(".$sol["solicitud_refaccionid"].",".$ref["refaccionid"].",".$refacciones[1].",'".$refacciones[2]."','".$refacciones[3]."','".$refacciones[9]."','',29,'".$refacciones[4]."','".$refacciones[5]."','".$refacciones[6]."','".$refacciones[7]."',50,null,'','null',null,null,'',null,'',null,'','".$refacciones[10]."')");}
}


/*$pedidox=mssql_query("select * from dsolicitud_refaccion where solicitud_refaccionidfk=".$sol["solicitud_refaccionid"]." ");
while($pedido = mssql_fetch_array($pedidox))
    {*/$con=1;

	if($folio=='0'){echo $sol["solicitud_refaccionid"];}
else{
	echo"<fieldset><legend>Pedido ".$sol["solicitud_refaccionid"]."</legend>
<table id='tablaNuevoPedido".$NumFolio."' width='100%' border='0' cellspacing='0' cellpadding='2' style='font-size:11px'>
				<tr> <th bgcolor='#F5F5F5' style='width:20px; border:#ccc solid 1px'></th>   
				<th bgcolor='#F5F5F5' style='border:#ccc solid 1px';>Clave</th>
				<th bgcolor='#F5F5F5' style='border:#ccc solid 1px';>Descripcion</th>
				<th bgcolor='#F5F5F5' style='border:#ccc solid 1px';>Cant</th>
				</tr>";

$refo=mssql_query("select observaciones from tsolicitud_refaccion where folio_solicitudidfk='".$folio."' and solicitud_refaccionid=".$sol["solicitud_refaccionid"]." ");
$refox = mssql_fetch_array($refo);

 $refx=mssql_query("select r.clave,r.nombre ref,cantidad,serie,view2,denominacion,licencia,version,ip,j.nombre juego,ds.descripcion,ds.diagnostico from dsolicitud_refaccion ds
inner join crefaccion r on (r.refaccionid=ds.refaccionidfk) inner join cjuego j on (j.juegoid=ds.juegoidfk) inner join tsolicitud_refaccion ts on (ts.solicitud_refaccionid=ds.solicitud_refaccionidfk)
where solicitud_refaccionidfk=".$sol["solicitud_refaccionid"]." ");$con=1; 
while($ref = mssql_fetch_array($refx))
    {	
echo"<tr><td bgcolor='#F5F5F5' style='width:20px; border:#ccc solid 1px' align='center'>".$con."</td>
     <td align='center'>".$ref["clave"]."</td>
	 <td align='center'><textarea cols='50' rows='2' readonly>".$ref["ref"]."</textarea></td>
	 <td align='center'>".$ref["cantidad"]."</td><td align='center'>".$ref["serie"]."</td></tr>";$con++;
	}

/*$con2=mssql_query("select observaciones from tsolicitud_refaccion where solicitud_refaccionid='".$soli2."' ");
$conx2 = mssql_fetch_array($con2);*/
	//$sol=$pedido["solicitud_refaccionid"];
		echo"<table width='100%' border='0' cellspacing='0' cellpadding='2' style='font-size:11px'><tr>    
				 
				</tr></table></legend>";
if($valor==1){echo "Obsevaciones: &nbsp;<textarea cols='70' rows='2' id='texaObservacionesNP".$NumFolio."' style='color:#666'>".$refox["observaciones"]."</textarea>";}else{echo "		Obsevaciones: &nbsp;<textarea cols='70' rows='2' id='texaObservaciones".$sol["solicitud_refaccionid"].$NumFolio."' style='color:#666'>".$refox["observaciones"]."</textarea>";}echo"
				</fieldset>";$estImgNuevoPedido='0';
	if($banderaSol==0){
	echo"||<img src='imgs/flechaVerde.bmp' style='float:right; margin-right:7px; cursor:pointer;' title='Enviar a Supervisor' onclick='enviaSupervisor(".$con.",".$sol["solicitud_refaccionid"].",".$NumFolio.");'/>";}
	else{echo"</span><span id='spanDesRefaccion".$folio."' class='spanDesRefaccion'></span>
	<span id='spanEnviaSup".$folio."'><img src='imgs/flechaVerde.bmp' style='float:right; margin-right:80px; cursor:pointer;' title='Enviar a Supervisor' onclick='enviaSupervisorRep(".$con.",".$sol["solicitud_refaccionid"].",".$NumFolio.");'/></span><span id='spanCatalogo".$folio."'><img src='imgs/catalogo.bmp' style='float:right; margin-right:7px; cursor:pointer;' title='Catalogo' onClick='ventanaCatalogoPiezasRep(\"".$folio."\");'/></span><span id='spanImgNuevoPedido".$folio."'></span> ";}
}/*fin else de if ($folio==0)*/}//fin if banderaRepetido==0
	else{echo"Repetido";}
$sd->desconectar();
?>