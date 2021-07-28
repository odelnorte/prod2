<?php 
include("../../Conexion/conectaBase.php");
$num = $_POST["numx"];
$tr = $_POST["trx"];
$entrada = $_POST["entradax"];
$ref = $_POST["refx"];
$obs = $_POST["obsx"];
$serie = $_POST["seriex"];
$usuarioID=$_POST["usuarioIDx"];

$sd = new conexion();
$sd->conectar();

if($num == 1){$estatus='Enviado a Stock'; 
	//$update = mssql_query("update entradasProduccion set estatus='".$estatus."' where entradaid=".$entrada." ");
	$movimiento = mssql_query("INSERT INTO tmovimiento(refaccionidfk,fecha,origen,destino,cantidad,observacion,usuarioidfk)
	VALUES(".$ref.",getdate(),'Produccion','Stock',1,'',".$usuarioID.")");
	$select=mssql_query("select top(1)* from tmovimiento order by fecha desc");
	$movimiento=mssql_fetch_array($select);
	$insertAct=mssql_query("INSERT INTO tactividadMovimiento(movimientoidfk,fecha,area,accion,motivo,destino,serie,usuarioidfk)
	VALUES(".$movimiento["movimientoid"].",getdate(),'Produccion','Envia','".$obs."','Stock','".$serie."',".$usuarioID.") ");
	$insert=mssql_query("INSERT INTO entradasStock(origen,estatus,observacion,serie,movimientoidfk,refaccionidfk)
	VALUES('Produccion','enviado','".$obs."','".$serie."',".$movimiento["movimientoid"].",".$ref.") ");
	$selectEntrada=mssql_query("select TOP(1)entradaid from entradasStock order by entradaid desc");
	$selectEntradax=mssql_fetch_array($selectEntrada);
	$update = mssql_query("update entradasProduccion set estatus='".$estatus."', entradaidfk='".$selectEntradax["entradaid"]."' where entradaid=".$entrada." ");}
//if($num == 2){$estatus='Cancelado'; }


$select = mssql_query("select ent.*, cr.clave, cr.nombre nomRef, cu.nombre nomUsu, cu.apellido_paterno
from entradasProduccion ent 
inner join crefaccion cr on (cr.refaccionid=ent.refaccionidfk)
inner join cusuario cu on (cu.usuarioid=ent.usuarioidfk)
where ent.estatus='Aceptado' ");

$color = '#E8F3FF';
$contador=0;
echo "<p style='text-align:left; font-size:14px;'>ENTRADAS PARA PERDIDA</p>";
echo "<table class='listaPiezas'><tr style='background:#FFF;'>";
echo "<th>Codigo".$movimiento["movimientoidfk"]."</th>
	  <th>Refacci&oacute;n</th>
	  <th>Serie</th>
      <th>Observaci&oacute;n</th>
	  <th>Patrimonio / Activo</th>
	  <th>Usuario</th>
	  <th >Enviar</th>
	  </tr>";
	  
while($row = mssql_fetch_array($select)){ ++$contador;
echo"<tr id='tr".$contador."' title='". $row["entradaid"] ."' style='font-size:10px; background:".$color.";'>";
echo "<td>" . $row["clave"] . "</td>
	 <td>" . $row["nomRef"] . "</td>
     <td>" . $row["serie"] . "</td>
	 <td>" . $row["observacion"] . "</td>
	 <td>" . $row["numPatAct"] . "</td>
	 <td>" . $row["nomUsu"] . " " . $row["apellido_paterno"] . "</td>
	 <td align='center'><img src='imgs/icono_paloma.gif' title='Aceptar' style='cursor:pointer;' onClick='movimientosSalidasPro(1, ".$contador.", ".$row["entradaid"].", ".$row["refaccionidfk"].", \"".$row["observacion"]."\", \"".$row["serie"]."\")')'/></td>"; 
echo"</tr>";
if($color=='#FFF'){$color='#E8F3FF';}else{$color='#FFF';}
} 
echo "</table>";
	
$sd->desconectar();
?>