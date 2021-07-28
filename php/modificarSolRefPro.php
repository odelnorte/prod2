<?php
include("../../Conexion/conectaBase.php");

$solicitud=$_GET["pedidox"];
$dep=$_GET["departamentox"];
$usuario=$_GET["usuarioIDx"];

//$folio='mex-90537-2014';
//$NumFolio='94290';
//$estatus=$_POST["estatusx"];
$departamento;
$colorEstatus='black';//$_POST["imgx"];
$banderaPedido=0;
$numPiezas=0;
$estImgNuevoPedido=0;
$id=''; $sol="";
$sd =new conexion();
$sd->conectar();
echo '<!DOCTYPE html>
<html lang="es">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
	<title>Cancelacion de Solicitudes de material</title>';?>
    
<!--<link rel="stylesheet" type="text/css" href="../css/basicoAct.css">
<script type="text/javascript" src="../js/calendario/jquery.functions.js"></script>-->
<script type="text/javascript" src="../js/funcionesCanPed.js"></script>
<script type="text/javascript" src="../js/jquery-1.4.4.min.js"></script>
<?php echo "<script type='text/javascript'>
</script>
	</head>
<body >";
/*Area Tecnica 10
--Produccion2       8 Pro
--Nuevos Proyectos 16 Des
--Gerentes de Cuenta  3 GTE*/
/*if($area["area"]=='Area Tecnica'){$departamento=10;}
if($area["area"]=='Produccion2'){$departamento=8;}
if($area["area"]=='Nuevos Proyectos'){$departamento=16;}
if($area["area"]=='Gerentes de Cuenta'){$departamento=3;}*/

//$pedidoDosx=mssql_query("select t.*,es.nombre estatus from tsolicitud_refaccion t inner join cestatus es on (es.estatusid=t.estatusidfk)
//where solicitud_refaccionid=".$solicitud." and departamentoidfk=".$dep." ");
//$obtener=mssql_fetch_array($pedidoDosx);

$pedidox=mssql_query("select t.*,es.nombre estatus from tsolicitud_refaccion t inner join cestatus es on (es.estatusid=t.estatusidfk)
where solicitud_refaccionid=".$solicitud." and departamentoidfk=".$dep." ");

while($pedido = mssql_fetch_array($pedidox))
    {$con=1;if($pedido["estatusidfk"]==31){$colorEstatus="RED";}
	else{
	if($pedido["estatusidfk"]==42 || $pedido["estatusidfk"]==103 || $pedido["estatusidfk"]==115 || $pedido["estatusidfk"]==116 || $pedido["estatusidfk"]==117 || $pedido["estatusidfk"]==118 || $pedido["estatusidfk"]==119 || $pedido["estatusidfk"]==120 || $pedido["estatusidfk"]==121){$colorEstatus="GREEN";}else{$colorEstatus="BLACK";}}
	
	echo"<div id='divPedido".$solicitud."'><fieldset id='fieldset".$solicitud."'><legend>".$pedido["solicitud_refaccionid"]." <span style='color:".$colorEstatus."'>".$pedido["estatus"]."</span> </legend>
	
<table id='tablaPedido".$pedido["solicitud_refaccionid"]."' width='100%' border='0' cellspacing='0' cellpadding='2' style='font-size:11px'>
				<tr> <th bgcolor='#F5F5F5' style='width:20px; border:#ccc solid 1px'></th>   
				<th bgcolor='#F5F5F5' style='border:#ccc solid 1px';>Clave</th><th bgcolor='#F5F5F5' style='border:#ccc solid 1px';>Descripcion</th>
		<th bgcolor='#F5F5F5' style='border:#ccc solid 1px';>Cantidad</th><th bgcolor='#F5F5F5' style='border:#ccc solid 1px';>Cancelar</th><th bgcolor='#F5F5F5' style='border:#ccc solid 1px';>Estatus</th>
				</tr>";
$refo=mssql_query("select observaciones from tsolicitud_refaccion where solicitud_refaccionid='".$solicitud."' and solicitud_refaccionid=".$pedido["solicitud_refaccionid"]." ");
$refox = mssql_fetch_array($refo);
				
 $refx=mssql_query("select r.refaccionid,r.clave,r.nombre refa,cantidad,serie,view2,denominacion,licencia,version,ip,j.nombre juego,ds.descripcion, ds.solicitud_refaccionidfk, diagnostico,ISNULL(enviado,'0')enviado,ds.estatusidfk estatusDos from dsolicitud_refaccion ds
inner join crefaccion r on (r.refaccionid=ds.refaccionidfk) 
left join cjuego j on (j.juegoid=ds.juegoidfk)
where solicitud_refaccionidfk=".$pedido["solicitud_refaccionid"]." ");$con=1;
while($ref = mssql_fetch_array($refx))
    {
	if($ref["estatusDos"]==29){$ref["estatusDos"]='En Proceso';}
	if($ref["estatusDos"]==31){$ref["estatusDos"]='Cancelado';}
	if($ref["estatusDos"]==47){$ref["estatusDos"]='Completo';}
	if($ref["estatusDos"]==42){$ref["estatusDos"]='Enviado';}
	if($ref["estatusDos"]==33){$ref["estatusDos"]='Parcial';}
	if($ref["estatusDos"]==103){$ref["estatusDos"]='Enviado Parcial';}
	if($ref["estatusDos"]==43){$ref["estatusDos"]='Sin Existencia';}
	if($ref["estatusDos"]==51){$ref["estatusDos"]='Similar';}
echo"<tr id='tr".$pedido["solicitud_refaccionid"]."-".$con."'><td bgcolor='#F5F5F5' style='width:20px; border:#ccc solid 1px' align='center'>".$con."</td>
     <td align='center'>".$ref["clave"]."</td><td align='center'>".$ref["refa"]."</td><td align='center'>".$ref["cantidad"]."</td>
	 <td align='center'>"; if($pedido["estatusidfk"]!='31' && $ref["enviado"]=='0' && $ref["estatusDos"]!='Cancelado'){echo"
	 <img src='cancela.png' id='lugarEntradaimg".$ref["refaccionid"]."' style='cursor:pointer;' onClick='colocaPiezasCan(".$pedido["solicitud_refaccionid"].",".$ref["refaccionid"].",\"".$ref["serie"]."\");oculta(this.id,".$pedido["solicitud_refaccionid"].",".$con.");' title='Cancelar'>";}echo"</td>";
	 	if($ref["estatusDos"]=='Cancelado'){echo"<b><font color='#FF0000'><td align='center'>".$ref['estatusDos']."</td></font></b>";}
		else if($ref["estatusDos"]=='Completo'){echo"<b><font color='green'><td align='center'>".$ref['estatusDos']."</td></font></b>";}else{echo"
		<td align='center'>".$ref['estatusDos']."</td>";}echo"
	 </tr>";$con++;
	}echo"</table>";
	echo"</legend>";
$refo2=mssql_query("select observaciones from tsolicitud_refaccion where solicitud_refaccionid='".$solicitud."' and solicitud_refaccionid=".$pedido["solicitud_refaccionid"]." ");
$refox2 = mssql_fetch_array($refo2);	
if($refox2["observaciones"]==' '){$refox2["observaciones"]='';}
echo "				Observaciones: &nbsp;<textarea cols='70' rows='2' id='texaObservaciones".$pedido["solicitud_refaccionid"]."' style='color:#666' >".$refox2["observaciones"]."</textarea>";
echo "</fieldset>";
echo"<span id='spanDesRefaccion' class='spanDesRefaccion'></span>
<span id='cancelarCompleto".$NumFolio."'><input";if($pedido["estatusidfk"]==42 || $pedido["estatusidfk"]==115 || $pedido["estatusidfk"]==116 || $pedido["estatusidfk"]==117 || $pedido["estatusidfk"]==118 || $pedido["estatusidfk"]==119 || $pedido["estatusidfk"]==120 || $pedido["estatusidfk"]==121){ echo" disabled ";}
	echo" type='submit' value='Cancelar Completo' onClick='cancelaPedidoOS(1,".$pedido["solicitud_refaccionid"].",\"".$usuario."\");' /></span>
	<span id='cancelarParcial".$NumFolio."'><input ";
	if($con==2 || $pedido["estatusidfk"]==42 || $pedido["estatusidfk"]==115 || $pedido["estatusidfk"]==116 || $pedido["estatusidfk"]==117 || $pedido["estatusidfk"]==118 || $pedido["estatusidfk"]==119 || $pedido["estatusidfk"]==120 || $pedido["estatusidfk"]==121){ echo" disabled ";}
	echo" type='submit'  value='Cancelar Parcial' onclick='cancelaPedidoOS(2,".$pedido["solicitud_refaccionid"].",\"".$usuario."\");' /></span>
	<span style='display:none'><input type='text' size='10' id='input".$pedido["solicitud_refaccionid"]."' /></span>
	<br><br>";
$con=1;$estImgNuevoPedido='1';//style='visibility:hidden'
	}
	
	//////////////////PEDIDOS RELACIONADOS/////////////////////////////
	
	
	$pedidoDosx=mssql_query("select t.*,es.nombre estatus from tsolicitud_refaccion t inner join cestatus es on (es.estatusid=t.estatusidfk)
where solicitud_refaccionid=".$solicitud." and departamentoidfk=".$dep." ");
$obtenerPedido=mssql_fetch_array($pedidoDosx);

$pedidoRelacionadox=mssql_query("select t.*,es.nombre estatus from tsolicitud_refaccion t inner join cestatus es on (es.estatusid=t.estatusidfk)
where pedidoRelacionado = ".$obtenerPedido["solicitud_refaccionid"]." and departamentoidfk=".$dep." ");
//$pedidoRelacionado=mssql_fetch_array($pedidoRelacionadox);
//if($pedidoRelacionado["pedidoRelacionado"]!='NULL' || $pedidoRelacionado["pedidoRelacionado"]!='' || $pedidoRelacionado["pedidoRelacionado"]!=' '){
	
	while($pedido = mssql_fetch_array($pedidoRelacionadox))
    {$con=1;if($pedido["estatusidfk"]==31){$colorEstatus="RED";}
	else{
	if($pedido["estatusidfk"]==42 || $pedido["estatusidfk"]==103){$colorEstatus="GREEN";}else{$colorEstatus="BLACK";}}
	
	echo"<div id='divPedido".$solicitudDos."'><fieldset id='fieldset".$solicitudDos."'><legend>".$pedido["solicitud_refaccionid"]." <span style='color:".$colorEstatus."'>".$pedido["estatus"]."</span> </legend>
	
<table id='tablaPedido".$pedido["solicitud_refaccionid"]."' width='100%' border='0' cellspacing='0' cellpadding='2' style='font-size:11px'>
				<tr> <th bgcolor='#F5F5F5' style='width:20px; border:#ccc solid 1px'></th>   
				<th bgcolor='#F5F5F5' style='border:#ccc solid 1px';>Clave</th><th bgcolor='#F5F5F5' style='border:#ccc solid 1px';>Descripcion</th>
		<th bgcolor='#F5F5F5' style='border:#ccc solid 1px';>Cantidad</th><th bgcolor='#F5F5F5' style='border:#ccc solid 1px';>Cancelar</th><th bgcolor='#F5F5F5' style='border:#ccc solid 1px';>Estatus</th>
				</tr>";
$refo=mssql_query("select observaciones from tsolicitud_refaccion where solicitud_refaccionid='".$obtenerPedido["solicitud_refaccionid"]."' and solicitud_refaccionid=".$pedido["solicitud_refaccionid"]." ");
$refox = mssql_fetch_array($refo);
				
 $refx=mssql_query("select r.refaccionid,r.clave,r.nombre refa,cantidad,serie,view2,denominacion,licencia,version,ip,j.nombre juego,ds.descripcion, ds.solicitud_refaccionidfk, diagnostico,ISNULL(enviado,'0')enviado,ds.estatusidfk estatusDos from dsolicitud_refaccion ds
inner join crefaccion r on (r.refaccionid=ds.refaccionidfk) 
left join cjuego j on (j.juegoid=ds.juegoidfk)
where solicitud_refaccionidfk=".$pedido["solicitud_refaccionid"]." ");$con=1;
while($ref = mssql_fetch_array($refx))
    {
	if($ref["estatusDos"]==29){$ref["estatusDos"]='En Proceso';}
	if($ref["estatusDos"]==31){$ref["estatusDos"]='Cancelado';}
	if($ref["estatusDos"]==47){$ref["estatusDos"]='Completo';}
	if($ref["estatusDos"]==42){$ref["estatusDos"]='Enviado';}
	if($ref["estatusDos"]==33){$ref["estatusDos"]='Parcial';}
	if($ref["estatusDos"]==103){$ref["estatusDos"]='Enviado Parcial';}
	if($ref["estatusDos"]==43){$ref["estatusDos"]='Sin Existencia';}
	if($ref["estatusDos"]==51){$ref["estatusDos"]='Similar';}
echo"<tr id='tr".$pedido["solicitud_refaccionid"]."-".$con."'><td bgcolor='#F5F5F5' style='width:20px; border:#ccc solid 1px' align='center'>".$con."</td>
     <td align='center'>".$ref["clave"]."</td><td align='center'>".$ref["refa"]."</td><td align='center'>".$ref["cantidad"]."</td>
	 <td align='center'>"; if($pedido["estatusidfk"]!='31' && $ref["enviado"]=='0' && $ref["estatusDos"]!='Cancelado'){echo"
	 <img src='cancela.png' id='lugarEntradaimg".$ref["refaccionid"]."' style='cursor:pointer;' onClick='colocaPiezasCan(".$pedido["solicitud_refaccionid"].",".$ref["refaccionid"].",\"".$ref["serie"]."\");oculta(this.id,".$pedido["solicitud_refaccionid"].",".$con.");' title='Cancelar'>";}echo"</td>";
	 	if($ref["estatusDos"]=='Cancelado'){echo"<b><font color='#FF0000'><td align='center'>".$ref['estatusDos']."</td></font></b>";}
		else if($ref["estatusDos"]=='Completo'){echo"<b><font color='green'><td align='center'>".$ref['estatusDos']."</td></font></b>";}else{echo"
		<td align='center'>".$ref['estatusDos']."</td>";}echo"
	 </tr>";$con++;
	}echo"</table>";
	echo"</legend>";
$refo2=mssql_query("select observaciones from tsolicitud_refaccion where solicitud_refaccionid='".$pedido["solicitud_refaccionid"]."' and solicitud_refaccionid=".$pedido["solicitud_refaccionid"]." ");
$refox2 = mssql_fetch_array($refo2);	
if($refox2["observaciones"]==' '){$refox2["observaciones"]='';}
echo "				Observaciones: &nbsp;<textarea cols='70' rows='2' id='texaObservaciones".$pedido["solicitud_refaccionid"]."' style='color:#666' >".$refox2["observaciones"]."</textarea>";
echo "</fieldset>";
echo"<span id='spanDesRefaccion' class='spanDesRefaccion'></span>
<span id='cancelarCompleto".$NumFolio."'><input";if($pedido["estatusidfk"]==42 || $pedido["estatusidfk"]==115 || $pedido["estatusidfk"]==116 || $pedido["estatusidfk"]==117 || $pedido["estatusidfk"]==118 || $pedido["estatusidfk"]==119 || $pedido["estatusidfk"]==120 || $pedido["estatusidfk"]==121){ echo" disabled ";}
	echo" type='submit' value='Cancelar Completo' onClick='cancelaPedidoOS(1,".$pedido["solicitud_refaccionid"].",\"".$usuario."\");' /></span>
	<span id='cancelarParcial".$NumFolio."'><input ";
	if($con==2 || $pedido["estatusidfk"]==42 || $pedido["estatusidfk"]==115 || $pedido["estatusidfk"]==116 || $pedido["estatusidfk"]==117 || $pedido["estatusidfk"]==118 || $pedido["estatusidfk"]==119 || $pedido["estatusidfk"]==120 || $pedido["estatusidfk"]==121){ echo" disabled ";}
	echo" type='submit'  value='Cancelar Parcial' onclick='cancelaPedidoOS(2,".$pedido["solicitud_refaccionid"].",\"".$usuario."\");' /></span>
	<span style='display:none'><input type='text' size='10' id='input".$pedido["solicitud_refaccionid"]."' /></span>
	<br><br>";
$con=1;$estImgNuevoPedido='1';//style='visibility:hidden'
	}
	
	//}

echo"</div></td></tr></table>
</body>
</html>";
?>