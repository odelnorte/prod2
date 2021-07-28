<?php
include("../../Conexion/conectaBase.php");
	 
$sd =new conexion();
$sd->conectar(); 
$pais=$_POST["paisIDx"]; 
echo"
<div id='contenedor' style='border-style: solid; border-width: 2px; border-color:#A8D3FF' align= 'center'>
<b>Maquinas con Placas en Bodega</b>
<p>
<p>
<p>

Tipo de Placa:&nbsp;&nbsp;<input type='text' size='15' id='numeroPlaca' />&nbsp;&nbsp;&nbsp;&nbsp;

Bodega: &nbsp;<select id='selectBodegaMaq'  onChange='traedatosBod(this.value);'>
<option value='Bodega 102'>Bodega 102</option>
<option value='bodega 2'>Bodega 2</option>
<option value='bodega 5'>Bodega 5</option>
<option value='bodega 9'>Bodega 9</option>
<option value='bodega 1'>Bodega 1</option>
</select>
Rack: &nbsp;<span id='cambiaRack'><select id='selectRackMaq'>
<option value='1'>1</option>
<option value='2'>2</option>
<option value='3'>3</option>
<option value='4'>4</option>
<option value='5'>5</option>
<option value='6'>6</option>
<option value='7'>7</option>
<option value='8'>8</option>
<option value='9'>9</option>
<option value='10'>10</option>
<option value='11'>11</option>
<option value='12'>12</option>
<option value='13'>13</option>
<option value='14'>14</option>
<option value='15'>15</option>
<option value='16'>16</option>
<option value='17'>17</option>
<option value='18'>18</option>
<option value='19'>19</option>
<option value='20'>20</option>
<option value='21'>21</option>
<option value='22'>22</option>
<option value='99'>99</option>
</select></span>
Nivel: &nbsp;<select id='selectNivelMaq'>
<option value='1'>1</option>
<option value='2'>2</option>
<option value='3'>3</option>
<option value='4'>4</option>
</select>&nbsp;&nbsp;&nbsp;&nbsp;
<input type='submit' value='Buscar' id='botonBusquedaMaq' onClick='busquedaMaquinasyPlacas(selectBodegaMaq.value, selectRackMaq.value, selectNivelMaq.value,numeroPlaca.value,1);'>

<img src='imgs/export_to_excel.gif' style='cursor:pointer;' alt='Exportar a Excel' title='Exportar a Excel' onclick='busquedaMaquinasExcel(selectBodegaMaq.value, selectRackMaq.value, selectNivelMaq.value);' />
</div>"; //FIN de contenedorST
echo"
<div id='mostrarMaquinasyPlacasDiv' style='overflow:auto;'> </div>";
	   
//echo" </table>";
 $sd->desconectar();
?>