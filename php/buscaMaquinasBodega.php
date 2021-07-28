<?php
include("../../Conexion/conectaBase.php");
$sd =new conexion();
$sd->conectar(); 
$bodega=$_POST["bodegax"];
$rack=$_POST["rackx"];
$nivel=$_POST["nivelx"];
$pais=$_POST["paisIDx"];
//echo".$bodega. - .$rack. - .$pais. - .$nivel.";
$consultax=mssql_query("select a.bodega,a.rack,a.serie,b.estatus,b.motivo, b.modelo, b.maquinaid from cubicacion2 a inner join cmaquinas b on (b.ubicacionidfk=a.ubicacionid) where a.bodega = '".$bodega."' and a.rack = ".$rack." and a.nivel = ".$nivel." and a.serie is not null and b.ubicacionidfk is not null");

//echo"<div align='center'><a href='javascript:seleccionarTodos()'>Seleccionar Todos</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href='javascript:deseleccionarTodos()' >Deseleccionar Todos</a> </div>";
			
echo"
<div align='center'>

<b>Estatus:</b> <select id='selectEstatus'>
<option value='Disponible'>Disponible</option>
<option value='No Disponible'>No Disponible</option>
</select>&nbsp;&nbsp;&nbsp;
<b>Motivo:</b> <select id='selectMotivo'>
<option value='Reservado Internacional'>Reservado Internacional</option>
<option value='Reservado Nacional'>Reservado Nacional</option>
<option value='Inservible'>Inservible</option>
<option value='Material Faltante'>Material Faltante</option>
<option value='Sin serie'>Sin serie</option>
<option value='Sin Documentos'>Sin Documentos</option>
<option value='Disponible'>Disponible</option>
<option value='Blackwave 1era Generacion'>Blackwave 1era Generacion</option>
<option value='En Revision'>En Revision</option>
<option value='Shoow Room'>Shoow Room</option>
<option value='Maquinas de Feria'>Maquinas de Feria</option>
<option value='Mueble Dañado'>Mueble Dañado</option>
<option value='Cobro Seguro'>Cobro Seguro</option>
<option value='Componente dañado'>Componente dañado</option>
<option value='Mueble en Rehabilitacion'>Mueble en Rehabilitacion</option>
<option value='SIN PLACA'>SIN PLACA</option>
<option value='SIN MONITOR'>SIN MONITOR</option>
<option value='FERIA NIGA'>FERIA NIGA</option>
<option value='FILIPINAS'>FILIPINAS</option>
</select>&nbsp;&nbsp;
<span id='cambiaEstatus'><input type='button' value='Cambiar Estatus' onclick='cambiaEstatus(selectEstatus.value, selectMotivo.value,\"".$bodega."\",\"".$rack."\",\"".$nivel."\")'></span></div>

<form name='f1' style='float:center'> 
<table id='tablaMaq' border='1' cellspacing='1' cellpadding='5' align= 'center' style='width:80%; font-size:12px; border:0px;'>
<tr>
<th align='center'>Serie</th>
<th align='center'>Modelo</th>
<th align='center'>Bodega</th>
<th align='center'>Rack</th>
<th align='center'>Estatus</th>
<th align='center'>Motivo</th>
<th align='center'>Seleccionar</th>
</tr>";
while($res=mssql_fetch_array($consultax)){
$val=0; $val++;
echo"
<tr>
<td align='center'>".$res["serie"]."</td>
<td align='center'>".$res["modelo"]."</td>
<td align='center'>".$res["bodega"]."</td>
<td align='center'>".$res["rack"]."</td>
<td align='center'>".$res["estatus"]."</td>
<td align='center'>".$res["motivo"]."</td>
<td align='center'><input type='checkbox' id=".$res["serie"]." name=".$res["maquinaid"]."></td>
</tr>";}
echo"
</table></form>";
$sd->desconectar();
?>