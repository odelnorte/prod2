<?php
include("../../Conexion/conectaBase.php");
$sd =new conexion();
$sd->conectar(); 
$id=$_POST["idx"];
$numero=0;
$datosx=mssql_query("select serieCompleta,tipoMaquina,ma.maquinaid from maquinasCNuevos m left join cmaquinas ma on (ma.maquinaid=m.maquinaidfk)
where m.contratoidfk=".$id." ");

echo"<img src='imgs/export_to_excel.gif' style='cursor:pointer;' alt='Exportar a Excel' title='Exportar a Excel' onclick='excelContratosMaq(\"".$id."\");' /></td>
<table id='tablaRF' border='1' cellspacing='1' cellpadding='5' align= 'center' style='width:100%; font-size:12px; border:0px;'>
					<thead style='font-size:12px;' >
		   			<tr style='background:#A4A4A4';>
					   	<th align='center'>No.</th>
						<th align='center'>Serie</th>
						<th align='center'>Tipo</th>
						<th align='center'>Cancelar</th>
					</tr> 
					 </thead>";
					 echo "<tbody>";
	while($datos = mssql_fetch_array($datosx)){$numero=$numero+1;
	echo"
	<tr>
	<td>".$numero."</td>
	<td>".$datos["serieCompleta"]."</td>
	<td>".$datos["tipoMaquina"]."</td>";
	if($datos["serieCompleta"]=='NULL' || $datos["serieCompleta"]==NULL){echo"
	<td></td>";}else{echo"<td><img src='imgs/cancela.png' id=".$numero." title='Quitar maquina' style='cursor:pointer' onClick='quitaMaqContrato(\"".$id."\",\"".$datos["maquinaid"]."\")'; /></td>";}echo"
	</tr>
	";}
echo"</tbody></table>";
$sd->desconectar();
?>