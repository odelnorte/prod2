<?php
include("../../Conexion/conectaBase.php");
	 
$sd =new conexion();
$sd->conectar();  

$selectFamiliaCP=$_POST["selectFamiliaCPx"];	
$codigoCP=$_POST["codigoCPx"];	
$nombreCP=$_POST["nombreCPx"];	
$selectMaquinaCP=$_POST["selectMaquinaCPx"];

$fol=$_POST["folx"];
$cabecera='';

//if($codigoCP==''){$codigoCP='%';}
//if($nombreCP==''){$nombreCP='%';}

if($codigoCP!='' || $nombreCP!=''){
$sql = mssql_query("select cfr.nombre nombrecfr, cr.clave, cr.nombre nombrecr, cr.descripcion, cr.estatusidfk from crefaccion cr inner join cfamilia_refaccion cfr on (cfr.familiaid=cr.familiaidfk) where clave like '%".$codigoCP."%' and cr.nombre like '%".$nombreCP."%'");}
else{
$sql = mssql_query("select cfr.nombre nombrecfr, cr.clave, cr.nombre nombrecr, cr.descripcion, cr.estatusidfk from crefaccion cr inner join cfamilia_refaccion cfr on (cfr.familiaid=cr.familiaidfk) where cfr.familiaid like '".$selectFamiliaCP."' and cr.nombre like '%".$nombreCP."%' and  cr.descripcion like '%".$selectMaquinaCP."%' ");}


	$cabecera = ",,<table width='100%' border='0'>
		   		<thead style='font-size:12px'>
            		<tr>
						<th width='15%' align='center'>Familia
						<th width='12%' align='center'>Codigo
						<th width='30%' align='center'>Nombre
						<th width='18%' align='center'>Observaciones
						<th width='15%' align='center'>Estatus
						<th width='15%' align='center'>Imagen
					</tr>
           		 </thead>
	  </table>";
	  
//	  $res=mssql_fetch_array($sql);
	
	  $cabecera=$cabecera.",,<table width='100%'  border='1' cellspacing='1' cellpadding='3' align= 'center'>";
	  while ($res=mssql_fetch_array($sql)){
		  if($res["estatusidfk"]=='15'){$estatus='En Existencia';}
		  if($res["estatusidfk"]=='16'){$estatus='En Existencia y Requiere Folio de Retorno';}
		  if($res["estatusidfk"]=='58'){$estatus='Baja';}
		  			
$fichero="../../../FotosPiezas/".$res["clave"].".jpg";
$cabecera=$cabecera. "		<tr title='".$res["nombrecr"]."');'>";
$cabecera=$cabecera. " <td style='font-size:10px' width='15%' title='".$res["nombrecr"]."' onClick='puenteRep(".$res["clave"].", ".$res["estatusidfk"].", \"".$fol."\",this.title);'>".$res["nombrecfr"]."</td>
<td style='font-size:10px' width='12%' title='".$res["nombrecr"]."' onClick='puenteRep(".$res["clave"].", ".$res["estatusidfk"].", \"".$fol."\",this.title);'>".$res["clave"]."</td>
<td style='font-size:10px' width='30%' title='".$res["nombrecr"]."' onClick='puenteRep(".$res["clave"].", ".$res["estatusidfk"].", \"".$fol."\",this.title);'>".$res["nombrecr"]."</td>
<td style='font-size:10px' width='18%' title='".$res["nombrecr"]."' onClick='puenteRep(".$res["clave"].", ".$res["estatusidfk"].", \"".$fol."\",this.title);'>".$res["descripcion"]."</td>
<td style='font-size:10px' width='15%' title='".$res["nombrecr"]."' onClick='puenteRep(".$res["clave"].", ".$res["estatusidfk"].", \"".$fol."\",this.title);'>".$estatus."</td>";if( file_exists($fichero)){$cabecera=$cabecera."
								<td style='font-size:12px; cursor:pointer' onclick='mirarRefaccionLab(".$res["clave"].")' align='center';><font color='#0099FF'><u>Ver Pieza Completa</u></font></td>";}
								else
								{$cabecera=$cabecera."<td style='font-size:12px' align='center';>Imagen no Disponible</td>";}
								$cabecera=$cabecera."
							</tr>";}
$cabecera=$cabecera. "		 </table> ";

echo $cabecera;

 $sd->desconectar();
?>