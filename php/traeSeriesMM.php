<?php 
include("../../Conexion/conectaBase.php");
$sd =new conexion();
$sd->conectar();
$ubi=$_POST["ubix"];
$valor=$_POST["valorx"];
$cont=1;

if($ubi=='Bodega'){$bodega=$_POST["bodegax"];  $rack=$_POST["rackx"];  $nivel=$_POST["nivelx"];
$seriesx=mssql_query("select u.*,m.maquinaid,m.transito from cubicacion2 u
left join cmaquinas m on (m.ubicacionidfk=u.ubicacionid) where bodega='".$bodega."' and u.rack=".$rack." and nivel=".$nivel." and u.serie like'".$valor."%' order by convert(int,fila),columna ");

echo "<table id='listaBusquedaSeriesMM'>";
while($rowx = mssql_fetch_array($seriesx)){++$cont;
if($rowx["transito"]==0){
	echo"<tr><td id='".$rowx["ubicacionid"]."' class='tablaOrigen'>
			<div id='".$rowx["maquinaid"]."' class='drag orange climit1_2' title='".$rowx["serie"]."' >".$rowx["serie"]."</div></td></tr>";}
else{echo"<tr><td id='".$rowx["ubicacionid"]."' class='tablaOrigen'></td></tr>";}
} 
	echo "</table>";
}//fin if($ubi=='Bodega'){

if($ubi=='Sala'){
	$salaid=$_POST["salaidx"];
$seriesx=mssql_query("select * from cmaquinas where lugarUbi like 'Bodega' and salaidfkObodegaidfk like '".$salaid."' and estatusidfk=96 and serieCompleta like '".$valor."%' ");

echo "<table id='listaBusquedaSeriesMM'>";
while($row = mssql_fetch_array($seriesx)){++$cont;
if($row["transito"]==0){
	echo"<tr><td id='td".$row["maquinaid"]."' class='tablaOrigen'>
			<div id='".$row["maquinaid"]."' class='drag orange climit1_2' title='".$row["serieCompleta"]."' >".$row["serieCompleta"]."</div></td></tr>";}
else{echo"<tr><td id='td".$row["maquinaid"]."' class='tablaOrigen'></td></tr>";}
} 
	echo "</table>";
}//fin if($ubi=='Sala'){
	
$sd->desconectar();
/*echo"<tr><td><input id='inputLic".$folio."' style='border:none; background:none; width:80px' value='".$row["serie"]."' onkeydown='(event.keyCode==13)?poneSerieMM(\"".$row["serie"]."\"):null' onclick='poneSerieMM(\"".$row["serie"]."\");' readonly></td></tr>";*/
?>