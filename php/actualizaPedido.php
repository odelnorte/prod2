<?php
include("../../Conexion/conectaBase.php");
$sd =new conexion();
$sd->conectar();

$arr=$_POST["arreglox"];
$cadenas = explode(".%.",$arr);
$j=$_POST["jx"];
$con=$j-1;
$soli2=$_POST["solx"];


for($i=0;$i<=$con;$i++){
	$refacciones = explode("||",$cadenas[$i]);
	$refx=mssql_query("select * from crefaccion where clave='".$refacciones[0]."' ");
	$ref = mssql_fetch_array($refx);
	  if($ref["refaccionid"]!=''){//echo $refacciones[0];
	$insert2=mssql_query("INSERT INTO dsolicitud_refaccion(solicitud_refaccionidfk,refaccionidfk,cantidad,serie,view2,descripcion,folioRetorno,estatusidfk
,denominacion,licencia,version,ip,juegoidfk,entregaParcial,estatus_fr,observacion,similaridfk,salidaidfk,no_guia,patrimonioidfk
,localizacion,refaccionRetorno,serieEnvia)
 VALUES(".$soli2.",".$ref["refaccionid"].",".$refacciones[3].",'".$refacciones[4]."','".$refacciones[5]."','".$refacciones[12]."','',29,'".$refacciones[6]."','".$refacciones[7]."','".$refacciones[8]."','".$refacciones[9]."',".$refacciones[10].",null,'',null,null,null,'',null,'',null,'' )");}
}
$update=mssql_query("UPDATE tsolicitud_refaccion SET observaciones='".$observaciones."' where solicitud_refaccionid=".$soli2." ");

echo "<table id='tablaNuevoPedidoSup".$soli2."' class='divPiezastd'><tr><th bgcolor='#F5F5F5' style='width:20px; border:#ccc solid 1px' class='divPiezasth'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th class='divPiezasth'>Codigo</th><th class='divPiezasth'>Descripcion</th><th class='divPiezasth'>Observaciones</th><th class='divPiezasth'>Cantidad</th><th class='divPiezasth'>Serie</th><th class='divPiezasth'>Caja</th><th class='divPiezasth'>Denominacion</th><th class='divPiezasth'>Licencia</th><th class='divPiezasth'>Version</th><th class='divPiezasth'>IP</th><th class='divPiezasth'>Juego</th><th class='divPiezasth'>Estatus</th><th class='divPiezasth'>Motivo</th></tr>";

$piezasx=mssql_query("select clave,LOWER(r.nombre) ref,r.descripcion,sr.cantidad,
sr.serie,view2,denominacion,licencia,version,ip,j.nombre juego,es.nombre estatus,sr.descripcion motivo, sr.refaccionidfk
from dsolicitud_refaccion sr inner join crefaccion r on (r.refaccionid=sr.refaccionidfk)
inner join cjuego j on (j.juegoid=sr.juegoidfk)
inner join cestatus es on (es.estatusid=sr.estatusidfk) where solicitud_refaccionidfk=".$soli2." ");
$cont=0;
while($piezas = mssql_fetch_array($piezasx))
{$cont++;
echo"<tr><td bgcolor='#F5F5F5' style='width:20px; border:#ccc solid 1px' align='center'>".$cont."</td>
<td>".$piezas["clave"]."</td><td style='width:200px;'>".$piezas["ref"]."</td>
<td>".$piezas["descripcion"]."</td>
<td id='tdAgregarCantPed".$soli2.$cont."' align='center';>".$piezas["cantidad"]." 
<img src='imgs/editarPequeno.bmp' title='Editar Cantidad' id='imgAgregarCantPed".$soli2.$cont."' onclick='imgAgregarCantPed(".$soli2.", ".$cont.", ".$piezas["refaccionidfk"].", \"".$piezas["serie"]."\", ".$piezas["cantidad"].", 1);' style='cursor: pointer;' /></td>
<td>".$piezas["serie"]."</td>
<td id='tdCamCajaPed".$soli2.$cont."' align='center';>
	<select id='sCajaPedido".$soli2.$cont."' onChange='imgAgregarCantPed(".$soli2.", ".$cont.", ".$piezas["refaccionidfk"].", \"".$piezas["serie"]."\", this.value, 2);'>
	<option value='Caja Zitro'";if($piezas["view2"]=='Caja Zitro'){echo"selected";}echo">Caja Zitro</option>
	<option value='I View'";if($piezas["view2"]=='I View'){echo"selected";}echo">I View</option>
	<option value='Sielcon'";if($piezas["view2"]=='Sielcon'){echo"selected";}echo">Sielcon</option>
	<option value='Twin'";if($piezas["view2"]=='Twin'){echo"selected";}echo">Twin</option>
	<option value='Alesis'";if($piezas["view2"]=='Alesis'){echo"selected";}echo">Alesis</option>
	<option value='Electrochance'";if($piezas["view2"]=='Electrochance'){echo"selected";}echo">Electrochance</option>
	<option value='Genesis'";if($piezas["view2"]=='Genesis'){echo"selected";}echo">Genesis</option>
	<option value='Wingos'";if($piezas["view2"]=='Wingos'){echo"selected";}echo">Wingos</option>
	<option value='Kristal'";if($piezas["view2"]=='Kristal'){echo"selected";}echo">Kristal</option>
	<option value='Nexus'";if($piezas["view2"]=='Nexus'){echo"selected";}echo">Nexus</option><select>
</td>
<td id='tdCamDenoPed".$soli2.$cont."' align='center';>
	<select id='sDenominacionPedido".$soli2.$cont."' onChange='imgAgregarCantPed(".$soli2.", ".$cont.", ".$piezas["refaccionidfk"].", \"".$piezas["serie"]."\", this.value, 3);'>
	<option value='(1)-2-5-10'";if($piezas["denominacion"]=='(1)-2-5-10'){echo"selected";}echo">(1)-2-5-10</option>
	<option value='50c-(1)-2-5-10'";if($piezas["denominacion"]=='50c-(1)-2-5-10'){echo"selected";}echo">50c-(1)-2-5-10</option>
	<option value='(50c)-1-2-5-10'";if($piezas["denominacion"]=='(50c)-1-2-5-10'){echo"selected";}echo">(50c)-1-2-5-10</option>
	<option value='(10c)-20c-50c-1-2'";if($piezas["denominacion"]=='(10c)-20c-50c-1-2'){echo"selected";}echo">(10c)-20c-50c-1-2</option></select>
</td>
<td id='tdCamLicPed".$soli2.$cont."' align='center';>".$piezas["licencia"]."
<img src='imgs/editarPequeno.bmp' title='Editar Cantidad' id='camLicPed".$soli2.$cont."' onclick='imgAgregarCantPed(".$soli2.", ".$cont.", ".$piezas["refaccionidfk"].", \"".$piezas["serie"]."\", \"".$piezas["licencia"]."\", 4);' style='cursor: pointer;' />
</td>
<td id='tdCamVerPed".$soli2.$cont."' align='center';>".$piezas["version"]."
<img src='imgs/editarPequeno.bmp' title='Editar Cantidad' id='camVerPed".$soli2.$cont."' onclick='imgAgregarCantPed(".$soli2.", ".$cont.", ".$piezas["refaccionidfk"].", \"".$piezas["serie"]."\", \"".$piezas["version"]."\", 5);' style='cursor: pointer;' />
</td>
<td id='tdCamIpPed".$soli2.$cont."' align='center';>".$piezas["ip"]."
<img src='imgs/editarPequeno.bmp' title='Editar Cantidad' id='camIpPed".$soli2.$cont."' onclick='imgAgregarCantPed(".$soli2.", ".$cont.", ".$piezas["refaccionidfk"].", \"".$piezas["serie"]."\", \"".$piezas["ip"]."\", 6);' style='cursor: pointer;' />
</td>
<td  id='tdCamJuegoPed".$soli2.$cont."' align='center';>";
$query= mssql_query("select * from cjuego where nombre!='NO DISPONIBLE' order by nombre");
	echo "<select style='font-size:10px' id='sJuegoPedido".$soli2.$cont."' onChange='imgAgregarCantPed(".$soli2.", ".$cont.", ".$piezas["refaccionidfk"].", \"".$piezas["serie"]."\", this.value, 7);'>";  
					  
	while($row = mssql_fetch_array($query)){		 
	echo "<option value='".$row["juegoid"]."'"; if($row["nombre"]==$piezas["juego"]){echo 'selected';} echo">".$row["nombre"]."</option>"; } 
	echo "</select>"; echo"
</td>
<td   id='tdCamEstatusPed".$soli2.$cont."' align='center';>
<select id='estatus".$soli2.$cont."' id='camEstatusPed".$soli2.$cont."' onChange='imgAgregarCantPed(".$soli2.", ".$cont.", ".$piezas["refaccionidfk"].", \"".$piezas["serie"]."\", this.value, 8);' style='cursor: pointer;'>
	<option value='pendiente'"; if($piezas["estatus"]=='pendiente'){echo 'selected';} echo">Pendiente</option>
	<option value='cancelado'"; if($piezas["estatus"]=='cancelado'){echo 'selected';} echo">Cancelado</option></select>
</td>
<td>".$piezas["motivo"]."</td>";
echo"</tr>";}echo"</table>";


$sd->desconectar();
?>