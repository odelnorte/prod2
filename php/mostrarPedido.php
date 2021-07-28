<?php 
include("../../Conexion/conectaBase.php");
$sol=$_POST["pedidox"];
$estatus=$_POST["estatusx"];
$sd =new conexion();
$sd->conectar();
$pedidosx = mssql_query("select s.nombre sala,s.localizacion,folio_solicitudidfk,observaciones,sr.estatusidfk from tsolicitud_refaccion sr
inner join tfolio_solicitud f on (f.folio_solicitudid=sr.folio_solicitudidfk)
inner join csala s on (s.salaid=f.salaidfk) where solicitud_refaccionid=".$sol." ");
$row = mssql_fetch_array($pedidosx);
$obser2=$row["observaciones"];
if($row["estatusidfk"]==87){$updt=mssql_query("update tsolicitud_refaccion set estatusidfk=29 where solicitud_refaccionid=".$sol." ");}
/*$tecx=mssql_query("select top(1)t.nombre tecnico,su.nombre supervisor, tecnicoidfk from tsolicitud_servicio ss
inner join ctecnico t on (t.tecnicoid=ss.tecnicoidfk) inner join csupervisor su on (t.supervisoridfk=su.supervisorid)
where folio_solicitudidfk='".$row["folio_solicitudidfk"]."' ");*/
$tecx=mssql_query("select t.nombre tecnico,su.nombre supervisor,t.tecnicoid from tsolicitud_refaccion ts inner join ctecnico t on (t.tecnicoid=ts.tecnicoidfk)
inner join csupervisor su on (su.supervisorid=t.supervisoridfk)
where solicitud_refaccionid=".$sol." ");
$tec = mssql_fetch_array($tecx);
echo "<div id='titulo".$sol."' align='center' style='border-style:solid; border-width: 2px; border-color:#A8D3FF;'>Pedido ".$sol."</div>";

echo "<div id='con".$sol."' style='border-style:solid; border-width: 2px; border-color:#A8D3FF;'><table ><tr><td width='220px'>Folio: <span class='gris'>".$row["folio_solicitudidfk"]."</span></td>
<td>Tecnico: <span class='gris'>".$tec["tecnico"]."</span></td><td>Supervisor: <span class='gris'>".$tec["supervisor"]."</span></td></tr>
<tr><td>Sala: <span class='gris'>".$row["sala"]."</span></td><td colspan='2'>Direccion: <span class='gris'>".$row["localizacion"]."</span></td></tr>
</table></br>
<div id='divPiezas".$sol."' style='width:99%; background-color:#FFF; overflow:auto; border:#999 solid 1px; float:center;'><table id='tablaNuevoPedidoSup".$sol."' class='divPiezastd'><tr><th bgcolor='#F5F5F5' style='width:20px; border:#ccc solid 1px' class='divPiezasth'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th class='divPiezasth'>Codigo</th><th class='divPiezasth'>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Descripcion&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th class='divPiezasth'>Observaciones</th><th class='divPiezasth'>Cantidad</th><th class='divPiezasth'>Serie</th><th class='divPiezasth'>Caja</th><th class='divPiezasth'>Denominacion</th><th class='divPiezasth'>Licencia</th><th class='divPiezasth'>Version</th><th class='divPiezasth'>IP</th><th class='divPiezasth'>Juego</th><th class='divPiezasth'>Estatus</th><th class='divPiezasth'>Motivo</th></tr>";

$piezasx=mssql_query("select clave,LOWER(r.nombre) ref,r.descripcion,sr.cantidad,
sr.serie,view2,denominacion,licencia,version,ip,j.nombre juego,es.nombre estatus,sr.descripcion motivo, sr.refaccionidfk, r.estatusidfk
from dsolicitud_refaccion sr inner join crefaccion r on (r.refaccionid=sr.refaccionidfk)
inner join cjuego j on (j.juegoid=sr.juegoidfk)
inner join cestatus es on (es.estatusid=sr.estatusidfk) where solicitud_refaccionidfk=".$sol." ");
$con=0;
while($piezas = mssql_fetch_array($piezasx))
{$con++;
echo"<tr><td bgcolor='#F5F5F5' style='width:20px; border:#ccc solid 1px' align='center'>".$con."</td>
<td>".$piezas["clave"]."</td><td>".$piezas["ref"]."</td>
<td>".$piezas["descripcion"]."</td>

<td id='tdAgregarCantPed".$sol.$con."' align='center';>".$piezas["cantidad"]."</td>
<td>".$piezas["serie"]."</td>

<td id='tdCamCajaPed".$sol.$con."' align='center';>".$piezas["view2"]."</td>

<td id='tdCamDenoPed".$sol.$con."' align='center';>
	<select id='sDenominacionPedido".$sol.$con."' onChange='imgAgregarCantPed(".$sol.", ".$con.", ".$piezas["refaccionidfk"].", \"".$piezas["serie"]."\", this.value, 1);'>
	<option value='(1)-2-5-10'";if($piezas["denominacion"]=='(1)-2-5-10'){echo"selected";}echo">(1)-2-5-10</option>
	<option value='50c-(1)-2-5-10'";if($piezas["denominacion"]=='50c-(1)-2-5-10'){echo"selected";}echo">50c-(1)-2-5-10</option>
	<option value='(50c)-1-2-5-10'";if($piezas["denominacion"]=='(50c)-1-2-5-10'){echo"selected";}echo">(50c)-1-2-5-10</option>
	<option value='(10c)-20c-50c-1-2'";if($piezas["denominacion"]=='(10c)-20c-50c-1-2'){echo"selected";}echo">(10c)-20c-50c-1-2</option></select>
</td>

<td id='tdCamLicPed".$sol.$con."' align='center';>".$piezas["licencia"]."</td>

<td id='tdCamVerPed".$sol.$con."' align='center';>".$piezas["version"]."
<img src='imgs/editarPequeno.bmp' title='Editar Cantidad' id='camVerPed".$sol.$con."' onclick='imgAgregarCantPed(".$sol.", ".$con.", ".$piezas["refaccionidfk"].", \"".$piezas["serie"]."\", \"".$piezas["version"]."\", 2);' style='cursor: pointer;' /></td>

<td id='tdCamIpPed".$sol.$con."' align='center';>".$piezas["ip"]."</td>

<td  id='tdCamJuegoPed".$sol.$con."' align='center';>";
$query= mssql_query("select * from cjuego where estatus=45 order by nombre");
	echo "<select style='font-size:10px' id='sJuegoPedido".$sol.$con."' onChange='imgAgregarCantPed(".$sol.", ".$con.", ".$piezas["refaccionidfk"].", \"".$piezas["serie"]."\", this.value, 3);'>";  
					  
	while($row = mssql_fetch_array($query)){		 
	echo "<option value='".$row["juegoid"]."'"; if($row["nombre"]==$piezas["juego"]){echo 'selected';} echo">".$row["nombre"]."</option>"; } 
	echo "</select>"; echo"
</td>
<td   id='tdCamEstatusPed".$sol.$con."' align='center';>".$piezas["estatus"]."</td>

<td>".$piezas["motivo"]."</td>";
echo"</tr>";}echo"</table>";
////////////////////////////////////////////////Fila para agregar pieza\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
echo"
	</div></span></br>

<strong>Observaciones:</strong> 
<div id='spanObs".$sol."' align='center'><textarea cols='110' rows='6' id='txtObs".$sol."' readonly>".$obser2."</textarea></div><br />
<strong>Escribe tus Observaciones:</strong>
<div align='center'><textarea cols='110' rows='2' id='obs".$sol."' name='desc'></textarea></div><br />
<div align='right'><input type='submit' id='guardarObs' alt='Guardar Observaciones' value='Guardar' onclick='guardaObsPedido(obs".$sol.".value, ".$sol.");' /></div>


</table></div>";
$sd->desconectar();
/*guardaFilasPedido(guardarFilasPedido".$sol.".name,".$sol.",".$estatus.");*/

?>