<script type="text/javascript" src="../js/funcionesCC.js"></script>
<script type="text/javascript" src="../js/jquery-1.4.4.min.js"></script>
<?php
include("../../Conexion/conectaBase.php");

$fol=$_GET["folx"];
	 
$sd =new conexion();
$sd->conectar(); 


echo"   <div id='contenedorCP' style='border-style: solid; border-width: 2px; border-color:#A8D3FF' align= 'center'>
        <b>Catalogo de Piezas</b>
		
		

		<div id='filtroCP' style='padding:5px; background-color:#ECF5FA'>
			Familia:&nbsp;
			<SELECT style='font-size:10px' id='selectFamiliaCP'>";
			$sql1 = mssql_query("select familiaid, nombre from cfamilia_refaccion where estatus = 48 order by nombre");
			while ($res1=mssql_fetch_array($sql1)){
			echo"<OPTION VALUE='".$res1["familiaid"]."'>".$res1['nombre']."</OPTION>";
		    }
echo"		</SELECT>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			
			Codigo:&nbsp;
			<input id='codigoCP' size='8' style='font-size:10px; type='text' /></input>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			
			Nombre:&nbsp;
			<input id='nombreCP' size='8' style='font-size:10px; type='text' /></input>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

			Maquina:&nbsp;
			<SELECT style='font-size:10px' id='selectMaquinaCP' >
			<option value='%'>TODAS</option>
			<option value='WBR'>WBR</option>
			<option value='Sleic'>Sleic</option>
			<option value='BlackWave'>BlackWave</option>
			<option value='BlueWave'>BlueWave</option>
			<option value='Poker'>Poker</option>
  			</SELECT>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						
			<input type='submit' value='Buscar' onClick='busquedaCatalogoPiezasPro(selectFamiliaCP.value, codigoCP.value, nombreCP.value, selectMaquinaCP.value, \"".$fol."\");'>
		</div>
		
		<div id='cabeceraCP' style='background-color:#ccc;'> </div>
		<div id='resultadoCP' style='background-color:#EEEEEE; width:100%; height:30px'> </div>
		</div>";


 $sd->desconectar();
?>