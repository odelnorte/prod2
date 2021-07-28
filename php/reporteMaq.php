<?php
include("../../Conexion/conectaBase.php");
require("calendario.php");

$sd =new conexion();
$sd->conectar();


$var1=111;$var2=222;
$region=mssql_query("select regionid, nombre from cregion where estatusidfk=1 ");
$csala=mssql_query("select salaid, nombre, OfficeID, cliente from csala where regionidfk=1 order by nombre ");

echo" <div id='contenedorAT' style='border-style: solid; border-width: 2px; border-color:#A8D3FF' align= 'center'>
        <b>Historial de Maquinas</b>

	 	<div id='filtadoAT' style='padding:3px; background-color:#CDE9F8; border-color:red' align='center';>
			
			Fecha Inicio:&nbsp;<input id='txtFHRCalendario111' value=".date("d/m/Y")." size='8' style='font-size:10px;' type='text' readOnly='true'/>&nbsp;<img src='imgs/calendario_ico.jpg' name='111' id='calendarioIco111' style='cursor: pointer;' onclick='show_calendar(this.name);' />&nbsp;&nbsp;<span class='divCalendario'><div id='calendario111'>";
    calendar_html($var1);    
echo"    </div></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

			Fecha Fin:&nbsp;<input id='txtFHRCalendario222' value=".date("d/m/Y")." size='8' style='font-size:10px;' type='text' readOnly='true'/>&nbsp;<img src='imgs/calendario_ico.jpg' name='222' id='calendarioIco222' style='cursor: pointer;' onclick='show_calendar(this.name);' />&nbsp;&nbsp;<span class='divCalendario'><div id='calendario222'>";
    calendar_html($var2);    
echo"    </div></span>
		</div>
		
		<div id='filtroAT' style='padding:0px 20px 0px 20px; background-color:#ECF5FA' align='left';>
			SERIE:&nbsp;<input id='txtSerieAT' size='4' style='font-size:10px;' type='text'><input style='width:60px; cursor:pointer; visibility:hidden;'>
			
			UBICACI&Oacute;N:&nbsp;
			<select style='font-size:10px' id='selectUbicacionAT' onChange='traeCombosReporteMaq(this.value);'>
			<option value='sala'>Sala</option>
			<option value='bodega'>Bodega</option>
			</select><input style='width:60px; cursor:pointer; visibility:hidden;'>
			
			<span id='spanCombosAT'>
			REGION:&nbsp;
			<select style='font-size:10px' id='selectRegionAT' onchange='traeSalasReg(this.value);'>";
			while ($regionx=mssql_fetch_array($region)){
			echo"<option value='".$regionx["regionid"]."'>".$regionx['nombre']."</option>"; }
echo"		</select><input style='width:60px; cursor:pointer; visibility:hidden;'>
			
			SALA:&nbsp;
			<span id='spanSalaAT'><select style='font-size:10px' id='selectSalaAT'>";
			while ($csalax=mssql_fetch_array($csala)){
			echo"<option value='".$csalax["salaid"]."'>".$csalax['nombre']."</option>"; }
echo"		</select></span><input style='width:60px; cursor:pointer; visibility:hidden;'>
			</span>


			<span id='spanBotonAT'>
			<input type='submit' value='Buscar' onClick='busquedaReporteMaqAT(txtFHRCalendario111.value, txtFHRCalendario222.value, txtSerieAT.value, selectUbicacionAT.value, selectRegionAT.value, selectSalaAT.value);'>
			</span><input style='width:60px; cursor:pointer; visibility:hidden;'>
			
			<span id='imgexportar'>
				<img src='imgs/export_to_excel.gif' style='cursor:pointer;' alt='exporta a excel' title='Exportar a Excel' onclick='busquedaReporteFolioRFATExcel(1,txtFHRCalendario111.value, txtFHRCalendario222.value, txtSerieAT.value, selectUbicacionAT.value, selectRegionAT.value, selectSalaAT.value,2);' />
			</span>
	
		</div>
		
		<div id='tablaATDiv' style='overflow:auto'></div>
				
	  </div>";//FIN de contenedorST
	
$sd->desconectar();
?>