<?php
include("../../Conexion/conectaBase.php");
//$n=$_POST["nx"];
$sd =new conexion();
$sd->conectar();
$pedidosx = mssql_query("select vp.*,rsol.departamentoidfk
from vista_pedidos vp
inner join dsolicitud_refaccion dsol on (dsol.solicitud_refaccionidfk=vp.solicitud_refaccionid)
inner join tsolicitud_refaccion rsol on (rsol.solicitud_refaccionid = vp.solicitud_refaccionid)
where (vp.estatusidfk=30 or vp.estatusidfk=103) and rsol.departamentoidfk = 8 and rsol.tipoPedido is null group by vp.solicitud_refaccionid, sala, usuario, vp.folio_solicitudidfk, vp.fecha_creacion, sala2, vp.observaciones, tecnico, supervisor, vp.estatus, vp.fechaStock, vp.estatusidfk, paterno, regionidfk, salaid, vp.impresion, vp.paisidfk,vp.subcentroidfk,rsol.departamentoidfk,vp.tipoPedido,vp.actividad,vp.liberacionGerentes,vp.subcentro,vp.departamentoidfk
order by vp.fecha_creacion desc ");

echo "<table id='listaFolios'>";

while($row = mssql_fetch_array($pedidosx)){
	 
	if($row["folio_solicitudidfk"]!='0'){
		$tecx=mssql_query("select top(1)t.nombre tecnico,su.nombre supervisor from tsolicitud_servicio ss
inner join ctecnico t on (t.tecnicoid=ss.tecnicoidfk) inner join csupervisor su on (t.supervisoridfk=su.supervisorid)
where folio_solicitudidfk='".$row["folio_solicitudidfk"]."' ");
	$tec = mssql_fetch_array($tecx);if($tec["tecnico"]==''){$tec["tecnico"]='';}
	
	if($row["estatusidfk"]==29){$background="style='background-color:#fff'";$marcado='';}
	if($row["estatusidfk"]==87){$background="style='background-color:#EBEBEB'";$marcado='';}
	if($row["estatusidfk"]==88){$marcado="<img src='imgs/marcadoPequeno.jpg' id='marcado".$row["solicitud_refaccionid"]."' title='Pedido Marcado'/>";$background='';}
	echo"<tr ".$background.">
		 <td class='tt' id='tdPedidoLista".$row["solicitud_refaccionid"]."' title='".$row["solicitud_refaccionid"]."' onClick='mostrarPedido(".$row["solicitud_refaccionid"].", ".$row["estatusidfk"].");cambiaColorPedido(".$row["solicitud_refaccionid"].")'>".$row["solicitud_refaccionid"]."  &nbsp; ".$row["sala2"]."  &nbsp;  ".$marcado."
		 
		 <span class='tooltip'>
			<span class='top'></span>
			<span class='middle'>Folio: ".$row["folio_solicitudidfk"]."</br>Sala: ".$row["sala"]."</br>Tecnico: ".$tec["tecnico"]."</br>Fecha: ".$row["fecha_creacion"]."</br>Operador: ".$row["usuario"]." ".$row["paterno"]."</br>Comentarios: ".$row["observaciones"]."</span>
			<span class='bottom'></span>
		 </span></td>
		 </tr>";
	
	}else{
		
	echo"<tr ".$background.">
		<td class='tt' id='tdPedidoLista".$row["solicitud_refaccionid"]."' title='".$row["solicitud_refaccionid"]."' onclick='mostrarPedidoSinFolio(".$row["solicitud_refaccionid"].", ".$row["estatusidfk"].");cambiaColorPedido(".$row["solicitud_refaccionid"].")'>".$row["solicitud_refaccionid"]."  &nbsp; ".$row["sala2"]."  &nbsp;  ".$marcado."
		 
		 <span class='tooltip'>
			<span class='top'></span>
			<span class='middle'>Folio: ".$row["folio_solicitudidfk"]."</br>Sala: ".$row["sala"]."</br>Tecnico: ".$row["tecnico"]."</br>Fecha: ".$row["fecha_creacion"]."</br>Operador: ".$row["usuario"]." ".$row["paterno"]."</br>Comentarios: ".$row["observaciones"]."</span>
			<span class='bottom'></span>
		 </span></td>
		 </tr>";
	}$marcado='';$background='';
}
echo "</table>";
$sd->desconectar();
?>