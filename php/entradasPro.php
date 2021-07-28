<?php 
include("../../Conexion/conectaBase.php");
$sd = new conexion();
$sd->conectar();
$select = mssql_query("select ent.*, cr.clave, cr.nombre nomRef, cu.nombre nomUsu, cu.apellido_paterno
from entradasProduccion ent 
inner join crefaccion cr on (cr.refaccionid=ent.refaccionidfk)
inner join cusuario cu on (cu.usuarioid=ent.usuarioidfk)
where ent.estatus='Pendiente' ");

$color = '#E8F3FF';
$contador=0;
echo "<p style='text-align:left; font-size:14px;'>ENTRADAS PARA PERDIDA</p>";
echo "<table class='listaPiezas'><tr style='background:#FFF;'>";
echo "<th>Codigo</th>
	  <th>Refacci&oacute;n</th>
	  <th>Serie</th>
      <th>Observaci&oacute;n</th>
	  <th>Patrimonio / Activo</th>
	  <th>Usuario</th>
	  <th >Aceptar</th>
	  <th >Cancelar</th>
	  </tr>";
	  
while($row = mssql_fetch_array($select)){ ++$contador;
echo"<tr id='tr".$contador."' title='". $row["entradaid"] ."' style='font-size:10px; background:".$color.";'>";
echo "<td>" . $row["clave"] . "</td>
	 <td>" . $row["nomRef"] . "</td>
     <td>" . $row["serie"] . "</td>
	 <td>" . $row["observacion"] . "</td>
	 <td>" . $row["numPatAct"] . "</td>
	 <td>" . $row["nomUsu"] . " " . $row["apellido_paterno"] . "</td>
	 <td align='center'><img src='imgs/icono_paloma.gif' title='Aceptar' style='cursor:pointer;' onClick='movimientosEntradasPro(1, ".$contador.", tr".$contador.".title, ".$row["refaccionidfk"].")'/></td>
	 <td align='center'><img src='imgs/cancela.png' title='Cancelar' style='cursor:pointer;' onClick='movimientosEntradasPro(2, ".$contador.", tr".$contador.".title, ".$row["refaccionidfk"].")'/></td>"; 
echo"</tr>";
if($color=='#FFF'){$color='#E8F3FF';}else{$color='#FFF';}
} 
echo "</table>";
$sd->desconectar();
?>