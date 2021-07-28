<?php
include("../../Conexion/conectaBase.php");
$valor=$_POST["valorx"];

$sd =new conexion();
$sd->conectar();

if($valor=='bodega'){
echo "		BODEGA:&nbsp;
			<select id='selectBodegaAT'>
			<option value='Bodega 2'>2</option>
			<option value='Bodega 5'>5</option>
			<option value='Bodega 9'>9</option>
			<option value='Bodega 102'>102</option>
			</select><input style='width:90px; cursor:pointer; visibility:hidden;'>";
}//fin if($val==1){	


if($valor=='sala'){
$region=mssql_query("select regionid, nombre from cregion where estatusidfk=1 ");
$csala=mssql_query("select salaid, nombre, OfficeID, cliente from csala where regionidfk=1 order by nombre ");

echo "		REGION:&nbsp;
			<select style='font-size:10px' id='selectRegionAT' onchange='traeSalasReg(this.value);'>";
			while ($regionx=mssql_fetch_array($region)){
			echo"<option value='".$regionx["regionid"]."'>".$regionx['nombre']."</option>"; }
echo"		</select><input style='width:60px; cursor:pointer; visibility:hidden;'>
			
			SALA:&nbsp;
			<span id='spanSalaAT'><select style='font-size:10px' id='selectSalaAT'>";
			while ($csalax=mssql_fetch_array($csala)){
			echo"<option value='".$csalax["salaid"]."'>".$csalax['nombre']."</option>"; }
echo"		</select></span><input style='width:60px; cursor:pointer; visibility:hidden;'>";
}//fin if($val==2){	

$sd->desconectar();
?>