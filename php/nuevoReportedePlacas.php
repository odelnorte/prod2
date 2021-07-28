<?php
include("../../Conexion/conectaBase.php");
	 
$sd =new conexion();
$sd->conectar(); 

$tipoPlaca=mssql_query("select distinct(tipoPlaca) from cmaquinas where tipoPlaca is not NULL and tipoPlaca != '' and tipoPlaca != 'BENUS 1.0' and tipoPlaca != 'BENUS 2.0' order by tipoPlaca");
$region=mssql_query("select * from cregion where paisidfk = 1 order by nombre");
echo"
<div id='contenedorFP' style='border-style: solid; border-width: 2px; border-color:#A8D3FF' align= 'center'>
<div><b>Reporte de Placas</b></div>
<div id='filtadoRepPlacas' style='padding:3px; background-color:#CDE9F8; border-color:red' align='center';>

<td>Serie:&nbsp;<input id='txtSerie' size='15' style='font-size:10px;' type='text'></td>&nbsp;&nbsp;&nbsp;&nbsp;
<td>Tipo de Placa:&nbsp;&nbsp;<select id='selectTipo' style='font-size:10px'>
<option value='1'>Todas</option>
<option value='2'>Vacios o Nulos</option>
<option value='benusUno'>BENUS 1.0</option>
<option value='benusDos'>BENUS 2.0</option>";
while ($placa = mssql_fetch_array($tipoPlaca)){echo"
<option value=".$placa["tipoPlaca"].">".$placa["tipoPlaca"]."</option>";
	}echo"
</select></td>
<td>Bodega:&nbsp;&nbsp;<select id='selectBodega' style='font-size:10px'>
<option value='%'>Todas</option>
<option value='bodega 1'>Bodega 1</option>
<option value='bodega 2'>Bodega 2</option>
<option value='bodega 5'>Bodega 5</option>
<option value='bodega 9'>Bodega 9</option>
<option value='bodega 102'>Bodega 102</option>
</select></td>
<td>Region:&nbsp;&nbsp;<select id='selectRegion' style='font-size:10px' onchange='traeDatosPlacas(this.value,2);'>
<option value='%'>Todas</option>";
while($reg=mssql_fetch_array($region)){echo"
<option value=".$reg["regionid"].">".$reg["nombre"]."</option>";
	}echo"
</select></td>
<td>Sala:&nbsp;&nbsp;<span id='spanSalasPlacas' style='font-size:10px'><select id='salaOS' style='font-size:10px'><option value='%'>Todas</option></select></span></td>
</div>
<input type='button' id='buscarPlacas' value='Buscar' onClick='buscaTipoPlacas(txtSerie.value,selectTipo.value,selectBodega.value,selectRegion.value,salaOS.value);'>
<img src='imgs/export_to_excel.gif' style='cursor:pointer;' alt='Exportar a Excel' title='Exportar a Excel' onclick='busquedaPlacasExcel(txtSerie.value,selectTipo.value,selectBodega.value,selectRegion.value,salaOS.value);' />
</div>
<div id='contenidoPlacas' >
		<div id='reportePlacas' style='overflow:auto;' > </div>
		<div id='totalPlacas' align='center'> </div>
	</div>
				
	  
";

 $sd->desconectar();
?>